<?php

namespace App\Models\Workflow;

use App\Models\BaseModel;
use App\Models\Form\InputType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SlotCondition extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'operator',
        'input_id',
        'title',
        'condition_value',
    ];

    public function input(): BelongsTo
    {
        return $this->belongsTo(InputType::class);
    }




}
