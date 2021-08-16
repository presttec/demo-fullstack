<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Autor;
use Illuminate\Auth\Access\HandlesAuthorization;

class AutorPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the autor.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Autor  $autor
     * @return mixed
     */
    public function view(User $user, Autor $autor)
    {
        // Update $user authorization to view $autor here.
        return true;
    }

    /**
     * Determine whether the user can create autor.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Autor  $autor
     * @return mixed
     */
    public function create(User $user, Autor $autor)
    {
        // Update $user authorization to create $autor here.
        return true;
    }

    /**
     * Determine whether the user can update the autor.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Autor  $autor
     * @return mixed
     */
    public function update(User $user, Autor $autor)
    {
        // Update $user authorization to update $autor here.
        return true;
    }

    /**
     * Determine whether the user can delete the autor.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Autor  $autor
     * @return mixed
     */
    public function delete(User $user, Autor $autor)
    {
        // Update $user authorization to delete $autor here.
        return true;
    }
}
