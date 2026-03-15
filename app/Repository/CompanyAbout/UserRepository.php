<?php

namespace App\Repository\CompanyAbout;

use App\Http\Filters\Filter;
use App\Models\User;
use App\Repository\MainRepository;

class UserRepository extends MainRepository
{

    /**
     * model
     *
     * @return string
     */
    public function model(): string
    {
        return User::class;
    }


    /**
     * index
     *
     * @param mixed $page
     * @param mixed $perPage
     */
    public function index(int $page, int $perPage, ?Filter $filter = null)
    {
        $columns = [
            "users.*",
            "contacts.id as contact_id",
            "contacts.name as contact_name",
            "contacts.position as contact_position",
            "companies.id as company_id",
            "companies.name as company_name",
            "roles.id as role_id",
            "roles.name as role_name",
            "created_by.id as created_by_id",
            "created_by_contact.id as created_by_contact_id",
            "created_by_contact.name as created_by_contact_name",
            "updated_by.id as updated_by_id",
            "updated_by_contact.id as updated_by_contact_id",
            "updated_by_contact.name as updated_by_contact_name",


        ];

        return $this->model
            ->where("users.is_hide", 0)
            ->leftJoinContactCompany()
            ->leftJoinRole()
            ->leftJoinCreatedByContact()
            ->leftJoinUpdatedByContact()
            ->filter($filter)
            ->groupBy("users.id")
            ->with("updatedBy", "createdBy", "createdBy.contact", "updatedBy.contact")
            ->latest()->paginate($perPage, $columns, 'page', $page);
    }


    /**
     * show
     *
     * @param mixed $id
     * @return mixed
     */
    public function show(int $id)
    {
        $columns = [
            "users.*",
            "contacts.id as contact_id",
            "contacts.name as contact_name",
            "contacts.position as contact_position",
            "companies.id as company_id",
            "companies.name as company_name",
            "roles.id as role_id",
            "roles.name as role_name"
        ];

        return $this->model
//            ->where("users.is_hide", 0)
            ->leftJoinContactCompany()
            ->leftJoinRole()
            ->where("users.id", $id)
            ->groupBy("users.id")
            ->with("updatedBy", "createdBy", "createdBy.contact", "updatedBy.contact", "projects", "projects.wbs","loginHistories")
            ->select($columns)
            ->first();
    }

    /**
     * lookUpPagination
     *
     * @param mixed $page
     * @param mixed $perPage
     * @param mixed $filter
     * @return mixed
     */
    public function lookUpPagination(int $page, int $perPage, ?Filter $filter = null): mixed
    {
        $columns = [
            "users.*",
            "contacts.id as contact_id",
            "contacts.name as contact_name"
        ];

        return $this->model->leftJoinContact()
            ->filter($filter)
            ->where("users.is_hide", 0)->latest()
            ->paginate($perPage, $columns, 'page', $page);
    }

public function exportAll(?Filter $filter = null)
{
            $columns = [
            "users.*",
            "contacts.id as contact_id",
            "contacts.name as contact_name",
            "contacts.position as contact_position",
            "companies.id as company_id",
            "companies.name as company_name",
            "roles.id as role_id",
            "roles.name as role_name",
            "created_by.id as created_by_id",
            "created_by_contact.id as created_by_contact_id",
            "created_by_contact.name as created_by_contact_name",
            "updated_by.id as updated_by_id",
            "updated_by_contact.id as updated_by_contact_id",
            "updated_by_contact.name as updated_by_contact_name",


        ];

    return $this->model
        ->where("users.is_hide", 0)
        ->leftJoinContactCompany()
        ->leftJoinRole()
        ->leftJoinCreatedByContact()
        ->leftJoinUpdatedByContact()
        ->filter($filter)
        ->groupBy("users.id")
        ->select($columns)->latest()
        ->get();
}

}
