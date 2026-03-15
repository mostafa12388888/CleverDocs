<?php

namespace App\Http\Filters\Company;

use App\Http\Filters\MainFilter;
use Illuminate\Contracts\Database\Eloquent\Builder;

class LoginHistoryFilter extends MainFilter
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

        return $this->builder->where("login_histories.browser", "like", "%$value%")
            ->orWhere("login_histories.device", "like", "%$value%");
    }
    /**
     * contactId
     *
     * @param  mixed $value
     * @return Builder
     */
    function ip(mixed $value = null): Builder
    {
        if (!$value) return $this->builder;
        return $this->builder->where('login_histories.ip', 'LIKE', '%' . $value . '%');
    }
    /**
     * companyId
     *
     * @param  mixed $value
     * @return Builder
     */
    function userId(mixed $value = null): Builder
    {
        if (!$value) return $this->builder;
        return $this->builder->where('login_histories.user_id', $value);
    }
    /**
     * email
     *
     * @param  mixed $value
     * @return Builder
     */
    function location(mixed $value = null): Builder
    {
        if (!$value) return $this->builder;
        return $this->builder->where('login_histories.location', 'LIKE', '%' . $value . '%');
    }
    /**
     * isActive
     *
     * @param  mixed $value
     * @return Builder
     */
    function status(mixed $value = null): Builder
    {
        if (!$value) return $this->builder;
        if ($value == 2) return $this->builder->where('login_histories.status', 0);
        return $this->builder->where('login_histories.status', $value);
    }
    /**
     * code
     *
     * @param  mixed $value
     * @return Builder
     */
    function device(mixed $value = null): Builder
    {
        if (!$value) return $this->builder;

        return $this->builder->where('login_histories.device', 'LIKE', '%' . $value . '%');
    }
    /**
     * browser
     *
     * @param  mixed $value
     * @return Builder
     */
    function browser(mixed $value = null): Builder
    {
        if (!$value) return $this->builder;

        return $this->builder->where('login_histories.browser', 'LIKE', '%' . $value . '%');
    }
    /**
     * os
     *
     * @param  mixed $value
     * @return Builder
     */
    function os(mixed $value = null): Builder
    {
        if (!$value) return $this->builder;

        return $this->builder->where('login_histories.os', 'LIKE', '%' . $value . '%');
    }


    /**
     * updateAt
     *
     * @param  mixed $value
     * @param  mixed $columnName
     * @return Builder
     */
    public function updatedAt(?string $startDate = null, ?string $endDate = null, string $columnName = 'users.updated_at'): Builder
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
    public function createdAt(?string $startDate = null, ?string $endDate = null, string $columnName = 'users.created_at'): Builder
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
    public function createdBy(string $value, string $columnName = 'users.created_by'): Builder
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
    public function updatedBy(string $value, string $columnName = 'users.updated_by'): Builder
    {
        return parent::updatedBy($value, $columnName);
    }
}
