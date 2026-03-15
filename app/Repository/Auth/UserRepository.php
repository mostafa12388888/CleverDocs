<?php

namespace App\Repository\Auth;

use App\Models\User;
use App\Repository\MainRepository;

class UserRepository extends MainRepository
{
    /**
     * @return string
     */
    public function model(): string
    {
        return User::class;
    }

    
}
