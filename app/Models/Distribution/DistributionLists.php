<?php

namespace App\Models\Distribution;

use App\Models\CompanyAbout\Contact;
use App\Models\User;
use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;
use App\Models\ContactDistributionList;
use App\Models\Form\CustomOption\InputOption;
use App\Models\Form\Project;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class DistributionLists extends BaseModel
{
    use HasFactory,SoftDeletes, Filterable;
   /**
    * fillable
    *
    * @var array
    */
   public $table="distribution_lists";
   protected $fillable=[ 'created_by', 'updated_by', 'deleted_by', 'is_active', 'title',"project_id"];
   public function project():BelongsTo
   {
    return $this->belongsTo(Project::class,"project_id");
   }

   /**
    * contactsActions
    *
    * @return HasMany
    */
   public function contactsActions():HasMany
{
    return $this->hasMany(ContactDistributionList::class, 'distribution_list_id');
}

        /**
         * distributionInbox
         *
         * @return HasMany
         */
        public function distributionInbox(): HasMany
        {
            return $this->hasMany(DistributionInbox::class, 'distribution_list_id');
        }
   /**
    * contact
    *
    * @return void
    */
    public function contacts(): BelongsToMany
    {
     return $this->belongsToMany(Contact::class, "contact_distribution_lists", "distribution_list_id",'contact_id')->withPivot("action_id");
   }

    /**
     * customList
     *
     * @return void
     */
    public function action(): BelongsToMany
    {
        return $this->belongsToMany(InputOption::class, "contact_distribution_lists", "distribution_list_id", 'action_id');
    }
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
    * casts
    *
    * @var array
    */
   protected $casts=['title'=>"array"];
}
