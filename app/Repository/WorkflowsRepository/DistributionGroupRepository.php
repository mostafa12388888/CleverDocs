<?php

namespace App\Repository\WorkflowsRepository;

use App\Models\Workflows\DistributionGroup;

class DistributionGroupRepository{

    public function store($data){
        DistributionGroup::create([]);
    }
}

