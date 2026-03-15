<?php

namespace App\Models\Form;

use App\Models\CompanyAbout\Company;
use App\Models\CompanyAbout\Contact;
use App\Models\File;
use App\Models\Fileable;
use App\Models\User;
use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;
use App\Models\Form\CustomOption\InputOption;
use App\Models\TemplatesFormProjects;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends BaseModel
{
    use HasFactory,SoftDeletes,Filterable;
    protected $fillable=[
        'w_b_s_id', 'status', 'updated_by','logo', 'created_by',"deleted_by", 'country_id', 'company_id', 'contact_id', 'project_type_id', 'project_type',
         'contract_value', 'description', 'reference_number', 'order', 'name'];
    public function wbs(){
        return $this->belongsTo(WBS::class,'w_b_s_id');
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
    public function contact(){
        return $this->belongsTo(Contact::class, 'contact_id');
    }
    public function company(){
        return $this->belongsTo(Company::class, 'company_id');
    }
    public function templateForm(){
        return $this->belongsToMany(TemplatesForm::class,'templates_form_projects');
    }
    /**
     * templateFormProjects
     *
     * @return HasMany
     */
    public function templateFormProjects () : HasMany
    {
        return $this->hasMany(TemplatesFormProjects::class,'project_id');
    }
    /**
     * inputOption
     *
     * @return BelongsTo
     */
    public function inputOption(): BelongsTo
    {
        return $this->belongsTo(InputOption::class, 'project_type_id', 'id');
    }

    /**
     * country
     *
     * @return BelongsTo
     */
    public function country(): BelongsTo
    {
        return $this->belongsTo(InputOption::class, 'country_id');
    }


    public function assignedUsers(){
        return $this->hasManyThrough(User::class, UserAssignProject::class, 'project_id', 'id', 'id', 'user_id');
    }


    public function logoFile(): HasOneThrough
    {
        return $this->hasOneThrough(File::class, Fileable::class, 'fileable_id', 'id', 'id', 'file_id')->where('fileable_type', self::class);
    }
}
