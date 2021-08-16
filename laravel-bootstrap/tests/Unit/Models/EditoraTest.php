<?php

namespace Tests\Unit\Models;

use App\Models\User;
use App\Models\Editora;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\BrowserKitTest as TestCase;

class EditoraTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_editora_has_name_link_attribute()
    {
        $editora = Editora::factory()->create();

        $title = __('app.show_detail_title', [
            'name' => $editora->name, 'type' => __('editora.editora'),
        ]);
        $link = '<a href="'.route('editoras.show', $editora).'"';
        $link .= ' title="'.$title.'">';
        $link .= $editora->name;
        $link .= '</a>';

        $this->assertEquals($link, $editora->name_link);
    }

    /** @test */
    public function a_editora_has_belongs_to_creator_relation()
    {
        $editora = Editora::factory()->make();

        $this->assertInstanceOf(User::class, $editora->creator);
        $this->assertEquals($editora->creator_id, $editora->creator->id);
    }
}
