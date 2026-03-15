<?php

namespace App\Repository\WorkflowsRepository;

use App\Models\Workflows\WorkflowsSubmission;

class WorkflowSubmissionRepository{

    public function store($data, $submissionId)
    {
        $WorkflowsSubmission = WorkflowsSubmission::create([
            'created_by' => 'created_by',
            'workflow_id'=> $submissionId,
            'document_submission_id'=> $data['documentSubmissionId'],
            'status'=> $data['status'],
            'type' => $data['type'],
        ]);
        return $WorkflowsSubmission;
    }
}


