<?php
namespace App\Repository\Form;

use App\Models\Form\ProjectAssignedCompany;
use App\Repository\MainRepository;

class ProjectAssignedCompanyRepository extends MainRepository{


    /**
     * model
     *
     * @return string
     */
    public function model(): string
    {
        return ProjectAssignedCompany::class;
    }
}
