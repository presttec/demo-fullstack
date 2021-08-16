<?php

namespace Tests\Unit\Models;

use App\Models\User;
use App\Models\Livro;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\BrowserKitTest as TestCase;

class LivroTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_livro_has_name_link_attribute()
    {
        $livro = Livro::factory()->create();

        $title = __('app.show_detail_title', [
            'name' => $livro->name, 'type' => __('livro.livro'),
        ]);
        $link = '<a href="'.route('livros.show', $livro).'"';
        $link .= ' title="'.$title.'">';
        $link .= $livro->name;
        $link .= '</a>';

        $this->assertEquals($link, $livro->name_link);
    }

    /** @test */
    public function a_livro_has_belongs_to_creator_relation()
    {
        $livro = Livro::factory()->make();

        $this->assertInstanceOf(User::class, $livro->creator);
        $this->assertEquals($livro->creator_id, $livro->creator->id);
    }
}
