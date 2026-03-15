<?php

namespace App\Models\Workflow;

use App\Models\BaseModel;
use App\Models\Form\Project;
use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class MainWorkflow extends BaseModel
{
    use HasFactory, SoftDeletes, Filterable;

    protected $fillable = [
        'created_by',
        'updated_by',
        'project_id',
    ];

    /**
     * @return HasMany
     */
    public function workflows(): HasMany
    {
        return $this->hasMany(Workflow::class);
    }
    /**
     * project
     *
     * @return BelongsTo
     */
    public function project() : BelongsTo
    {
        return $this->belongsTo(Project::class,'project_id');
    }


    /**
     * @return HasOne
     */
    public function lastVersion(): HasOne
    {
        return $this->hasOne(Workflow::class, 'main_workflow_id', 'id')
            ->latest('version');
    }

    /**
     * @return HasMany
     */
    public function watchers(): HasMany
    {
        return $this->hasMany(MainWorkflowWatcher::class);
    }
}
