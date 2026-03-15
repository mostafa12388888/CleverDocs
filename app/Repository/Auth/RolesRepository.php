<?php

namespace App\Repository\Auth;

use App\Http\Filters\Filter;
use App\Models\Role;
use App\Repository\MainRepository;


class RolesRepository extends MainRepository
{
        /**
     * @return string
     */
    public function model(): string
    {
        return Role::class;
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

        $query = $this->model;
        if ($filter)  $query = $query->filter($filter);
        return  $query->select(['roles.id','roles.name','roles.key'])->latest()->paginate($perPage, ['*'], 'page', $page);
    }

}
