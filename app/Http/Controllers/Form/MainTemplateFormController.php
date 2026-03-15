<?php

namespace App\Http\Controllers\Form;

use App\Enum\HttpStatusCodeEnum;
use App\Enum\PaginationEnum;
use App\Exports\Form\MainTemplateFormExport;
use App\Http\Controllers\Controller;
use App\Http\Filters\Form\MainTemplateFormFilter;
use App\Http\Filters\Form\MainTemplateFormFilters;
use App\Http\Resources\MainTemplateForm\MainFormListResource;
use App\Http\Resources\MainTemplateForm\MainFormDetailsResource;
use App\Http\Resources\MainTemplateForm\MainFormAndModuleGroupLookupResource;
use App\Http\Resources\MainTemplateForm\MainTemplateFormLookupResource;
use App\Http\Resources\MainTemplateForm\MainTemplateFormSummaryResource;
use App\Services\Form\MainTemplateFormService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class MainTemplateFormController extends Controller
{

    /**
     * @var MainTemplateFormService
     */
    protected MainTemplateFormService $service;

    /**
     * @param MainTemplateFormService $service
     */
    public function __construct(MainTemplateFormService $service)
    {
        $this->service = $service;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request,MainTemplateFormFilter $filter): JsonResponse
    {
        $paginator = $this->service->allWithLastVersion(
            $request->get('page', PaginationEnum::PAGE),
            $request->get('perPage', PaginationEnum::LIMIT),
            $filter
        );
        $resourceData = MainFormListResource::collection($paginator);
        return $this->response($this->formatPagination($resourceData, $paginator), HttpStatusCodeEnum::OK);
    }
    /**
     * export
     *
     * @param  mixed $filter
     * @return void
     */
     public function export(MainTemplateFormFilter $filter)
    {
        $dataExport = $this->service->getDataExport($filter);
        return Excel::download(new MainTemplateFormExport($dataExport), 'main-forms.xlsx');
    }
    /**
     * lookup
     *
     * @param  mixed $filter
     * @return JsonResponse
     */
    public function lookup(MainTemplateFormFilter $filter)
    {
        $resource=$this->service->lookup($filter);
        // return $resource;
        return $this->response( MainFormAndModuleGroupLookupResource::collection($resource), HttpStatusCodeEnum::OK);
    }
    /**
     * lookupPaginate
     *
     * @param  mixed $request
     * @param  mixed $filter
     * @return JsonResponse
     */
    public function lookupPaginate(Request $request,MainTemplateFormFilter $filter): JsonResponse
    {
        $paginator=$this->service->lookupPaginate(
            $request->get('page', PaginationEnum::PAGE),
            $request->get('perPage', PaginationEnum::LIMIT),
            $filter);
        $resourceData = MainTemplateFormLookupResource::collection($paginator);
        return $this->response($this->formatPagination($resourceData, $paginator), HttpStatusCodeEnum::OK);
    }
    /**
     * summary
     *
     * @return JsonResponse
     */
    public function summary():JsonResponse
    {
        $result=$this->service->summary();
        return $this->response(MainTemplateFormSummaryResource::make($result), HttpStatusCodeEnum::OK);
    }


}
