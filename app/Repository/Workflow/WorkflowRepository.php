<?php

namespace App\Repository\Workflow;

use App\Models\Workflow\Workflow;
use App\Repository\MainRepository;

class WorkflowRepository extends MainRepository
{

    /**
     * @return string
     */
    public function model(): string
    {
        return Workflow::class;
    }


    /**
     * @param int $mainWorkflowId
     * @param int $page
     * @param int $perPage
     * @return mixed
     */
    public function allVersions(int $mainWorkflowId, int $page, int $perPage): mixed
    {

        return $this->model
            ->select(['workflows.*'])
            ->with("updatedBy","createdBy","mainWorkflow")
            ->byMainWorkflowId($mainWorkflowId)
            ->latest()->paginate($perPage, '*', 'page', $page);
    }

}

