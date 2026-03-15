<?php
namespace App\Http\Filters\CustomList;

use App\Http\Filters\MainFilter;
use Illuminate\Contracts\Database\Eloquent\Builder;

class CustomListFilter extends MainFilter
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
        if (!$this->isJoined($this->builder, 'input_options')) $this->_joinInputOption();
        return $this->builder->where("custom_option_lists.title",'LIKE', '%' . $value . '%')->orWhere('input_options.title', 'LIKE', '%' . $value . '%');

    }
    /**
     * name
     *
     * @param  mixed $value
     * @return Builder
     */
    function name(mixed $value=null):Builder
    {
        if(!$value)return $this->builder;
        return $this->builder->where("custom_option_lists.title",'LIKE', '%' . $value . '%');
    }
    /**
     * isActive
     *
     * @param  mixed $value
     * @return Builder
     */
    function isActive(mixed $value=null):Builder
    {
        if(!$value)return $this->builder;
        if($value==2)return $this->builder->where('custom_option_lists.is_active', 0);
        return $this->builder->where("custom_option_lists.is_active", $value);
    }
    /**
     * listId
     *
     * @param  mixed $value
     * @return Builder
     */
    function listId(mixed $value=null):Builder
    {
        if(!$value)return $this->builder;
        return $this->builder->where("custom_option_lists.id", $value);
    }
    /**
     * key
     *
     * @param  mixed $value
     * @return Builder
     */
    function key(mixed $value=null):Builder
    {
        if(!$value)return $this->builder;
        return $this->builder->where("custom_option_lists.key", '=', $value);
    }
    /**
     * updateAt
     *
     * @param  mixed $value
     * @param  mixed $columnName
     * @return Builder
     */
    public function updatedAt(?string $startDate = null, ?string $endDate = null, string $columnName = 'custom_option_lists.updated_at'): Builder
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
    public function createdAt(?string $startDate = null, ?string $endDate = null, string $columnName = 'custom_option_lists.created_at'): Builder
    {

    return parent::createdAt($startDate, $endDate, $columnName);
    }

    /**
     * _joinInputOption
     *
     * @return void
     */
    public function _joinInputOption():void
    {
        $this->builder->leftJoin('input_options', 'input_options.custom_option_list_id', '=', 'custom_option_lists.id');
    }
}
