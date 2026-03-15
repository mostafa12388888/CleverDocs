<?php

namespace App\Models\Form;

use App\Exceptions\Form\FormSubmissionHasVersionsException;
use App\Models\AuditLog;
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
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class FormSubmission extends BaseModel
{
    use HasFactory, SoftDeletes, Filterable;

    protected $table = "form_submissions";
    protected $fillable = ['templates_form_project_id','submissions_id', 'status', 'created_by', 'updated_by', 'deleted_by'];
    protected $casts = [
        'name' => 'array',
    ];


    /**
     * scopeSubmissionMainTemplate
     *
     * @param  mixed $query
     * @param  mixed $mainTemplateId
     * @return void
     */
    public function scopeSubmissionMainTemplate($query,int $mainTemplateId)
    {
        return $query->leftJoin('templates_form_projects', 'form_submissions.templates_form_project_id', '=', 'templates_form_projects.id')
            ->leftJoin('templates_forms', 'templates_forms.id', '=', 'templates_form_projects.templates_form_id')
            ->LeftJoin('main_template_forms', 'templates_forms.main_template_form_id', '=', 'main_template_forms.id')
            ->where('main_template_forms.id', $mainTemplateId);
    }
    //--------------------Relations--------------------
    public function templateFormProject(): BelongsTo
    {
        return $this->belongsTo(TemplatesFormProjects::class, 'templates_form_project_id');
    }

    /**
     * @return HasOneThrough
     */
    public function form(): HasOneThrough
    {
        return $this->hasOneThrough(TemplatesForm::class, TemplatesFormProjects::class, 'id', 'id', 'templates_form_project_id', 'template_form_id');
    }

    public function submissionValues(): HasMany
    {
        return $this->hasMany(FormSubmissionValue::class, 'form_submission_id');
    }

    /**
     * submission
     *
     * @return BelongsTo
     */
    public function submission():BelongsTo
    {
        return $this->belongsTo(FormSubmission::class, 'submissions_id');
    }


    /**
     * versions
     *
     * @return HasMany
     */
    public function versions(): HasMany
    {
        return $this->hasMany(FormSubmission::class, 'submissions_id');
    }

    /**
     * auditLogs
     *
     * @return MorphMany
     */
    public function auditLogs(): MorphMany
    {
        return $this->morphMany(AuditLog::class, 'auditable');
    }

    /**
     * booted
     *
     * @return void
     */
    protected static function booted()
{
    static::deleting(function ($submission) {
        if ($submission->versions()->exists()) {
            throw new FormSubmissionHasVersionsException();
        }
    });
}

}
