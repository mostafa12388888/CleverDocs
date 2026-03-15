<?php

namespace App\Http\Filters\Communication;

use App\Http\Filters\MainFilter;
use Illuminate\Contracts\Database\Eloquent\Builder;

class MailFilter extends MainFilter
{
    /**
     * search
     *
     * @param  mixed $value
     * @return Builder
     */
    function search(mixed $value = null) :Builder
    {
        return $this->builder->when($value, function ($query, $value) {
            $query->where('emails.body', 'like', '%' . $value . '%');
        });
    }
    /**
     * type
     *
     * @param  mixed $value
     * @return Builder
     */
    function type(mixed $value = null): Builder
    {
        if (!$value) return $this->builder;
        return $this->builder->where('emails.type', $value);
    }
    /**
     * typeId
     *
     * @param  mixed $value
     * @return Builder
     */
    function typeId(mixed $value = null): Builder
    {
        if (!$value) return $this->builder;
        return $this->builder->where('emails.type_id', $value);
    }
    /**
     * toContactId
     *
     * @param  mixed $value
     * @return Builder
     */
    public function toContactId(mixed $value = null): Builder
    {
        if (!$this->isJoined($this->builder, 'emails_contacts')) $this->_joinKeyContactEmailTable();
        return $this->builder->where('emails_contacts.contact_id', $value)->where('contact_type', 'to');
    }
    /**
     * ccContactId
     *
     * @param  mixed $value
     * @return Builder
     */
    public function ccContactId(mixed $value = null): Builder
    {
        if (!$this->isJoined($this->builder, 'emails_contacts')) $this->_joinKeyContactEmailTable();
        return $this->builder->where('emails_contacts.contact_id', $value)->where('contact_type', 'cc');
    }
    /**
     * priority
     *
     * @param  mixed $value
     * @return Builder
     */
    function priority(mixed $value = null): Builder
    {
        if (!$value) return $this->builder;


        return $this->builder->where('emails.priority', $value);
    }
    /**
     * createdAt
     *
     * @param  mixed $value
     * @param  mixed $columnName
     * @return Builder
     */
    public function createdAt(?string $startDate = null, ?string $endDate = null, string $columnName = 'emails.created_at'): Builder
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
    public function createdBy(string $value, string $columnName = 'emails.created_by'): Builder
    {
        return parent::createdBy($value, $columnName);
    }
    /**
     * _joinKeyContactTable
     *
     * @return void
     */
    private function _joinKeyContactEmailTable(): void
    {
        $this->builder->join('emails_contacts', 'emails_contacts.email_id', '=', 'emails.id');
    }
}
