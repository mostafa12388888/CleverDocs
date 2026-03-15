<?php

namespace App\Repository\Workflow;

use App\Http\Filters\Filter;
use App\Models\Workflow\MainWorkflow;
use App\Repository\MainRepository;
use Illuminate\Database\Eloquent\Builder;

class MainWorkflowRepository extends MainRepository
{
    /**
     * @return string
     */
    public function model(): string
    {
        return MainWorkflow::class;
    }


    /**
     * @param int $page
     * @param int $perPage
     * @param Filter|null $filter
     * @return mixed
     */
    public function allWithLastVersion(int $page, int $perPage,?Filter $filter=null ,bool $usePagination = true): mixed
    {
        $query = $this->model->select(['main_workflows.*'])
            ->with(['lastVersion', 'lastVersion.createdBy', 'lastVersion.createdBy.contact','project']);

        if ($filter) {
            $query = $query->whereHas('lastVersion', function (Builder $query) use ($filter) {
                $filter->apply($query);
            });
        }

        return $usePagination ? $query->latest()->paginate($perPage, ['*'], 'page', $page) : $query->latest()->get();    }
    /**
     * lookupPaginate
     *
     * @param  mixed $page
     * @param  mixed $perPage
     * @param  mixed $filter
     * @return mixed
     */
    public function lookupPaginate(int $page, int $perPage,?Filter $filter=null): mixed
    {
        $query = $this->model->select(['main_workflows.*'])->with(['lastVersion','project']);
        if ($filter) {
            $query = $query->whereHas('lastVersion', function (Builder $query) use ($filter) {
                $filter->apply($query);
            });
        }
        return $query->latest()->paginate($perPage, ['*'], 'page', $page);
     }

    public function formWithWorkFlow(int $page, int $perPage,?Filter $filter=null): mixed
    {
            $query = $this->model->select(['main_workflows.*'])
                ->with(['lastVersion','lastVersion','lastVersion.mainForm.lastVersion']);
            if ($filter) {
                $query = $query->whereHas('lastVersion', function (Builder $query) use ($filter) {
                    $filter->apply($query);
                });}
            return $query->latest()->paginate($perPage, ['*'], 'page', $page);
    }


}

