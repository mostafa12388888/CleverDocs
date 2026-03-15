<?php

namespace App\Services\Auth;

use App\Http\Filters\Filter;
use App\Repository\Auth\RolesRepository;
use App\Repository\MainRepository;
use App\Services\AuditLogService;
use App\Services\MainService;
use Illuminate\Support\Str;
class RolesService extends MainService
{
    /**
     * @var RolesRepository
     */
    protected MainRepository $repository;

    /**
     * @param RolesRepository $repository
     */
    public function __construct(RolesRepository $repository)
    {
        $this->repository = $repository;
        parent::__construct($repository);
    }
    /**
     * lookupRolesPaginate
     *
     * @param  mixed $page
     * @param  mixed $perPage
     * @param  mixed $filter
     * @return mixed
     */
    public function lookupRolesPaginate(int $page, int $perPage, ?Filter $filter = null): mixed
    {

        return  $this->repository->lookupRolesPaginate($page,$perPage,$filter);
    }



    /**
     * store
     *logging
     * @param  mixed $data
     * @return mixed
     */
    public function store(array $data): mixed
    {
        return $this->applyTransaction(function () use ($data) {
              $role = $this->add([
                'name' => json_encode($data['name']),
                "key"=>Str::uuid(),
                "created_by"=>auth()->id()
                ]);
            $role->syncPermissions($data['permissions']);
            app(AuditLogService::class)->log('create', "Role", $role->id, null, [json_decode($role->name)],null,['permissions' => $data['permissions'] ?? []]);
            return $role;
        });
    }

    public function updateRole(array $data, $id): mixed
    {
        $role = $this->findOrFail($id);

        return $this->applyTransaction(function () use ($data, $role) {
            $oldPermissions = $role->permissions->pluck('name')->sort()->values()->toArray();
            $newPermissions = collect($data['permissions'] ?? [])->sort()->values()->toArray();
            $isNameChanged = $role->name !== json_encode($data['name']);
            $isPermissionsChanged = $oldPermissions !== $newPermissions;
            if (! $isNameChanged && ! $isPermissionsChanged)
                return $role;
            $role->update([
                'name' => json_encode($data['name']),
                "updated_by"=>auth()->id()
            ]);
            $role->syncPermissions($newPermissions);
            app(AuditLogService::class)->log(
                'update',
                "Role",
                $role->id,
                oldValue: [json_decode($role->name)],
                newValue: [json_decode($role->fresh()->name)],
                oldRelated: ['permissions' => $oldPermissions],
                newRelated: ['permissions' => $role->permissions->pluck('name')->sort()->values()->toArray()],

            );
            return $role;
        });
    }
    /**
     * reportRole
     *
     * @param  mixed $page
     * @param  mixed $perPage
     * @param  mixed $moduleType
     * @param  mixed $filter
     * @return mixed
     */
    public function reportRole(int $page, int $perPage, ?Filter $filter = null): mixed
    {
       return app(AuditLogService::class)->index($page, $perPage, "Role", $filter);
    }
    public function destroy($id):mixed
    {
        $role=$this->findOrFail($id);
        $this->update($role->id,["deleted_by"=>auth()->id()]);
        return $this->deleteOne($role->id);
    }
}
