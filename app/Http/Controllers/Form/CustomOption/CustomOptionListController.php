<?php

namespace App\Http\Controllers\Form\CustomOption;

use App\Enum\HttpStatusCodeEnum;
use App\Enum\PaginationEnum;
use App\Exports\Form\CustomOption\CustomOptionListExport;
use App\Http\Controllers\Controller;
use App\Http\Filters\CustomList\CustomListFilter;
use App\Http\Requests\Form\CustomOption\CustomOptionListRequest;
use App\Http\Requests\Form\CustomOption\CustomOptionListRequestBulkDelete;
use App\Http\Requests\form\CustomOption\CustomOptionListShowRequest;
use App\Http\Resources\Form\CustomOption\CustomOptionListResource;
use App\Http\Resources\Form\CustomOption\CustomOptionLockupResource;
use App\Http\Resources\Form\CustomOption\CustomOptionSummaryResource;
use App\Services\Form\CustomOption\CustomOptionListServices;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class CustomOptionListController extends Controller
{

protected CustomOptionListServices $services;
/**
 * __construct
 *
 * @param  mixed $services
 * @return void
 */
public function __construct(CustomOptionListServices $services){
    $this->services = $services;
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
    public function index(Request $request,CustomListFilter $filter): JsonResponse
    {
        $paginator=$this->services->index(
        $filter,
        $request->get("page",PaginationEnum::PAGE),
        $request->get("perPage",PaginationEnum::LIMIT));
        $resource=CustomOptionListResource::collection($paginator);
        return $this->response($this->formatPagination($resource, $paginator), HttpStatusCodeEnum::OK);
    }
        /**
     * export
     *
     * @param  mixed $filter
     * @return void
     */
     public function export(CustomListFilter $filter)
    {
        $dataExport = $this->services->getDataExport($filter);
        return Excel::download(new CustomOptionListExport($dataExport), 'inputTypes.xlsx');
    }
    /**
     * lookup
     *
     * @param  mixed $filter
     * @return JsonResponse
     */
    public function lookup(CustomListFilter $filter): JsonResponse
    {
      $resource=$this->services->lookup($filter);

       return $this->response(CustomOptionLockupResource::collection($resource),HttpStatusCodeEnum::OK);
  }
     /**
      * lookupPaginate
      *
      * @param  mixed $request
      * @param  mixed $filter
      * @return JsonResponse
      */
     public function lookupPaginate(Request $request,CustomListFilter $filter): JsonResponse
    {
        $paginator=$this->services->lookupPaginate(
        $filter,
        $request->get("page",PaginationEnum::PAGE),
        $request->get("perPage",PaginationEnum::LIMIT));
        $resource=CustomOptionLockupResource::collection($paginator);
        return $this->response($this->formatPagination($resource, $paginator), HttpStatusCodeEnum::OK);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
    public function store(CustomOptionListRequest $request):JsonResponse
    {

        $resource= $this->services->store($request->all());
        return $this->response(CustomOptionListResource::make($resource),HttpStatusCodeEnum::OK);
    }

    /**
     * Display the specified resource.
     */
    /**
     * show
     *
     * @param  mixed $customOptionId
     * @return JsonResponse
     */
    public function show(int $customOptionId): JsonResponse
    {

        $resource=$this->services->firstOrFailBy(['id'=>$customOptionId],['inputOption',"updatedBy","createdBy"]);

         return $this->response(CustomOptionListResource::make($resource),HttpStatusCodeEnum::OK);
    }
    /**
     * summary
     *
     * @param  mixed $customOptionId
     * @return JsonResponse
     */
    public function summary(int $customOptionId): JsonResponse
    {

        $resource=$this->services->firstOrFailBy(['id'=>$customOptionId]);

         return $this->response(CustomOptionSummaryResource::make($resource),HttpStatusCodeEnum::OK);
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
    public function update(CustomOptionListRequest $request, string $id): JsonResponse
    {
        $resource= $this->services->update($id, $request->all());
        return $this->response(CustomOptionListResource::make($resource),HttpStatusCodeEnum::OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    /**
     * destroy
     *
     * @param  mixed $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $this->services->deleteCustomOptionList($id);
        return $this->response([],HttpStatusCodeEnum::OK) ;
    }
    /**
     * bulkDelete
     *
     * @param  mixed $request
     * @return JsonResponse
     */
    public function bulkDelete(CustomOptionListRequestBulkDelete $request): JsonResponse
    {
        $this->services->bulkDelete($request->all());

        return $this->response([], HttpStatusCodeEnum::OK);
    }
}
