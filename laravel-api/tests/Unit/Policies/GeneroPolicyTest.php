<?php

namespace Tests\Unit\Policies;

use App\Models\Genero;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\BrowserKitTest as TestCase;

class GeneroPolicyTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_create_genero()
    {
        $user = $this->createUser();
        $this->assertTrue($user->can('create', new Genero));
    }

    /** @test */
    public function user_can_view_genero()
    {
        $user = $this->createUser();
        $genero = Genero::factory()->create();
        $this->assertTrue($user->can('view', $genero));
    }

    /** @test */
    public function user_can_update_genero()
    {
        $user = $this->createUser();
        $genero = Genero::factory()->create();
        $this->assertTrue($user->can('update', $genero));
    }

    /** @test */
    public function user_can_delete_genero()
    {
        $user = $this->createUser();
        $genero = Genero::factory()->create();
        $this->assertTrue($user->can('delete', $genero));
    }
}
