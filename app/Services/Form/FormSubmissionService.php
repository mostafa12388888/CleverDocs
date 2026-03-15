<?php

namespace App\Services\Form;

use App\Http\Filters\Filter;
use App\Repository\Form\FormSubmissionRepository;
use App\Repository\MainRepository;
use App\Services\Communication\MailService;
use App\Services\AuditLogService;
use App\Services\MainService;
use Exception;
use Illuminate\Support\Facades\App;
use Throwable;
use App\Exceptions\Form\CanAddNewFormSubmission;
use App\Exceptions\Form\FormNotAttachedToProjectException;
use App\Exceptions\Form\FormSubmissionHasVersionsException;

class FormSubmissionService extends MainService
{

    /**
     * @var FormSubmissionRepository
     */
    protected MainRepository $repository;

    /**
     * @param FormSubmissionRepository $repository
     */
    public function __construct(FormSubmissionRepository $repository)
    {
        $this->repository = $repository;
        parent::__construct($repository);
    }
    public function history(int $page, int $perPage, ?Filter $filter = null): mixed
    {
     return app(AuditLogService::class)->index($page, $perPage, "formSubmission", $filter);
    }

    /**
     * @param array $data
     * @return mixed
     * @throws Exception
     */
    public function store(array $data): mixed
    {

        $formVersionId = $data['formVersionId'];

        $status = $data['status'];
        $inputsValues = $data['inputsValues'] ?? [];
        $parentSubmissionId = $data['parentSubmissionId'] ?? null;
        $formProject = app(TemplateFormProjectService::class)->firstBy(['templates_form_id' => $formVersionId, 'project_id' => $data['projectId']]);


        if (!$formProject) {

            throw new FormNotAttachedToProjectException();
        }

        return $this->_addSubmissionWithValues($formProject->id, $status, $inputsValues, $parentSubmissionId);
    }

    /**
     * @param $id
     * @param array $data
     * @return mixed
     * @throws Throwable
     */
    public function updateSubmissionValues($id, array $data): mixed
    {
        $formSubmission = $this->firstOrFailBy(['id' => $id]);
    $oldSubmission = $formSubmission->submissionValues()
        ->select('value','input_key as inputKey','template_input_id as templateInputId')
        ->get()
        ->map(function ($item) {
        $decoded = json_decode($item->value, true);
        return [
            'templateInputId' => $item->templateInputId,
            'value' => $decoded['value'] ?? $item->value,
            'inputKey' => $item->inputKey,
        ];
    })->toArray();
        // $this->_validateFormSubmissionValues($formProject, $data['inputsValues']);
       app(FormSubmissionValueService::class)->updateSubmissionValues($id, $data['inputsValues']);
         app(AuditLogService::class)->log(
                'update',
                "formSubmission",
                $formSubmission->id,
                oldValue: [],
                newValue: [],
                oldRelated: ['formSubmissionValues' => $oldSubmission],
                newRelated: ['formSubmissionValues' => array($data['inputsValues'], 'value')],
            );
        return $this->show($id);
    }

    /**
     * @param $id
     * @return mixed
     * @throws Throwable
     */
    public function show($id): mixed
    {
        return $this->firstOrFailBy(['id' => $id] , ['submissionValues']);
    }

    /**
     * @param int $mainTemplateId
     * @param int $page
     * @param int $perPage
     * @param Filter $filter
     * @return mixed
     */
    public function mainTemplateSubmissions(int $mainTemplateId, int $page, int $perPage, Filter $filter): mixed
    {
        $allLastFormVersionInputs = app(MainTemplateFormService::class)->allLastFormVersionInputs($mainTemplateId);
        $allSubmissionsData = $this->repository->mainTemplateSubmissions($mainTemplateId, $page, $perPage, $filter);

        return (object)[
            'allSubmissionsData' => $allSubmissionsData,
            'formInputTypes' => $allLastFormVersionInputs
        ];
    }
    /**
     * sendManualMail
     *
     * @param  mixed $data
     * @return mixed
     */
    public function sendManualMail(array $data): mixed
    {
        $type = $this->findOrFail($data["typeId"]);
        return app(MailService::class)->sendManualMail($data, 'submission', $type->title);
    }
    /**
     * getManualMail
     *
     * @param  mixed $page
     * @param  mixed $perPage
     * @param  mixed $filter
     * @return mixed
     */
    public function getManualMail(int $page, int $perPage, ?Filter $filter = null): mixed
    {
        return app(MailService::class)->index($page, $perPage, 'submission', $filter);
    }

    /**
     * submissionMainTemplate
     *
     * @param  mixed $filter
     * @param  mixed $mainTemplateId
     * @return mixed
     */
    public function submissionMainTemplate(?Filter $filter,int $mainTemplateId,?string $countBy = null, ?string $groupBy = null): mixed
    {
        return $this->repository->aggregatedCounts($filter, $mainTemplateId,$countBy, $groupBy);
    }
    /**
     * @param int $page
     * @param int $perPage
     * @param Filter $filter
     * @return mixed
     */
    public function all(int $page, int $perPage, Filter $filter): mixed
    {
        $allSubmissionsData =  $this->repository->all($page, $perPage, $filter);
        return $allSubmissionsData;
    }

    /**
     * @param $id
     * @return void
     * @throws Throwable
     */
    public function deleteSubmission($id)
    {
        $this->_validateFormSubmissionVersionDelete($id);
        app(FormSubmissionValueService::class)->deleteSubmissionValues($id);
        $this->deleteOne($id);
    }

    private function _validateFormSubmissionVersionDelete(int $submissionId): void
    {
        if ($this->repository->versions($submissionId)) {
            throw new FormSubmissionHasVersionsException();
        }
    }

    /**
     * @param mixed $formProject
     * @param mixed $inputs
     * @return void
     * @throws Exception
     */
    private function _validateFormSubmissionValues(mixed $formProject, mixed $inputs): void
    {
        $form = $formProject?->templateForm;
        $formInputs = $form?->templateInputs;
        $formInputsIds = $formInputs->pluck('id')->toArray();
        $inputValuesIds = array_column($inputs, 'templateInputId');
        $diff = array_diff($formInputsIds, $inputValuesIds);
        if (!empty($diff)) {
            throw new CanAddNewFormSubmission();
        }
    }

    /**
     * @param mixed $formProjectId
     * @param mixed $status
     * @param mixed $inputsValues
     * @return mixed
     */
    private function _addSubmissionWithValues(mixed $formProjectId, mixed $status, mixed $inputsValues, mixed $parentSubmissionId = null): mixed
    {
        $formSubmission = $this->repository->add([
            'templates_form_project_id' => $formProjectId,
            'created_by' => auth()->id(),
            'submissions_id' => $parentSubmissionId ?? null,
            'status' => $status
        ]);

        app(FormSubmissionValueService::class)->storeSubmissionValues($formSubmission->id, $inputsValues);
        $formSubmission->load('submissionValues');
        app(AuditLogService::class)->log('create', "formSubmission", $formSubmission->id, null, [],null,['formSubmissionValues' => $formSubmission->submissionValues->pluck('value')->map(function ($item) {return json_decode($item, true)['value'] ?? null;})->filter()->sort()->values()->toArray() ?? []]);


        return $formSubmission;
    }


}
