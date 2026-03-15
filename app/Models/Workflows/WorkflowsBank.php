<?php

namespace App\Models\Workflows;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
class WorkflowsBank extends BaseModel
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['deleted_by', 'created_by'];
    public function workflow()
    {
        return $this->hasMany(Workflows::class, 'workflows_bank_id');
    }
}
