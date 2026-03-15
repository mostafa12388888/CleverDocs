<?php

namespace App\Models\Form;

use App\Models\Form\CustomOption\CustomOptionList;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use SebastianBergmann\CodeCoverage\Report\Html\CustomCssFile;

class InputOption extends BaseModel
{
    use HasFactory,SoftDeletes;
    protected $table="input_options";
    protected $fillable=['title', 'is_active', 'custom_optionslist_id', 'is_default'];
    public function customOptionList(){
        return $this->belongsTo(CustomOptionList::class, 'custom_optionslist_id');
      }
}
