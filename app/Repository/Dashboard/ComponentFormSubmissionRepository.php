<?php

namespace App\Repository\Dashboard;
use App\Models\Dashboard\ComponentFormSubmission;
use App\Repository\MainRepository;
class ComponentFormSubmissionRepository extends MainRepository
{
    /**
     * @return string
     */
    public function model(): string
    {
        return ComponentFormSubmission::class;
    }

}
