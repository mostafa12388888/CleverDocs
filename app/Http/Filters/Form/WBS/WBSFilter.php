<?php
namespace App\Http\Filters\Form\WBS;

use App\Http\Filters\MainFilter;
use Illuminate\Contracts\Database\Eloquent\Builder;

class WBSFilter extends MainFilter
{



    /**
     * title
     *
     * @param  mixed $value
     * @return Builder
     */
    function title(mixed $value=null):Builder
    {
        if(!$value)return $this->builder;
        return $this->builder->where('w_b_s.title', 'like', '%' . $value . '%');
    }
    /**
     * projectId
     *
     * @param  mixed $value
     * @return Builder
     */
    function projectId(mixed $value=null):Builder
    {
        if (!$value) return $this->builder;
        if (!$this->isJoined($this->builder, 'projects')) $this->_joinProjectTable();
        return $this->builder->where('projects.id', $value);

    }
    /**
     * search
     *
     * @param  mixed $value
     * @return Builder
     */
    function search(mixed $value=null):Builder
    {
        if (!$value) return $this->builder;
        if (!$this->isJoined($this->builder, 'projects')) $this->_joinProjectTable();
        return $this->builder->where('projects.name', 'LIKE', '%' . $value . '%')->orWhere('w_b_s.title', 'LIKE', '%' . $value . '%');

    }
    /**
     * updateAt
     *
     * @param  mixed $value
     * @param  mixed $columnName
     * @return Builder
     */
    public function updatedAt(?string $startDate = null, ?string $endDate = null, string $columnName = 'w_b_s.updated_at'): Builder
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
    public function createdAt(?string $startDate = null, ?string $endDate = null, string $columnName = 'w_b_s.created_at'): Builder
    {

    return parent::createdAt($startDate, $endDate, $columnName);
    }

    /**
     * _joinProjectTable
     *
     * @return void
     */

     private function _joinProjectTable():void
    {
        $this->builder->leftJoin('projects', 'projects.w_b_s_id', '=', 'w_b_s.id');
    }
}
