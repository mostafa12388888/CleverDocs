<?php

namespace App\Models\Workflow;

use App\Models\BaseModel;
use App\Models\Form\InputType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SlotRelationshipCondition extends BaseModel
{
    use HasFactory;

    protected $fillable = [

        'title',
        'is_default',
        'type',
        'ui_info',

        //-------- condition data ------------
        'condition_operator',
        'condition_input_id',
        'condition_value',

        'parent_slot_id',
        'child_slot_id',
    ];

    public function parentSlot(): BelongsTo
    {
        return $this->belongsTo(SubmissionWorkflowSlot::class, 'parent_slot_id');
    }

    public function childSlot(): BelongsTo
    {
        return $this->belongsTo(SubmissionWorkflowSlot::class, 'child_slot_id');
    }

    public function condition(): BelongsTo
    {
        return $this->belongsTo(SlotCondition::class, 'condition_id');
    }





}
