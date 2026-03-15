<?php

namespace App\Http\Filters\Module;

use App\Http\Filters\MainFilter;
use Illuminate\Contracts\Database\Eloquent\Builder;

class ModuleFilter extends MainFilter
{

    function search(mixed $value = null): Builder
    {
        if (!$value) return $this->builder;


        return $this->builder->where('modules.name', 'LIKE', '%' . $value . '%');
    }
    /**
     * projectId
     *
     * @param  mixed $value
     * @return Builder
     */
    public function projectId(mixed $value = null): Builder
    {
        if (!$value) return $this->builder;

        if (!$this->isJoined($this->builder, "templates_forms"))
            $this->_joinTemplateForm();

        if (!$this->isJoined($this->builder, "templates_forms.templates_form_projects"))
            $this->_joinTemplateFormProject();

        return $this->builder->where('templates_form_projects.project_id', $value);

    }
    /**
     * name
     *
     * @param  mixed $value
     * @return Builder
     */
    public function name(mixed $value = null): Builder
    {
        if (!$value) return $this->builder;

        return $this->builder->where('modules.name', 'like', "%".$value."%");
    }
    /**
     * updateAt
     *
     * @param  mixed $value
     * @param  mixed $columnName
     * @return Builder
     */
    public function updatedAt(?string $startDate = null, ?string $endDate = null, string $columnName = 'modules.updated_at'): Builder
    {
        return parent::updatedAt($startDate, $endDate, $columnName);
    }

    /**
     * createdAt
     *
     * @param  mixed $value
     * @param  mixed $columnName
     * @return Builder
     */
    public function createdAt(?string $startDate = null, ?string $endDate = null, string $columnName = 'modules.created_at'): Builder
    {

    return parent::createdAt($startDate, $endDate, $columnName);
    }




    public function _joinTemplateForm(): void
    {
        $this->builder->join('templates_forms', 'templates_forms.main_template_form_id', '=', 'main_template_forms.id');
    }
    public function _joinTemplateFormProject(): void
    {
        $this->builder->join('templates_form_projects', 'templates_form_projects.templates_form_id', '=', 'templates_forms.id');
    }

    /**
     * _joinTemplateFormAndProject
     *
     * @return void
     */
    public function _joinTemplateFormAndProject()
    {
        $this->builder->join('templates_forms', 'templates_forms.main_template_form_id', '=', 'main_template_forms.id');
        $this->builder->join('templates_form_projects', 'templates_form_projects.templates_form_id', '=', 'templates_forms.id');
    }
}
