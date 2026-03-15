<?php

namespace App\Repository\Form\CustomOption;

use App\Http\Filters\Filter;
use App\Models\Form\CustomOption\CustomOptionList;
use App\Repository\MainRepository;

class CustomOptionListRepository extends MainRepository{


    /**
     * model
     *
     * @return string
     */
    public function model(): string
    {
        return CustomOptionList::class;
    }
    /**
     * index
     *
     * @param  mixed $page
     * @param  mixed $perPage
     * @return void
     */
    public function index( ?Filter $filter  ,int $page, int $perPage , bool $usePagination = true){
        $query = $this->model;

        if ($filter)  $query = $query->filter($filter);
        $query=$query->select('custom_option_lists.*')->groupBy("custom_option_lists.id")->with("updatedBy","createdBy");
        return $usePagination?$query->latest()->paginate($perPage, ['*'], 'page', $page): $query->latest()->get();    }
    /**
     * lookup
     *
     * @param  mixed $filter
     * @return void
     */
    public function lookup(?Filter $filter){
        $query = $this->model;

        if ($filter)  $query = $query->filter($filter);
        return $query->select("custom_option_lists.*")->groupBy("custom_option_lists.id")->latest()->get();
    }
    public function lookupPaginate( ?Filter $filter  ,int $page, int $perPage , bool $usePagination = true){
        $query = $this->model;

        if ($filter)  $query = $query->filter($filter);
        $query=$query->select('custom_option_lists.*')->groupBy("custom_option_lists.id");
        return $usePagination?$query->latest()->paginate($perPage, ['*'], 'page', $page): $query->latest()->get();    }
}
