<?php

namespace App\Models\Form;

use App\Models\File;
use App\Models\Fileable;
use App\Models\User;
use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\SoftDeletes;


class Layout extends BaseModel
{
    use HasFactory, SoftDeletes,Filterable;
    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = ["deleted_by", 'updated_by','subject', 'project_id', "created_by", 'module_id', 'print_format_id', 'image', 'status', 'type'];


        public function createdBy():BelongsTo
        {
            return $this->belongsTo(User::class, 'created_by');
        }
        public function updatedBy():BelongsTo
        {
            return $this->belongsTo(User::class, 'updated_by');
        }

    /**
     * project
     *
     * @return void
     */
    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
    /**
     * module
     *
     * @return void
     */
    public function module()
    {
        return $this->belongsTo(Project::class, 'module_id');
    }


    public function imageFile(): HasOneThrough
    {
        return $this->hasOneThrough(File::class, Fileable::class, 'fileable_id', 'id', 'id', 'file_id')->where('fileable_type', self::class);
    }

    //--------------------- Scopes ------------------------//


}
