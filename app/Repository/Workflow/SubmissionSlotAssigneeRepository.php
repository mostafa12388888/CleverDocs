<?php

namespace App\Repository\Workflow;

use App\Models\Workflow\SubmissionSlotAssignee;
use App\Repository\MainRepository;

class SubmissionSlotAssigneeRepository extends MainRepository
{

    /**
     * @return string
     */
    public function model(): string
    {
        return SubmissionSlotAssignee::class;
    }

}

