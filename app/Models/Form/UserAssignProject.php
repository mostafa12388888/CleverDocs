<?php

namespace App\Models\Form;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Filterable;
class UserAssignProject extends BaseModel
{
    use HasFactory,Filterable;
    protected $fillable = ['user_id', 'project_id'];
    public $timestamps = false;
}
