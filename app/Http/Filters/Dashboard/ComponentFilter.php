<?php

namespace App\Http\Filters\Dashboard;

use App\Http\Filters\MainFilter;
use Illuminate\Contracts\Database\Eloquent\Builder;

class ComponentFilter extends MainFilter
{

    /**
     * search
     *
     * @param  mixed $value
     * @return Builder
     */
    function search(mixed $value = null): Builder
    {
        if (!$value) return $this->builder;
        return $this->builder->where('components.title', 'LIKE', '%' . $value . '%')
            ->orWhere('components.count_by', 'LIKE', '%' . $value . '%')
            ->orWhere('components.chart_type', 'LIKE', '%' . $value . '%')
            ->orWhere('components.updated_by', $value)
            ->orWhere('components.created_by',  $value);
    }

    /**
     * hasUser
     *
     * @param  mixed $value
     * @return Builder
     */
    function isPrivate(mixed $value = null): Builder
    {
        if (!$value) return $this->builder;
        if($value==2)return $this->builder->where('components.is_private', 0);
        return $this->builder->where('components.is_private', $value);
    }

    /**
     * name
     *
     * @param  mixed $value
     * @return Builder
     */
    function title(mixed $value = null): Builder
    {
        if (!$value) return $this->builder;
        return $this->builder->where('components.title', 'LIKE', '%' . $value . '%');
    }
    /**
     * chartType
     *
     * @param  mixed $value
     * @return Builder
     */
    function chartType(mixed $value = null): Builder
    {
        if (!$value) return $this->builder;
        return $this->builder->where('components.chart_type', 'LIKE', '%' . $value . '%');
    }
    /**
     * countBy
     *
     * @param  mixed $value
     * @return Builder
     */
    function countBy(mixed $value = null): Builder
    {
        if (!$value) return $this->builder;
        return $this->builder->where('components.count_by', 'LIKE', '%' . $value . '%');
    }
    /**
     * groupBy
     *
     * @param  mixed $value
     * @return Builder
     */
    function groupBy(mixed $value = null): Builder
    {
        if (!$value) return $this->builder;
        return $this->builder->where('components.group_by', 'LIKE', '%' . $value . '%');
    }
    /**
     * settings
     *
     * @param  mixed $value
     * @return Builder
     */
    function formId(mixed $value = null): Builder
    {
        if (!$value) return $this->builder;
        return $this->builder->where('components.form_id', $value);
    }
    /**
     * is_default
     *
     * @param  mixed $value
     * @return Builder
     */
    function dashboardId(mixed $value = null): Builder
    {
        if (!$value) return $this->builder;
        return $this->builder->where('components.dashboard_id', $value);
    }    /**
     * updateAt
     *
     * @param  mixed $value
     * @param  mixed $columnName
     * @return Builder
     */
    public function updatedAt(?string $startDate = null, ?string $endDate = null, string $columnName = 'components.updated_at'): Builder
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
    public function createdAt(?string $startDate = null, ?string $endDate = null, string $columnName = 'components.created_at'): Builder
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
    public function createdBy(string $value, string $columnName = 'components.created_by'): Builder
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
    public function updatedBy(string $value, string $columnName = 'components.updated_by'): Builder
    {
        return parent::updatedBy($value, $columnName);
    }
}
