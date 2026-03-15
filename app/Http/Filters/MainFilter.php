<?php

namespace App\Http\Filters;
use Illuminate\Support\Carbon;
use App\Http\Filters\Filter;
use Illuminate\Contracts\Database\Eloquent\Builder;

class MainFilter extends Filter
{


    /**
     * @param $query
     * @param $table
     * @return bool
     */
    function isJoined($query, $table): bool
    {
        $joins = collect($query->getQuery()->joins);
        return $joins->pluck('table')->contains($table);
    }

    /**
     * Filter the resources by the given course.
     * @param string $value
     * @param string $columnName
     * @return Builder
     */
    public function createdBy(string $value, string $columnName = 'created_by'): Builder
    {
        return $this->builder->where($columnName, $value);
    }
    /**
     * updateAt
     *
     * @param  mixed $value
     * @param  mixed $columnName
     * @return Builder
     */
    public function updatedAt(?string $startDate = null, ?string $endDate = null, string $columnName = 'updated_at'): Builder
    {
        if (!$startDate && $endDate)
          return $this->builder->where($columnName,'<',$endDate);
        $startDate = $startDate ?? now()->toDateString();
        $endDate   = $endDate ?? now()->toDateString();
        return $this->builder->whereBetween($columnName, [$startDate, $endDate]);
    }
    /**
     * createdAt
     *
     * @param  mixed $value
     * @param  mixed $columnName
     * @return Builder
     */
    public function createdAt(?string $startDate = null, ?string $endDate = null, string $columnName = 'created_at'): Builder
    {
        if (!$startDate && $endDate)
          return $this->builder->where($columnName,'<',$endDate);
        $startDate = $startDate ?? now()->toDateString();
        $endDate   = $endDate ?? now()->toDateString();
        return $this->builder->whereBetween($columnName, [$startDate, $endDate]);
    }

    /**
     * updatedBy
     *
     * @param  mixed $value
     * @param  mixed $columnName
     * @return Builder
     */
    public function updatedBy(string $value, string $columnName = 'update_by'): Builder
    {
        return $this->builder->where($columnName, $value);
    }


}
