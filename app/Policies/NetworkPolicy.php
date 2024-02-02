<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\Network;
use App\Models\User;

class NetworkPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->isAdmin() || $user->checkPermissionTo('view-any Network');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Network $network): bool
    {
        return $user->isAdmin() || $user->checkPermissionTo('view Network');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->isAdmin() || $user->checkPermissionTo('create Network');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Network $network): bool
    {
        return $user->isAdmin() || $user->checkPermissionTo('update Network');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Network $network): bool
    {
        return $user->isAdmin() || $user->checkPermissionTo('delete Network');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Network $network): bool
    {
        return $user->isAdmin() || $user->checkPermissionTo('restore Network');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Network $network): bool
    {
        return $user->isAdmin() || $user->checkPermissionTo('force-delete Network');
    }
}
