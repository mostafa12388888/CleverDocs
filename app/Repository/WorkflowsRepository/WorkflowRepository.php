<?php

namespace App\Repository\WorkflowsRepository;

use App\Models\Workflows\WorkflowsBank;
use App\Models\Workflows\Workflows;

class WorkflowRepository{
    public function showAll(){
return WorkflowsBank::with('workflow.workflowSlot.users')->get();
    }
    public function show($id){
        if(WorkflowsBank::whereId($id)->exists())
       return WorkflowsBank::with('workflow.workflowSlot.users')->whereId($id)->get();
    return 0;
    }
    public function storeBanck()
    {
        $WorkflowsBank = WorkflowsBank::create([
            'created_by' => 'created_by']);
        return $WorkflowsBank;
    }
    public function store($data, $workflowbanckId){
        $version = Workflows::where('workflows_bank_id', $workflowbanckId)->get()->sortByDesc('version')->first();
        $workflow = Workflows::create([
            'created_by'=> 'created_by',
            'workflows_bank_id'=>  $workflowbanckId,
            'is_active'=> $data['isActive'],
            'version'=>isset($version)? $version->version+1:0 ,
            'change_doc_status'=> $data['changeDocStatus'],
            'alert_days'=> $data['AlertDays'],
            'title'=> ['ar'=>$data['titleEn'], 'en'=>$data['titleAr']],
        ]);

        return  $workflow;
    }
    // public function update($data){

    // }
    public function delete($id){
        $value = WorkflowsBank::find($id);
        if($value)
        return $value::destroy($id);
    }

}

