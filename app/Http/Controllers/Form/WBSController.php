<?php

namespace App\Http\Controllers\Form;

use App\Enum\HttpStatusCodeEnum;
use App\Enum\PaginationEnum;
use App\Exports\Form\WBSExport;
use App\Http\Controllers\Controller;
use App\Http\Filters\Form\WBS\WBSFilter;
use App\Http\Requests\Company\WBSRequestBulkDelete;
use App\Http\Requests\Form\WBSRequest;
use App\Http\Resources\Form\WBSDetailsResource;
use App\Http\Resources\Form\WBSListResource;
use App\Http\Resources\Form\WBSLookupResource;
use App\Http\Resources\Form\WBsSummeryResource;
use App\Services\Form\WBSService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class WBSController extends Controller
{
    /**
     * @var WBSService
     */
    protected  WBSService $service;
    /**
     * @param WBSService $service
     */
    public function __construct(WBSService $service)
    {
        $this->service = $service;
    }
    /**
     * index
     *
     * @return JsonResponse
     */
    public function index(Request $request,WBSFilter $filter): JsonResponse
    {
        $paginator = $this->service->index(
            $request->get('page', PaginationEnum::PAGE),
            $request->get('perPage', PaginationEnum::LIMIT),
            $filter);
        $resourceData = WBSListResource::collection($paginator);
        return $this->response($this->formatPagination($resourceData, $paginator), HttpStatusCodeEnum::OK);
    }
    /**
     * lookupPaginate
     *
     * @param  mixed $request
     * @param  mixed $filter
     * @return JsonResponse
     */
    public function lookupPaginate(Request $request,WBSFilter $filter): JsonResponse
    {
        $paginator = $this->service->lookupPaginate(
            $request->get('page', PaginationEnum::PAGE),
            $request->get('perPage', PaginationEnum::LIMIT),
            $filter);
        $resourceData = WBSLookupResource::collection($paginator);
        return $this->response($this->formatPagination($resourceData, $paginator), HttpStatusCodeEnum::OK);
    }
         /**
     * export
     *
     * @param  mixed $filter
     * @return void
     */
     public function export(WBSFilter $filter)
    {
        $dataExport = $this->service->getDataExport($filter);
        return Excel::download(new WBSExport($dataExport), 'WBS.xlsx');
    }
    /**
     * show
     *
     * @param  mixed $id
     * @return JsonResponse
     */
    public function show(int $id)
    {
        $resource = $this->service->firstOrFailBy(['id' => $id],withCount: ['projects']);
        return $this->response(WBSDetailsResource::make($resource), HttpStatusCodeEnum::OK);
    }
    /**
     * summary
     *
     * @param  mixed $id
     * @return JsonResponse
     */
    public function summary(int $id): JsonResponse
    {
        $resource = $this->service->firstOrFailBy(['id' => $id]);
        return $this->response(WBsSummeryResource::make($resource), HttpStatusCodeEnum::OK);
    }
    /**
     * store
     *
     * @param  mixed $request
     * @return JsonResponse
     */
    function store(WBSRequest $request): JsonResponse
    {
        $resource = $this->service->store($request->all());
        return $this->response(WBSListResource::make($resource), HttpStatusCodeEnum::OK);
    }
    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $id
     * @return JsonResponse
     */
    function update(WBSRequest $request, $id): JsonResponse
    {
        $resource = $this->service->update($id, $request->all());
        return $this->response(WBSListResource::make($resource), HttpStatusCodeEnum::OK);
    }
    /**
     * @param int $id
     * @return JsonResponse
     * @throws Throwable
     *  CanDeleteProjectHastWbsException
     */
    public function delete(int $id): JsonResponse
    {
        $this->service->destroy($id);
        return $this->response([], HttpStatusCodeEnum::OK);
    }
    /**
     * bulkDelete
     *
     * @param  mixed $request
     * @return JsonResponse
     */
    public function bulkDelete(WBSRequestBulkDelete $request): JsonResponse
    {
        $this->service->bulkDelete($request->all());

        return $this->response([], HttpStatusCodeEnum::OK);
    }
}
