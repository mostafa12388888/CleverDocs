<?php

namespace App\Models\Workflow;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SubmissionWorkflowSlot extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'sla_unit',
        'sla_value',
        'shape',
        'is_auto_decision',
        'position',
        'auto_close',
        'status',
        'index',
        'approval_method',
        'is_official_signature',
        'signature_input_id',
        'approval_text_id',
        'submission_workflow_id',
        'workflow_slot_id',
    ];


    public function conditions(): HasMany
    {
        return $this->hasMany(SlotCondition::class);
    }


}
