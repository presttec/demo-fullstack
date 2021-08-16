<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Livro;
use Illuminate\Auth\Access\HandlesAuthorization;

class LivroPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the livro.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Livro  $livro
     * @return mixed
     */
    public function view(User $user, Livro $livro)
    {
        // Update $user authorization to view $livro here.
        return true;
    }

    /**
     * Determine whether the user can create livro.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Livro  $livro
     * @return mixed
     */
    public function create(User $user, Livro $livro)
    {
        // Update $user authorization to create $livro here.
        return true;
    }

    /**
     * Determine whether the user can update the livro.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Livro  $livro
     * @return mixed
     */
    public function update(User $user, Livro $livro)
    {
        // Update $user authorization to update $livro here.
        return true;
    }

    /**
     * Determine whether the user can delete the livro.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Livro  $livro
     * @return mixed
     */
    public function delete(User $user, Livro $livro)
    {
        // Update $user authorization to delete $livro here.
        return true;
    }
}
