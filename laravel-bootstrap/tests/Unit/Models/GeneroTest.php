<?php

namespace Tests\Unit\Models;

use App\Models\User;
use App\Models\Genero;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\BrowserKitTest as TestCase;

class GeneroTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_genero_has_name_link_attribute()
    {
        $genero = Genero::factory()->create();

        $title = __('app.show_detail_title', [
            'name' => $genero->name, 'type' => __('genero.genero'),
        ]);
        $link = '<a href="'.route('generos.show', $genero).'"';
        $link .= ' title="'.$title.'">';
        $link .= $genero->name;
        $link .= '</a>';

        $this->assertEquals($link, $genero->name_link);
    }

    /** @test */
    public function a_genero_has_belongs_to_creator_relation()
    {
        $genero = Genero::factory()->make();

        $this->assertInstanceOf(User::class, $genero->creator);
        $this->assertEquals($genero->creator_id, $genero->creator->id);
    }
}
