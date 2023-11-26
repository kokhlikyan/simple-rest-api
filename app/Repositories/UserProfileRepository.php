<?php

namespace App\Repositories;

use App\Interfaces\UserProfileRepositoryInterface;

class UserProfileRepository implements UserProfileRepositoryInterface
{

    public function getAuthUser()
    {
        return auth()->user();
    }
}
