<?php

namespace App\Repository\Dashboard;

use App\Http\Filters\Filter;
use App\Models\Dashboard\Component;
use App\Repository\MainRepository;

class ComponentRepository extends MainRepository
{


    /**
     * @return string
     */
    public function model(): string
    {
        return Component::class;
    }
    /**
     * index
     *
     * @param  mixed $page
     * @param  mixed $perPage
     * @param  mixed $filter
     * @return mixed
     */
    public function index(int $page, int $perPage, ?Filter $filter = null): mixed
    {
        $query = $this->model->with("updatedBy", "createdBy");
        if (isset($filter)) $query = $query->filter($filter);
        $query = $query;
        return $query->paginate($perPage, ['*'], 'page', $page);
    }
    /**
     * lookup
     *
     * @param  mixed $filter
     * @return mixed
     */
    public function lookup(?Filter $filter=null):mixed
    {
        $query = $this->model->with( "updatedBy", "createdBy");
        if($filter || $filter==0) $query= $query->filter($filter);
        return $query->get();
    }
}
