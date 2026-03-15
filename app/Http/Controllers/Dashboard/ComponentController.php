<?php

namespace App\Http\Controllers\Dashboard;

use App\Enum\HttpStatusCodeEnum;
use App\Enum\PaginationEnum;
use App\Http\Controllers\Controller;
use App\Http\Filters\Dashboard\ComponentFilter;
use App\Http\Filters\FormSubmission\FormSubmissionFilter;
use App\Http\Requests\Dashboard\bulkDeleteComponentRequest;
use App\Http\Requests\Dashboard\ComponentRequest;
use App\Http\Resources\Dashboard\ComponentDetailsResource;
use App\Http\Resources\Dashboard\ComponentResource;
use App\Services\Dashboard\ComponentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ComponentController extends Controller
{

    /**
     * @var ComponentService
     */
    protected ComponentService $service;

    /**
     * @param ComponentService $service
     */
    public function __construct(ComponentService $service)
    {
        $this->service = $service;
    }
    public function getSubmissionData(Request $request): JsonResponse
    {
        $submissionData = $this->service->getSubmissionData($request->all());
        return $this->response($submissionData, HttpStatusCodeEnum::OK);
    }

    /**
     * index
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request, ComponentFilter $filter): JsonResponse
    {
        $paginator = $this->service->index(
            $request->get('page', PaginationEnum::PAGE),
            $request->get('perPage', PaginationEnum::LIMIT),
            $filter
        );
        $resourceData = ComponentResource::collection($paginator);

        return $this->response($this->formatPagination($resourceData, $paginator), HttpStatusCodeEnum::OK);
    }
    /**
     * lookup
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function lookup(ComponentFilter $filter)
    {
        $resource = $this->service->lookup($filter);
        return $this->response(ComponentResource::collection($resource), HttpStatusCodeEnum::OK);
    }
    /**
     * show
     *
     * @param  mixed $componentId
     * @return JsonResponse
     */
    public function show(int $componentId)
    {
        $resource = $this->service->firstOrFailBy(['id' => $componentId],["updatedBy", "createdBy", 'filters']);
        $filtersArray = $resource->filters->filter ?? [];

        $fakeRequest = new Request($filtersArray);

        $filterObject = new FormSubmissionFilter($fakeRequest);

         $statistics  = $this->service->componentChartLogic($filterObject, $resource->form_id, $resource->count_by, $resource->group_by);
        return $this->response(
            ComponentDetailsResource::make($resource, $statistics),
            HttpStatusCodeEnum::OK
        );
    }

    /**
     * store
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function store(ComponentRequest $request)
    {
        $component = $this->service->componentStore($request->all());
        return $this->response(ComponentResource::make($component), HttpStatusCodeEnum::OK);
    }
    /**
     * update
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(ComponentRequest $request, int $id)
    {
        $component = $this->service->componentUpdate($request->all(), $id);
        return $this->response(ComponentResource::make($component), HttpStatusCodeEnum::OK);
    }
    /**
     * destroy
     *
     * @param  mixed $id
     * @return JsonResponse
     */
    public function delete(int $id): JsonResponse
    {
        $this->service->deleteComponent($id);
        return  $this->response([], HttpStatusCodeEnum::OK);
    }
    /**
     * bulkDelete
     *
     * @param  mixed $request
     * @return JsonResponse
     */
    public function bulkDelete(bulkDeleteComponentRequest $request): JsonResponse
    {
        $this->service->bulkDelete($request->all());

        return $this->response([], HttpStatusCodeEnum::OK);
    }
}
