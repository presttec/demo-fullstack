<?php

namespace Tests\Unit\Policies;

use App\Models\Livro;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\BrowserKitTest as TestCase;

class LivroPolicyTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_create_livro()
    {
        $user = $this->createUser();
        $this->assertTrue($user->can('create', new Livro));
    }

    /** @test */
    public function user_can_view_livro()
    {
        $user = $this->createUser();
        $livro = Livro::factory()->create();
        $this->assertTrue($user->can('view', $livro));
    }

    /** @test */
    public function user_can_update_livro()
    {
        $user = $this->createUser();
        $livro = Livro::factory()->create();
        $this->assertTrue($user->can('update', $livro));
    }

    /** @test */
    public function user_can_delete_livro()
    {
        $user = $this->createUser();
        $livro = Livro::factory()->create();
        $this->assertTrue($user->can('delete', $livro));
    }
}
