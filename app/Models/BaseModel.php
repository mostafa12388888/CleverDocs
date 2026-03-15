<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

abstract class BaseModel extends Model
{


    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

    }


    // Override the setUpdatedAt method to prevent updating on create
    public function setUpdatedAt($value)
    {
        // Do nothing, so updated_at remains null on create
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

    /*********** scopes ***********/

    public function leftJoinCreatedBy(object $query){
        $query->leftJoin('users as created_by','created_by.id',"users.created_by");
    }
    public function leftJoinUpdatedBy(object $query){
        $query->leftJoin('users as updated_by','updated_by.id',"users.updated_by");
    }

}
