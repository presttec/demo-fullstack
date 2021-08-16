<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Editora;
use Illuminate\Auth\Access\HandlesAuthorization;

class EditoraPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the editora.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Editora  $editora
     * @return mixed
     */
    public function view(User $user, Editora $editora)
    {
        // Update $user authorization to view $editora here.
        return true;
    }

    /**
     * Determine whether the user can create editora.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Editora  $editora
     * @return mixed
     */
    public function create(User $user, Editora $editora)
    {
        // Update $user authorization to create $editora here.
        return true;
    }

    /**
     * Determine whether the user can update the editora.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Editora  $editora
     * @return mixed
     */
    public function update(User $user, Editora $editora)
    {
        // Update $user authorization to update $editora here.
        return true;
    }

    /**
     * Determine whether the user can delete the editora.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Editora  $editora
     * @return mixed
     */
    public function delete(User $user, Editora $editora)
    {
        // Update $user authorization to delete $editora here.
        return true;
    }
}
