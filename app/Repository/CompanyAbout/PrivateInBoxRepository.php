<?php
namespace App\Repository\CompanyAbout;

use App\Http\Filters\Filter;
use App\Models\CompanyAbout\PrivateInBox;
use App\Repository\MainRepository;

class PrivateInBoxRepository extends MainRepository
{
    /**
     * model
     *
     * @return string
     */
    public function model(): string
    {
        return PrivateInBox::class;
    }
     /**
     * index
     *
     * @param  mixed $page
     * @param  mixed $perPage
     * @return mixed
     */
    public function index(int $page,int $perPage,?Filter  $filter=null , bool $usePagination = true):mixed
    {
        $query=$this->model->select('private_in_boxes.*')->withResolvedName()->with("fromContact","project");

        if($filter) $query=$query->filter($filter);
        return  $usePagination? $query->latest()->paginate($perPage,"*","page",$page): $query->latest()->get();    }
    /**
     * lookupPaginate
     *
     * @param  mixed $page
     * @param  mixed $perPage
     * @param  mixed $filter
     * @return mixed
     */
    public function lookupPaginate(int $page, int $perPage ,?Filter $filter=null): mixed
    {
        $query=$this->model;
        if(isset($filter)) $query= $query->filter($filter);
        return $query->latest()->paginate($perPage, ['*'], 'page', $page);
        }



}
