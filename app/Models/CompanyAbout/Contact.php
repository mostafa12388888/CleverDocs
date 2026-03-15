<?php

namespace App\Models\CompanyAbout;

use App\Models\Distribution\DistributionLists;
use App\Models\User;
use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;
use App\Models\File;
use App\Models\Fileable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends BaseModel
{
    use HasFactory, SoftDeletes,Filterable;
    protected $table= 'contacts';
    protected $fillable= ['address','is_hide', "image", 'avatar_id', 'created_by', 'updated_by', 'name', 'phone1', 'phone2', 'is_key_contact', 'position', 'company_id', 'contact_email'];

    public function company(){
        return $this->belongsTo(Company::class, 'company_id');
    }
    public function user(){
        return $this->hasOne(User::class, 'contact_id');
    }
    /**
     * DistributionLists
     *
     * @return BelongsToMany
     */
    public function distributionLists(): BelongsToMany
    {
        return $this->belongsToMany(DistributionLists::class, "contact_distribution_lists", "contact_id", 'distribution_list_id')->withPivot("action_id");
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
        /**
         * logoFile
         *
         * @return void
         */
        public function imageFile()
    {
        return $this->hasOneThrough(File::class, Fileable::class, 'fileable_id', 'id', 'id', 'file_id')->where('fileable_type', self::class);
    }

}
