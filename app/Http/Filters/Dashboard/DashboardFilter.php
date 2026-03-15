<?php

namespace App\Http\Filters\Dashboard;

use App\Http\Filters\MainFilter;
use Illuminate\Contracts\Database\Eloquent\Builder;

class DashboardFilter extends MainFilter
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
        return $this->builder->where('dashboards.title', 'LIKE', '%' . $value . '%')
            ->orWhere('dashboards.settings', 'LIKE', '%' . $value . '%');
    }

    /**
     * hasUser
     *
     * @param  mixed $value
     * @return Builder
     */
    function usersId(mixed $value = null): Builder
    {
        if (!$value) return $this->builder;
        return $this->builder->where('dashboard_assign_to_users.user_id', $value);
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
        return $this->builder->where('dashboards.title', 'LIKE', '%' . $value . '%');
    }
    /**
     * settings
     *
     * @param  mixed $value
     * @return Builder
     */
    function settings(mixed $value = null): Builder
    {
        if (!$value) return $this->builder;
        return $this->builder->where('dashboards.settings', 'LIKE', '%' . $value . '%');
    }
    /**
     * is_default
     *
     * @param  mixed $value
     * @return Builder
     */
    function isDefault(mixed $value = null): Builder
    {
        if (!$value) return $this->builder;
        if($value==2)return $this->builder->where('dashboards.is_default', 0);
        return $this->builder->where('dashboards.is_default', $value);
    }
        /**
     * updateAt
     *
     * @param  mixed $value
     * @param  mixed $columnName
     * @return Builder
     */
    public function updatedAt(?string $startDate = null, ?string $endDate = null, string $columnName = 'dashboards.updated_at'): Builder
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
    public function createdAt(?string $startDate = null, ?string $endDate = null, string $columnName = 'dashboards.created_at'): Builder
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
    public function createdBy(string $value, string $columnName = 'dashboards.created_by'): Builder
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
    public function updatedBy(string $value, string $columnName = 'dashboards.updated_by'): Builder
    {
        return parent::updatedBy($value, $columnName);
    }
}
