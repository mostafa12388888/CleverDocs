<?php

namespace App\Models\Dashboard;

use App\Models\User;
use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Component extends Model
{
    use HasFactory, Filterable, SoftDeletes;
    protected $fillable = [
        'title',
        'is_private',
        'form_id',
        'dashboard_id',
        'created_by',
        'updated_by',
        'deleted_by',
        'color_record',
        'group_by',
        'chart_type',
        'count_by',
    ];
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'title' => 'array',
        'color_record' => 'array',
    ];
    /**
     * filters
     *
     * @return HasMany
     */
    public function filters(): HasOne
    {
        return $this->hasOne(ComponentFormSubmission::class, 'component_id');
    }
    /**
     * createdBy
     *
     * @return BelongsTo
     */
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    /**
     * updatedBy
     *
     * @return BelongsTo
     */
    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
