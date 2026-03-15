<?php

namespace App\Http\Filters\Distribution;

use App\Http\Filters\MainFilter;
use Illuminate\Database\Eloquent\Builder;

class DistributionListFilter extends MainFilter
{

    /**
     * search
     *
     * @param  mixed $value
     * @return Builder
     */
    function search(mixed $value = null)
    {
        if (!$value) return $this->builder;
        return $this->builder->where(function ($query) use ($value) {
            $query->where('distribution_lists.title', 'LIKE', '%' . $value . '%')
                ->orWhere('distribution_lists.project_id', $value);
        });
    }
    /**
     * title
     *
     * @param  mixed $value
     * @return Builder
     */
    function title(mixed $value = null): Builder
    {
        if (!$value) return $this->builder;
        return $this->builder->where('distribution_lists.title', 'LIKE', '%' . $value . '%');
    }
    /**
     * projectId
     *
     * @param  mixed $value
     * @return Builder
     */
    function projectId(mixed $value = null): Builder
    {
        if (!$value) return $this->builder;
        return $this->builder->where('distribution_lists.project_id',  $value);
    }

    // Filters by distribution_lists
    /**
     * isActive
     *
     * @param  mixed $value
     * @return Builder
     */
    function isActive(mixed $value = null): Builder
    {
        if (!$value) return $this->builder;
        if($value==2)return $this->builder->where('distribution_lists.is_active', 0);
        return $this->builder->where('distribution_lists.is_active', $value);
    }

    /**
     * updateAt
     *
     * @param  mixed $value
     * @param  mixed $columnName
     * @return Builder
     */
    public function updatedAt(?string $startDate = null, ?string $endDate = null, string $columnName = 'distribution_lists.updated_at'): Builder
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
    public function createdAt(?string $startDate = null, ?string $endDate = null, string $columnName = 'distribution_lists.created_at'): Builder
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
    public function createdBy(string $value, string $columnName = 'distribution_lists.created_by'): Builder
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
    public function updatedBy(string $value, string $columnName = 'distribution_lists.updated_by'): Builder
    {
        return parent::updatedBy($value, $columnName);
    }
}
