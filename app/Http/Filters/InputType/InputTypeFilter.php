<?php
namespace App\Http\Filters\InputType;

use App\Http\Filters\MainFilter;
use Illuminate\Database\Eloquent\Builder;

 class InputTypeFilter extends MainFilter
 {

    /**
     * InputType
     *
     * @param  mixed $value
     * @return Builder
     */
    public function InputType(mixed $value=null):Builder
    {
         if(!$value) $this->builder;
            return $this->builder->where('input_types.type',$value);
    }
    /**
     * optionsType
     *
     * @param  mixed $value
     * @return Builder
     */
    public function optionsType(mixed $value=null):Builder
    {
         if(!$value) $this->builder;
            return $this->builder->where('input_types.options_type',$value);
    }
    /**
     * customListOptionsId
     *
     * @param  mixed $value
     * @return Builder
     */
    public function customListOptionsId(mixed $value=null):Builder
    {
         if(!$value) $this->builder;
            return $this->builder->where('input_types.custom_option_list_id',$value);
    }
    /**
     * category
     *
     * @param  mixed $value
     * @return Builder
     */
    public function category(mixed $value=null):Builder
    {
        if(!$value) $this->builder;
            return $this->builder->where('input_types.category',$value);
    }
    /**
     * title
     *
     * @param  mixed $value
     * @return Builder
     */
    public function title(mixed $value=null):Builder
    {
         if(!$value) $this->builder;
            return $this->builder->where('input_types.title',"LIKE","%".$value."%");
    }
    /**
     * createdBy
     *
     * @param  mixed $value
     * @param  mixed $columnName
     * @return Builder
     */
    public function createdBy(string $value, string $columnName = 'input_types.created_by'): Builder
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
    public function updatedBy(string $value, string $columnName = 'input_types.updated_by'): Builder
    {
       return parent::updatedBy($value, $columnName);
    }

        /**
     * updateAt
     *
     * @param  mixed $value
     * @param  mixed $columnName
     * @return Builder
     */
    public function updatedAt(?string $startDate = null, ?string $endDate = null, string $columnName = 'input_types.updated_at'): Builder
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
    public function createdAt(?string $startDate = null, ?string $endDate = null, string $columnName = 'input_types.created_at'): Builder
    {
     return parent::createdAt($startDate, $endDate, $columnName);
    }

 }
