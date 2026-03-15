<?php

namespace App\Http\Controllers\Distribution;

use App\Enum\HttpStatusCodeEnum;
use App\Enum\PaginationEnum;
use App\Exports\Distribution\DistributionListsExport;
use App\Http\Controllers\Controller;
use App\Http\Filters\Distribution\DistributionListFilter;
use App\Http\Requests\Distribution\DistributionListRequest;
use App\Http\Requests\Distribution\DistributionRequestBulkDelete;
use App\Http\Resources\Distribution\DistributionListResource;
use App\Http\Resources\Distribution\DistributionListDetailsResource;
use App\Http\Resources\Distribution\DistributionListSummaryResource;
use App\Services\Distribution\DistributionListService;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class DistributionListsController extends Controller
{

    /**
     * @var DistributionListService
     */
    protected DistributionListService $service;

/**
 * __construct
 *
 * @param  mixed $service
 * @return void
 */
public function __construct(DistributionListService $service)
{
    $this->service=$service;
}
    /**
     * Display a listing of the resource.
     */

    /**
     * index
     *
     * @param  mixed $request
     * @return JsonResponse
     */
    public function index(Request $request,DistributionListFilter $filter):JsonResponse
    {
         $paginator=$this->service->index($request->get('page',PaginationEnum::PAGE),
         $request->get('perPage', PaginationEnum::LIMIT),$filter);
        $resource=DistributionListResource::collection($paginator);
        return $this->response($this->formatPagination($resource,$paginator),HttpStatusCodeEnum::OK);
        }
    /**
     * lookupPaginate
     *
     * @param  mixed $request
     * @param  mixed $filter
     * @return JsonResponse
     */
    public function lookupPaginate(Request $request,DistributionListFilter $filter):JsonResponse
    {
         $paginator=$this->service->lookupPaginate($request->get('page',PaginationEnum::PAGE),
         $request->get('perPage', PaginationEnum::LIMIT),$filter);
        $resource=DistributionListSummaryResource::collection($paginator);
        return $this->response($this->formatPagination($resource,$paginator),HttpStatusCodeEnum::OK);
        }
        /**
     * export
     *
     * @param  mixed $filter
     * @return void
     */
     public function export(DistributionListFilter $filter)
    {
        $dataExport = $this->service->getDataExport($filter);
        return Excel::download(new DistributionListsExport($dataExport), 'users.xlsx');
    }
    /**
     * Store a newly created resource in storage.
     */
    /**
     * store
     *
     * @param  mixed $request
     * @return JsonResponse
     */
    public function store(DistributionListRequest $request):JsonResponse
    {
        $resource =$this->service->store($request->all());
        return $this->response(DistributionListDetailsResource::make($resource),HttpStatusCodeEnum::OK);
    }

    /**
     * Display the specified resource.
     */
    /**
     * show
     *
     * @param  mixed $id
     * @return JsonResponse
     */
    public function show(int $id)
    {
       $resource =$this->service->firstOrFailBy(['id'=>$id],['contactsActions.contact','contactsActions.contact.company', 'contactsActions.action',"updatedBy","createdBy"]);
       return $this->response(DistributionListDetailsResource::make($resource),HttpStatusCodeEnum::OK);
    }
    /**
     * Update the specified resource in storage.
     */
    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $id
     * @return JsonResponse
     */
    public function update(DistributionListRequest $request, int $id):JsonResponse
    {
        $resource =$this->service->update($id,$request->all());
        return $this->response(DistributionListDetailsResource::make($resource),HttpStatusCodeEnum::OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id):JsonResponse
    {
        $this->service->deleteDistributionList($id);
          return $this->response([],HttpStatusCodeEnum::OK);
    }
         /**
     * bulkDelete
     *
     * @param  mixed $request
     * @return JsonResponse
     */
    public function bulkDelete(DistributionRequestBulkDelete $request): JsonResponse
    {
        $this->service->bulkDelete($request->all());

        return $this->response([], HttpStatusCodeEnum::OK);
    }
}
