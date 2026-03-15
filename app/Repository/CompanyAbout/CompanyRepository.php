<?php

namespace App\Repository\CompanyAbout;

use App\Http\Filters\Filter;
use App\Models\CompanyAbout\Company;
use App\Repository\MainRepository;
use Illuminate\Database\Eloquent\Builder;

class CompanyRepository extends MainRepository
{


    /**
     * @return string
     */
    public function model(): string
    {
        return Company::class;
    }

    /**
     * index
     *
     * @param  mixed $page
     * @param  mixed $perPage
     * @param  mixed $filter
     * @return mixed
     */
    public function index(int $page, int $perPage, ?Filter $filter=null,bool $usePagination = true ):mixed
    {
        $query = $this->_joinInputOptionTable();

        $columns = ['companies.*', 'input_options.title as input_options_title', 'input_options.id as input_options_id'];
        if ($filter)  $query = $query->filter($filter);
        $query=$query->where("companies.is_hide",0)
           ->with(["field","keyContact","updatedBy","createdBy"])
            ->groupBy('companies.id');
        return $usePagination?$query->latest()->paginate($perPage, $columns, 'page', $page): $query->latest()->get();
    }

    /**
     * lookup
     *
     * @param  mixed $filter
     * @return mixed
     */
    public function lookup(?Filter $filter=null ):mixed
    {
        $query = $this->_joinInputOptionTable();

        if ($filter)  $query = $query->filter($filter);

        return $query->select('companies.*', 'input_options.title as input_options_title', 'input_options.id as input_options_id')
            ->groupBy('companies.id')
            ->where('companies.is_hide', 0)->latest()
            ->get();
    }
    /**
     * lookupPaginate
     *
     * @param  mixed $page
     * @param  mixed $perPage
     * @param  mixed $filter
     * @return mixed
     */
    public function lookupPaginate(int $page, int $perPage,?Filter $filter=null ):mixed
    {
        $query=$this->model;
        if ($filter)  $query = $query->filter($filter);
        return $query->where('companies.is_hide', 0)->latest()->paginate($perPage, ["*"], $page);
    }


    /**
     * @return Builder
     */
    protected function _joinInputOptionTable(): Builder
    {
        return $this->model->leftJoin('input_options', 'input_options.id', 'companies.company_filed');
    }

}

