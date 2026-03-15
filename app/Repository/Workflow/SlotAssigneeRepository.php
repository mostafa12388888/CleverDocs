<?php

namespace App\Repository\Workflow;

use App\Models\Workflow\SlotAssignee;
use App\Repository\MainRepository;

class SlotAssigneeRepository extends MainRepository
{

    /**
     * @return string
     */
    public function model(): string
    {
        return SlotAssignee::class;
    }

}

