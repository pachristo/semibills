<?php

namespace App\Policies;

use App\Models\Admin\Admin;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class AdminPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(Admin $admin): bool
    {
        //
       return $admin->type===0;

    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(Admin $admin): bool
    {
        //
          return $admin->type===0;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(Admin $admin): bool
    {
        //
          return $admin->type===0;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Admin $admin): bool
    {
        //
        return $admin->type===0;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Admin $admin): bool
    {
        //
          return $admin->type===0;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Admin $admin): bool
    {
        //
          return $admin->type===0;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Admin $admin): bool
    {
        //
          return $admin->type===0;
    }
}
