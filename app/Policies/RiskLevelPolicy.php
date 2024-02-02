<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\RiskLevel;
use App\Models\User;

class RiskLevelPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->isAdmin() || $user->checkPermissionTo('view-any RiskLevel');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, RiskLevel $risklevel): bool
    {
        return $user->isAdmin() || $user->checkPermissionTo('view RiskLevel');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->isAdmin() || $user->checkPermissionTo('create RiskLevel');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, RiskLevel $risklevel): bool
    {
        return $user->isAdmin() || $user->checkPermissionTo('update RiskLevel');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, RiskLevel $risklevel): bool
    {
        return $user->isAdmin() || $user->checkPermissionTo('delete RiskLevel');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, RiskLevel $risklevel): bool
    {
        return $user->isAdmin() || $user->checkPermissionTo('restore RiskLevel');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, RiskLevel $risklevel): bool
    {
        return $user->isAdmin() || $user->checkPermissionTo('force-delete RiskLevel');
    }
}
