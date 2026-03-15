<?php

namespace App\Repository\Workflow;

use App\Models\Workflow\EscalationCondition;
use App\Repository\MainRepository;

class EscalationConditionRepository extends MainRepository
{

    public function model(): string
    {
        return EscalationCondition::class;
    }

}

