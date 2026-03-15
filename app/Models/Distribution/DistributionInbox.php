<?php

namespace App\Models\Distribution;

use App\Models\BaseModel;
use App\Models\CompanyAbout\Contact;
use App\Models\Form\CustomOption\CustomOptionList;
use App\Models\Form\InputOption;
use App\Models\Form\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class DistributionInbox extends BaseModel
{
    use HasFactory, Filterable;
    public $table = "distribution_inboxes";
    protected $fillable = ['message', 'type_id', 'priority_id', 'type', 'user_id', 'status', 'distribution_list_id', 'created_by', "project_id"];
    /**
     * contact
     *
     * @return void
     */
    public function contacts(): BelongsToMany
    {
        return $this->belongsToMany(Contact::class, "contact_distribution_inboxes", "distribution_inbox_id", 'contact_id')->withPivot("action_id");
    }
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
     * customList
     *
     * @return void
     */
    public function action(): BelongsToMany
    {
        return $this->belongsToMany(InputOption::class, "contact_distribution_inboxes", "distribution_inbox_id", 'action_id');
    }
    /**
     * priority
     *
     * @return BelongsTo
     */
    public function priority(): BelongsTo
    {
        return $this->belongsTo(InputOption::class, "priority_id", 'id');
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
     * user
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    /**
     * distributionList
     *
     * @return BelongsTo
     */
    public function distributionList(): BelongsTo
    {
        return $this->belongsTo(DistributionLists::class, 'distribution_list_id')->select("title", "id", 'is_active');
    }
    public function scopeWithResolvedName(Builder $query): Builder
    {
        return $query
            ->leftJoin('projects', function ($join) {
                $join->on('distribution_inboxes.type_id', '=', 'projects.id')
                    ->where('distribution_inboxes.type', '=', 'project');
            })
            ->leftJoin('companies', function ($join) {
                $join->on('distribution_inboxes.type_id', '=', 'companies.id')
                    ->where('distribution_inboxes.type', '=', 'company');
            })

            ->leftJoin('workflows', function ($join) {
                $join->on('distribution_inboxes.type_id', '=', 'workflows.id')
                    ->where('distribution_inboxes.type', '=', 'workflow');
            })->leftJoin('main_workflows', 'workflows.main_workflow_id', '=', 'main_workflows.id')
            ->leftJoin('distribution_lists', function ($join) {
                $join->on('distribution_inboxes.type_id', '=', 'distribution_lists.id')
                    ->where('distribution_inboxes.type', '=', 'distribution');
            })
            //form
            ->leftJoin('templates_forms as tf_form', function ($join) {
                $join->on('distribution_inboxes.type_id', '=', 'tf_form.id')
                    ->where('distribution_inboxes.type', '=', 'form');
            })->leftJoin('main_template_forms as mt_forms', 'tf_form.main_template_form_id', '=', 'mt_forms.id')
            //only sumission
            ->when(true, function ($q) {
                $q->leftJoin('form_submissions', function ($join) {
                    $join->on('distribution_inboxes.type_id', '=', 'form_submissions.id')
                        ->where('distribution_inboxes.type', '=', 'submission');
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
                'distribution_inboxes.*',
                'main_template_forms.id as main_template_form_id',
                'main_template_forms.name as main_template_form_title',
                'main_template_forms.module_id as main_template_form_model_id',
                'mt_forms.id as main_template_form_id',
                'mt_forms.name as main_template_form_title',
                'modules.name as module_name',
                'templates_forms.name as templates_form_name',
                'tf_form.name as templates_form_name',
                'tf_form.id as templates_form_version_id',
                'templates_form_projects.templates_form_id as templates_form_id',
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
    // scope forContact
    public function scopeForContact(Builder $query, int $contactId): Builder
    {
        return $query->whereHas('contacts', function ($q) use ($contactId) {
            $q->where('contact_id', $contactId);
        });
    }
}
