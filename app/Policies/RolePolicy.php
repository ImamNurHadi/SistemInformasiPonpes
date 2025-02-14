<?php

namespace App\Policies;

use App\Models\User;

class RolePolicy
{
    public function isAdmin(User $user)
    {
        return $user->hasRole('Admin');
    }

    public function isSantri(User $user)
    {
        return $user->hasRole('Santri');
    }
}

