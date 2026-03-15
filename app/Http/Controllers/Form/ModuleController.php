<?php

namespace App\Http\Controllers\Form;

use App\Enum\HttpStatusCodeEnum;
use App\Enum\PaginationEnum;
use App\Exports\Form\ModuleExport;
use App\Http\Controllers\Controller;
use App\Http\Filters\Module\ModuleFilter;
use App\Http\Requests\Form\ModuleRequest;
use App\Http\Requests\Form\ModuleRequestBulkDelete;
use App\Http\Requests\Form\UpdateOrderModuleRequest;
use App\Http\Resources\Form\MainFormAndModuleDetailResource;
use App\Http\Resources\Form\MainFormAndModuleResource;
use App\Http\Resources\Form\MainFormAndModuleWithLastVersionResource;
use App\Http\Resources\Form\ModuleLookupResource;
use App\Http\Resources\Form\ModuleResource;
use App\Services\Form\ModuleService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ModuleController extends Controller
{
    /**
     * @var ModuleService
     */
    protected ModuleService $service;

    /**
     * __construct
     *
     * @param  mixed $service
     * @return void
     */
    public function __construct(ModuleService $service)
    {
        $this->service = $service;
    }
    /**
     * storeModule
     *
     * @param  mixed $request
     * @return JsonResponse
     */
    function storeModule(ModuleRequest $request): JsonResponse
    {

        $resource = $this->service->storeModule($request->all());
        return $this->response(new ModuleResource($resource), HttpStatusCodeEnum::OK);
    }
    /**
     * showAll
     *
     * @param  mixed $request
     * @return JsonResponse
     */
    public function showAll(Request $request,ModuleFilter $filter): JsonResponse
    {
        $paginate = $this->service->showAll(
            $request->get("page", PaginationEnum::PAGE),
            $request->get("perPage", PaginationEnum::LIMIT),
            $filter
        );
        $resource = ModuleResource::collection($paginate);
        return $this->response($this->formatPagination($resource, $paginate), HttpStatusCodeEnum::OK);
    }
     /**
     * export
     *
     * @param  mixed $filter
     * @return void
     */
     public function export(ModuleFilter $filter)
    {
        $dataExport = $this->service->getDataExport($filter);
        return Excel::download(new ModuleExport($dataExport), 'modules.xlsx');
    }
    /**
     * showLookupData
     *
     * @param  mixed $request
     * @return JsonResponse
     */
    public function showLookupData(ModuleFilter $filter): JsonResponse
    {
        $resource = ModuleResource::collection($this->service->showLookupData($filter));
        return $this->response($resource, HttpStatusCodeEnum::OK);
    }
    /**
     * lookupPaginate
     *
     * @param  mixed $request
     * @param  mixed $filter
     * @return JsonResponse
     */
    public function lookupPaginate(Request $request, ModuleFilter $filter): JsonResponse
    {
        $paginator = $this->service->lookupPaginate($request->get('page', PaginationEnum::PAGE), $request->get('perPage', PaginationEnum::LIMIT), $filter);
        $resourceData = ModuleLookupResource::collection($paginator);
        return $this->response($this->formatPagination($resourceData, $paginator), HttpStatusCodeEnum::OK);
    }


    /**
     * mainFormAndModules
     *
     * @param  mixed $filter
     * @return JsonResponse
     */
    public function mainFormWithLastVersions(ModuleFilter $filter, int $projectId): JsonResponse
    {
        $resource = $this->service->mainFormWithLastVersions($projectId, $filter);
        return $this->response(MainFormAndModuleWithLastVersionResource::collection($resource),HttpStatusCodeEnum::OK);
    }

    /**
     * show
     *
     * @param  mixed $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $resource = new ModuleResource($this->service->firstOrFailBy(["id" => $id]));
        return $this->response($resource, HttpStatusCodeEnum::OK);
    }

    /**
     * updateModule
     *
     * @param  mixed $request
     * @param  mixed $id
     * @return void
     */
    function updateModule(ModuleRequest $request, $id): JsonResponse
    {
        $resource = new ModuleResource($this->service->updateModule($request->all(), $id));
        return $this->response($resource, HttpStatusCodeEnum::OK);
    }
    /**
     * updateOrderModule
     *
     * @param  mixed $request
     * @return JsonResponse
     */
    function updateOrderModule(UpdateOrderModuleRequest $request): JsonResponse
    {
        $resource = ModuleResource::collection($this->service->updateOrderModule($request->all()));
        return $this->response($resource, HttpStatusCodeEnum::OK);
    }
    /**
     * deleteModule
     *
     * @param  mixed $id
     * @return JsonResponse
     */
    public function deleteModule($id): JsonResponse
    {
        $this->service->deleteModule($id);
        return $this->response([], HttpStatusCodeEnum::OK);
    }
     /**
     * bulkDelete
     *
     * @param  mixed $request
     * @return JsonResponse
     */
    public function bulkDelete(ModuleRequestBulkDelete $request): JsonResponse
    {
        $this->service->bulkDelete($request->all());

        return $this->response([], HttpStatusCodeEnum::OK);
    }


}
