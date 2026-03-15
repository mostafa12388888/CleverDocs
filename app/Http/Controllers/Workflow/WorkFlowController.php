<?php

namespace App\Http\Controllers\Workflow;

use App\Enum\HttpStatusCodeEnum;
use App\Enum\PaginationEnum;
use App\Exceptions\CantDeleteFormHasSubmissionsException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Forms\StoreUpdateFormRequest;
use App\Http\Requests\Workflow\StoreUpdateWorkflowRequest;
use App\Http\Requests\Workflow\WorkflowBulkDeleteRequest;
use App\Http\Resources\Form\FormDetailsResource;
use App\Http\Resources\Form\FormListResource;
use App\Http\Resources\Workflow\WorkflowDetailsResource;
use App\Http\Resources\Workflow\WorkflowListResource;
use App\Services\Workflow\WorkflowService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class WorkFlowController extends Controller
{

    /**
     * @var WorkflowService
     */
    protected WorkflowService $service;

    /**
     * @param WorkflowService $service
     */
    public function __construct(WorkflowService $service)
    {
        $this->service = $service;
    }

    /**
     * @param Request $request
     * @param int $mainFormId
     * @return JsonResponse
     */
    public function allVersions(Request $request, int $mainFormId): JsonResponse
    {
        $paginator = $this->service->allVersions(
            $mainFormId,
            $request->get('page', PaginationEnum::PAGE),
            $request->get('perPage', PaginationEnum::LIMIT),
        );

        $resourceData = WorkflowListResource::collection($paginator);
        return $this->response($this->formatPagination($resourceData, $paginator), HttpStatusCodeEnum::OK);
    }

    /**
     * @param StoreUpdateWorkflowRequest $request
     * @return JsonResponse
     * @throws Throwable
     */
    public function store(StoreUpdateWorkflowRequest $request): JsonResponse
    {
        $resource = $this->service->store($request->all());
        return $this->response(WorkflowListResource::make($resource), HttpStatusCodeEnum::OK);
    }

    /**
     * @param StoreUpdateWorkflowRequest $request
     * @param int $id
     * @return JsonResponse
     * @throws Throwable
     */
    public function update(StoreUpdateWorkflowRequest $request, int $id): JsonResponse
    {
        $resource = $this->service->update($id, $request->all());
        return $this->response(WorkflowListResource::make($resource), HttpStatusCodeEnum::OK);
    }

    /**
     * @param int $workflowId
     * @return JsonResponse
     * @throws Throwable
     */
    public function view(int $workflowId):JsonResponse
    {
        $resource = $this->service->firstOrFailBy(['id' => $workflowId], ['createdBy']);
        return $this->response(WorkflowDetailsResource::make($resource), HttpStatusCodeEnum::OK);
    }

    /**
     * @param int $id
     * @return JsonResponse
     * @throws Throwable
     */
    public function delete(int $id): JsonResponse
    {
        $this->service->deleteWorkflow($id);
        return $this->response([], HttpStatusCodeEnum::OK);
    }
     /**
     * bulkDelete
     *
     * @param  mixed $request
     * @return JsonResponse
     */
    public function bulkDelete(WorkflowBulkDeleteRequest $request): JsonResponse
    {
        $this->service->bulkDelete($request->all());
        return $this->response([], HttpStatusCodeEnum::OK);
    }

}
