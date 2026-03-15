<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

abstract class Filter
{
    /**
     * @var Request
     */
    protected Request $request;

    /**
     * @var Builder
     */
    protected Builder $builder;

    /**
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @param Builder $builder
     * @return Builder
     */
    public function apply(Builder $builder): Builder
    {
        $this->builder = $builder;

        collect($this->filters())->each(function ($value, $filter) {

            if (in_array($filter, ['createdAtStart', 'createdAtEnd', 'updatedAtStart', 'updatedAtEnd'])) {
                return;
            }

            if (method_exists($this, $filter)) {
                $this->{$filter}($value);
            }
        });

        $createdStart = $this->request->query('createdAtStart');
        $createdEnd   = $this->request->query('createdAtEnd');
        if ($createdStart || $createdEnd) {
            if (method_exists($this, 'createdAt')) {
                $this->createdAt($createdStart, $createdEnd);
            }
        }

        $updatedStart = $this->request->query('updatedAtStart');
        $updatedEnd   = $this->request->query('updatedAtEnd');
        if ($updatedStart || $updatedEnd) {
            if (method_exists($this, 'updatedAt')) {
                $this->updatedAt($updatedStart, $updatedEnd);
            }
        }

        return $this->builder;
    }



    /**
     * @return array
     */
    protected function filters(): array
    {
        return array_filter($this->request->all());
    }
}
