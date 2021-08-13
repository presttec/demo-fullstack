<?php

namespace Tests\Unit\Models;

use App\Models\User;
use App\Models\Author;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\BrowserKitTest as TestCase;

class AuthorTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_author_has_name_link_attribute()
    {
        $author = Author::factory()->create();

        $title = __('app.show_detail_title', [
            'name' => $author->name, 'type' => __('author.author'),
        ]);
        $link = '<a href="'.route('authors.show', $author).'"';
        $link .= ' title="'.$title.'">';
        $link .= $author->name;
        $link .= '</a>';

        $this->assertEquals($link, $author->name_link);
    }

    /** @test */
    public function a_author_has_belongs_to_creator_relation()
    {
        $author = Author::factory()->make();

        $this->assertInstanceOf(User::class, $author->creator);
        $this->assertEquals($author->creator_id, $author->creator->id);
    }
}
