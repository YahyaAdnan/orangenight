<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\InventoryStock;
use App\Models\User;

class InventoryStockPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->checkPermissionTo('view-any InventoryStock');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, InventoryStock $inventorystock): bool
    {
        return $user->checkPermissionTo('view InventoryStock');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->checkPermissionTo('create InventoryStock');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, InventoryStock $inventorystock): bool
    {
        return $user->checkPermissionTo('update InventoryStock');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, InventoryStock $inventorystock): bool
    {
        return $user->checkPermissionTo('delete InventoryStock');
    }

    /**
     * Determine whether the user can delete any models.
     */
    public function deleteAny(User $user): bool
    {
        return $user->checkPermissionTo('delete-any InventoryStock');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, InventoryStock $inventorystock): bool
    {
        return $user->checkPermissionTo('restore InventoryStock');
    }

    /**
     * Determine whether the user can restore any models.
     */
    public function restoreAny(User $user): bool
    {
        return $user->checkPermissionTo('restore-any InventoryStock');
    }

    /**
     * Determine whether the user can replicate the model.
     */
    public function replicate(User $user, InventoryStock $inventorystock): bool
    {
        return $user->checkPermissionTo('replicate InventoryStock');
    }

    /**
     * Determine whether the user can reorder the models.
     */
    public function reorder(User $user): bool
    {
        return $user->checkPermissionTo('reorder InventoryStock');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, InventoryStock $inventorystock): bool
    {
        return $user->checkPermissionTo('force-delete InventoryStock');
    }

    /**
     * Determine whether the user can permanently delete any models.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->checkPermissionTo('force-delete-any InventoryStock');
    }
}
