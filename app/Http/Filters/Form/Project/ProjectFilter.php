<?php

namespace App\Http\Filters\Form\Project;

use App\Http\Filters\MainFilter;
use Illuminate\Contracts\Database\Eloquent\Builder;

class ProjectFilter extends MainFilter
{
    /**
     * name
     *
     * @param  mixed $value
     * @return Builder
     */
    function name(mixed $value = null): Builder
    {
        if (!$value) return $this->builder;
        return $this->builder->where('projects.name', 'LIKE', '%' . $value . '%');;
    }
    /**
     * referenceNo
     *
     * @param  mixed $value
     * @return Builder
     */
    function referenceNo(mixed $value = null): Builder
    {
        if (!$value) return $this->builder;
        return $this->builder->where('projects.reference_number', 'LIKE', '%' . $value . '%');;
    }
    /**
     * description
     *
     * @param  mixed $value
     * @return Builder
     */
    function description(mixed $value = null): Builder
    {
        if (!$value) return $this->builder;
        return $this->builder->where('projects.description', 'LIKE', '%' . $value . '%');;
    }
    /**
     * wbsId
     *
     * @param  mixed $value
     * @return Builder
     */
    function wbsId(mixed $value = null): Builder
    {
        if (!$value) return $this->builder;
        return $this->builder->where('projects.w_b_s_id', $value);
    }
    /**
     * active
     *
     * @param  mixed $value
     * @return Builder
     */
    function status(mixed $value = null): Builder
    {
        if (!$value) return $this->builder;
        return $this->builder->where('projects.status', $value);
    }
    /**
     * countryId
     *
     * @param  mixed $value
     * @return Builder
     */
    function countryId(mixed $value = null): Builder
    {
        if (!$value) return $this->builder;
        return $this->builder->where('projects.country_id',  $value);
    }
    /**
     * companyId
     *
     * @param  mixed $value
     * @return Builder
     */
    function companyId(mixed $value = null): Builder
    {
        if (!$value) return $this->builder;
        return $this->builder->where('projects.company_id',  $value);
    }
    /**
     * contractValue
     *
     * @param  mixed $value
     * @return Builder
     */
    function contractValue(mixed $value = null): Builder
    {
        if (!$value) return $this->builder;
        return $this->builder->where('projects.contract_value', $value);
    }
    /**
     * projectTypeId
     *
     * @param  mixed $value
     * @return Builder
     */
    function projectTypeId(mixed $value = null): Builder
    {
        if (!$value) return $this->builder;
        return $this->builder->where('projects.project_type_id', $value);
    }
      /**
     * isAssignedToMe
     *
     * @param  mixed $value
     * @return Builder
     */
    public function isAssignedToMe(): Builder
    {
        if(!$this->isJoined($this->builder,'user_assign_projects'))
            $this->_joinUserAssignProjects();
        return $this->builder->where('user_assign_projects.user_id', auth()->id());
    }
    /**
     * notAssignedToMe
     *
     * @return Builder
     */
    public function notAssignedToMe (): Builder
    {
        if(!$this->isJoined($this->builder,'user_assign_projects'))
            $this->_joinUserAssignProjects();
            return $this->builder
            ->whereNull('user_assign_projects.user_id') // Filter out projects where user_id is null
            ->orWhere('user_assign_projects.user_id', '<>', auth()->id()); // Ensure that user_id does not match the current user's id
    }
    /**
     * assignedUsers
     *
     * @param  mixed $value
     * @return Builder
     */
    public function assignedUsers(array $value): Builder
    {
        if(!$this->isJoined($this->builder,'user_assign_projects'))
            $this->_joinUserAssignProjects();
        if (!$value) return $this->builder;
        return $this->builder->whereIn('user_assign_projects.user_id', $value);
    }
    /**
     * updateAt
     *
     * @param  mixed $value
     * @param  mixed $columnName
     * @return Builder
     */
    public function updatedAt(?string $startDate = null, ?string $endDate = null, string $columnName = 'projects.updated_at'): Builder
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
    public function createdAt(?string $startDate = null, ?string $endDate = null, string $columnName = 'projects.created_at'): Builder
    {

    return parent::createdAt($startDate, $endDate, $columnName);
    }


    /**
     * _joinUsers
     *
     * @return void
     */
    public function _joinUserAssignProjects(): void
    {
        $this->builder->leftJoin('user_assign_projects', 'user_assign_projects.project_id', '=', 'projects.id');
    }
}
