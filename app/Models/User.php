<?php

namespace App\Models;

use App\Enum\Authorization\DefaultRolesEnum;
use App\Models\CompanyAbout\Contact;
use App\Models\Workflows\WorkflowsSlot;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\CompanyAbout\Signature;
use App\Models\Form\Project;
use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Role;

class User extends Authenticatable
{
    use HasApiTokens, HasRoles, HasFactory, Notifiable, SoftDeletes, Filterable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'password',
        'account_code',
        'is_active',
        'role_id',
        'contact_id',
        'contact_name',
        'code',
        'is_hide',
        'expire_at',
        'updated_by',
        "created_by",
    ];


    /**
     * role
     *
     * @return BelongsTo
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * signature
     *
     * @return HasManyThrough
     */
    public function signature(): HasManyThrough
    {
        return $this->hasManyThrough(File::class, Fileable::class, 'fileable_id', 'id', 'id', 'file_id')->where('fileable_type',"signatureUser");
    }
    /**
     * logoFile
     *
     * @return HasOneThrough
     */
    public function logoFile()
    {
        return $this->hasOneThrough(File::class, Fileable::class, 'fileable_id', 'id', 'id', 'file_id')->where('fileable_type', self::class);
    }



    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function contact()
    {
        return $this->belongsTo(Contact::class, "contact_id");
    }
    /**
     * workflows
     *
     * @return BelongsToMany
     */
    public function workflows()
    {
        return $this->belongsToMany(WorkflowsSlot::class, 'user_workflow_slot');
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
     * loginHistories
     *
     * @return HasMany
     */
    public function loginHistories(): HasMany
    {
        return $this->hasMany(LoginHistory::class, 'user_id');
    }
    /**
     * genrateCode
     *
     * @return void
     */
    public function genrateCode()
    {
        $this->timestamps = false;
        $this->code = rand(1000, 9999);
        $this->expire_at = now()->addMinute(60);
        $this->save();
    }

    public function isSuperAdmin(): bool
    {
        return $this->roles()->where('key', DefaultRolesEnum::SUPER_ADMIN)->exists();
    }
    /**
     * Projects
     *
     * @return BelongsToMany
     */
    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class, "user_assign_projects", "user_id", "project_id");
    }


    /*********************** Scopes **************************/

    public function scopeLeftJoinContactCompany(object $query)
    {
        $query->leftJoin('contacts', 'contacts.id', "users.contact_id")
            ->leftJoin('companies', 'companies.id', "contacts.company_id");
    }

    public function scopeLeftJoinRole(object $query)
    {
        $query->leftJoin('roles', 'roles.id', ".role_id");
    }

    public function scopeLeftJoinContact(object $query)
    {
        $query->leftJoin('contacts', 'contacts.id', "users.contact_id");
    }

    public function scopeLeftJoinProject(object $query)
    {
        $query->leftJoin('user_assign_projects', 'user_assign_projects.user_id', "users.id")
            ->leftJoin('projects', 'projects.id', "user_assign_projects.project_id");
    }

    public function scopeLeftJoinCreatedByContact(object $query)
    {
        $query->leftJoin('users as created_by', 'created_by.id', "users.created_by")
            ->leftJoin('contacts as created_by_contact', 'created_by_contact.id', "created_by.contact_id");
    }
    public function scopeLeftJoinUpdatedByContact(object $query)
    {
        $query->leftJoin('users as updated_by', 'updated_by.id', "users.updated_by")
            ->leftJoin('contacts as updated_by_contact', 'updated_by_contact.id', "updated_by.contact_id");
    }
}
