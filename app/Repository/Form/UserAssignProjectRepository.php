<?php

namespace App\Repository\Form;

use App\Models\Form\UserAssignProject;
use App\Repository\MainRepository;

class UserAssignProjectRepository extends MainRepository
{

    /**
     * @return string
     */
    public function model(): string
    {
        return UserAssignProject::class;
    }


}
