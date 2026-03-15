<?php

namespace App\Http\Controllers\Form;


use App\Enum\HttpStatusCodeEnum;
use App\Enum\PaginationEnum;
use App\Exports\Form\LayoutExport;
use App\Http\Controllers\Controller;
use App\Http\Filters\Layout\LayoutFilter;
use App\Http\Requests\Form\LayoutRequest;
use App\Http\Requests\Form\LayoutRequestBulkDelete;
use App\Http\Resources\Form\LayoutLookupResource;
use App\Http\Resources\Form\LayoutResource;
use App\Services\Form\LayoutServices;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Throwable;

class LayoutController extends Controller
{

    /**
     * service
     *
     * @var LayoutService
     */
    protected LayoutServices $service;
    /**
     * __construct
     *
     * @param  mixed $service
     * @return void
     */
    public function __construct(LayoutServices $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     */
    /**
     * index
     *
     * @param  mixed $request
     * @param  mixed $type
     * @return JsonResponse
     */
    public function index(Request $request ,LayoutFilter $filter): JsonResponse
    {

        $paginator = $this->service->index($filter, $request->get("page", PaginationEnum::PAGE), $request->get("perPage", PaginationEnum::LIMIT));
        $resource = LayoutResource::collection($paginator);
        return $this->response($this->formatPagination($resource, $paginator), HttpStatusCodeEnum::OK);
    }
    /**
     * lookupPaginate
     *
     * @param  mixed $request
     * @param  mixed $filter
     * @return JsonResponse
     */
    public function lookupPaginate(Request $request ,LayoutFilter $filter): JsonResponse
    {

        $paginator = $this->service->lookupPaginate($filter, $request->get("page", PaginationEnum::PAGE), $request->get("perPage", PaginationEnum::LIMIT));
        $resource = LayoutLookupResource::collection($paginator);
        return $this->response($this->formatPagination($resource, $paginator), HttpStatusCodeEnum::OK);
    }
    /**
     * export
     *
     * @param  mixed $filter
     * @return void
     */
     public function export(LayoutFilter $filter)
    {
        $dataExport = $this->service->getDataExport($filter);
        return Excel::download(new LayoutExport($dataExport), 'layouts.xlsx');
    }
    /**
     * Store a newly created resource in storage.
     */
    /**
     * store
     *
     * @param mixed $request
     * @return JsonResponse
     * @throws Throwable
     */
    public function store(LayoutRequest $request): JsonResponse
    {
        $resource = $this->service->store($request->all());
        return $this->response(LayoutResource::make($resource), HttpStatusCodeEnum::OK);
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
    public function show(int $id): JsonResponse
    {

        $resource = $this->service->firstOrFailBy(["id" => $id],["createdBy","updatedBy"]);
        return $this->response(LayoutResource::make($resource), HttpStatusCodeEnum::OK);
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
    public function update(LayoutRequest $request, int $id): JsonResponse
    {
        $resource = $this->service->update($id, $request->all());
        return $this->response(LayoutResource::make($resource), HttpStatusCodeEnum::OK);
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
    public function destroy($id): JsonResponse
    {
        $this->service->deleteLayout($id);
        return $this->response([], HttpStatusCodeEnum::OK);
    }
       /**
     * bulkDelete
     *
     * @param  mixed $request
     * @return JsonResponse
     */
    public function bulkDelete(LayoutRequestBulkDelete $request): JsonResponse
    {
        $this->service->bulkDelete($request->all());

        return $this->response([], HttpStatusCodeEnum::OK);
    }
}
