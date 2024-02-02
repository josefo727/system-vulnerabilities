<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\Status;
use App\Models\User;

class StatusPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->isAdmin() || $user->checkPermissionTo('view-any Status');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Status $status): bool
    {
        return $user->isAdmin() || $user->checkPermissionTo('view Status');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->isAdmin() || $user->checkPermissionTo('create Status');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Status $status): bool
    {
        return $user->isAdmin() || $user->checkPermissionTo('update Status');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Status $status): bool
    {
        return $user->isAdmin() || $user->checkPermissionTo('delete Status');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Status $status): bool
    {
        return $user->isAdmin() || $user->checkPermissionTo('restore Status');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Status $status): bool
    {
        return $user->isAdmin() || $user->checkPermissionTo('force-delete Status');
    }
}
