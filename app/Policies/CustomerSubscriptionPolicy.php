<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\CustomerSubscription;
use App\Models\User;

class CustomerSubscriptionPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->checkPermissionTo('view-any CustomerSubscription');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, CustomerSubscription $customersubscription): bool
    {
        return $user->checkPermissionTo('view CustomerSubscription');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->checkPermissionTo('create CustomerSubscription');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, CustomerSubscription $customersubscription): bool
    {
        return $user->checkPermissionTo('update CustomerSubscription');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, CustomerSubscription $customersubscription): bool
    {
        return $user->checkPermissionTo('delete CustomerSubscription');
    }

    /**
     * Determine whether the user can delete any models.
     */
    public function deleteAny(User $user): bool
    {
        return $user->checkPermissionTo('delete-any CustomerSubscription');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, CustomerSubscription $customersubscription): bool
    {
        return $user->checkPermissionTo('restore CustomerSubscription');
    }

    /**
     * Determine whether the user can restore any models.
     */
    public function restoreAny(User $user): bool
    {
        return $user->checkPermissionTo('restore-any CustomerSubscription');
    }

    /**
     * Determine whether the user can replicate the model.
     */
    public function replicate(User $user, CustomerSubscription $customersubscription): bool
    {
        return $user->checkPermissionTo('replicate CustomerSubscription');
    }

    /**
     * Determine whether the user can reorder the models.
     */
    public function reorder(User $user): bool
    {
        return $user->checkPermissionTo('reorder CustomerSubscription');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, CustomerSubscription $customersubscription): bool
    {
        return $user->checkPermissionTo('force-delete CustomerSubscription');
    }

    /**
     * Determine whether the user can permanently delete any models.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->checkPermissionTo('force-delete-any CustomerSubscription');
    }
}
