<?php

namespace Tests\Unit\Policies;

use App\Models\Gender;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\BrowserKitTest as TestCase;

class GenderPolicyTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_create_gender()
    {
        $user = $this->createUser();
        $this->assertTrue($user->can('create', new Gender));
    }

    /** @test */
    public function user_can_view_gender()
    {
        $user = $this->createUser();
        $gender = Gender::factory()->create();
        $this->assertTrue($user->can('view', $gender));
    }

    /** @test */
    public function user_can_update_gender()
    {
        $user = $this->createUser();
        $gender = Gender::factory()->create();
        $this->assertTrue($user->can('update', $gender));
    }

    /** @test */
    public function user_can_delete_gender()
    {
        $user = $this->createUser();
        $gender = Gender::factory()->create();
        $this->assertTrue($user->can('delete', $gender));
    }
}
