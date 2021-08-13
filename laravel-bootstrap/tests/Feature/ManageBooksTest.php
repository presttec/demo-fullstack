<?php

namespace Tests\Feature;

use App\Models\Books;
use Tests\BrowserKitTest as TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManageBooksTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_see_books_list_in_books_index_page()
    {
        $books = Books::factory()->create();

        $this->loginAsUser();
        $this->visitRoute('books.index');
        $this->see($books->name);
    }

    private function getCreateFields(array $overrides = [])
    {
        return array_merge([
            'name'        => 'Books 1 name',
            'description' => 'Books 1 description',
        ], $overrides);
    }

    /** @test */
    public function user_can_create_a_books()
    {
        $this->loginAsUser();
        $this->visitRoute('books.index');

        $this->click(__('books.create'));
        $this->seeRouteIs('books.create');

        $this->submitForm(__('books.create'), $this->getCreateFields());

        $this->seeRouteIs('books.show', Books::first());

        $this->seeInDatabase('books', $this->getCreateFields());
    }

    /** @test */
    public function validate_books_name_is_required()
    {
        $this->loginAsUser();

        // name empty
        $this->post(route('books.store'), $this->getCreateFields(['name' => '']));
        $this->assertSessionHasErrors('name');
    }

    /** @test */
    public function validate_books_name_is_not_more_than_60_characters()
    {
        $this->loginAsUser();

        // name 70 characters
        $this->post(route('books.store'), $this->getCreateFields([
            'name' => str_repeat('Test Title', 7),
        ]));
        $this->assertSessionHasErrors('name');
    }

    /** @test */
    public function validate_books_description_is_not_more_than_255_characters()
    {
        $this->loginAsUser();

        // description 256 characters
        $this->post(route('books.store'), $this->getCreateFields([
            'description' => str_repeat('Long description', 16),
        ]));
        $this->assertSessionHasErrors('description');
    }

    private function getEditFields(array $overrides = [])
    {
        return array_merge([
            'name'        => 'Books 1 name',
            'description' => 'Books 1 description',
        ], $overrides);
    }

    /** @test */
    public function user_can_edit_a_books()
    {
        $this->loginAsUser();
        $books = Books::factory()->create(['name' => 'Testing 123']);

        $this->visitRoute('books.show', $books);
        $this->click('edit-books-'.$books->id);
        $this->seeRouteIs('books.edit', $books);

        $this->submitForm(__('books.update'), $this->getEditFields());

        $this->seeRouteIs('books.show', $books);

        $this->seeInDatabase('books', $this->getEditFields([
            'id' => $books->id,
        ]));
    }

    /** @test */
    public function validate_books_name_update_is_required()
    {
        $this->loginAsUser();
        $books = Books::factory()->create(['name' => 'Testing 123']);

        // name empty
        $this->patch(route('books.update', $books), $this->getEditFields(['name' => '']));
        $this->assertSessionHasErrors('name');
    }

    /** @test */
    public function validate_books_name_update_is_not_more_than_60_characters()
    {
        $this->loginAsUser();
        $books = Books::factory()->create(['name' => 'Testing 123']);

        // name 70 characters
        $this->patch(route('books.update', $books), $this->getEditFields([
            'name' => str_repeat('Test Title', 7),
        ]));
        $this->assertSessionHasErrors('name');
    }

    /** @test */
    public function validate_books_description_update_is_not_more_than_255_characters()
    {
        $this->loginAsUser();
        $books = Books::factory()->create(['name' => 'Testing 123']);

        // description 256 characters
        $this->patch(route('books.update', $books), $this->getEditFields([
            'description' => str_repeat('Long description', 16),
        ]));
        $this->assertSessionHasErrors('description');
    }

    /** @test */
    public function user_can_delete_a_books()
    {
        $this->loginAsUser();
        $books = Books::factory()->create();
        Books::factory()->create();

        $this->visitRoute('books.edit', $books);
        $this->click('del-books-'.$books->id);
        $this->seeRouteIs('books.edit', [$books, 'action' => 'delete']);

        $this->press(__('app.delete_confirm_button'));

        $this->dontSeeInDatabase('books', [
            'id' => $books->id,
        ]);
    }
}
