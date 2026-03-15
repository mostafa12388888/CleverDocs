<?php

namespace App\Repository\WorkflowsRepository;

use App\Models\Workflows\WorkflowsSubmissionSlot;

class WorkflowSubmissionSlotRepository {

    public function store($data){
        WorkflowsSubmissionSlot::create([
            'is_choice'=>$data['isChoice'],
            'has_official_signature'=> $data['hasOfficialSignature'],
            'index'=> $data['index'],
             'level_duration_value'=>$data['levelDurationValue'],
             'approval_method'=>$data['approvalMethod'],
             'types'=>$data['types'],
            'description'=>$data['description'],
            'level_duration_type'=>$data['levelDurationType'],
             'status'=>$data['status'],
             'finished_at'=>$data['finishedAt'],
             'signature_type'=>$data['signatureType'],
            'signature_img'=>$data['signatureImg'],
        ]);
    }
}
