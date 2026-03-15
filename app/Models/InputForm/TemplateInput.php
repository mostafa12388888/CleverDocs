<?php

namespace App\Models\InputForm;

use App\Models\Form\InputType;
use App\Models\Form\TemplatesForm;
use App\Models\InputForm\PrintFormat;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;
use App\Models\Form\FormSubmissionValue;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class TemplateInput extends BaseModel
{
    use HasFactory,SoftDeletes;
    protected $table= 'template_inputs';
    protected $fillable= ['input_types_id', "uuid", 'templates_forms_id', 'width', 'height', 'position_y', 'position_x', 'title', 'is_mandatory', 'styles'];

    public function TemplateForm(){
    return $this->belongsTo(TemplatesForm::class,'templates_forms_id');
}



    public function PrintFormat(){
        return $this->belongsToMany(PrintFormat::class, 'print_inputs', 'template_input_id', 'print_format_id')->using(PrintInput::class)->withPivot('position', 'styles', 'hide', 'width', 'height', 'custom_title');
    }
    public function documentSubmissionValue(){
        return $this->hasMany(FormSubmissionValue::class, 'template_input_id');
    }
    protected $casts = [
        'styles' => 'array',
        'title' => 'array',
    ];

    public function templateType(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(InputType::class,'input_types_id');
    }
    /**
     * TemplateInput
     *
     * @return HasMany
     */
    public function submissionValue():HasMany
    {
        return $this->hasMany(FormSubmissionValue::class, 'template_input_id');
    }
}
