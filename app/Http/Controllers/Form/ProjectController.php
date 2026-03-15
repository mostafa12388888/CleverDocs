<?php

namespace App\Http\Controllers\Form;

use App\Enum\HttpStatusCodeEnum;
use App\Enum\PaginationEnum;
use App\Exports\Form\ProjectExport;
use App\Http\Controllers\Controller;
use App\Http\Filters\Form\Project\ProjectFilter;
use App\Http\Requests\Form\AssignCompanyRequest;
use App\Http\Requests\Form\projectStoreRequest;
use App\Http\Requests\Form\projectUpdateRequest;
use App\Http\Resources\Form\ProjectDetailsResource;
use App\Http\Resources\Form\ProjectListResource;
use App\Http\Resources\Form\ProjectLokupResource;
use App\Http\Requests\Form\AssignProjectsToUserRequest;
use App\Http\Requests\Form\AssignProjectsToUsersRequest;
use App\Http\Requests\Form\ProjectRequestBulkDelete;
use App\Http\Requests\Form\AssignUserToProjectRequest;
use App\Services\Form\ProjectService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Throwable;

class ProjectController extends Controller
{

    /**
     * @var ProjectService
     */
    protected ProjectService $service;

    /**
     * __construct
     *
     * @param  mixed $service
     * @return void
     */
    public function __construct(ProjectService $service)
    {
        $this->service = $service;
    }

    /**
     * @param Request $request
     * @param ProjectFilter $filter
     * @return JsonResponse
     */
    public function index(Request $request, ProjectFilter $filter): JsonResponse
    {
        $paginator = $this->service->index($request->get('page', PaginationEnum::PAGE), $request->get('perPage', PaginationEnum::LIMIT), $filter);
        $resourceData = ProjectListResource::collection($paginator);
        return $this->response($this->formatPagination($resourceData, $paginator), HttpStatusCodeEnum::OK);
    }
    /**
     * lookupPaginate
     *
     * @param  mixed $request
     * @param  mixed $filter
     * @return JsonResponse
     */
    public function lookupPaginate(Request $request, ProjectFilter $filter): JsonResponse
    {
        $paginator = $this->service->lookupPaginate($request->get('page', PaginationEnum::PAGE), $request->get('perPage', PaginationEnum::LIMIT), $filter);
        $resourceData = ProjectLokupResource::collection($paginator);
        return $this->response($this->formatPagination($resourceData, $paginator), HttpStatusCodeEnum::OK);
    }
    /**
     * export
     *
     * @param  mixed $filter
     * @return void
     */
     public function export(ProjectFilter $filter)
    {
        $dataExport = $this->service->getDataExport($filter);
        return Excel::download(new ProjectExport($dataExport), 'projects.xlsx');
    }

    /**
     * lookupProject
     *
     * @param ProjectFilter $filter
     * @return JsonResponse
     */
    public function lookupProject(ProjectFilter $filter): JsonResponse
    {
        $resource = $this->service->lookupProject($filter);
        return $this->response(ProjectLokupResource::collection($resource), HttpStatusCodeEnum::OK);
    }

    /**
     * show
     *
     * @param mixed $id
     * @return JsonResponse
     * @throws \Throwable
     */
    public function show(int $id): JsonResponse
    {
        $resource = $this->service->firstOrFailBy(['id' => $id], [
            'company','contact','createdBy', 'updatedBy','wbs', 'inputOption','country','assignedUsers','assignedUsers.contact.company',
        ]);
        return $this->response(ProjectDetailsResource::make($resource), HttpStatusCodeEnum::OK);
    }
    /**
     * assignCompany
     *
     * @param  mixed $request
     * @return void
     */
    public function assignCompany(AssignCompanyRequest $request)
    {
        $resource = $this->service->assignCompany($request->all());
        return $this->response([], HttpStatusCodeEnum::OK);
    }

    /**
     * @param projectStoreRequest $request
     * @return JsonResponse
     * @throws Throwable
     */
    function storeProject(projectStoreRequest $request): JsonResponse
    {
        $resource = $this->service->storeProject($request->all());
        return $this->response(ProjectListResource::make($resource), HttpStatusCodeEnum::OK);
    }

    /**
     * @param projectUpdateRequest $request
     * @param $id
     * @return JsonResponse
     * @throws Throwable
     */
    function updateProject(projectUpdateRequest $request, $id): JsonResponse
    {
        $resource = $this->service->updateProject($request->all(), $id);
        return $this->response(ProjectListResource::make($resource), HttpStatusCodeEnum::OK);
    }


    /**
     * @param int $id
     * @return JsonResponse
     * @throws Throwable

     */
    public function delete(int $id): JsonResponse
    {
        $this->service->destroy($id);
        return $this->response([], HttpStatusCodeEnum::OK);
    }
    /**
     * bulkDelete
     *
     * @param  mixed $request
     * @return JsonResponse
     */
    public function bulkDelete(ProjectRequestBulkDelete $request): JsonResponse
    {
        $this->service->bulkDelete($request->all());
        return $this->response([], HttpStatusCodeEnum::OK);
    }      /**
     * assignProjectsToUser
     *
     * @param  mixed $request
     * @return JsonResponse
     */
    public function assignProjectsToUser(AssignProjectsToUserRequest $request): JsonResponse
     {
        $this->service->assignProjectsToUser($request->userId, $request->assignProjects);
        return $this->response([], HttpStatusCodeEnum::OK);
     }
    /**
     * assignProjectsToUsers
     *
     * @param  mixed $request
     * @return JsonResponse
     */
    public function assignProjectsToUsers(AssignProjectsToUsersRequest $request): JsonResponse
     {
        $this->service->assignProjectsToUsers($request->userIds, $request->assignProjects);
        return $this->response([], HttpStatusCodeEnum::OK);
     }
     /**
      * assignUsersToProject
      *
      * @return JsonResponse
      */
     public function assignUsersToProject(AssignUserToProjectRequest $request): JsonResponse
     {
        $this->service->assignUserToProject($request->projectId, $request->userIds);
        return $this->response([], HttpStatusCodeEnum::OK);

     }
}
