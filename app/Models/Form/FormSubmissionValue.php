<?php

namespace App\Models\Form;

use App\Models\InputForm\PrintInput;
use App\Models\InputForm\TemplateInput;
use App\Models\User;
use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;
use App\Models\CompanyAbout\Company;
use App\Models\CompanyAbout\Contact;
use App\Models\Form\CustomOption\InputOption;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;

class FormSubmissionValue extends BaseModel
{
    use HasFactory, SoftDeletes, Filterable;

    protected $table = "form_submission_values";

    protected $fillable = ['template_input_id', 'form_submission_id', 'value', "deleted_by", "updated_by", 'input_key', "created_by", "is_default", "type_entity"];

    public function TemplateInput()
    {
        return $this->belongsTo(TemplateInput::class, 'template_input_id');
    }

    public function inputType()
    {
        return $this->hasOneThrough(InputType::class, TemplateInput::class, 'id', 'id', 'template_input_id', 'input_types_id');
    }
    public function formSubmission()
    {
        return $this->belongsTo(FormSubmission::class, 'form_submission_id');
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
    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class, 'value', 'id')
            ->when($this->type_entity !== 'contact', function ($query) {
                $query->whereRaw('1 = 0');
            });
    }
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'value', 'id')
            ->when($this->type_entity !== 'company', function ($query) {
                $query->whereRaw('1 = 0');
            });
    }
    public function customList(): BelongsTo
    {
        return $this->belongsTo(InputOption::class, 'value', 'id')
            ->when($this->type_entity !== 'customList', function ($query) {
                $query->whereRaw('1 = 0');
            });
    }
}
