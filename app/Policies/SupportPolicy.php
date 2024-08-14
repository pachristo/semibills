<?php

namespace App\Policies;

use App\Models\Admin\Support;
use App\Models\Admin\Admin;
use Illuminate\Auth\Access\Response;

class SupportPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(Admin $admin): bool
    {
        //

return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(Admin $admin, Support $support): bool
    {
        //

return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(Admin $admin): bool
    {
        //
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Admin $admin, Support $support): bool
    {
        //
        return true;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Admin $admin, Support $support): bool
    {
        //
        return $admin->type===0;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Admin $admin, Support $support): bool
    {
        //
        return $admin->type===0;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Admin $admin, Support $support): bool
    {
        //
        return $admin->type===0;

    }
}
