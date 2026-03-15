<?php

namespace App\Models\Workflows;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
class WorkflowsSubmissionSlot extends BaseModel
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'is_choice', 'has_official_signature',
        'level', 'level_duration_value', 'approval_method', 'types',
        'description', 'level_duration_type', 'status', 'finished_at', 'signature_type', 'signature_img'];
}
