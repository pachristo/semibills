<?php

namespace App\Policies;

use App\Models\Admin\Notify;
use App\Models\Admin\Admin;
use Illuminate\Auth\Access\Response;

class NotifyPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(Admin $user): bool
    {
           return  true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(Admin $user, Notify $notify): bool
    {
           return  true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(Admin $user): bool
    {
           return  true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Admin $user, Notify $notify): bool
    {
           return  true;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Admin $user, Notify $notify): bool
    {
           return  true;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Admin $user, Notify $notify): bool
    {
           return  true;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Admin $user, Notify $notify): bool
    {
           return  true;
    }
}
