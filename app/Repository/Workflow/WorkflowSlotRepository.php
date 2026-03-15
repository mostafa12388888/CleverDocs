<?php

namespace App\Repository\Workflow;

use App\Models\Workflow\WorkflowSlot;
use App\Repository\MainRepository;

class WorkflowSlotRepository extends MainRepository
{

    /**
     * @return string
     */
    public function model(): string
    {
        return WorkflowSlot::class;
    }


}

