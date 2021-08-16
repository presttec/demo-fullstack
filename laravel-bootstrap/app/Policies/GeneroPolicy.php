<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Genero;
use Illuminate\Auth\Access\HandlesAuthorization;

class GeneroPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the genero.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Genero  $genero
     * @return mixed
     */
    public function view(User $user, Genero $genero)
    {
        // Update $user authorization to view $genero here.
        return true;
    }

    /**
     * Determine whether the user can create genero.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Genero  $genero
     * @return mixed
     */
    public function create(User $user, Genero $genero)
    {
        // Update $user authorization to create $genero here.
        return true;
    }

    /**
     * Determine whether the user can update the genero.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Genero  $genero
     * @return mixed
     */
    public function update(User $user, Genero $genero)
    {
        // Update $user authorization to update $genero here.
        return true;
    }

    /**
     * Determine whether the user can delete the genero.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Genero  $genero
     * @return mixed
     */
    public function delete(User $user, Genero $genero)
    {
        // Update $user authorization to delete $genero here.
        return true;
    }
}
