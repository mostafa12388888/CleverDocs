<?php

namespace App\Services\Workflow;

use App\Repository\MainRepository;
use App\Repository\Workflow\WorkflowRepository;
use App\Services\MainService;
use Throwable;


class WorkflowService extends MainService
{

    /**
     * @var WorkflowRepository
     */
    protected MainRepository $repository;

    /**
     * @param WorkflowRepository $repository
     */
    public function __construct(WorkflowRepository $repository)
    {
        $this->repository = $repository;
        parent::__construct($repository);
    }

    /**
     * @param int $mainWorkflowId
     * @param int $page
     * @param int $perPage
     * @return mixed
     */
    public function allVersions(int $mainWorkflowId, int $page, int $perPage): mixed
    {
        return $this->repository->allVersions($mainWorkflowId, $page, $perPage);
    }


    /**
     * @param array $data
     * @return mixed
     * @throws Throwable
     */
    public function store(array $data): mixed
    {
        return $this->applyTransaction(function () use ($data) {
            $mainWorkflow = app(MainWorkflowService::class)->add([
                'created_by' => auth()->id(),
                'project_id'=>$data['projectId']
            ]);
            return $this->_createWorkflowVersion($mainWorkflow->id, $data);
        });
    }

    /**
     * @param $mainWorkflowId
     * @param array $data
     * @return mixed
     * @throws Throwable
     */
    private function _createWorkflowVersion($mainWorkflowId, array $data): mixed
    {
        return $this->applyTransaction(function () use ($mainWorkflowId, $data) {

            ///-------------- step 1 create Workflow
            $workflow = $this->add([
                'main_workflow_id' => $mainWorkflowId,
                'created_by' => auth()->id(),
                'title' => json_encode($data['title']),
                'sla_unit' => $data['sla']['type'],
                'sla_value' => $data['sla']['value'],
                'is_auto_close' => $data['isAutoClose'] ?? false,
                'is_active' => $data['isActive'] ?? true,
                'version' =>  ($this->max('version', ['main_workflow_id' => $mainWorkflowId]) ?? 0) + 1,
                'main_form_id' => $data['mainFormId'] ?? null,
            ]);

            ///-------------- step 2 create Workflow Slots And Slot Assignees and Slots Branches (Slot Relationships)
            $workflowSlotsMappedWithIndex =  app(WorkflowSlotService::class)->addWorkflowSlots($workflow->id, $data['slots']);

            //------------ step 3 create Workflow Watchers
            if(isset($data['watchers']) && count($data['watchers']) > 0)
            app(MainWorkflowWatcherService::class)->addMainWorkflowWatchers($mainWorkflowId, $data['watchers']);

            //------------ step 4 create Workflow Escalations and Escalation Conditions
            if(isset($data['escalations']) && count($data['escalations']) > 0)
            app(EscalationConditionService::class)->addWorkflowEscalations($workflow->id, $data['escalations'], $workflowSlotsMappedWithIndex);


            return $workflow;
        });
    }

    /**
     * @param int $id
     * @return bool
     * @throws Throwable
     */
    public function deleteWorkflow(int $id): bool
    {
        $workflow = $this->find($id);
        if (!$workflow) return false;
        return $this->_deleteWorkflow($workflow);
    }

    /**
     * @param int $id
     * @param mixed $workflow
     * @return bool
     * @throws Throwable
     */
    private function _deleteWorkflow(mixed $workflow): bool
    {
        return $this->applyTransaction(function () use ($workflow) {

            $this->_validateDelete($workflow);

            $mainWorkflow = app(MainWorkflowService::class)->find($workflow->main_workflow_id);

//            parent::update($workflow->id, ['deleted_by' => auth()->id()]);

            $this->delete([$workflow->id]);

            if ($mainWorkflow && $mainWorkflow->workflows_count == 0) {
                app(MainWorkflowService::class)->delete([$mainWorkflow->id]);
            }

            return true;
        });
    }

    /**
     * @param int $id
     */
    private function _validateDelete(mixed $workflow)
    {
    }

    /**
     * @param int $id
     * @param array $data
     * @return mixed
     * @throws Throwable
     */
    public function update(int $id, array $data): mixed
    {
        return $this->applyTransaction(function () use ($id, $data) {
            $mainWorkflow = app(MainWorkflowService::class)->update($id, [
                'updated_by' => auth()->id(),
            ]);
            return $this->_createWorkflowVersion($mainWorkflow->id, $data);
        });
    }

    public function bulkDelete(array $workflow)
    {
        $mainIds=$this->findAllByWhereIn("id",$workflow["ids"])->pluck("main_workflow_id")->unique()->toArray();
        $this->repository->updateWhereIn("id",$workflow["ids"], [
            'deleted_by' => auth()->user()->id,
        ]);
        app(MainWorkflowService::class)->findAllByWhereIn("id",$mainIds)->each(function($mainWorkflow){
            if($mainWorkflow->workflows_count==0){
                app(MainWorkflowService::class)->update($mainWorkflow->id,['deleted_by' => auth()->id()]);
                app(MainWorkflowService::class)->delete([$mainWorkflow->id]);
            }
        });
        return $this->delete($workflow["ids"]);

    }



}
