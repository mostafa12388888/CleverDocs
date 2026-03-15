<?php

namespace App\Models\InputForm;

use App\Models\InputForm\PrintInput;
use App\Models\InputForm\TemplateInput;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
class PrintFormat extends BaseModel
{
    use HasFactory,SoftDeletes;
    protected $fillable=['templates_form_id'];
    public function tempalteInput()
    {

        return $this->belongsToMany(TemplateInput::class, 'print_inputs', 'print_format_id','template_input_id')->using(PrintInput::class)->withPivot('position', 'styles', 'hide', 'width', 'height', 'custom_title');;
    }
    public function ScopePrintStyle($query,$id){
        return $query->with('tempalteInput')->where('id',$id);
    }

}
