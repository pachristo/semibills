<?php

namespace App\Policies;

use App\Models\APITransaction;
use App\Models\Admin\Admin as User;
use Illuminate\Auth\Access\Response;

class APITransactionPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //

        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, APITransaction $aPITransaction): bool
    {
        //
            return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, APITransaction $aPITransaction): bool
    {
        //
        return  $user->type===0;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, APITransaction $aPITransaction): bool
    {
        //
        return  $user->type===0;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, APITransaction $aPITransaction): bool
    {
        //
        return  $user->type===0;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, APITransaction $aPITransaction): bool
    {
        //
        return  $user->type===0;
    }
}
