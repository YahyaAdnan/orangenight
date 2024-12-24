<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\Agreement;
use App\Models\User;

class AgreementPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->checkPermissionTo('view-any Agreement');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Agreement $agreement): bool
    {
        return $user->checkPermissionTo('view Agreement');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->checkPermissionTo('create Agreement');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Agreement $agreement): bool
    {
        return $user->checkPermissionTo('update Agreement');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Agreement $agreement): bool
    {
        return $user->checkPermissionTo('delete Agreement');
    }

    /**
     * Determine whether the user can delete any models.
     */
    public function deleteAny(User $user): bool
    {
        return $user->checkPermissionTo('delete-any Agreement');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Agreement $agreement): bool
    {
        return $user->checkPermissionTo('restore Agreement');
    }

    /**
     * Determine whether the user can restore any models.
     */
    public function restoreAny(User $user): bool
    {
        return $user->checkPermissionTo('restore-any Agreement');
    }

    /**
     * Determine whether the user can replicate the model.
     */
    public function replicate(User $user, Agreement $agreement): bool
    {
        return $user->checkPermissionTo('replicate Agreement');
    }

    /**
     * Determine whether the user can reorder the models.
     */
    public function reorder(User $user): bool
    {
        return $user->checkPermissionTo('reorder Agreement');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Agreement $agreement): bool
    {
        return $user->checkPermissionTo('force-delete Agreement');
    }

    /**
     * Determine whether the user can permanently delete any models.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->checkPermissionTo('force-delete-any Agreement');
    }
}
