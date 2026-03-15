<?php

namespace App\Models\Form;

use App\Models\Form\CustomOption\CustomOptionList;
use App\Models\InputForm\TemplateInput;
use App\Models\User;
use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class InputType extends BaseModel
{
    use HasFactory, SoftDeletes,Filterable;
    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = ["updated_by", "created_by","deleted_by", 'key', 'type', 'options_type', 'entity', 'is_default', 'type', 'category', 'title', 'custom_option_list_id', 'entities_list_id'];

    //------------------- Relations ---------------------//
public $timestamps = false;
    /**
     * customOption
     *
     * @return void
     */
    public function CustomOptionList()
    {
        return $this->belongsTo(CustomOptionList::class, 'custom_option_list_id');
    }
    /**
     * templateInput
     *
     * @return void
     */
    public function templateInput()
    {
        return $this->hasOne(TemplateInput::class, 'input_types_id');
    }

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

    /**
     * casts
     *
     * @var array
     */
    protected $casts = [
        'title' => 'array',
        'help' => 'array',
        'description' => 'array',
    ];

        //--------------------- Scopes ------------------------//
        public function ScopeInputTypeData($query ,string $type=Null)
        {
            return $query->where("type",$type);
        }
}
