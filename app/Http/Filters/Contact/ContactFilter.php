<?php
namespace App\Http\Filters\Contact;

use App\Http\Filters\MainFilter;
use Illuminate\Contracts\Database\Eloquent\Builder;

class ContactFilter extends MainFilter
{

        //Key Contact Filter
    /**
     * search
     *
     * @param  mixed $value
     * @return Builder
     */
    function search(mixed $value = null): Builder
    {
        if (!$value) return $this->builder;


        return $this->builder->where('contacts.name', 'LIKE', '%' . $value . '%')
        ->orWhere('contacts.contact_email', 'LIKE', '%' . $value . '%')
        ->orWhere('contacts.position', 'LIKE', '%' . $value . '%')
        ->orWhere('contacts.address', 'LIKE', '%' . $value . '%');
    }
    /**
     * isKeyContact
     *
     * @param  mixed $value
     * @return Builder
     */
    function isKeyContact(mixed $value=null):Builder
    {
        if(!$value) return $this->builder;
        if($value==2)return $this->builder->where('contacts.is_key_contact', 0);
        return $this->builder->where('contacts.is_key_contact', $value);
    }
    /**
     * phone
     *
     * @param  mixed $value
     * @return Builder
     */
    function phone(mixed $value = null):Builder
    {
        if(!$value) return $this->builder;
        return $this->builder->where(function ($query) use ($value) {
            $query->where('contacts.phone1', 'LIKE', '%' . $value . '%');
            $query->orWhere('contacts.phone2', 'LIKE', '%' . $value . '%');
        });
    }
    /**
     * hasUser
     *
     * @param  mixed $value
     * @return Builder
     */
    function hasUser(mixed $value = null):Builder
    {
        if ($value == null) return $this->builder;
        if ($value == 1) {
            // Filter for contacts that have an associated user
            return $this->builder->whereHas('user');
        } elseif ($value == 2) {
            // Filter for contacts that do not have an associated user
            return $this->builder->whereDoesntHave('user');
        }

        return $this->builder;
    }

        /**
     * address
     *
     * @param  mixed $value
     * @return Builder
     */
    function address(mixed $value = null):Builder
    {
        if(!$value) return $this->builder;
        return $this->builder->where('contacts.address', 'LIKE', '%' . $value . '%');
    }
    /**
     * email
     *
     * @param  mixed $value
     * @return Builder
     */
    function email(mixed $value = null):Builder
    {
        if(!$value) return $this->builder;
        return $this->builder->where('contacts.contact_email', 'LIKE', '%' . $value . '%');
    }
    /**
     * position
     *
     * @param  mixed $value
     * @return Builder
     */
    function position(mixed $value = null):Builder
    {
        if(!$value) return $this->builder;
        return $this->builder->where('contacts.position', 'LIKE', '%' . $value . '%');
    }
    /**
     * name
     *
     * @param  mixed $value
     * @return Builder
     */
    function name(mixed $value = null):Builder
    {
        if(!$value) return $this->builder;
        return $this->builder->where('contacts.name', 'LIKE', '%' . $value . '%');
    }
    /**
     * companyId
     *
     * @param  mixed $value
     * @return Builder
     */
    function companyId(mixed $value = null):Builder
    {
        if(!$value) return $this->builder;
        return $this->builder->where('contacts.company_id', $value);
    }
 /**
     * updateAt
     *
     * @param  mixed $value
     * @param  mixed $columnName
     * @return Builder
     */
    public function updatedAt(?string $startDate = null, ?string $endDate = null, string $columnName = 'contacts.updated_at'): Builder
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
    public function createdAt(?string $startDate = null, ?string $endDate = null, string $columnName = 'contacts.created_at'): Builder
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
    public function createdBy(string $value, string $columnName = 'contacts.created_by'): Builder
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
    public function updatedBy(string $value, string $columnName = 'contacts.updated_by'): Builder
    {
       return parent::updatedBy($value, $columnName);
    }


}
