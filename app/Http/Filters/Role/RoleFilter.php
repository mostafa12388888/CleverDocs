<?php

namespace App\Http\Filters\Role;

use App\Http\Filters\MainFilter;
use Illuminate\Database\Eloquent\Builder;

class RoleFilter extends MainFilter
{
    /**
     * Search method
     *
     * @param mixed $value
     * @return Builder
     */
    function search(mixed $value = null): Builder
    {
        if (!$value) return $this->builder;
        return $this->builder->where('roles.name', 'LIKE', '%' . $value . '%');
    }

    /**
     * Filter by name
     *
     * @param mixed $value
     * @return Builder
     */
    public function name(mixed $value = null): Builder
    {
        return  $this->builder->where('roles.name', 'LIKE', '%' . $value . '%');
    }
    /**
     * key
     *
     * @param  mixed $value
     * @return Builder
     */
    public function key(mixed $value = null): Builder
    {
        return  $this->builder->where('roles.key', 'LIKE', '%' . $value . '%');
    }
    /**
     * isActive
     *
     * @param  mixed $value
     * @return Builder
     */
    public function isDefault(mixed $value = null): Builder
    {
        return  $this->builder->where('roles.is_default', $value);
    }

}
