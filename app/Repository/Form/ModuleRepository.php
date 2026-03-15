<?php

namespace App\Repository\Form;

use App\Http\Filters\Filter;
use App\Http\Filters\Module\ModuleFilter;
use App\Models\Form\Module;
use App\Repository\MainRepository;
use Illuminate\Database\Eloquent\Relations\Relation;

use function Symfony\Component\VarDumper\Dumper\esc;

class ModuleRepository extends MainRepository
{

    /**
     * model
     *
     * @return string
     */
    public function model(): string
    {
        return Module::class;
    }

    /**
     * index
     *
     * @param  mixed $page
     * @param  mixed $perPage
     * @return mixed
     */
    public function index(int $page, int $perPage, ?Filter $filter = null, bool $usePagination = true): mixed
    {
        $query=$this->model;
        if($filter) $query=$query->filter($filter);
        $query= $query->with("updatedBy","createdBy");
        return $usePagination? $query->latest()->paginate($perPage, '*', 'page', $page):$query->latest()->get();
    }
    /**
     * showLookupData
     *
     * @return mixed
     */
    public function showLookupData(?Filter $filter = null): mixed
    {
        $query=$this->model;
        if($filter) $query=$query->filter($filter);
        return $query->latest()->get();
    }

    public function lookupPaginate(int $page, int $perPage, ?Filter $filter = null): mixed
    {
        $query=$this->model;
        if($filter) $query=$query->filter($filter);
        return $query->latest()->paginate($perPage, ['*'], 'page', $page);
    }

    /**
     * @param int $projectId
     * @param Filter|null $filter
     * @return mixed
     */
    public function mainFormWithLastVersions(int $projectId, ?Filter $filter = null): mixed
    {
        $query = $this->model
            ->leftJoin('main_template_forms', 'main_template_forms.module_id', '=', 'modules.id')
            ->leftJoin('templates_forms', function ($join) {$join->on('templates_forms.main_template_form_id', '=', 'main_template_forms.id')
                ->where('templates_forms.status', 'active');
            })->leftJoin('templates_form_projects', 'templates_form_projects.templates_form_id', '=', 'templates_forms.id')
            ->where('templates_form_projects.project_id', $projectId)
            ->whereRaw('templates_forms.version = (
            SELECT MAX(tf2.version)
            FROM templates_forms AS tf2
            WHERE tf2.main_template_form_id = main_template_forms.id
        )')
            ->select(
                'modules.id as module_id',
                'modules.name as module_name',
                'main_template_forms.id as main_form_id',
                'main_template_forms.name as main_form_name',
                'templates_forms.id as form_version_id',
                'templates_forms.name as form_name',
                'templates_forms.version as form_version'
            );

        if ($filter)  $query = $query->filter($filter);
        return $query->get();
    }
}
