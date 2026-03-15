<?php

namespace App\Services\Workflow;

use App\Repository\MainRepository;
use App\Repository\Workflow\SubmissionWorkflowSlotRepository;
use App\Services\MainService;


class SubmissionWorkflowSlotService extends MainService
{

    /**
     * @var SubmissionWorkflowSlotRepository
     */
    protected MainRepository $repository;

    /**
     * @param SubmissionWorkflowSlotRepository $repository
     */
    public function __construct(SubmissionWorkflowSlotRepository $repository)
    {
        $this->repository = $repository;
        parent::__construct($repository);
    }


}
