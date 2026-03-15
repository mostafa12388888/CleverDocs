<?php
namespace App\Http\Filters\Company;

use App\Http\Filters\MainFilter;
use Illuminate\Contracts\Database\Eloquent\Builder;

class CompanyFilter extends MainFilter
{

    //Key Company Filter
    /**
     * search
     *
     * @param  mixed $value
     * @return Builder
     */
    function search(mixed $value = null): Builder
    {
        if (!$value) return $this->builder;
        return $this->builder->where('companies.name', 'LIKE', '%' . $value . '%')
        ->orWhere('companies.email', 'LIKE', '%' . $value . '%');
        }
    /**
     * ContactAddress
     *
     * @param  mixed $value
     * @return Builder
     */
    function ContactAddress(mixed $value = null): Builder
    {
        if (!$value) return $this->builder;
        if (!$this->isJoined($this->builder, 'contacts')) $this->_joinKeyContactTable();
        return $this->builder->where('contacts.address' ,'LIKE', '%' . $value . '%');
    }
    function ContactName(mixed $value = null): Builder
    {
        if (!$value) return $this->builder;
        if (!$this->isJoined($this->builder, 'contacts')) $this->_joinKeyContactTable();
        return $this->builder->where('contacts.name' ,'LIKE', '%' . $value . '%');
    }
    // Filters by company
    /**
     * companyId
     *
     * @param  mixed $value
     * @return Builder
     */
    function companyId(mixed $value = null): Builder
    {
        if (!$value) return $this->builder;

        return $this->builder->where('companies.id', $value);
    }
    /**
     * phone
     *
     * @param  mixed $value
     * @return Builder
     */
    function phone(mixed $value = null): Builder
    {
        if (!$value) return $this->builder;

        return $this->builder->where('companies.phone1', 'LIKE', '%' . $value . '%')
        ->orWhere('companies.phone2', 'LIKE', '%' . $value . '%');
    }
    /**
     * address
     *
     * @param  mixed $value
     * @return Builder
     */
    function address(mixed $value = null): Builder
    {
        if (!$value) return $this->builder;

        return $this->builder->where('companies.address', 'LIKE', '%' . $value . '%');
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

        return $this->builder->where('companies.email', 'LIKE', '%' . $value . '%');
    }
    /**
     * vatNo
     *
     * @param  mixed $value
     * @return Builder
     */
    function vatNo(mixed $value = null): Builder
    {
        if (!$value) return $this->builder;

        return $this->builder->where('companies.vat', 'LIKE', '%' . $value . '%');
    }
    /**
     * taxNo
     *
     * @param  mixed $value
     * @return Builder
     */
    function taxNo(mixed $value = null): Builder
    {
        if (!$value) return $this->builder;

        return $this->builder->where('companies.tax', 'LIKE', '%' . $value . '%');
    }
    /**
     * taxPercent
     *
     * @param  mixed $value
     * @return Builder
     */
    function taxPercent(mixed $value = null): Builder
    {
        if (!$value) return $this->builder;

        return $this->builder->where('companies.tax_percentage', $value);
    }
    /**
     * vatPercent
     *
     * @param  mixed $value
     * @return Builder
     */
    function vatPercent(mixed $value = null): Builder
    {
        if (!$value) return $this->builder;

        return $this->builder->where('companies.vat_percentage', $value);
    }
    /**
     * registration
     *
     * @param  mixed $value
     * @return Builder
     */
    function registration(mixed $value = null): Builder
    {
        if (!$value) return $this->builder;

        return $this->builder->where('companies.registration', 'LIKE', '%' . $value . '%');
    }
    /**
     * fieldId
     *
     * @param  mixed $value
     * @return Builder
     */
    function fieldId(mixed $value = null): Builder
    {
        return $this->builder->where('companies.company_filed', $value);
    }
    /**
     * projectCompanyId
     *
     * @param  mixed $value
     * @return Builder
     */
    public function projectCompanyId(mixed $value = null): Builder
    {
        if (!$value) return $this->builder;
        if (!$this->isJoined($this->builder, 'project_assigned_company')) $this->_joinKeyProjectAssignCompanyTable();
        return $this->builder->where('project_assigned_company.project_id', $value);
    }
    /**
     * projectId
     *
     * @param  mixed $value
     * @return Builder
     */
    public function projectId(mixed $value = null): Builder
    {
        if (!$value) return $this->builder;
        if (!$this->isJoined($this->builder, 'projects')) $this->_joinKeyProjectTable();
        return $this->builder->where('projects.id', $value);
    }
    /**
     * updateAt
     *
     * @param  mixed $value
     * @param  mixed $columnName
     * @return Builder
     */
    public function updatedAt(?string $startDate = null, ?string $endDate = null, string $columnName = 'companies.updated_at'): Builder
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
    public function createdAt(?string $startDate = null, ?string $endDate = null, string $columnName = 'companies.created_at'): Builder
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
    public function createdBy(string $value, string $columnName = 'companies.created_by'): Builder
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
    public function updatedBy(string $value, string $columnName = 'companies.updated_by'): Builder
    {
       return parent::updatedBy($value, $columnName);
    }

    /**
     * _joinKeyContactTable
     *
     * @return void
     */
    private function _joinKeyContactTable(): void
    {
        $this->builder->join('contacts', 'contacts.company_id', '=', 'companies.id');
    }
    /**
     * _joinKeyProjectTable
     *
     * @return void
     */
    private function _joinKeyProjectTable(): void
    {
        $this->builder->join('projects', 'projects.company_id', '=', 'companies.id');
    }
    /**
     * _joinKeyProjectAssignCompanyTable
     *
     * @return void
     */
    private function _joinKeyProjectAssignCompanyTable(): void
    {
        $this->builder->join('project_assigned_company', 'project_assigned_company.company_id', '=', 'companies.id');
    }



}
