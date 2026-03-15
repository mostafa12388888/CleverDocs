<?php

namespace App\Http\Filters\Workflow;

use App\Http\Filters\MainFilter;
use Illuminate\Database\Eloquent\Builder;

class MainWorkflowFilter extends MainFilter
{
    /**
     * Search method
     *
     * @param mixed $value
     * @return Builder
     */
    public function search(mixed $value = null): Builder
    {
        // TODO: Implement business search logic
        return $this->builder;
    }

    /**
     * Filter by title
     *
     * @param mixed $value
     * @return Builder
     */
    public function title(mixed $value = null): Builder
    {
        return  $this->builder->where('workflows.title', 'LIKE', '%' . $value . '%');
    }
    /**
     * isActive
     *
     * @param  mixed $value
     * @return Builder
     */
    public function isActive(mixed $value = null): Builder
    {
        return  $this->builder->where('workflows.is_active', $value);
    }
    /**
     * isAutoClose
     *
     * @param  mixed $value
     * @return Builder
     */
    public function isAutoClose(mixed $value = null): Builder
    {
        return  $this->builder->where('workflows.is_auto_close', $value);
    }
    /**
     * slaValue
     *
     * @param  mixed $value
     * @return Builder
     */
    public function slaValue(mixed $value = null): Builder
    {
        return  $this->builder->where('workflows.sla_value', 'LIKE', '%' . $value . '%');
    }
    /**
     * slaUnit
     *
     * @param  mixed $value
     * @return Builder
     */
    public function slaUnit(mixed $value = null): Builder
    {
        return  $this->builder->where('workflows.sla_unit', 'LIKE', '%' . $value . '%');
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
        return $this->builder->where('main_workflows.project_id',  $value);
    }
    /**
     * updateAt
     *
     * @param  mixed $value
     * @param  mixed $columnName
     * @return Builder
     */
    public function updatedAt(?string $startDate = null, ?string $endDate = null, string $columnName = 'main_workflows.updated_at'): Builder
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
public function createdAt(?string $startDate = null, ?string $endDate = null, string $columnName = 'main_workflows.created_at'): Builder
    {

    return parent::createdAt($startDate, $endDate, $columnName);
    }
    /**
     * createdBy
     *
     * @param  mixed $value
     * @param  mixed $columnName
     * @return Builder
     */
    public function createdBy(string $value, string $columnName = 'main_workflows.created_by'): Builder
    {
        return parent::createdBy($value, $columnName);
    }
    /**
     * updatedBy
     *
     * @param  mixed $value
     * @param  mixed $columnName
     * @return Builder
     */
    public function updatedBy(string $value, string $columnName = 'main_workflows.updated_by'): Builder
    {
        return parent::updatedBy($value, $columnName);
    }
}
