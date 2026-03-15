<?php

namespace App\Models\Workflow;

use App\Models\BaseModel;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SlotAssignee extends BaseModel
{

    use HasFactory;

    protected $fillable = [
        'workflow_slot_id',
        'user_id',
    ];

    /**
     * @return BelongsTo
     */
    public function slot(): BelongsTo
    {
        return $this->belongsTo(WorkflowSlot::class);
    }

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
