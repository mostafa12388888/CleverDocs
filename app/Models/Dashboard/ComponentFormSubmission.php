<?php

namespace App\Models\Dashboard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComponentFormSubmission extends Model
{
    use HasFactory;
        protected $fillable = [
        'component_id',
        'filter',
    ];
        protected $casts = [
        'filter' => 'array',
    ];
}
