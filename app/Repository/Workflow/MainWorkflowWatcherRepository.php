<?php

namespace App\Repository\Workflow;

use App\Models\Workflow\MainWorkflowWatcher;
use App\Repository\MainRepository;

class MainWorkflowWatcherRepository extends MainRepository
{

    /**
     * @return string
     */
    public function model(): string
    {
        return MainWorkflowWatcher::class;
    }

}

