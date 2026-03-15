<?php

namespace App\Models\Form\CustomOption;

use App\Models\Distribution\DistributionLists;
use App\Models\Form\InputType;
use App\Models\User;
use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
class CustomOptionList extends BaseModel
{
    use HasFactory, SoftDeletes,Filterable;
    protected $fillable=[ 'created_by', 'updated_by','deleted_by', 'key', 'title', 'is_default', 'is_active'];
    protected $casts=[
        "title"=>"array",
    ];
    protected $attributes = [
        'is_default' => 0
    ];

    public function inputType(){
        return $this->hasMany(InputType::class,'custom_option_list_id');
    }
    public function inputTypeSubject(){
        return $this->inputType()->where('key','id');
    }
    public function inputOption(){
        return $this->hasMany(InputOption::class, "custom_option_list_id");
    }
    public function distributionLists(): BelongsToMany
    {
        return $this->belongsToMany(DistributionLists::class, "contact_distribution_lists", 'action_id', "distribution_list_id");
    }
    //---------------------- Scopes ------------------//
    /**
     * createdBy
     *
     * @return BelongsTo
     */
    public function createdBy():BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    /**
     * updatedBy
     *
     * @return BelongsTo
     */
    public function updatedBy():BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
    //---------------------- Scopes ------------------//

}
