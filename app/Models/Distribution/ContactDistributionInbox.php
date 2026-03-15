<?php

namespace App\Models\Distribution;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactDistributionGroup extends Model
{
    use HasFactory;
    public $table = "contact_distribution_inboxes";
}
