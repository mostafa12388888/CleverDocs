<?php
namespace App\Repository\Distribution;

use App\Http\Filters\Filter;
use App\Models\Distribution\DistributionLists;
use App\Repository\MainRepository;

class DistributionListRepository extends MainRepository{

    /**
     * model
     *
     * @return string
     */
    public function model(): string
    {
        return DistributionLists::class;
    }

    /**
     * index
     *
     * @param  mixed $page
     * @param  mixed $perPage
     * @return mixed
     */
    public function index(int $page,int $perPage,?Filter $filter=null ,bool $usePagination = true):mixed
    {
        $query=$this->model;

        if($filter) $query=$query->filter($filter);
        $query=$query->select('distribution_lists.*')->with('contacts', 'action',"updatedBy","createdBy");
        return $usePagination? $query->latest()->paginate($perPage,"*","page",$page): $query->latest()->get();
    }
    /**
     * lookupPaginate
     *
     * @param  mixed $page
     * @param  mixed $perPage
     * @param  mixed $filter
     * @return mixed
     */
    public function lookupPaginate(int $page,int $perPage,?Filter $filter=null):mixed
    {
        $query=$this->model;
        if($filter) $query=$query->filter($filter);
        return  $query->select('distribution_lists.*')->latest()->paginate($perPage,"*","page",$page);
    }


}
