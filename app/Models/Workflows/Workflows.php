<?php

namespace App\Models\Workflows;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
class Workflows extends BaseModel
{
    use HasFactory, SoftDeletes;
    protected $table= "workflows";
    protected $fillable = ['deleted_by', 'created_by', 'workflows_bank_id', 'is_active', 'version', 'change_doc_status', 'alert_days', 'title'];
    public function workflowBank(){
        return $this->belongsTo(WorkflowsBank::class, 'workflows_bank_id');
    }
    public function workflowSubmission()
    {
        return $this->belongsTo(WorkflowsSubmission::class, 'workflow_id');
    }
    public function workflowSlot(){
        return $this->hasMany(WorkflowsSlot::class, 'workflow_id');
    }
    protected $casts = [
        'title' => 'array',
    ];

}
