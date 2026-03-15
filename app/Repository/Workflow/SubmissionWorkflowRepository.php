<?php

namespace App\Repository\Workflow;

use App\Models\Workflow\SubmissionWorkflow;
use App\Repository\MainRepository;

class SubmissionWorkflowRepository extends MainRepository
{

    /**
     * @return string
     */
    public function model(): string
    {
        return SubmissionWorkflow::class;
    }

}

