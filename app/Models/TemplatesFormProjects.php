<?php

namespace App\Models;

use App\Models\Form\Project;
use App\Models\Form\TemplatesForm;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;

class TemplatesFormProjects extends BaseModel
{
    use HasFactory;
    protected $table= 'templates_form_projects';
    protected $fillable=['project_id'];
   public function project(){
    return $this->belongsTo(Project::class, 'project_id');
   }
   public function templateForm(){
    return $this->belongsTo(TemplatesForm::class, 'templates_form_id');
   }
}
