<?php

namespace App\Models\Workflow;

use App\Models\BaseModel;
use App\Models\Form\MainTemplateForm;
use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;

class Workflow extends BaseModel
{
    use HasFactory, Filterable,SoftDeletes;

    protected $fillable = [
        'created_by',
        'updated_by',
        'sla_unit',
        'sla_value',
        'version',
        'title',
        'is_auto_close',
        'is_active',
        'main_workflow_id',
        'main_form_id',
    ];

    /**
     * @return BelongsTo
     */
    public function mainWorkflow():BelongsTo
    {
        return $this->belongsTo(MainWorkflow::class);
    }
    /**
     * mainForm
     *
     * @return BelongsTo
     */
    public function mainForm():BelongsTo
    {
        return $this->belongsTo(MainTemplateForm::class,"main_form_id");
    }

    /**
     * @return HasMany
     */
    public function workflowSlots(): HasMany
    {
        return $this->hasMany(WorkflowSlot::class);
    }

    /**
     * @return HasMany
     */
    public function escalationConditions(): HasMany
    {
        return $this->hasMany(EscalationCondition::class);
    }

    /**
     * @return HasManyThrough
     */
    public function watchers(): HasManyThrough
    {
        return $this->hasManyThrough(MainWorkflowWatcher::class, MainWorkflow::class, 'id', 'main_workflow_id', 'main_workflow_id', 'id');
    }



    //------------------ scopes -----------------------//

    /**
     * @param object $query
     * @param int $id
     * @return mixed
     */
    public function scopeByMainWorkflowId(object $query, int $id): mixed
    {
        return $query->where('main_workflow_id', $id);
    }
}


