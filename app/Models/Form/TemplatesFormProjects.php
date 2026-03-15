<?php

namespace App\Models\Form;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TemplatesFormProjects extends BaseModel
{
    use HasFactory;

    protected $table = 'templates_form_projects';
    protected $fillable = ['project_id','templates_form_id'];


    //-------------------------- Relations ----------------------------//
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function templateForm(): BelongsTo
    {
        return $this->belongsTo(TemplatesForm::class, 'templates_form_id');
    }


    //---------------------- Scopes -------------------------------------//
}
