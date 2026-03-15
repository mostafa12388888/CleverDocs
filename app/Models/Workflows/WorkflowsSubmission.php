<?php

namespace App\Models\Workflows;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;
use App\Models\Form\FormSubmission;
use Illuminate\Database\Eloquent\SoftDeletes;
class WorkflowsSubmission extends BaseModel
{
    use HasFactory, SoftDeletes;
    protected $fillable= ['workflow_id', 'document_submission_id', 'created_by', 'status', 'type'];
    public function workflow(){
        return $this->belongsTo(Workflows::class, 'workflow_id');
    }
    public function documentSubmission(){
        return $this->belongsTo(FormSubmission::class, 'document_submission_id');
    }
}
