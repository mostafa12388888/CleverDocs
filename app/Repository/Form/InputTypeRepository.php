<?php

namespace App\Repository\Form;

use App\Http\Filters\Filter;
use App\Models\Form\InputType;
use App\Repository\MainRepository;

class InputTypeRepository extends MainRepository
{

    /**
     * model
     *
     * @return string
     */
    public function model(): string
    {
        return InputType::class;
    }

    /**
     * index
     *
     * @param  mixed $page
     * @param  mixed $perPage
     * @return mixed
     */
    public function index(?Filter $filter=null,int $page,int $perPage , bool $usePagination = true):mixed
    {
        $query=$this->model;
        if($filter)$query=$query->filter($filter);
        $query=$query->with("updatedBy","createdBy");
        return $usePagination? $query->latest()->paginate($perPage, ['*'], 'page', $page): $query->latest()->get();    }
    /**
     * lookupPaginate
     *
     * @param  mixed $filter
     * @param  mixed $page
     * @param  mixed $perPage
     * @param  mixed $usePagination
     * @return mixed
     */
    public function lookupPaginate(?Filter $filter=null,int $page,int $perPage ):mixed
    {
        $query=$this->model;
        if($filter)$query=$query->filter($filter);
        return $query->latest()->paginate($perPage, ['*'], 'page', $page);
     }
    /**
     * categories
     *
     * @param  mixed $filter
     * @return mixed
     */
    public function categories(?Filter $filter=null):mixed
    {
        $query=$this->model;
        if($filter)$query=$query->filter($filter);
        return $query->with("updatedBy","createdBy")->get();
    }

}
