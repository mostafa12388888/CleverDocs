<?php

namespace App\Http\Filters\Layout;

use App\Http\Filters\MainFilter;
use Illuminate\Contracts\Database\Eloquent\Builder;

class LayoutFilter extends MainFilter
{
    /**
     * type
     *
     * @param  mixed $value
     * @return Builder
     */
    public function type(mixed $value=null):Builder
    {
        if(!$value) return $this->builder;
        return $this->builder->where('layouts.type', $value);
    }
    /**
     * status
     *
     * @param  mixed $value
     * @return Builder
     */
    public function status(Mixed $value=null):Builder
    {
        if(!$value)return $this->builder;
        return $this->builder->where('layouts.status', $value);
    }
    /**
     * title
     *
     * @param  mixed $value
     * @return Builder
     */
    public function title(Mixed $value=null):Builder
    {
        if(!$value)return $this->builder;
        return $this->builder->where('layouts.subject','LIKE', '%' . $value . '%');;
    }
    /**
     * moduleId
     *
     * @param  mixed $value
     * @return Builder
     */
    public function moduleId($value):Builder
    {
        return $this->builder->where('layouts.module_id',$value);
    }
    /**
     * projectId
     *
     * @param  mixed $value
     * @return Builder
     */
    public function projectId($value):Builder
    {
        return $this->builder->where('layouts.project_id',$value);
    }
    /**
     * updateAt
     *
     * @param  mixed $value
     * @param  mixed $columnName
     * @return Builder
     */
    public function updatedAt(?string $startDate = null, ?string $endDate = null, string $columnName = 'layouts.updated_at'): Builder
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
    public function createdAt(?string $startDate = null, ?string $endDate = null, string $columnName = 'layouts.created_at'): Builder
    {

    return parent::createdAt($startDate, $endDate, $columnName);
    }


}
