<?php

namespace App\Models\Form;

use App\Models\User;
use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Module extends BaseModel
{
    use HasFactory, SoftDeletes, Filterable;
    protected $fillable = ['order', 'name',"updated_by","deleted_by","created_by"];
    // public $timestamps = false;
    protected $casts = [
        "name" => "array",
    ];


    public function mainTemplateForms(): HasMany
    {
        return $this->hasMany(MainTemplateForm::class, 'module_id');
    }


    public function mainTemplateWithFormLastVersion(): HasMany
    {
        return $this->hasMany(MainTemplateForm::class, 'module_id')->with('lastVersion');
    }


    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
    public function deletedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }
}
