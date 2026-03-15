<?php

namespace App\Models\InputForm;

use App\Models\PrintFormat;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\Pivot;

class PrintInput extends Pivot
{
    use HasFactory,SoftDeletes;
    protected $table= 'print_inputs';
    protected $fillable = [
        'position_x',
        'position_y',
        'template_input_id',
        'print_format_id',
        'position',
        'styles',
        'hide',
        'width',
        'height',
        'custom_title',
    ];

    // public $timestamps=false;
    // public function PrintFormat(){
    //     return $this->belongsTo(PrintFormat::class,'print_format_id');
    // }
    public function TemplateInput(){
        return $this->belongsTo(TemplateInput::class,'template_input_id');
    }
    protected $casts = [
        'styles' => 'array',
    ];
}
