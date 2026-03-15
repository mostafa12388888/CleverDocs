<?php

namespace App\Http\Controllers\Form\CustomOption;

use App\Enum\HttpStatusCodeEnum;
use App\Enum\PaginationEnum;
use App\Http\Controllers\Controller;
use App\Http\Filters\CustomOption\CustomOptionListFilter;
use App\Http\Requests\Form\CustomOption\InputOptionListRequestBulkDelete;
use App\Http\Requests\Form\CustomOption\InputOptionRequest;
use App\Http\Resources\Form\CustomOption\InputOptionLockupResource;
use App\Http\Resources\Form\CustomOption\InputOptionResource;
use App\Http\Resources\Form\CustomOption\InputOptionSummeryResource;
use App\Services\Form\CustomOption\InputOptionServices;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class InputOptionController extends Controller
{
    protected InputOptionServices $services;
    public function __construct(InputOptionServices $services){
        $this->services=$services;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, CustomOptionListFilter $filter): JsonResponse
    {
        $paginator = $this->services->list(
            $request->get('page', PaginationEnum::PAGE),
            $request->get('perPage', PaginationEnum::LIMIT),
            $filter);
        $resource = InputOptionResource::collection($paginator);
        return $this->response($this->formatPagination($resource, $paginator), HttpStatusCodeEnum::OK);
    }
 /**
     * lookup
     *
     * @param  mixed $filter
     * @return JsonResponse
     */
    public function lookup(CustomOptionListFilter $filter): JsonResponse
    {
        $resource = InputOptionLockupResource::collection($this->services->lookup($filter));
        return $this->response($resource, HttpStatusCodeEnum::OK);
    }
     /**
      * lookupPaginate
      *
      * @param  mixed $request
      * @param  mixed $filter
      * @return JsonResponse
      */
     public function lookupPaginate(Request $request, CustomOptionListFilter $filter): JsonResponse
    {
        $paginator = $this->services->lookupPaginate(
            $request->get('page', PaginationEnum::PAGE),
            $request->get('perPage', PaginationEnum::LIMIT),
            $filter);
        $resource = InputOptionLockupResource::collection($paginator);
        return $this->response($this->formatPagination($resource, $paginator), HttpStatusCodeEnum::OK);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(InputOptionRequest $request):JsonResponse
    {
        $resource=$this->services->store($request->all());
        return $this->response(InputOptionResource::make($resource),HttpStatusCodeEnum::OK);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id):JsonResponse
    {
        $resource=$this->services->firstOrFailBy(["id"=>$id],["updatedBy","createdBy"]);
        return $this->response(InputOptionResource::make($resource),HttpStatusCodeEnum::OK);
    }

    /**
     * summary
     *
     * @param  mixed $id
     * @return JsonResponse
     */
    public function summary(int $id): JsonResponse
    {
        $resource=$this->services->firstOrFailBy(['id'=>$id],[],[],['id','name']);

         return $this->response(InputOptionSummeryResource::make($resource),HttpStatusCodeEnum::OK);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
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
    public function update(InputOptionRequest $request, string $id): JsonResponse
    {
        $resource=$this->services->update($id, $request->all());
        return $this->response(InputOptionResource::make($resource),HttpStatusCodeEnum::OK);
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
    public function destroy(int $id):JsonResponse
    {
        $this->services->deleteInputOptionList($id);
        return $this->response([], HttpStatusCodeEnum::OK);
    }
     /**
     * bulkDelete
     *
     * @param  mixed $request
     * @return JsonResponse
     */
    public function bulkDelete(InputOptionListRequestBulkDelete $request): JsonResponse
    {
        $this->services->bulkDelete($request->all());

        return $this->response([], HttpStatusCodeEnum::OK);
    }
}
