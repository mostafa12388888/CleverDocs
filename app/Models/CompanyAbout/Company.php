<?php

namespace App\Models\CompanyAbout;

use App\Models\File;
use App\Models\Fileable;
use App\Models\Form\CustomOption\InputOption;
use App\Models\User;
use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;
use App\Models\Form\Project;
use App\Models\Form\ProjectAssignedCompany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends BaseModel
{

    use HasFactory, SoftDeletes,Filterable;
    protected $table= 'companies';
    protected $fillable= ['name','is_hide', 'created_by', 'updated_by', 'address', 'phone2', 'phone1', 'tax_percentage', 'vat_percentage', 'email', 'registration', 'tax', 'vat', 'company_filed'];
    public $casts=[
        "phone"=>'array',
        "name"=>'array',
    ];


    /**
     * keyContact
     *
     * @return void
     */
    public function keyContact(){
        return $this->hasMany(Contact::class, 'company_id')->where("contacts.is_key_contact",1);
     }
     /**
      * contact
      *
      * @return void
      */
     public function contact(){
        return $this->hasMany(Contact::class, 'company_id');
    }

    /**
      * contact
      *
      * @return HasMany
     */
     public function contacts(): HasMany
     {
        return $this->hasMany(Contact::class, 'company_id');
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


    public function field(): BelongsTo
    {
        return $this->belongsTo(InputOption::class, 'company_filed');
    }


    public function logoFile()
    {
        return $this->hasOneThrough(File::class, Fileable::class, 'fileable_id', 'id', 'id', 'file_id')->where('fileable_type', self::class);
    }


    /**
     * projects
     *
     * @return HasMany
     */
    public function projects(): HasMany
    {
        return $this->hasMany(Project::class, 'company_id');
    }
    /**
     * projectAssignedCompany
     *
     * @return HasMany
     */
    public function projectAssignedCompany(): HasMany
    {
        return $this->hasMany(ProjectAssignedCompany::class, 'company_id');
    }
}
