<?php
namespace App\Services\Workflows;

use App\Models\Workflows\WorkflowsSlot;
use App\Repository\WorkflowsRepository\WorkflowRepository;
use App\Repository\WorkflowsRepository\WorkflowSlotRepository;
use App\Repository\WorkflowsRepository\WorkflowSubmissionSlotRepository;

class WorkflowServices{
    private $repository;
    private $submissionRepostory;
 public function __construct(WorkflowRepository $repository,WorkflowSlotRepository $submissionRepostory)
 {
 $this->repository = $repository;
 $this->submissionRepostory= $submissionRepostory;
 }
 public function showAll(){
        return $this->repository->showAll();
 }
 public function show($id){
        return $this->repository->show($id);
 }
 public function store($data, $workflowbanckId=null){
        $banckId =is_null($workflowbanckId)? $this->repository->storeBanck()->id:$workflowbanckId;

        $submissionId=$this->repository->store($data["mainData"],$banckId);
        $arrydata=[];
        foreach($data["workflowsData"] as $value)
        $arrydata[]=$this->submissionRepostory->store($value, $submissionId->id);
    $value= array_merge($arrydata, [$submissionId]);
      return "success";

 }
 public function delete($id){
    return $this->repository->delete($id);
 }

}
