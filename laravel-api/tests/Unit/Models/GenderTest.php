<?php

namespace Tests\Unit\Models;

use App\Models\User;
use App\Models\Gender;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\BrowserKitTest as TestCase;

class GenderTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_gender_has_name_link_attribute()
    {
        $gender = Gender::factory()->create();

        $title = __('app.show_detail_title', [
            'name' => $gender->name, 'type' => __('gender.gender'),
        ]);
        $link = '<a href="'.route('genders.show', $gender).'"';
        $link .= ' title="'.$title.'">';
        $link .= $gender->name;
        $link .= '</a>';

        $this->assertEquals($link, $gender->name_link);
    }

    /** @test */
    public function a_gender_has_belongs_to_creator_relation()
    {
        $gender = Gender::factory()->make();

        $this->assertInstanceOf(User::class, $gender->creator);
        $this->assertEquals($gender->creator_id, $gender->creator->id);
    }
}
