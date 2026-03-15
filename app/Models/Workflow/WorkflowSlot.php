<?php

namespace App\Models\Workflow;

use App\Models\BaseModel;
use App\Models\User;
use App\Services\Workflow\SlotRelationshipConditionService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class WorkflowSlot extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'title',
        'shape',
        'description',
        'sla_unit',
        'sla_value',
        'is_auto_decision',
        'position',
        'auto_close',
        'status',
        'index',
        'approval_method',
        'is_official_signature',
        'signature_input_id',
        'index',
        'ui_info',
        'workflow_id',
    ];


    public function workflow(): BelongsTo
    {
        return $this->belongsTo(Workflow::class);
    }

    public function parentSlots(): BelongsToMany
    {
        return $this->belongsToMany(WorkflowSlot::class, 'slot_relationship_conditions', 'child_slot_id', 'parent_slot_id')
            ->withPivot('operator', 'title', 'condition_value', 'condition_id');
    }

    public function childSlots(): BelongsToMany
    {
        return $this->belongsToMany(WorkflowSlot::class, 'slot_relationship_conditions', 'parent_slot_id', 'child_slot_id')
            ->withPivot('operator', 'title', 'condition_value', 'condition_id');
    }

    public function assignees(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'slot_assignees', 'slot_id', 'user_id');
    }

    public function escalationConditions(): BelongsToMany
    {
        return $this->belongsToMany(EscalationCondition::class, 'slot_escalation_conditions', 'slot_id', 'escalation_condition_id');
    }
}
