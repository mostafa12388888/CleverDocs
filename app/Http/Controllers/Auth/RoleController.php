<?php

namespace App\Http\Controllers\Auth;

use App\Enum\Authorization\PermissionEnum;
use App\Enum\Authorization\PermissionGroupEnum;
use App\Enum\HttpStatusCodeEnum;
use App\Enum\PaginationEnum;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Http\Filters\Report\AuditLogFilter;
use App\Http\Filters\Role\RoleFilter;
use App\Http\Requests\Auth\RolesRequest;
use App\Http\Resources\AuditLogResource;
use App\Http\Resources\Auth\Role\PermissionGroupResource;
use App\Http\Resources\Auth\Role\PermissionResource;
use App\Http\Resources\Auth\Role\RoleDetailsResource;
use App\Http\Resources\Auth\Role\RoleLookupResource;
use App\Http\Resources\Auth\Role\RoleResource;
use App\Services\Auth\RolesService;
use Illuminate\Http\JsonResponse;





use Illuminate\Http\RedirectResponse;

class RoleController extends Controller
{
    /**
     * @var RolesService
     */
    protected RolesService $service;

    /**
     * @param RolesService $roleService
     */
    public function __construct(RolesService $roleService)
    {
        $this->service = $roleService;
    }


    /**
     * index
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $role = $this->service->findAll();
        return $this->response(RoleResource::collection($role), HttpStatusCodeEnum::OK);
    }
    /**
     * lookupRolesPaginate
     *
     * @return JsonResponse
     */
    public function lookupRolesPaginate(Request $request, RoleFilter $filter ): JsonResponse
    {
        $paginator = $this->service->lookupRolesPaginate( $request->get('page', PaginationEnum::PAGE),$request->get('perPage', PaginationEnum::LIMIT),$filter);
            $resourceData = RoleLookupResource::collection($paginator);
        return $this->response($this->formatPagination($resourceData, $paginator), HttpStatusCodeEnum::OK);
    }
    /**
     * reportRole
     *
     * @param  mixed $request
     * @param  mixed $filter
     * @return JsonResponse
     */
    public function reportRole(Request $request, AuditLogFilter $filter): JsonResponse
    {
        $logs = $this->service->reportRole(
            $request->get("page", PaginationEnum::PAGE),
            $request->get("perPage", PaginationEnum::LIMIT),
            $filter
        );
        $resourceData = AuditLogResource::collection($logs);
        return $this->response($this->formatPagination($resourceData, $logs), HttpStatusCodeEnum::OK);
    }


    /**

     * Show the form for creating a new resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function getPermissions(): JsonResponse
    {
        return $this->response(PermissionGroupResource::collection(PermissionGroupEnum::GROUP_PERMISSION), HttpStatusCodeEnum::OK);
    }
    /**
     * lookupPermission
     *
     * @return JsonResponse
     */
    public function lookupPermission()
    {
        return $this->response(PermissionResource::collection(array_values(PermissionEnum::getLocalConstants())), HttpStatusCodeEnum::OK);
    }

    /**
     * store
     *
     * @param  mixed $request
     * @return JsonResponse
     */
    public function store(RolesRequest $request): JsonResponse
    {
        $role = $this->service->store($request->all());
        return $this->response(RoleResource::make($role), HttpStatusCodeEnum::OK);
    }

    /**
     * show
     *
     * @param  mixed $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        $role = $this->service->firstOrFailBy(["id" => $id], ["permissions"]);
        return $this->response(RoleDetailsResource::make($role), HttpStatusCodeEnum::OK);
    }

    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $id
     * @return JsonResponse
     */
    public function update(RolesRequest $request, $id): JsonResponse
    {
        $role = $this->service->updateRole($request->all(), $id);
        return $this->response(RoleResource::make($role), HttpStatusCodeEnum::OK);
    }

    /**
     * destroy
     *
     * @param  mixed $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $this->service->destroy($id);
        return $this->response([], HttpStatusCodeEnum::OK);
    }
}
