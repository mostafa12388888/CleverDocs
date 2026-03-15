<?php

namespace App\Http\Filters\Form;

use App\Http\Filters\MainFilter;
use Illuminate\Database\Eloquent\Builder;

class MainTemplateFormFilter extends MainFilter
{
    /**
     * Search method
     *
     * @param mixed $value
     * @return Builder
     */
    public function search(mixed $value = null): Builder
    {
        if (!$value) return $this->builder;
        if (!$this->isJoined($this->builder, 'templates_form_projects')) $this->_joinTemplateFormProject();

        return $this->builder->where(function ($query) use ($value) {
            $query->where('main_template_forms.name', 'like', '%' . $value . '%')
                ->orWhere('templates_forms.version', $value);
        });
    }

    /**
     * Filter by name
     *
     * @param mixed $value
     * @return Builder
     */
    public function name(mixed $value = null): Builder
    {
        if (!$value) return $this->builder;
        return $this->builder->where('main_template_forms.name', 'like', '%' . $value . '%');
    }

    /**
     * Filter by moduleId
     *
     * @param mixed $value
     * @return Builder
     */
    public function moduleId(mixed $value = null): Builder
    {
        if (!$value) return $this->builder;
        return $this->builder->where('main_template_forms.module_id', $value);
    }

    /**
     * Filter by status
     *
     * @param mixed $value
     * @return Builder
     */
    public function status(mixed $value = null): Builder
    {
        if (!$value) return $this->builder;
        return $this->builder->where('templates_forms.status', $value);
    }


    /**
     * workflowIds
     *
     * @param  mixed $value
     * @return Builder
     */
    public function hasWorkflow(mixed $value = null): Builder
    {
        if (!$value) return $this->builder;
        if($value==2)return $this->builder->whereDoesntHave('workflows.workflows');
        return $this->builder->whereHas('workflows.workflows');

    }
    /**
     * Filter by projectId
     *
     * @param mixed $value
     * @return Builder
     */
    public function projectId(mixed $value = null): Builder
    {
        if (!$value) return $this->builder;
        if (!$this->isJoined($this->builder, 'templates_form_projects')) $this->_joinTemplateFormProject();

        return $this->builder->where('templates_form_projects.project_id', $value);
    }

    /**
     * Filter by layout
     *
     * @param mixed $value
     * @return Builder
     */
    public function layout(mixed $value = null): Builder
    {
        if (!$value) return $this->builder;
        return $this->builder->where('templates_forms.layout', $value);
    }

    /**
     * Filter by primary
     *
     * @param mixed $value
     * @return Builder
     */
    public function primary(mixed $value = null): Builder
    {
        if (!$value) return $this->builder;
        return $this->builder->where('templates_forms.primary', $value);
    }

    /**
     * Filter by updatedAt
     *
     * @param string $value
     * @param string $columnName
     * @return Builder
     */
    public function updatedAt(?string $startDate = null, ?string $endDate = null, string $columnName = 'templates_forms.updated_at'): Builder
    {
        return parent::updatedAt($startDate, $endDate, $columnName);
    }


    /**
     * Filter by createdAt
     *
     * @param string $value
     * @param string $columnName
     * @return Builder
     */
    public function createdAt(?string $startDate = null, ?string $endDate = null, string $columnName = 'templates_forms.created_at'): Builder
    {

    return parent::createdAt($startDate, $endDate, $columnName);
    }

    /**
     * Filter by createdBy
     *
     * @param string $value
     * @param string $columnName
     * @return Builder
     */
    public function createdBy(string $value, string $columnName = 'templates_forms.created_by'): Builder
    {
        return parent::createdBy($value, $columnName);
    }

    /**
     * Filter by updatedBy
     *
     * @param string $value
     * @param string $columnName
     * @return Builder
     */
    public function updatedBy(string $value, string $columnName = 'templates_forms.updated_by'): Builder
    {
        return parent::updatedBy($value, $columnName);
    }
    /**
     * _joinUsers
     *
     * @return void
     */
    public function _joinTemplateFormProject(): void
    {
        $this->builder->leftJoin('templates_form_projects', 'templates_form_projects.templates_form_id', '=', 'templates_forms.id');
    }

}
