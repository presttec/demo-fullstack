<?php

namespace Tests\Unit\Policies;

use App\Models\Editora;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\BrowserKitTest as TestCase;

class EditoraPolicyTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_create_editora()
    {
        $user = $this->createUser();
        $this->assertTrue($user->can('create', new Editora));
    }

    /** @test */
    public function user_can_view_editora()
    {
        $user = $this->createUser();
        $editora = Editora::factory()->create();
        $this->assertTrue($user->can('view', $editora));
    }

    /** @test */
    public function user_can_update_editora()
    {
        $user = $this->createUser();
        $editora = Editora::factory()->create();
        $this->assertTrue($user->can('update', $editora));
    }

    /** @test */
    public function user_can_delete_editora()
    {
        $user = $this->createUser();
        $editora = Editora::factory()->create();
        $this->assertTrue($user->can('delete', $editora));
    }
}
