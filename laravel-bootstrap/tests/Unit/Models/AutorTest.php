<?php

namespace Tests\Unit\Models;

use App\Models\User;
use App\Models\Autor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\BrowserKitTest as TestCase;

class AutorTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_autor_has_name_link_attribute()
    {
        $autor = Autor::factory()->create();

        $title = __('app.show_detail_title', [
            'name' => $autor->name, 'type' => __('autor.autor'),
        ]);
        $link = '<a href="'.route('autors.show', $autor).'"';
        $link .= ' title="'.$title.'">';
        $link .= $autor->name;
        $link .= '</a>';

        $this->assertEquals($link, $autor->name_link);
    }

    /** @test */
    public function a_autor_has_belongs_to_creator_relation()
    {
        $autor = Autor::factory()->make();

        $this->assertInstanceOf(User::class, $autor->creator);
        $this->assertEquals($autor->creator_id, $autor->creator->id);
    }
}
