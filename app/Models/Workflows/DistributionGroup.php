<?php

namespace App\Models\Workflows;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
class DistributionGroup extends BaseModel
{
    use HasFactory, SoftDeletes;
}
