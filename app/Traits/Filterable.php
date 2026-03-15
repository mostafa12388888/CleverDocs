<?php

namespace App\Traits;

use App\Http\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

trait Filterable
{
    /**
     * Apply all relevant filters.
     *
     * @param Builder $query
     * @param Filter|null $filter
     * @return Builder
     */
    public function scopeFilter(Builder $query, ?Filter $filter = null): Builder
    {
        if (!$filter) {
            return $query;
        }
        return $filter->apply($query);
    }
}
