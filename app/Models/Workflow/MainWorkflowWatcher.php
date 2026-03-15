<?php

namespace App\Models\Workflow;

use App\Models\BaseModel;
use App\Models\User;
use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class MainWorkflowWatcher extends BaseModel
{
    use HasFactory, Filterable;

    protected $fillable = [
        'user_id',
        'main_workflow_id'
    ];


    public function mainWorkflow(): HasOne
    {
        return $this->hasOne(MainWorkflow::class, 'id', 'main_workflow_id');
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
