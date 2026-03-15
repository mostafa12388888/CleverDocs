<?php

namespace App\Services\Workflow;

use App\Repository\MainRepository;
use App\Repository\Workflow\SlotRelationshipConditionRepository;
use App\Services\MainService;


class SlotRelationshipConditionService extends MainService
{

    /**
     * @var SlotRelationshipConditionRepository
     */
    protected MainRepository $repository;



    /**
     * @param SlotRelationshipConditionRepository $repository
     */
    public function __construct(SlotRelationshipConditionRepository $repository)
    {
        $this->repository = $repository;
        parent::__construct($repository);
    }



}
