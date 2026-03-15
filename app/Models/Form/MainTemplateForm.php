<?php

namespace App\Models\Form;

use App\Models\User;
use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;
use App\Models\Workflow\Workflow;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class MainTemplateForm extends BaseModel
{
    use HasFactory, SoftDeletes,Filterable;

    protected $table = "main_template_forms";
    protected $fillable = ['deleted_by', "is_default", "key", 'created_by', 'updated_by', 'module_id', 'name'];


    //------------------- Relations ---------------------//

    public function templateForms():HasMany
    {
        return $this->hasMany(TemplatesForm::class, 'main_template_form_id');
    }

    public function lastVersion(): HasOne
    {
        return $this->hasOne(TemplatesForm::class, 'main_template_form_id', 'id')
            ->latest('version');
    }


    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
    public function modules(): BelongsTo
    {
        return $this->belongsTo(Module::class, 'module_id');
    }
    /**
     * workflows
     *
     * @return HasMany
     */
    public function workflows(): HasMany
    {
        return $this->hasMany(Workflow::class, 'main_form_id', 'id');
    }
    //--------------------- Scopes ------------------------//


}
