<?php

namespace App\Services\Form;

use App\Enum\Form\FormLayoutEnum;
use App\Enum\Form\FormStatusEnum;
use App\Exceptions\CantDeleteFormHasSubmissionsException;
use App\Http\Filters\Filter;
use App\Repository\Form\FormRepository;
use App\Repository\MainRepository;
use App\Services\InputForm\InputFormService;
use Illuminate\Support\Str;
use App\Services\MainService;
use Throwable;


class FormService extends MainService
{

    /**
     * @var FormRepository
     */
    protected MainRepository $repository;

    /**
     * @param FormRepository $repository
     */
    public function __construct(FormRepository $repository)
    {
        $this->repository = $repository;
        parent::__construct($repository);
    }

    /**
     * @param int $mainFormId
     * @param int $page
     * @param int $perPage
     * @return mixed
     */
    public function allVersions(int $mainFormId, int $page, int $perPage, Filter $filter): mixed
    {
        return $this->repository->allVersions($mainFormId, $page, $perPage, $filter);
    }

    /**
     * @param array $data
     * @return mixed
     * @throws Throwable
     */
    public function store(array $data): mixed
    {
        return $this->applyTransaction(function () use ($data) {

            $mainTemplate = app(MainTemplateFormService::class)->add([
                'created_by' => auth()->user()->id,
                "name" => json_encode($data["mainData"]['name']),
                "module_id" => $data['mainData']['moduleId'],
                "key" => Str::uuid(),
                "is_default" => 0,
            ]);

            return $this->_createFormVersion($mainTemplate->id, $data);
        });
    }
    /**
     * getPrimaryForm
     *
     * @return mixed
     */
    public function getPrimaryForm():mixed
    {
        return $this->findAll(["Primary"=>1]);

    }

    /**
     * @param int $mainTemplateId
     * @param array $data
     * @return mixed
     * @throws Throwable
     */
    private function _createFormVersion(int $mainTemplateId, array $data): mixed
    {
        return $this->applyTransaction(function () use ($mainTemplateId, $data) {
            $mainData = $data["mainData"];
            $formData = $this->add([
                'update_date' => now(),
                'create_by' => auth()->user()->id,
                'status' => $mainData['status'] ?? FormStatusEnum::ACTIVE,
                'Primary' => $mainData['primary'] ?? 0,
                'layout' => $mainData['layout'] ?? FormLayoutEnum::LANDSCAPE,
                'name' => !empty($mainData['name']) ? json_encode($mainData['name']) : null,
                "symbol"=>$mainData['symbol'],
                'main_template_form_id' => $mainTemplateId,
                "version" => $this->max('version', ['main_template_form_id' => $mainTemplateId])+1 ?? 0,

            ]);

            app(TemplateFormProjectService::class)->attachTemplateProjects($formData->id, $mainData['projectIds']);

            app(InputFormService::class)->addFormInputs($formData->id, $data['inputs']);

            return $formData;
        });
    }

    /**
     * @param int $mainTemplateId
     * @param array $data
     * @return mixed
     * @throws Throwable
     */
    public function updateForm(int $mainTemplateId, array $data): mixed
    {
        $mainTemplate = app(MainTemplateFormService::class)->findOrFail($mainTemplateId);
        app(MainTemplateFormService::class)->update($mainTemplate->id, [
            //TODO: should be deleted updated_by
            'updated_by' => auth()->user()->id,
            "name" => json_encode($data["mainData"]['name']),
            "is_default" => 0,
        ]);
        return $this->applyTransaction(function () use ($mainTemplate, $data) {
            return $this->_createFormVersion($mainTemplate->id, $data);
        });
    }

    /**
     * @param int $id
     * @return void
     * @throws CantDeleteFormHasSubmissionsException
     * @throws Throwable
     */
    public function deleteForm(int $id): mixed
    {
        return $this->applyTransaction(function () use ($id) {
            $form = $this->find($id);
            if(!$form)
                return false;
            $this->_validateDelete($id);
            $this->_handleMainDelete($form);

            $this->repository->update($id, ['deleted_by' => auth()->user()->id]);
            $result = $this->delete([$id]);
            return $result;
        });

    }

    /**
     * @throws CantDeleteFormHasSubmissionsException
     * @throws Throwable
     */
    private function _validateDelete($id): void
    {
        $form = $this->firstOrFailBy(['id' => $id], withCount: ['submissions']);
        if ($form?->submissions && $form?->submissions_count) throw new CantDeleteFormHasSubmissionsException();
    }

    /**
     * @param mixed $form
     * @return void
     */
    function _handleMainDelete(mixed $form): void
    {
        $mainTemplate = null;
        if ($form->main_template_form_id) {
            $mainTemplate = app(MainTemplateFormService::class)->summary($form->main_template_form_id);
        }
        if ($mainTemplate && $mainTemplate?->templateForms?->count() <= 1) {
            app(MainTemplateFormService::class)->delete([$mainTemplate->id]);
        }
    }
}
