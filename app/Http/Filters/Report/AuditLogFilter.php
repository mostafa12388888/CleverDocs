<?php

namespace App\Http\Filters\Report;

use App\Http\Filters\MainFilter;
use Illuminate\Contracts\Database\Eloquent\Builder;

class AuditLogFilter extends MainFilter
{
    /**
     * type
     *
     * @param  mixed $value
     * @return Builder
     */
    public function moduleType(mixed $value = null): Builder
    {
        if (!$value) return $this->builder;
        return $this->builder->where('audit_logs.model_type',"LIKE",'%'.$value.'%');
    }
    /**
     * roleId
     *
     * @param  mixed $value
     * @return Builder
     */
    public function moduleId(mixed $value = null): Builder
    {
        if (!$value) return $this->builder;
        return $this->builder->where('audit_logs.model_id', $value);
    }
    /**
     * action
     *
     * @param  mixed $value
     * @return Builder
     */
    public function action(mixed $value = null): Builder
    {
        if (!$value) return $this->builder;
        return $this->builder->where('audit_logs.action', $value);
    }
    /**
     * createdBy
     *
     * @param  mixed $value
     * @param  mixed $columnName
     * @return Builder
     */
    public function createdBy(string $value, string $columnName = 'audit_logs.user_id'): Builder
    {
        return parent::createdBy($value, $columnName);
    }

 /**
     * updateAt
     *
     * @param  mixed $value
     * @param  mixed $columnName
     * @return Builder
     */
    public function updatedAt(?string $startDate = null, ?string $endDate = null, string $columnName = 'audit_logs.updated_at'): Builder
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
    public function createdAt(?string $startDate = null, ?string $endDate = null, string $columnName = 'audit_logs.created_at'): Builder
    {

    return parent::createdAt($startDate, $endDate, $columnName);
    }

}
