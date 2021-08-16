<?php

namespace Tests\Unit\Policies;

use App\Models\Autor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\BrowserKitTest as TestCase;

class AutorPolicyTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_create_autor()
    {
        $user = $this->createUser();
        $this->assertTrue($user->can('create', new Autor));
    }

    /** @test */
    public function user_can_view_autor()
    {
        $user = $this->createUser();
        $autor = Autor::factory()->create();
        $this->assertTrue($user->can('view', $autor));
    }

    /** @test */
    public function user_can_update_autor()
    {
        $user = $this->createUser();
        $autor = Autor::factory()->create();
        $this->assertTrue($user->can('update', $autor));
    }

    /** @test */
    public function user_can_delete_autor()
    {
        $user = $this->createUser();
        $autor = Autor::factory()->create();
        $this->assertTrue($user->can('delete', $autor));
    }
}
