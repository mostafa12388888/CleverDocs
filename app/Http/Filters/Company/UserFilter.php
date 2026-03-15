<?php
namespace App\Http\Filters\Company;

use App\Http\Filters\MainFilter;
use Illuminate\Contracts\Database\Eloquent\Builder;

class UserFilter extends MainFilter
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

        return $this->builder->where("users.email", "like", "%$value%")
            ->orWhere("contacts.name", "like", "%$value%");
    }
    /**
     * contactId
     *
     * @param  mixed $value
     * @return Builder
     */
    function contactId(mixed $value = null): Builder
    {
        if (!$value) return $this->builder;
       return $this->builder->where('users.contact_id', $value);
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
       return $this->builder->where('contacts.company_id', $value);
    }
    /**
     * email
     *
     * @param  mixed $value
     * @return Builder
     */
    function email(mixed $value = null): Builder
    {
        if (!$value) return $this->builder;
        return $this->builder->where('users.email' ,'LIKE', '%' . $value . '%');
    }
    /**
     * isActive
     *
     * @param  mixed $value
     * @return Builder
     */
    function isActive(mixed $value = null): Builder
    {
        if (!$value) return $this->builder;
        if($value==2)return $this->builder->where('users.is_active', 0);
        return $this->builder->where('users.is_active', $value);
    }
    /**
     * code
     *
     * @param  mixed $value
     * @return Builder
     */
    function code(mixed $value = null): Builder
    {
        if (!$value) return $this->builder;

        return $this->builder->where('users.code', 'LIKE', '%' . $value . '%');
    }


    /**
     * updateAt
     *
     * @param  mixed $value
     * @param  mixed $columnName
     * @return Builder
     */
    public function updatedAt(?string $startDate = null, ?string $endDate = null, string $columnName = 'users.updated_at'): Builder
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
    public function createdAt(?string $startDate = null, ?string $endDate = null, string $columnName = 'users.created_at'): Builder
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
    public function createdBy(string $value, string $columnName = 'users.created_by'): Builder
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
    public function updatedBy(string $value, string $columnName = 'users.updated_by'): Builder
    {
       return parent::updatedBy($value, $columnName);
    }

}
