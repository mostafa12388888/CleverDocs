<?php
namespace App\Http\Filters\Company;

use App\Http\Filters\MainFilter;
use Illuminate\Database\Eloquent\Builder;

class PrivateInBoxFilter extends MainFilter
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

        return $this->builder->where('private_in_boxes.type', $value);
    }
    function typeId(mixed $value = null): Builder
    {
        if (!$value) return $this->builder;

        return $this->builder->where('private_in_boxes.typeId', $value);
    }



    /**
     * contactsIds
     *
     * @param  mixed $value
     * @return Builder
     */
    function contactsIds(mixed $value = null): Builder
    {
        if (!$value) return $this->builder;

        return $this->builder->whereIn('private_in_boxes.from_contact_id', $value);
    }
    /**
     * contactsId
     *
     * @param  mixed $value
     * @return Builder
     */
    function contactId(mixed $value = null): Builder
    {
        if (!$value) return $this->builder;

        return $this->builder->where('private_in_boxes.from_contact_id', $value);
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

        return $this->builder->where('private_in_boxes.message', 'LIKE', '%' . $value . '%');
    }
    /**
     * userId
     *
     * @param  mixed $value
     * @return Builder
     */
    function userId(mixed $value = null): Builder
    {
        return $this->builder->where('private_in_boxes.user_id', $value);
    }
    /**
     * updateAt
     *
     * @param  mixed $value
     * @param  mixed $columnName
     * @return Builder
     */
    public function updatedAt(?string $startDate = null, ?string $endDate = null, string $columnName = 'private_in_boxes.updated_at'): Builder
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
    public function createdAt(?string $startDate = null, ?string $endDate = null, string $columnName = 'private_in_boxes.created_at'): Builder
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
    public function createdBy(string $value, string $columnName = 'private_in_boxes.created_by'): Builder
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
    public function updatedBy(string $value, string $columnName = 'private_in_boxes.updated_by'): Builder
    {
       return parent::updatedBy($value, $columnName);
    }

}
