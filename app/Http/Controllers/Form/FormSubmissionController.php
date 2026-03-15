<?php

namespace App\Http\Controllers\Form;

use App\Enum\HttpStatusCodeEnum;
use App\Enum\PaginationEnum;
use App\Http\Controllers\Controller;
use App\Http\Filters\Communication\MailFilter;
use App\Http\Filters\Form\MainTemplateFormFilter;
use App\Http\Filters\FormSubmission\FormSubmissionFilter;
use App\Http\Requests\Communication\ManualMailRequest;
use App\Http\Resources\Communication\EmailResource;
use App\Http\Filters\Report\AuditLogFilter;
use App\Http\Requests\FormSubmission\FormSubmissionRequest;
use App\Http\Resources\AuditLogResource;
use App\Http\Resources\FormSubmission\FormSubmissionDetailsHistoryResource;
use App\Http\Resources\FormSubmission\FormSubmissionListResource;
use App\Http\Resources\FormSubmission\FormSubmissionLookupResource;
use App\Http\Resources\FormSubmission\FormSubmissionResource;
use App\Http\Resources\FormSubmission\MainFormSubmissionListResource;
use App\Http\Resources\MainTemplateForm\MainFormListResource;
use App\Services\Form\FormSubmissionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class FormSubmissionController extends Controller
{
    /**
     * @var FormSubmissionService
     */
    protected FormSubmissionService $service;

    /**
     * @param FormSubmissionService $service
     */
    public function __construct(FormSubmissionService $service)
    {
        $this->service = $service;
    }


    /**
     * @param Request $request
     * @param FormSubmissionFilter $filter
     * @param int $mainTemplateId
     * @return JsonResponse
     */
    public function mainTemplateSubmissions(Request $request, FormSubmissionFilter $filter, int $mainTemplateId): JsonResponse
    {
        $mainTemplateSubmissionResource = $this->service->mainTemplateSubmissions(
            $mainTemplateId,
            $request->get('page', PaginationEnum::PAGE),
            $request->get('perPage', PaginationEnum::LIMIT),
            $filter
        );

        return $this->response(new MainFormSubmissionListResource($mainTemplateSubmissionResource), HttpStatusCodeEnum::OK);
    }
    /**
     * send
     *
     * @param  mixed $request
     * @return JsonResponse
     */
    public function sendEmail(ManualMailRequest $request): JsonResponse
    {
        $this->service->sendManualMail($request->all());
         return $this->response([], HttpStatusCodeEnum::OK);
    }
    /**
     * submissionMainTemplate
     *
     * @param  mixed $filter
     * @param  mixed $mainTemplateId
     * @return JsonResponse
     */
    public function submissionMainTemplate(FormSubmissionFilter $filter, int $mainTemplateId): JsonResponse
    {
        $formSubmissions = $this->service->submissionMainTemplate($filter, $mainTemplateId);

        return $this->response(FormSubmissionLookupResource::collection($formSubmissions), HttpStatusCodeEnum::OK);
    }



    /**
     * getManualMail
     *
     * @param  mixed $request
     * @param  mixed $filter
     * @return JsonResponse
     */
    public function getManualMail(Request $request,MailFilter $filter): JsonResponse
    {
        $paginator=$this->service->getManualMail($request->get("page", PaginationEnum::PAGE), $request->get("perPage", PaginationEnum::LIMIT), $filter);
        $resource = EmailResource::collection($paginator);
        return $this->response($this->formatPagination($resource, $paginator), HttpStatusCodeEnum::OK);
    }


    /**
     * @throws Throwable
     */
    public function show($id): JsonResponse
    {
        $resource = $this->service->show($id);
        return $this->response(FormSubmissionResource::make($resource), HttpStatusCodeEnum::OK);
    }
    /**
     * history
     *
     * @param  mixed  $id
     * @return JsonResponse
     */
    public function history(Request $request, AuditLogFilter $filter): JsonResponse
    {
        $logs = $this->service->history(
            $request->get("page", PaginationEnum::PAGE),
            $request->get("perPage", PaginationEnum::LIMIT),
            $filter
        );
        $resourceData = AuditLogResource::collection($logs);
        return $this->response($this->formatPagination($resourceData, $logs), HttpStatusCodeEnum::OK);
    }

    /**
     * @param FormSubmissionRequest $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function store(FormSubmissionRequest $request): JsonResponse
    {
        $resource = $this->service->store($request->validated());
        return $this->response(FormSubmissionResource::make($resource), HttpStatusCodeEnum::OK);
    }


    /**
     * @param FormSubmissionRequest $request
     * @param $id
     * @return JsonResponse
     * @throws Throwable
     */
    public function update(FormSubmissionRequest $request, $id): JsonResponse
    {
        $resource = $this->service->updateSubmissionValues($id, $request->validated());
        return $this->response(FormSubmissionResource::make($resource), HttpStatusCodeEnum::OK);
    }


    /**
     * @throws Throwable
     */
    public function delete($id): JsonResponse
    {
        $this->service->deleteSubmission($id);
        return $this->response([], HttpStatusCodeEnum::OK);
    }
}
