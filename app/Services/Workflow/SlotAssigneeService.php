<?php

namespace App\Services\Workflow;

use App\Repository\MainRepository;
use App\Repository\Workflow\SlotAssigneeRepository;
use App\Services\MainService;


class SlotAssigneeService extends MainService
{

    /**
     * @var SlotAssigneeRepository
     */
    protected MainRepository $repository;



    /**
     * @param SlotAssigneeRepository $repository
     */
    public function __construct(SlotAssigneeRepository $repository)
    {
        $this->repository = $repository;
        parent::__construct($repository);
    }


    public function addSlotAssignees(int $slotId, $assignees): mixed
    {
        $assigneesData = [];
        foreach ($assignees as $assignee){
            $assigneesData[] = [
                'workflow_slot_id' => $slotId,
                'user_id' => $assignee,
            ];
        }

        return $this->repository->insert($assigneesData);
    }


}
