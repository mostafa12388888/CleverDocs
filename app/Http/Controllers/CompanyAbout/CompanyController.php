<?php

namespace App\Http\Controllers\CompanyAbout;

use App\Enum\HttpStatusCodeEnum;
use App\Enum\PaginationEnum;
use App\Exceptions\CanDeleteContentException;
use App\Exceptions\Company\CanDeleteCompanyHasContactException;
use App\Exports\CompanyAbout\CompanyExport;
use App\Http\Controllers\Controller;
use App\Http\Filters\Company\CompanyFilter;
use App\Http\Requests\Company\CompanyRequest;
use App\Http\Requests\Company\CompanyRequestBulkDelete;
use App\Http\Requests\Company\CompanyRequestUpdate;
use App\Http\Resources\Company\CompanyDetailsResource;

use App\Http\Resources\Company\CompanyListResource;
use App\Http\Resources\Company\CompanySummaryResource;
use App\Services\CompanyAbout\CompanyService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Throwable;

class CompanyController extends Controller
{
    /**
     * @var CompanyService
     */
    protected CompanyService $service;

    /**
     * @param CompanyService $service
     */

    public function __construct(CompanyService $service)
    {
        return $this->service = $service;
    }

    /**
     * index
     *
     * @param Request $request
     * @param CompanyFilter $filter
     * @return JsonResponse
     */
    public function index(Request $request,CompanyFilter $filter):JsonResponse
    {
        $paginator = $this->service->index(
            $request->get('page', PaginationEnum::PAGE),
            $request->get('perPage', PaginationEnum::LIMIT),
            $filter
        );
        $resourceData = CompanyListResource::collection($paginator);

        return $this->response($this->formatPagination($resourceData, $paginator), HttpStatusCodeEnum::OK);
    }
    /**
     * export
     *
     * @param  mixed $filter
     * @return void
     */
     public function export(CompanyFilter $filter)
    {
        $dataExport = $this->service->getDataExport($filter);
        return Excel::download(new CompanyExport($dataExport), 'companies.xlsx');
    }

    /**
     * lookup
     *
     * @param  mixed $filter
     * @return JsonResponse
     */
    public function lookup(CompanyFilter $filter):JsonResponse
    {
        $resource = $this->service->lookup($filter);

        return $this->response(CompanySummaryResource::collection($resource), HttpStatusCodeEnum::OK);
    }
    /**
     * lookupPaginate
     *
     * @param  mixed $request
     * @param  mixed $filter
     * @return JsonResponse
     */
    public function lookupPaginate(Request $request,CompanyFilter $filter):JsonResponse
    {
        $paginator = $this->service->lookupPaginate( $request->get('page', PaginationEnum::PAGE),
            $request->get('perPage', PaginationEnum::LIMIT),$filter);
        $resource=CompanySummaryResource::collection($paginator);
        return $this->response($this->formatPagination($resource, $paginator), HttpStatusCodeEnum::OK);
    }

    /**
     * view
     *
     * @param mixed $companyId
     * @return JsonResponse
     * @throws Throwable
     */
    public function view(int $companyId): JsonResponse
    {
        $resource = $this->service->firstOrFailBy(['id' => $companyId], ['keyContact']);
        return $this->response(CompanyDetailsResource::make($resource), HttpStatusCodeEnum::OK);
    }
    /**
     * summary
     *
     * @param  mixed $companyId
     * @return JsonResponse
     */
    public function summary(int $companyId): JsonResponse
    {
        $resource = $this->service->firstOrFailBy(['id' => $companyId], [],[], ['id', 'name']);
        return $this->response(CompanySummaryResource::make($resource), HttpStatusCodeEnum::OK);
    }

    /**
     * store
     *
     * @param mixed $request
     * @return JsonResponse
     * @throws Throwable
     */
    public function store(CompanyRequest $request): JsonResponse
    {
        $resource = $this->service->store($request->all());
        return $this->response(CompanyListResource::make($resource), HttpStatusCodeEnum::OK);
    }

    /**
     * update
     *
     * @param mixed $request
     * @param mixed $id
     * @return JsonResponse
     * @throws Throwable
     */
    public function update(CompanyRequestUpdate $request,int  $id): JsonResponse
    {
        $resource = $this->service->update($id, $request->all());
        return $this->response(CompanyListResource::make($resource), HttpStatusCodeEnum::OK);
    }


    /**
     * @param int $id
     * @return JsonResponse
     * @throws Throwable
     * @throws CanDeleteContentException
     */
    public function destroy(int $id): JsonResponse
    {
        $this->service->destroy($id);
        return $this->response([], HttpStatusCodeEnum::OK);
    }

    /**
     * @param CompanyRequestBulkDelete $request
     * @return JsonResponse
     * @throws Throwable
     * @throws CanDeleteCompanyHasContactException
     */
    public function bulkDelete(CompanyRequestBulkDelete $request): JsonResponse
    {
        $this->service->bulkDelete($request->all());

        return $this->response([], HttpStatusCodeEnum::OK);
    }
}
