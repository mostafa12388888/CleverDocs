<?php

namespace App\Repository\Workflow;

use App\Models\Workflow\SubmissionWorkflowSlot;
use App\Repository\MainRepository;

class SubmissionWorkflowSlotRepository extends MainRepository
{

    /**
     * @return string
     */
    public function model(): string
    {
        return SubmissionWorkflowSlot::class;
    }

}

