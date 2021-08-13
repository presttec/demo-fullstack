<?php

namespace Tests\Unit\Policies;

use App\Models\Books;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\BrowserKitTest as TestCase;

class BooksPolicyTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_create_books()
    {
        $user = $this->createUser();
        $this->assertTrue($user->can('create', new Books));
    }

    /** @test */
    public function user_can_view_books()
    {
        $user = $this->createUser();
        $books = Books::factory()->create();
        $this->assertTrue($user->can('view', $books));
    }

    /** @test */
    public function user_can_update_books()
    {
        $user = $this->createUser();
        $books = Books::factory()->create();
        $this->assertTrue($user->can('update', $books));
    }

    /** @test */
    public function user_can_delete_books()
    {
        $user = $this->createUser();
        $books = Books::factory()->create();
        $this->assertTrue($user->can('delete', $books));
    }
}
