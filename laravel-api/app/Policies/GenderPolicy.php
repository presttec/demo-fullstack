<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Gender;
use Illuminate\Auth\Access\HandlesAuthorization;

class GenderPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the gender.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Gender  $gender
     * @return mixed
     */
    public function view(User $user, Gender $gender)
    {
        // Update $user authorization to view $gender here.
        return true;
    }

    /**
     * Determine whether the user can create gender.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Gender  $gender
     * @return mixed
     */
    public function create(User $user, Gender $gender)
    {
        // Update $user authorization to create $gender here.
        return true;
    }

    /**
     * Determine whether the user can update the gender.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Gender  $gender
     * @return mixed
     */
    public function update(User $user, Gender $gender)
    {
        // Update $user authorization to update $gender here.
        return true;
    }

    /**
     * Determine whether the user can delete the gender.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Gender  $gender
     * @return mixed
     */
    public function delete(User $user, Gender $gender)
    {
        // Update $user authorization to delete $gender here.
        return true;
    }
}
