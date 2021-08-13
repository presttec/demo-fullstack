<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Author;
use Illuminate\Auth\Access\HandlesAuthorization;

class AuthorPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the author.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Author  $author
     * @return mixed
     */
    public function view(User $user, Author $author)
    {
        // Update $user authorization to view $author here.
        return true;
    }

    /**
     * Determine whether the user can create author.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Author  $author
     * @return mixed
     */
    public function create(User $user, Author $author)
    {
        // Update $user authorization to create $author here.
        return true;
    }

    /**
     * Determine whether the user can update the author.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Author  $author
     * @return mixed
     */
    public function update(User $user, Author $author)
    {
        // Update $user authorization to update $author here.
        return true;
    }

    /**
     * Determine whether the user can delete the author.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Author  $author
     * @return mixed
     */
    public function delete(User $user, Author $author)
    {
        // Update $user authorization to delete $author here.
        return true;
    }
}
