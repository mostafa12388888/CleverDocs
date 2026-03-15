<?php

namespace App\Models\Workflow;

use App\Models\BaseModel;
use App\Models\CompanyAbout\Contact;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class EscalationCondition extends BaseModel
{
    protected $fillable = [
        'workflow_id',
        'slot_id',
        'type',
        'is_sla_exceeded',
        'is_before_sla_exceeded',
        'is_after_sla_exceeded',
        'before_sla_unit',
        'before_sla_value',
        'after_sla_unit',
        'after_sla_value',
        'is_on_received',
        'slot_index'
    ];

    /**
     * @return BelongsTo
     */
    public function workflow(): BelongsTo
    {
        return $this->belongsTo(Workflow::class);
    }

    /**
     * @return BelongsTo
     */
    public function slot(): BelongsTo
    {
        return $this->belongsTo(WorkflowSlot::class);
    }



    public function contacts(): BelongsToMany
    {
        return $this->belongsToMany(Contact::class, 'escalation_conditions_contacts', 'escalation_condition_id', 'contact_id');
    }
}
