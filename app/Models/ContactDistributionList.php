<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;
use App\Models\CompanyAbout\Contact;
use App\Models\Distribution\DistributionLists;
use App\Models\Form\CustomOption\InputOption;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContactDistributionList extends BaseModel
{
    use HasFactory;
    protected $table = "contact_distribution_lists";
    protected $fillable = ["action_id", "distribution_list_id", "contact_id"];
    public $timestamps = false;
    /**
     * contact
     *
     * @return BelongsTo
     */
    public function contact():BelongsTo
{
    return $this->belongsTo(Contact::class,'contact_id');
}

/**
 * action
 *
 * @return BelongsTo
 */
public function action():BelongsTo
{
    return $this->belongsTo(InputOption::class,"action_id");
}

/**
 * distributionList
 *
 * @return BelongsTo
 */
public function distributionList():BelongsTo
{
    return $this->belongsTo(DistributionLists::class,'distribution_list_id');
}

}
