<?php

namespace App\Models\Workflows;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
class WorkflowsSlot extends BaseModel
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['is_choice', 'workflow_id', 'has_official_signature', 'level', 'level_duration_value', 'approval_method', 'types', 'description', 'level_duration_type', 'template_input_id'];
 public function users(){
    return $this->belongsToMany(User::class, 'user_workflow_slot');
 }
 public function workflow(){
    return $this->belongsToMany(Workflows::class,'workflow_id');
 }
}
