<?php

namespace App\Repository\WorkflowsRepository;

use App\Models\User;
use App\Models\Workflows\WorkflowsSlot;

class WorkflowSlotRepository{

    public function store($data, $id){
        $WorkflowsSlot=WorkflowsSlot::create([
            'is_choice' => $data['isChoice'],
            'has_official_signature' => $data['hasOfficialSignature'],
            'index' => $data['index'],
            'level_duration_value' => $data['levelDurationValue'],
            'approval_method' => $data['approvalMethod'],
            'types' => $data['types'],
            'description' => $data['description'],
            'level_duration_type' => $data['levelDurationType'],
            'template_input_id'=>$data["templateInputId"] ,
            'workflow_id'=>$id ,
        ]);

        if (isset($data['usersId']))
        $WorkflowsSlot->users()->syncWithoutDetaching($data['usersId']);
        return $WorkflowsSlot;
    }
}
