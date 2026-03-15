<?php
namespace App\Repository\CompanyAbout;

use App\Http\Filters\Filter;
use App\Models\CompanyAbout\Contact;
use App\Repository\MainRepository;

class ContactRepository extends MainRepository
{

    public function model(): string
    {
       return  Contact::class;
    }

    /**
     * index
     *
     * @param  mixed $perPage
     * @param  mixed $page
     * @return mixed
     */
    public function index(int $page, int $perPage ,?Filter $filter=null,bool $usePagination = true): mixed
    {
        $query=$this->model;

        if(isset($filter)) $query= $query->filter($filter);
        $query=$query->where("contacts.is_hide",0)->with("user","updatedBy","createdBy");
        return $usePagination?$query->latest()->paginate($perPage, ['*'], 'page', $page): $query->latest()->get();    }
    /**
     * lookup
     *
     * @param  mixed $filter
     * @return mixed
     */
    public function lookup(?Filter $filter=null):mixed
    {
        $query=$this->model;
        if($filter || $filter==0) $query= $query->filter($filter);
        return $query->latest()->get();
    }
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
        return $query->where("contacts.is_hide",0)->latest()->paginate($perPage, ['*'], 'page', $page);
        }

}

