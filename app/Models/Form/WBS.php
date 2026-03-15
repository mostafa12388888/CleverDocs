<?php

namespace App\Models\Form;

use App\Models\User;
use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class WBS extends BaseModel
{
    use HasFactory,SoftDeletes,Filterable;
    protected $fillable=['title', 'w_b_s_id', 'created_by', 'updated_by', 'deleted_by'];
    public function chiles(){
        return $this->hasMany(WBS::class,'w_b_s_id')->withCount(['projects']);
    }
    public function projects(){
        return $this->hasMany(Project::class,'w_b_s_id');
    }
    // Model
    /**
     * createdBy
     *
     * @return BelongsTo
     */
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    /**
     * updatedBy
     *
     * @return BelongsTo
     */
    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function ScopeWpsProject($query,$id){
        return $query->with('wbs', 'projects.templateForm')->whereId($id);

    }

}
