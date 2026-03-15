<?php

namespace App\Http\Controllers\Dashboard;

use App\Enum\HttpStatusCodeEnum;
use App\Enum\PaginationEnum;
use App\Http\Controllers\Controller;
use App\Http\Filters\Dashboard\DashboardFilter;
use App\Http\Requests\Dashboard\bulkDeleteDashboardRequest;
use App\Http\Requests\Dashboard\DashboardRequest;
use App\Http\Resources\Dashboard\DashboardResource;
use App\Http\Resources\Dashboard\DashboardDetailsResource;
use App\Services\Dashboard\DashboardService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * @var DashboardService
     */
    protected DashboardService $service;

    /**
     * @param DashboardService $service
     */

    public function __construct(DashboardService $service)
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
    public function index(Request $request, DashboardFilter $filter): JsonResponse
    {
        $paginator = $this->service->index(
            $request->get('page', PaginationEnum::PAGE),
            $request->get('perPage', PaginationEnum::LIMIT),
            $filter
        );
        $resourceData = DashboardResource::collection($paginator);

        return $this->response($this->formatPagination($resourceData, $paginator), HttpStatusCodeEnum::OK);
    }
    /**
     * lookupDashboard
     *
     * @param  mixed $filter
     * @return JsonResponse
     */
    public function lookupDashboard(DashboardFilter $filter): JsonResponse
    {
        $resource = $this->service->lookup($filter);
        return $this->response(DashboardResource::collection($resource), HttpStatusCodeEnum::OK);
    }
    /**
     * show
     *
     * @param  mixed $dashboardId
     * @return JsonResponse
     */
    public function show(int $dashboardId): JsonResponse
    {
        $resource = $this->service->firstOrFailBy(['id' => $dashboardId],["updatedBy","createdBy"]);
        return $this->response(DashboardDetailsResource::make($resource), HttpStatusCodeEnum::OK);
    }
    /**
     * storeDashboard
     *
     * @param  mixed $request
     * @return void
     */
    public function storeDashboard(DashboardRequest $request)
    {
        $resource = $this->service->dashboardStore($request->all());
        return $this->response(DashboardResource::make($resource), HttpStatusCodeEnum::OK);
    }
    /**
     * updateDashboard
     *
     * @param  mixed $request
     * @param  mixed $id
     * @return void
     */
    public function updateDashboard(DashboardRequest $request, $id)
    {
        $resource = $this->service->dashboardUpdate($request->all(), $id);
        return $this->response(DashboardResource::make($resource), HttpStatusCodeEnum::OK);
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
        $this->service->deleteDashboard($id);
        return  $this->response([], HttpStatusCodeEnum::OK);
    }
         /**
     * bulkDelete
     *
     * @param  mixed $request
     * @return JsonResponse
     */
    public function bulkDelete(bulkDeleteDashboardRequest $request): JsonResponse
    {
        $this->service->bulkDelete($request->all());

        return $this->response([], HttpStatusCodeEnum::OK);
    }
}
