<?php

namespace App\Models\Form;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;

class ProjectAssignedCompany extends BaseModel
{
    use HasFactory;
    protected $table = 'project_assigned_company';
    protected $fillable = ['project_id','company_id'];
}
