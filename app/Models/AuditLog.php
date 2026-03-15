<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use App\Models\User;

class AuditLog extends Model
{
    use HasFactory, Filterable;
    protected $fillable = [
        'action',
        'model_type',
        'model_id',
        'old_values',
        'new_values',
        'old_related_data',
        'new_related_data',
        'user_id',
    ];

    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array',
        'old_related_data' => 'array',
        'new_related_data' => 'array',
    ];
    // Relation Functions
    /**
     * user
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }



    /**
     * auditable
     *
     * @return MorphTo
     */
    public function auditable(): MorphTo
    {
        return $this->morphTo();
    }
}
