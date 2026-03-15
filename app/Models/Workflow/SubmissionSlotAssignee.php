<?php

namespace App\Models\Workflow;

use App\Models\BaseModel;
use App\Models\Form\FormSubmission;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SubmissionSlotAssignee extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'submission_slot_id',
        'assignee_id',
        'status',
        'submission_workflow_slot_id',
        'submission_workflow_id',
        'submission_id',
        'is_chosen',
        'is_action_by',
        'comment',
        'action_date',
    ];

    public function submissionWorkflowSlot(): BelongsTo
    {
        return $this->belongsTo(SubmissionWorkflowSlot::class);
    }

    public function submissionWorkflow(): BelongsTo
    {
        return $this->belongsTo(SubmissionWorkflow::class);
    }

    public function submissionSlot(): BelongsTo
    {
        return $this->belongsTo(FormSubmission::class);
    }




}
