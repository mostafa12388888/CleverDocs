<?php

namespace App\Repository\Workflow;

use App\Models\Workflow\SlotRelationshipCondition;
use App\Repository\MainRepository;

class SlotRelationshipConditionRepository extends MainRepository
{

    /**
     * @return string
     */
    public function model(): string
    {
        return SlotRelationshipCondition::class;
    }

}

