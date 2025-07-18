<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function changeSponsor(User $loggedUser, User $user)
    {
        if ($user->id === (int)config('fortify.super_parent_id')) {
            return false;
        }
        if ($loggedUser->hasPermissionTo('users.change-sponsor', 'web') || $loggedUser->hasRole('super_admin', 'web')) {
            return $user->super_parent_id !== null && $user->parent_id === null && $user->position === null;
        }
        return false;
    }

    public function suspend(User $loggedUser, User $user)
    {
        if ($loggedUser->hasPermissionTo('users.suspend', 'web') || $loggedUser->hasRole('super_admin', 'web')) {
            return !$user->is_suspended;
        }
        return false;
    }

    public function reActivate(User $loggedUser, User $user)
    {
        if ($loggedUser->hasPermissionTo('users.activate-suspended', 'web') || $loggedUser->hasRole('super_admin', 'web')) {
            return $user->is_suspended;
        }
        return false;
    }
}
