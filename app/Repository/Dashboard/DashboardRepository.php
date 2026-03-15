<?php

namespace App\Repository\Dashboard;

use App\Http\Filters\Filter;
use App\Models\Dashboard\Dashboard;
use App\Repository\MainRepository;
use Illuminate\Database\Eloquent\Builder;

class DashboardRepository extends MainRepository
{


    /**
     * @return string
     */
    public function model(): string
    {
        return Dashboard::class;
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
        $query = $this->model->with("users", "updatedBy", "createdBy");
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
        $query = $this->model->with("users", "updatedBy", "createdBy");
        if($filter || $filter==0) $query= $query->filter($filter);
        return $query->get();
    }
}
