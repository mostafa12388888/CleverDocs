<?php

namespace App\Http\Filters\Distribution;

use App\Http\Filters\MainFilter;
use Illuminate\Database\Eloquent\Builder;

class DistributionInboxFilter extends MainFilter
{

    /**
     * search
     *
     * @param  mixed $value
     * @return Builder
     */
    function search(mixed $value = null)
    {
        if (!$value) return $this->builder;

        return $this->builder->where(function ($query) use ($value) {
            $query->where("private_in_boxes.created_by", $value)
                ->orWhere('projects.name', 'like', "%$value%")
                ->orWhere('companies.name', 'like', "%$value%")
                ->orWhere('workflows.title', 'like', "%$value%")
                ->orWhere('distribution_lists.title', 'like', "%$value%");
        });
    }
    // Filters by company
    /**
     * companyId
     *
     * @param  mixed $value
     * @return Builder
     */
    function type(mixed $value = null): Builder
    {
        if (!$value) return $this->builder;

        return $this->builder->where('distribution_inboxes.type', $value);
    }
    function typeId(mixed $value = null): Builder
    {
        if (!$value) return $this->builder;

        return $this->builder->where('distribution_inboxes.type_id', $value);
    }
    /**
     * contactsIds
     *
     * @param  mixed $value
     * @return Builder
     */
    public function contactsIds(array $value): Builder
    {
        if (!$this->isJoined($this->builder, 'contact_distribution_inboxes'))
            $this->_joinContactsActions();
        if (!$value) return $this->builder;
        return $this->builder->whereIn('contact_distribution_inboxes.contact_id', $value);
    }
    public function actionIds(array $value): Builder
    {
        if (!$this->isJoined($this->builder, 'contact_distribution_inboxes'))
            $this->_joinContactsActions();
        if (!$value) return $this->builder;
        return $this->builder->whereIn('contact_distribution_inboxes.action_id', $value);
    }
    /**
     * contactsId
     *
     * @param  mixed $value
     * @return Builder
     */
    function contactId(mixed $value = null): Builder
    {
        if (!$this->isJoined($this->builder, 'contact_distribution_inboxes'))
            $this->_joinContactsActions();
        if (!$value) return $this->builder;
        return $this->builder->where('contact_distribution_inboxes.contact_id', $value);
    }
    /**
     * actionId
     *
     * @param  mixed $value
     * @return Builder
     */
    function actionId(mixed $value = null): Builder
    {
        if (!$this->isJoined($this->builder, 'contact_distribution_inboxes'))
            $this->_joinContactsActions();
        if (!$value) return $this->builder;
        return $this->builder->where('contact_distribution_inboxes.action_id', $value);
    }
    /**
     * message
     *
     * @param  mixed $value
     * @return Builder
     */
    function message(mixed $value = null): Builder
    {
        if (!$value) return $this->builder;

        return $this->builder->where('distribution_inboxes.message', 'LIKE', '%' . $value . '%');
    }
    /**
     * userId
     *
     * @param  mixed $value
     * @return Builder
     */
    function userId(mixed $value = null): Builder
    {
        return $this->builder->where('distribution_inboxes.user_id', $value);
    }
    /**
     * distributionListId
     *
     * @param  mixed $value
     * @return Builder
     */
    function distributionListId(mixed $value = null): Builder
    {
        return $this->builder->where('distribution_inboxes.distribution_list_id', $value);
    }
    /**
     * priorityId
     *
     * @param  mixed $value
     * @return Builder
     */
    function priorityId(mixed $value = null): Builder
    {
        return $this->builder->where('distribution_inboxes.priority_id', $value);
    }
    /**
     * updateAt
     *
     * @param  mixed $value
     * @param  mixed $columnName
     * @return Builder
     */
    public function updatedAt(?string $startDate = null, ?string $endDate = null, string $columnName = 'distribution_inboxes.updated_at'): Builder
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
    public function createdAt(?string $startDate = null, ?string $endDate = null, string $columnName = 'distribution_inboxes.created_at'): Builder
    {
     return parent::createdAt($startDate, $endDate, $columnName);
    }
    /**
     * createdBy
     *
     * @param  mixed $value
     * @param  mixed $columnName
     * @return Builder
     */
    public function createdBy(string $value, string $columnName = 'distribution_inboxes.created_by'): Builder
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
    public function updatedBy(string $value, string $columnName = 'distribution_inboxes.updated_by'): Builder
    {
        return parent::updatedBy($value, $columnName);
    }

    /**
     * _joinContactsActions
     *
     * @return void
     */
    public function _joinContactsActions(): void
    {
        $this->builder->leftJoin('contact_distribution_inboxes', 'contact_distribution_inboxes.distribution_inbox_id', '=', 'distribution_inboxes.id');
    }
}
