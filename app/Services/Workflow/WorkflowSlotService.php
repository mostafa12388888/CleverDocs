<?php

namespace App\Services\Workflow;

use App\Repository\MainRepository;
use App\Repository\Workflow\WorkflowSlotRepository;
use App\Services\MainService;
use Exception;


class WorkflowSlotService extends MainService
{

    /**
     * @var WorkflowSlotRepository
     */
    protected MainRepository $repository;

    /**
     * @param WorkflowSlotRepository $repository
     */
    public function __construct(WorkflowSlotRepository $repository)
    {
        $this->repository = $repository;
        parent::__construct($repository);
    }


    /**
     * @throws \Throwable
     */
    public function addWorkflowSlots(int $workflowId, $slots): array
    {
        $workflowSlotsMappedWithIndex = [];


        foreach ($slots as $slot){
            $data = [
                'workflow_id' => $workflowId,
                'shape' => $slot['shape'],
                'title' => json_encode($slot['title']),
                'description' => $slot['description'] ? json_encode($slot['description']) : null,
                'sla_unit' => $slot['sla']['type'] ?? null,
                'sla_value' => $slot['sla']['value'] ?? null,
                'is_auto_decision' => $slot['isAutoDecision'] ?? null,
                'position' => isset($slot['position']) ? json_encode($slot['position']) : null,
                'auto_close' => $slot['autoClose'] ?? false,
                'approval_method' => $slot['approvalMethod'] ?? null,
                'is_official_signature' => $slot['isOfficialSignature'] ?? false,
                'signature_input_id' => $slot['signatureInputId'] ?? null,
                'index' => $slot['index'],
                'ui_info' => isset($slot['uiInfo']) ? json_encode($slot['uiInfo']) : null,
            ];

            $addedSlot = $this->add($data);

            $workflowSlotsMappedWithIndex[$slot['index']] = $addedSlot->id;

            // insert slot assignees
            if(isset($slot['assignees']) && count($slot['assignees']) > 0){
               app(SlotAssigneeService::class)->addSlotAssignees($addedSlot->id, $slot['assignees']);
            }

            // insert slot Relationship Condition
            $slotConditions = $this->_addSlotConditionRelationship($slot, $workflowSlotsMappedWithIndex, $addedSlot);
        }

        return $workflowSlotsMappedWithIndex;
    }

    /**
     * @param $slot
     * @param $workflowSlotsMappedWithIndex
     * @param mixed $addedSlot
     * @return mixed
     * @throws Exception
     */
    public function _addSlotConditionRelationship($slot, $workflowSlotsMappedWithIndex, mixed $addedSlot): mixed
    {
        $slotRelationshipConditions = [];
        if (isset($slot['fromBranches']) && count($slot['fromBranches']) > 0) {
            foreach ($slot['fromBranches'] as $branch) {

                if(!isset($branch['linkIndex']) || !$branch['linkIndex']){
                   continue;
                }
                if (!isset($workflowSlotsMappedWithIndex[$branch['linkIndex']])){
                    throw new Exception('Parent Slot Not Found');
                }

                $branchData = [];
                $branchData['parent_slot_id'] = $workflowSlotsMappedWithIndex[$branch['linkIndex']];
                $branchData['child_slot_id'] = $addedSlot->id;
                $branchData['title'] = json_encode($branch['title']);
                $branchData['is_default'] = $branch['isDefault'] ?? false;
                $branchData['type'] = $branch['type'];
                $branchData['condition_operator'] = isset($branch['condition']) ? $branch['condition']['operator'] : null;
                $branchData['condition_input_id'] = isset($branch['condition']) ? $branch['condition']['inputId'] : null;
                $branchData['condition_value'] = isset($branch['condition']) ? $branch['condition']['value'] : null;
                $branchData['ui_info'] = $branch['uiInfo'] ? json_encode($branch['uiInfo']) : null;
                $slotRelationshipConditions[] = $branchData;

            }
        }

        if (count($slotRelationshipConditions) > 0){
           return  app(SlotRelationshipConditionService::class)->insert($slotRelationshipConditions);
        }

        return null;
    }

}
