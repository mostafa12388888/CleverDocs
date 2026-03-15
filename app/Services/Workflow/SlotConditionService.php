<?php

namespace App\Services\Workflow;

use App\Repository\MainRepository;
use App\Repository\Workflow\SlotConditionRepository;
use App\Services\MainService;


class SlotConditionService extends MainService
{

    /**
     * @var SlotConditionRepository
     */
    protected MainRepository $repository;



    /**
     * @param SlotConditionRepository $repository
     */
    public function __construct(SlotConditionRepository $repository)
    {
        $this->repository = $repository;
        parent::__construct($repository);
    }

}
