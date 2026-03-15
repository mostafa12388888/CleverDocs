<?php

namespace App\Repository\Workflow;

use App\Models\Workflow\SlotCondition;
use App\Repository\MainRepository;

class SlotConditionRepository extends MainRepository
{

    /**
     * @return string
     */
    public function model(): string
    {
        return SlotCondition::class;
    }

}

