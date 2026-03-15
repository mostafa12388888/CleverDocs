<?php

namespace App\Services\Workflow;

use App\Repository\MainRepository;
use App\Repository\Workflow\SubmissionSlotAssigneeRepository;
use App\Services\MainService;


class SubmissionSlotAssigneeService extends MainService
{

    /**
     * @var SubmissionSlotAssigneeRepository
     */
    protected MainRepository $repository;

    /**
     * @param SubmissionSlotAssigneeRepository $repository
     */
    public function __construct(SubmissionSlotAssigneeRepository $repository)
    {
        $this->repository = $repository;
        parent::__construct($repository);
    }


}
