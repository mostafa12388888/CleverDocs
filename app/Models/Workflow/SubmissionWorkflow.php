<?php

namespace App\Models\Workflow;

use App\Models\BaseModel;
use App\Models\Form\FormSubmission;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SubmissionWorkflow extends BaseModel
{
    use HasFactory;


    protected $fillable = [
        'created_date',
        'started_date',
        'is_auto',
        'status',
        'created_by',
        'submission_id',
        'workflow_id',
    ];


    public function submission(): BelongsTo
    {
        return $this->belongsTo(FormSubmission::class);
    }

    public function workflow(): BelongsTo
    {
        return $this->belongsTo(Workflow::class);
    }

}
