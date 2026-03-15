<?php

namespace App\Http\Controllers\Workflow;

use App\Enum\HttpStatusCodeEnum;
use App\Enum\PaginationEnum;
use App\Exports\Workflow\MainWorkFlowExport;
use App\Http\Controllers\Controller;
use App\Http\Filters\Workflow\MainWorkflowFilter;
use App\Http\Resources\MainTemplateForm\MainFormListResource;
use App\Http\Resources\Workflow\MainWorkflowListResource;
use App\Http\Resources\Workflow\WorkflowFormResource;
use App\Http\Resources\Workflow\MainWorkflowLookupResource;
use App\Services\Workflow\MainWorkflowService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class MainWorkFlowController extends Controller
{

    /**
     * @var MainWorkflowService
     */
    protected MainWorkflowService $service;

    /**
     * @param MainWorkflowService $service
     */
    public function __construct(MainWorkflowService $service)
    {
        $this->service = $service;
    }


    /**
     * @param Request $request
     * @param MainWorkflowFilter $filter
     * @return JsonResponse
     */
    public function index(Request $request,MainWorkflowFilter $filter): JsonResponse
    {
        $paginator = $this->service->allWithLastVersion(
            $request->get('page', PaginationEnum::PAGE),
            $request->get('perPage', PaginationEnum::LIMIT),
            $filter
        );
        $resourceData = MainWorkflowListResource::collection($paginator);
        return $this->response($this->formatPagination($resourceData, $paginator), HttpStatusCodeEnum::OK);
    }

 /**
     * lookupPaginate
     *
     * @param  mixed $request
     * @param  mixed $filter
     * @return JsonResponse
     */
    public function lookupPaginate(Request $request,MainWorkflowFilter $filter): JsonResponse
    {
        $paginator = $this->service->lookupPaginate(
            $request->get('page', PaginationEnum::PAGE),
            $request->get('perPage', PaginationEnum::LIMIT),
            $filter
        );

        $resourceData = MainWorkflowLookupResource::collection($paginator);
        return $this->response($this->formatPagination($resourceData, $paginator), HttpStatusCodeEnum::OK);

     }


    public function formWithWorkFlow(Request $request ,MainWorkflowFilter $filter): JsonResponse
    {
        $paginator = $this->service->formWithWorkFlow(
            $request->get('page', PaginationEnum::PAGE),
            $request->get('perPage', PaginationEnum::LIMIT),
            $filter
        );
        $resourceData = WorkflowFormResource::collection($paginator);
        return $this->response($this->formatPagination($resourceData, $paginator), HttpStatusCodeEnum::OK);    }
    
         /**
     * export
     *
     * @param  mixed $filter
     * @return void
     */
     public function export(MainWorkflowFilter $filter)
    {
        $dataExport = $this->service->getDataExport($filter);
        return Excel::download(new MainWorkFlowExport($dataExport), 'workflows.xlsx');
    }

}
