<?php

namespace App\Repository\Form;

use App\Http\Filters\Filter;
use App\Models\Form\MainTemplateForm;
use App\Repository\MainRepository;
use Illuminate\Database\Eloquent\Builder;

class MainTemplateFormRepository extends MainRepository
{

    /**
     * @return string
     */
    public function model(): string
    {
        return MainTemplateForm::class;
    }

    /**
     * @param int $page
     * @param int $perPage
     * @param array $columns
     * @param array $with
     * @param array $withCount
     * @return mixed
     */
    public function allPaginated(int $page, int $perPage, array $columns = ["*"], array $with = [], array $withCount = []): mixed
    {
        return $this->model
            ->select($columns)
            ->with($with)
            ->withCount($withCount)
            ->latest()->paginate($perPage, $columns, 'page', $page);
    }


    /**
     * @param int $page
     * @param int $perPage
     * @return mixed
     */
    public function allWithLastVersion(int $page, int $perPage,?Filter $filter=null , bool $usePagination = true): mixed
    {
        $query = $this->model->select(['main_template_forms.*'])
        ->with(['lastVersion', 'lastVersion.createdBy', 'lastVersion.createdBy.contact','lastVersion.workflows.workflows']);

    if ($filter) {
        $query = $query->whereHas('lastVersion', function (Builder $query) use ($filter) {
            $filter->apply($query);
        });
    }

     return $usePagination? $query->latest()->paginate($perPage, ['*'], 'page', $page): $query->latest()->get();
    }
    public function lookupPaginate(int $page, int $perPage,?Filter $filter=null , bool $usePagination = true): mixed
    {
        $query = $this->model->select(['main_template_forms.*'])->with(['lastVersion']);
    if ($filter) {
        $query = $query->whereHas('lastVersion', function (Builder $query) use ($filter) {
            $filter->apply($query);
         });}

     return $usePagination? $query->paginate($perPage, ['*'], 'page', $page): $query->get();
    }
    /**
     * lookup
     *
     * @param  mixed $filter
     * @return mixed
     */
    public function lookup(?Filter $filter=null): mixed
    {
        $query = $this->model->select(['main_template_forms.*'])
        ->with(['lastVersion','modules']);

    if ($filter) {
        $query = $query->whereHas('lastVersion', function (Builder $query) use ($filter) {
            $filter->apply($query);
        });
    }

    return $query->latest()->get();

    }
    public function summary(): mixed
    {
        return $this->model
            ->with(['templateForms'])
            ->first();
    }

    public function allLastFormVersionInputs(int $mainTemplateId): mixed
    {
        $mainTemplateWithData=  $this->model->findOrFail($mainTemplateId)?->load('lastVersion.templateInputs.templateType');

        $allTemplateTypes =  $mainTemplateWithData?->lastVersion?->templateInputs?->map(function($input){
            return $input?->templateType;
        });

        return  $allTemplateTypes?->filter(function($type){
            return $type != null;
        });


    }


}

