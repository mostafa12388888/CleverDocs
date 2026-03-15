<?php

namespace App\Http\Controllers\Form;

use App\Enum\HttpStatusCodeEnum;
use App\Enum\PaginationEnum;
use App\Exceptions\CantDeleteFormHasSubmissionsException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Forms\StoreUpdateFormRequest;
use App\Http\Resources\Form\FormDetailsResource;
use App\Http\Resources\Form\FormPreViewResource;
use App\Http\Resources\Form\FormListResource;
use App\Services\Form\FormService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Filters\Form\MainTemplateFormFilter;
use Throwable;

class FormController extends Controller
{
    /**
     * @var FormService
     */
    protected FormService $service;

    /**
     * @param FormService $service
     */
    public function __construct(FormService $service)
    {
        $this->service = $service;
    }


    /**
     * @param Request $request
     * @param int $mainFormId
     * @return JsonResponse
     */
    public function allVersions(Request $request, int $mainFormId, MainTemplateFormFilter $filter): JsonResponse
    {
        $paginator = $this->service->allVersions(
            $mainFormId,
            $request->get('page', PaginationEnum::PAGE),
            $request->get('perPage', PaginationEnum::LIMIT),
            $filter
        );

        $resourceData = FormListResource::collection($paginator);
        return $this->response($this->formatPagination($resourceData, $paginator), HttpStatusCodeEnum::OK);
    }

    /**
     * @param StoreUpdateFormRequest $request
     * @return JsonResponse
     * @throws Throwable
     */
    public function store(StoreUpdateFormRequest $request): JsonResponse
    {
        $resource = $this->service->store($request->all());
        return $this->response(FormListResource::make($resource), HttpStatusCodeEnum::OK);
    }

    /**
     * @param int $id
     * @param StoreUpdateFormRequest $request
     * @return JsonResponse
     * @throws Throwable
     */
    public function updateForm(int $id, StoreUpdateFormRequest $request): JsonResponse
    {
        $resource = $this->service->updateForm($id, $request->all());
        return $this->response(FormListResource::make($resource), HttpStatusCodeEnum::OK);
    }


    /**
     * @param int $formId
     * @return JsonResponse
     * @throws Throwable
     */
    public function view(int $formId):JsonResponse
    {
        $resource = $this->service->firstOrFailBy(['id' => $formId], ['templateInputs',"mainTemplateForm"]);
        return $this->response(FormDetailsResource::make($resource), HttpStatusCodeEnum::OK);
    }

    /**
     * preview
     *
     * @param  mixed $formId
     * @return JsonResponse
     */
    public function preview(int $formId):JsonResponse
    {
        $resource = $this->service->firstOrFailBy(['id' => $formId], ['templateInputs']);
        return $this->response(FormPreViewResource::make($resource), HttpStatusCodeEnum::OK);
    }

    /**
     * @param int $id
     * @return JsonResponse
     * @throws Throwable
     * @throws CantDeleteFormHasSubmissionsException
     */
    public function delete(int $id): JsonResponse
    {
        $this->service->deleteForm($id);
        return $this->response([], HttpStatusCodeEnum::OK);
    }

}
