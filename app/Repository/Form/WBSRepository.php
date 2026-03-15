<?php

namespace App\Repository\Form;

use App\Http\Filters\Filter;
use App\Models\Form\Module;
use App\Models\Form\Project;
use App\Models\Form\WBS;
use App\Repository\MainRepository;

class WBSRepository extends MainRepository
{


    /**
     * @return string
     */
    public function model(): string
    {
        return WBS::class;
    }
    /**
     * index
     *
     * @param  mixed $perPage
     * @param  mixed $page
     * @return mixed
     */
    public function index(int $perPage, int $page,?Filter $filter=null): mixed
    {
        $query=$this->model->with('chiles','updatedBy','createdBy')->withCount(['projects']);
        if($filter){
            $query= $query->filter($filter);
            // Apply filter to children if they exist
            // @TODO: eng omer check this
            if ($this->model->chiles()->exists())
            $query= $query->whereHas('chiles', function ($childQuery) use ($filter) {
                 return $childQuery->filter($filter);
            });
        }
        return $query->whereNull("w_b_s.w_b_s_id")->groupBy("w_b_s.id")->latest()->paginate($page, '*', 'page', $perPage);
    }
    /**
     * lookupPaginate
     *
     * @param  mixed $perPage
     * @param  mixed $page
     * @param  mixed $filter
     * @return mixed
     */
    public function lookupPaginate(int $perPage, int $page,?Filter $filter=null): mixed
    {
        $query=$this->model->withCount(['projects']);
        if($filter){
            $query= $query->filter($filter);
            // Apply filter to children if they exist
            // @TODO: eng omer check this
            if ($this->model->chiles()->exists())
            $query= $query->whereHas('chiles', function ($childQuery) use ($filter) {
                 return $childQuery->filter($filter);
            });
        }
        return $query->whereNull("w_b_s.w_b_s_id")->groupBy("w_b_s.id")->latest()->paginate($page, '*', 'page', $perPage);
    }
   public function export(?Filter $filter=null): mixed
    {
        $query=$this->model->withCount('projects');
        if($filter) $query= $query->filter($filter);
            return $query->whereNull("w_b_s.w_b_s_id")->groupBy("w_b_s.id")->latest()->get();
   }

}
