<?php

namespace Tests\Unit\Models;

use App\Models\User;
use App\Models\Books;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\BrowserKitTest as TestCase;

class BooksTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_books_has_name_link_attribute()
    {
        $books = Books::factory()->create();

        $title = __('app.show_detail_title', [
            'name' => $books->name, 'type' => __('books.books'),
        ]);
        $link = '<a href="'.route('books.show', $books).'"';
        $link .= ' title="'.$title.'">';
        $link .= $books->name;
        $link .= '</a>';

        $this->assertEquals($link, $books->name_link);
    }

    /** @test */
    public function a_books_has_belongs_to_creator_relation()
    {
        $books = Books::factory()->make();

        $this->assertInstanceOf(User::class, $books->creator);
        $this->assertEquals($books->creator_id, $books->creator->id);
    }
}
