<?php

namespace App\Models\Form;

use App\Enum\Form\InputTypeEnum;
use App\Models\InputForm\PrintInput;
use App\Models\InputForm\TemplateInput;
use App\Models\User;
use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;

class TemplatesForm extends BaseModel
{
    use HasFactory, SoftDeletes,Filterable;

    protected $table = "templates_forms";
    protected $fillable = ['id', "symbol",'workflow_id', 'update_date', 'main_template_form_id', 'version', 'create_by', "deleted_by", 'status', 'Primary', 'layout', 'name'];
    protected $casts = [
        'name' => 'array',
    ];


    //------------------ relations -----------------------//

    public function mainTemplate(): BelongsTo
    {
        return $this->belongsTo(MainTemplateForm::class, 'main_template_form_id');
    }

    public function templateInputs(): HasMany
    {
        return $this->hasMany(TemplateInput::class, 'templates_forms_id');
    }
    public function hasOfficialSignature(): bool
    {
        return $this->templateInputs()
            ->whereRelation('templateType', 'type', InputTypeEnum::OFFICIAL_SIGNATURE)->exists();
    }


    public function templatesFormProjects(): HasMany
    {
        return $this->hasMany(TemplatesFormProjects::class, 'templates_form_id');
    }

    public function submissions(): HasManyThrough
    {
        return $this->hasManyThrough(FormSubmission::class, TemplatesFormProjects::class, 'templates_form_id', 'templates_form_project_id');
    }


    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'create_by');
    }


    public function project(): BelongsToMany
    {
        return $this->belongsToMany(Project::class, 'templates_form_projects');
    }


    public function mainTemplateForm(): BelongsTo
    {
        return $this->belongsTo(MainTemplateForm::class, 'main_template_form_id');
    }

    //---------------------- Scopes ------------------//

    /**
     * @param object $query
     * @param int $id
     * @return mixed
     */
    public function scopeByMainTemplateId(object $query, int $id): mixed
    {
        return $query->where('main_template_form_id', $id);
    }


    /**
     * @param object $query
     * @param int $id
     * @return mixed
     */
    public function ScopeMainData(object $query, int $id): mixed
    {
        return $query->with('TemplateInput.TemplateType.InputOption')->where('id', $id);
    }
    /**
     * workflows
     *
     * @return BelongsTo
     */
    public function workflows(): BelongsTo
    {
        return $this->belongsTo(MainTemplateForm::class, 'main_template_form_id')->with('workflows');
    }

}
