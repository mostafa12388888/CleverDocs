<?php

namespace App\Models;

use App\Models\CompanyAbout\Contact;
use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Email extends BaseModel
{
    use HasFactory,Filterable;
    protected $table = 'emails';
    protected $fillable = ['priority', 'type_id', 'type', 'body', 'created_by'];
    /**
     * recipients
     *
     * @return BelongsToMany
     */
    public function recipients(): BelongsToMany
    {
        return $this->belongsToMany(Contact::class, 'emails_contacts')
            ->withPivot('contact_type');
    }

    /**
     * toRecipients
     *
     * @return BelongsToMany
     */
    public function toRecipients(): BelongsToMany
    {
        return $this->recipients()->wherePivot('contact_type', 'to');
    }

    /**
     * ccRecipients
     *
     * @return BelongsToMany
     */
    public function ccRecipients(): BelongsToMany
    {
        return $this->recipients()->wherePivot('contact_type', 'cc');
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
}
