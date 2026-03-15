<?php

namespace App\Models\Form\CustomOption;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use  App\Traits\Filterable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InputOption extends BaseModel
{
    use HasFactory, SoftDeletes, Filterable;
    protected $fillable = ['title', 'is_active', 'is_default','is_default_list', 'custom_option_list_id','created_by','updated_by','deleted_by'];
    protected $casts = [
        "title" => "array",
    ];
    protected $attributes = [
        'is_default' => 0
    ];
    public function customOptionList()
    {
        return $this->belongsTo(CustomOptionList::class, 'custom_option_list_id');
    }

    /**
     * createdBy
     *
     * @return BelongsTo
     */
    public function createdBy():BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    /**
     * updatedBy
     *
     * @return BelongsTo
     */
    public function updatedBy():BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
    /**
     * deletedBy
     *
     * @return BelongsTo
     */
    public function deletedBy():BelongsTo
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }
}
