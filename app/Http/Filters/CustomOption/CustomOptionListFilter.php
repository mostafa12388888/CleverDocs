<?php

namespace App\Http\Filters\CustomOption;

use App\Http\Filters\MainFilter;
use Illuminate\Database\Eloquent\Builder;


class CustomOptionListFilter extends MainFilter
{


    /**
     * search
     *
     * @param  mixed $value
     * @return Builder
     */
    public function search(mixed $value=null):Builder
    {
        if(!$value)return $this->builder;

        return $this->builder->Where("input_options.title",'LIKE', '%' . $value . '%');

    }
    /**
     * title
     *
     * @param  mixed $value
     * @return Builder
     */
    public function title(mixed $value = null): Builder
    {
        if (!$value) return $this->builder;
        return $this->builder->where("input_options.title", 'LIKE', '%' . $value . '%');
    }

    /**
     * @param int|null $value
     * @return Builder
     */
    public function listId(mixed $value = null): Builder
    {
        if (!$value) return $this->builder;

        return $this->builder->where('input_options.custom_option_list_id', $value);
    }

    /**
     * @param string|null $value
     * @return Builder
     */
    public function listKey(mixed $value = null): Builder
    {
        if (!$value) return $this->builder;

        if (!$this->isJoined($this->builder, 'custom_option_lists')) $this->_joinCustomListTable();

        return $this->builder->where('custom_option_lists.key', $value);
    }


    /**
     * @param mixed|null $value
     * @return Builder
     */
    public function isDefault(mixed $value = null): Builder
    {
        if (!$value) return $this->builder;
        if($value==2)return $this->builder->where('input_options.is_default', 0);
        return $this->builder->where('input_options.is_default', $value);
    }
    /**
     * isActive
     *
     * @param  mixed $value
     * @return Builder
     */
    public function isActive(mixed $value = null): Builder
    {
        if (!$value) return $this->builder;
        if($value==2)return $this->builder->where('input_options.is_active', 0);
        return $this->builder->where('input_options.is_active', $value);
    }


    /**
     * @param mixed|null $value
     * @return Builder
     */
    public function isDefaultList(mixed $value = null): Builder
    {
        if (!$value) return $this->builder;
         if($value==2) return $this->builder->where('input_options.is_default_list', 0);
        return $this->builder->where('input_options.is_default_list', 1);
    }
    /**
     * updateAt
     *
     * @param  mixed $value
     * @param  mixed $columnName
     * @return Builder
     */
    public function updatedAt(?string $startDate = null, ?string $endDate = null, string $columnName = 'input_options.updated_at'): Builder
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
    public function createdAt(?string $startDate = null, ?string $endDate = null, string $columnName = 'input_options.created_at'): Builder
    {

    return parent::createdAt($startDate, $endDate, $columnName);
    }



    /**
     * @return void
     */
    private function _joinCustomListTable(): void
    {
        $this->builder->join('custom_option_lists', 'custom_option_lists.id', '=', 'input_options.custom_option_list_id');
    }

}
