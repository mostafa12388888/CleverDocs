<?php

namespace App\Http\Controllers\Form;

use App\Enum\HttpStatusCodeEnum;
use App\Enum\PaginationEnum;
use App\Exports\Form\InputTypeExport;
use App\Http\Controllers\Controller;
use App\Http\Filters\InputType\InputType;
use App\Http\Filters\InputType\InputTypeFilter;
use App\Http\Requests\Form\InputTypeRequest;
use App\Http\Requests\Form\InputTypeRequestBulkDelete;
use App\Http\Requests\Form\InputTypeUpdateRequest;
use App\Http\Resources\Form\InputTypeCategoryResource;
use App\Http\Resources\Form\InputTypeLookupResource;
use App\Http\Resources\Form\InputTypeResource;

use App\Services\Form\InputTypeService;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Maatwebsite\Excel\Facades\Excel;

class InputTypeController extends Controller
{

    /**
     * @var InputTypeService
     */
    protected InputTypeService $service;
    /**
     * __construct
     *
     * @param  mixed $service
     * @return void
     */
    public function __construct(InputTypeService $service)
    {
        $this->service = $service;
    }

    /**
     * index
     *
     * @param  mixed $request
     * @return JsonResponse
     */
    public function index(Request $request ,InputTypeFilter $filter )
    {
        $paginator = $this->service->index(
            $filter,
            $request->get('page', PaginationEnum::PAGE),
            $request->get('perPage', PaginationEnum::LIMIT),
        );
        $resource = InputTypeResource::collection($paginator);
        return $this->response($this->formatPagination($resource, $paginator), HttpStatusCodeEnum::OK);
    }
    /**
     * lookupPaginate
     *
     * @param  mixed $request
     * @param  mixed $filter
     * @return void
     */
    public function lookupPaginate(Request $request ,InputTypeFilter $filter )
    {
        $paginator = $this->service->lookupPaginate(
            $filter,
            $request->get('page', PaginationEnum::PAGE),
            $request->get('perPage', PaginationEnum::LIMIT),
        );
        $resource = InputTypeLookupResource::collection($paginator);
        return $this->response($this->formatPagination($resource, $paginator), HttpStatusCodeEnum::OK);
    }
    /**
     * export
     *
     * @param  mixed $filter
     * @return void
     */
     public function export(InputTypeFilter $filter)
    {
        $dataExport = $this->service->getDataExport($filter);
        return Excel::download(new InputTypeExport($dataExport), 'inputTypes.xlsx');
    }
    /**
     * categories
     *
     * @param  mixed $filter
     * @return void
     */
    public function categories(InputTypeFilter $filter )
    {
        $paginator = $this->service->categories($filter);

        $resource = InputTypeCategoryResource::collection($paginator);
        return $this->response($resource, HttpStatusCodeEnum::OK);
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
    public function store(InputTypeRequest $request)
    {

        $resource = $this->service->store($request->all());
        return $this->response(InputTypeResource::make($resource), HttpStatusCodeEnum::OK);
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
        $resource = $this->service->firstOrFailBy(['id' => $id],["updatedBy","createdBy"]);
        return $this->response(InputTypeResource::make($resource), HttpStatusCodeEnum::OK);
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
    public function update(InputTypeUpdateRequest $request, int $id): JsonResponse
    {
        $resource = $this->service->update($id, $request->all());
        return $this->response(InputTypeResource::make($resource), HttpStatusCodeEnum::OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    /**
     * destroy
     *
     * @param  mixed $id
     * @return void
     */
    public function destroy(int $id)
    {

        $this->service->deleteInputType($id);
        return $this->response([], HttpStatusCodeEnum::OK);
    }
       /**
     * bulkDelete
     *
     * @param  mixed $request
     * @return JsonResponse
     */
    public function bulkDelete(InputTypeRequestBulkDelete $request): JsonResponse
    {
        $this->service->bulkDelete($request->all());

        return $this->response([], HttpStatusCodeEnum::OK);
    }
}
