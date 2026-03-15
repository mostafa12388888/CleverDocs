<?php

namespace App\Repository\Form;

use App\Http\Filters\Filter;
use App\Models\Form\Layout;
use App\Repository\MainRepository;

class LayoutRepository extends MainRepository
{

    /**
     * model
     *
     * @return string
     */
    public function model(): string
    {
        return Layout::class;
    }


    /**
     * index
     *
     * @param  mixed $filter
     * @param  mixed $page
     * @param  mixed $perPage
     * @return void
     */
    public function index(?Filter $filter = null, int $page, int $perPage , bool $usePagination = true):mixed
    {

        $query = $this->model;

        if ($filter) $query = $query->filter($filter);
        $query=$query->with("createdBy","updatedBy");
        return $usePagination?$query->latest()->paginate($perPage, ['*'], 'page', $page): $query->latest()->get();
    }
    /**
     * lookupPaginate
     *
     * @param  mixed $filter
     * @param  mixed $page
     * @param  mixed $perPage
     * @return mixed
     */
    public function lookupPaginate(?Filter $filter = null, int $page, int $perPage ):mixed
    {
        $query = $this->model;
        if ($filter) $query = $query->filter($filter);
        return $query->latest()->paginate($perPage, ['*'], 'page', $page);
    }
}
