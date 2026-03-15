<?php

namespace App\Repository\Form;

use App\Http\Filters\Filter;
use App\Models\Form\Project;
use App\Repository\MainRepository;


class ProjectRepository extends MainRepository {


    /**
     * model
     *
     * @return string
     */
    public function model():string
    {
        return Project::class;
    }
    /**
     * index
     *
     * @param  mixed $perPage
     * @param  mixed $page
     * @return mixed
     */
    public function index(int $page, int $perPage,?Filter $filter=null , bool $usePagination = true): mixed
    {
        $query = $this->_joinUserAssignProjects();

        if ($filter) $query = $query->filter($filter);
       $query= $query->groupBy("projects.id")
            ->select("user_assign_projects.user_id","projects.*")
            ->with([ 'company', 'contact', 'createdBy', 'createdBy.contact', 'updatedBy', 'updatedBy.contact', 'wbs','inputOption','country']);

        return $usePagination?$query->latest()->paginate($perPage, ['*'], 'page', $page):$query->latest()->get();
    }
    /**
     * lookupProject
     *
     */
    public function lookupProject(?Filter $filter=null){
        $query = $this->_joinUserAssignProjects();
        if ($filter) $query = $query->filter($filter);

        return $query
            ->with(['wbs', 'wbs.createdBy', 'wbs.updatedBy'])
            ->select("user_assign_projects.user_id as userAssignId","projects.*")
            ->groupBy("projects.id")->latest()
            ->get();
    }
    public function lookupPaginate(int $page, int $perPage,?Filter $filter=null , bool $usePagination = true): mixed
    {
        $query = $this->_joinUserAssignProjects();
        if ($filter) $query = $query->filter($filter);

        return $query
            ->with(['wbs', 'wbs.createdBy', 'wbs.updatedBy'])
            ->select("user_assign_projects.user_id as userAssignId","projects.*")
            ->groupBy("projects.id")->latest()->paginate($perPage, ['*'], 'page', $page);
    }

    /**
     * _joinUsers
     *
     * @return object
     */
    public function _joinUserAssignProjects(): object
    {
       return $this->model->leftJoin('user_assign_projects', 'user_assign_projects.project_id', '=', 'projects.id');
    }
}

