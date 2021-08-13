<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Books;
use Illuminate\Auth\Access\HandlesAuthorization;

class BooksPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the books.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Books  $books
     * @return mixed
     */
    public function view(User $user, Books $books)
    {
        // Update $user authorization to view $books here.
        return true;
    }

    /**
     * Determine whether the user can create books.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Books  $books
     * @return mixed
     */
    public function create(User $user, Books $books)
    {
        // Update $user authorization to create $books here.
        return true;
    }

    /**
     * Determine whether the user can update the books.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Books  $books
     * @return mixed
     */
    public function update(User $user, Books $books)
    {
        // Update $user authorization to update $books here.
        return true;
    }

    /**
     * Determine whether the user can delete the books.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Books  $books
     * @return mixed
     */
    public function delete(User $user, Books $books)
    {
        // Update $user authorization to delete $books here.
        return true;
    }
}
