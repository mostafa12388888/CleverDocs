<?php

namespace App\Services\Workflow;

use App\Repository\MainRepository;
use App\Repository\Workflow\EscalationConditionRepository;
use App\Services\MainService;


class EscalationConditionService extends MainService
{

    /**
     * @var EscalationConditionRepository
     */
    protected MainRepository $repository;

    /**
     * @param EscalationConditionRepository $repository
     */
    public function __construct(EscalationConditionRepository $repository)
    {
        $this->repository = $repository;
        parent::__construct($repository);
    }


    /**
     * @param int $workflowId
     * @param array $conditions
     * @param array $workflowSlotsMappedWithIndex
     * @return mixed
     * @throws \Throwable
     */
    public function addWorkflowEscalations(int $workflowId, array $conditions, array $workflowSlotsMappedWithIndex): mixed
    {
        return $this->applyTransaction(function () use ($workflowId, $conditions, $workflowSlotsMappedWithIndex) {
            $this->deleteCollection(['workflow_id' => $workflowId]);
            $escalationConditions = array_map(function ($condition) use ($workflowId, $workflowSlotsMappedWithIndex) {
                $data = [
                    'type' => $condition['type'],
                    'is_on_received' => $condition['isOnReceived'],
                    'is_sla_exceeded' => $condition['isSLAExceed'],
                    'is_before_sla_exceeded' => $condition['isBeforeSLAExceed'],
                    'is_after_sla_exceeded' => $condition['isAfterSLAExceed'],
                    'before_sla_unit' => $condition['beforeSLA']['unit'] ?? null,
                    'before_sla_value' => $condition['beforeSLA']['value'] ?? null,
                    'after_sla_unit' => $condition['afterSLA']['unit'] ?? null,
                    'after_sla_value' => $condition['afterSLA']['value'] ?? null,
                    'workflow_id' => $workflowId,
                    'slot_index' => $condition['slotIndex'] ?? null,
                ];
                $data['slot_id'] =  null;
                if($condition['type'] != 'overall' && isset($condition['slotIndex']) && isset($workflowSlotsMappedWithIndex[$condition['slotIndex']])){
                    $data['slot_id'] = $workflowSlotsMappedWithIndex[$condition['slotIndex']];
                }

                return $data;

            }, $conditions);

            return $this->insert($escalationConditions);
        });

    }

}
