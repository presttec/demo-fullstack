<?php

namespace Tests\Unit\Policies;

use App\Models\Author;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\BrowserKitTest as TestCase;

class AuthorPolicyTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_create_author()
    {
        $user = $this->createUser();
        $this->assertTrue($user->can('create', new Author));
    }

    /** @test */
    public function user_can_view_author()
    {
        $user = $this->createUser();
        $author = Author::factory()->create();
        $this->assertTrue($user->can('view', $author));
    }

    /** @test */
    public function user_can_update_author()
    {
        $user = $this->createUser();
        $author = Author::factory()->create();
        $this->assertTrue($user->can('update', $author));
    }

    /** @test */
    public function user_can_delete_author()
    {
        $user = $this->createUser();
        $author = Author::factory()->create();
        $this->assertTrue($user->can('delete', $author));
    }
}
