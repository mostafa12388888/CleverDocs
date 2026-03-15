<?php

namespace App\Services\Workflow;

use App\Repository\MainRepository;
use App\Repository\Workflow\SubmissionWorkflowRepository;
use App\Services\MainService;


class SubmissionWorkflowService extends MainService
{

    /**
     * @var SubmissionWorkflowRepository
     */
    protected MainRepository $repository;

    /**
     * @param SubmissionWorkflowRepository $repository
     */
    public function __construct(SubmissionWorkflowRepository $repository)
    {
        $this->repository = $repository;
        parent::__construct($repository);
    }


}
