<?php

namespace Tests\Feature;

use App\Models\Author;
use Tests\BrowserKitTest as TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManageAuthorTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_see_author_list_in_author_index_page()
    {
        $author = Author::factory()->create();

        $this->loginAsUser();
        $this->visitRoute('authors.index');
        $this->see($author->name);
    }

    private function getCreateFields(array $overrides = [])
    {
        return array_merge([
            'name'        => 'Author 1 name',
            'description' => 'Author 1 description',
        ], $overrides);
    }

    /** @test */
    public function user_can_create_a_author()
    {
        $this->loginAsUser();
        $this->visitRoute('authors.index');

        $this->click(__('author.create'));
        $this->seeRouteIs('authors.create');

        $this->submitForm(__('author.create'), $this->getCreateFields());

        $this->seeRouteIs('authors.show', Author::first());

        $this->seeInDatabase('authors', $this->getCreateFields());
    }

    /** @test */
    public function validate_author_name_is_required()
    {
        $this->loginAsUser();

        // name empty
        $this->post(route('authors.store'), $this->getCreateFields(['name' => '']));
        $this->assertSessionHasErrors('name');
    }

    /** @test */
    public function validate_author_name_is_not_more_than_60_characters()
    {
        $this->loginAsUser();

        // name 70 characters
        $this->post(route('authors.store'), $this->getCreateFields([
            'name' => str_repeat('Test Title', 7),
        ]));
        $this->assertSessionHasErrors('name');
    }

    /** @test */
    public function validate_author_description_is_not_more_than_255_characters()
    {
        $this->loginAsUser();

        // description 256 characters
        $this->post(route('authors.store'), $this->getCreateFields([
            'description' => str_repeat('Long description', 16),
        ]));
        $this->assertSessionHasErrors('description');
    }

    private function getEditFields(array $overrides = [])
    {
        return array_merge([
            'name'        => 'Author 1 name',
            'description' => 'Author 1 description',
        ], $overrides);
    }

    /** @test */
    public function user_can_edit_a_author()
    {
        $this->loginAsUser();
        $author = Author::factory()->create(['name' => 'Testing 123']);

        $this->visitRoute('authors.show', $author);
        $this->click('edit-author-'.$author->id);
        $this->seeRouteIs('authors.edit', $author);

        $this->submitForm(__('author.update'), $this->getEditFields());

        $this->seeRouteIs('authors.show', $author);

        $this->seeInDatabase('authors', $this->getEditFields([
            'id' => $author->id,
        ]));
    }

    /** @test */
    public function validate_author_name_update_is_required()
    {
        $this->loginAsUser();
        $author = Author::factory()->create(['name' => 'Testing 123']);

        // name empty
        $this->patch(route('authors.update', $author), $this->getEditFields(['name' => '']));
        $this->assertSessionHasErrors('name');
    }

    /** @test */
    public function validate_author_name_update_is_not_more_than_60_characters()
    {
        $this->loginAsUser();
        $author = Author::factory()->create(['name' => 'Testing 123']);

        // name 70 characters
        $this->patch(route('authors.update', $author), $this->getEditFields([
            'name' => str_repeat('Test Title', 7),
        ]));
        $this->assertSessionHasErrors('name');
    }

    /** @test */
    public function validate_author_description_update_is_not_more_than_255_characters()
    {
        $this->loginAsUser();
        $author = Author::factory()->create(['name' => 'Testing 123']);

        // description 256 characters
        $this->patch(route('authors.update', $author), $this->getEditFields([
            'description' => str_repeat('Long description', 16),
        ]));
        $this->assertSessionHasErrors('description');
    }

    /** @test */
    public function user_can_delete_a_author()
    {
        $this->loginAsUser();
        $author = Author::factory()->create();
        Author::factory()->create();

        $this->visitRoute('authors.edit', $author);
        $this->click('del-author-'.$author->id);
        $this->seeRouteIs('authors.edit', [$author, 'action' => 'delete']);

        $this->press(__('app.delete_confirm_button'));

        $this->dontSeeInDatabase('authors', [
            'id' => $author->id,
        ]);
    }
}
