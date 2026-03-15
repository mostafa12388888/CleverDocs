<?php

namespace App\Models\CompanyAbout;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;
use App\Models\Form\Project;
use Illuminate\Database\Eloquent\Builder;
use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

class PrivateInBox extends BaseModel
{
    use HasFactory, Filterable;
    protected $fillable = ['message', 'typeId', 'type', 'from_contact_id', 'status', 'created_by', "project_id"];

    /**
     * project
     *
     * @return void
     */
    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
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
    public function fromContact()
    {
        return $this->belongsTo(Contact::class, 'from_contact_id');
    }
    //accessor
    /**
     * scopeWithResolvedName
     *
     * @param  mixed $query
     * @return Builder
     */
    public function scopeWithResolvedName(Builder $query): Builder
    {
        return $query
            ->leftJoin('projects', function ($join) {
                $join->on('private_in_boxes.typeId', '=', 'projects.id')
                    ->where('private_in_boxes.type', '=', 'project');
            })
            ->leftJoin('companies', function ($join) {
                $join->on('private_in_boxes.typeId', '=', 'companies.id')
                    ->where('private_in_boxes.type', '=', 'company');
            })
            ->leftJoin('workflows', function ($join) {
                $join->on('private_in_boxes.typeId', '=', 'workflows.id')
                    ->where('private_in_boxes.type', '=', 'workflow');
            })->leftJoin('main_workflows', 'workflows.main_workflow_id', '=', 'main_workflows.id')
            ->leftJoin('distribution_lists', function ($join) {
                $join->on('private_in_boxes.typeId', '=', 'distribution_lists.id')
                    ->where('private_in_boxes.type', '=', 'distribution');
            })
                //form
            ->leftJoin('templates_forms as tf_form', function ($join) {
                    $join->on('private_in_boxes.typeId', '=', 'tf_form.id')
                     ->where('private_in_boxes.type', '=', 'form');
                 })->leftJoin('main_template_forms as mt_forms', 'tf_form.main_template_form_id', '=', 'mt_forms.id')
            // only submission
            ->when(true, function ($q) {
                $q->leftJoin('form_submissions', function ($join) {
                    $join->on('private_in_boxes.typeId', '=', 'form_submissions.id')
                        ->where('private_in_boxes.type', '=', 'submission');
                })
                    ->leftJoin('templates_form_projects', 'form_submissions.templates_form_project_id', '=', 'templates_form_projects.id')
                    ->leftJoin('templates_forms', 'templates_form_projects.templates_form_id', '=', 'templates_forms.id')
                    ->leftJoin('main_template_forms', 'templates_forms.main_template_form_id', '=', 'main_template_forms.id')
                    ->leftJoin('modules', 'main_template_forms.module_id', '=', 'modules.id')
                    ->leftJoin('form_submission_values', function ($join) {
                        $join->on('form_submission_values.form_submission_id', '=', 'form_submissions.id')
                            ->where('form_submission_values.is_default', '=', true)
                            ->where('form_submission_values.input_key', '=', 'subject');
                    });
            })
            ->addSelect([
                'private_in_boxes.*',
                'main_template_forms.id as main_template_form_id',
                'main_template_forms.name as main_template_form_title',
                'main_template_forms.module_id as main_template_form_model_id',
                'mt_forms.id as main_template_form_id',
                'mt_forms.name as main_template_form_title',
                'modules.name as module_name',
                'templates_forms.name as templates_form_name',
                'templates_form_projects.templates_form_id as templates_form_id',
                'tf_form.name as templates_form_name',
                'tf_form.id as templates_form_version_id',
                'main_workflows.id as main_workflow_id',
                DB::raw("COALESCE(
                projects.name,
                companies.name,
                workflows.title,
                tf_form.name,
                form_submission_values.value,
                distribution_lists.title,
                'N/A'
            ) as subject")
            ]);
    }
}
