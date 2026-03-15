<?php

namespace App\Repository\Form;

use App\Models\Form\TemplatesFormProjects;
use App\Repository\MainRepository;

class TemplatesFormProjectRepository extends MainRepository
{

    /**
     * @return string
     */
    public function model(): string
    {
        return TemplatesFormProjects::class;
    }


}

