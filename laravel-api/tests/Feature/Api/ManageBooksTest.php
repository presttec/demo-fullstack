<?php

namespace Tests\Feature\Api;

use App\Models\Books;
use Tests\BrowserKitTest as TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManageBooksTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_see_books_list_in_books_index_page()
    {
        $user = $this->createUser();
        $books = Books::factory()->create();

        $this->getJson(route('api.books.index'), [
            'Authorization' => 'Bearer '.$user->api_token
        ]);

        $this->seeJson(['name' => $books->name]);
    }

    /** @test */
    public function user_can_create_a_books()
    {
        $user = $this->createUser();

        $this->postJson(route('api.books.store'), [
            'name'        => 'Books 1 name',
            'description' => 'Books 1 description',
        ], [
            'Authorization' => 'Bearer '.$user->api_token
        ]);

        $this->seeInDatabase('books', [
            'name'        => 'Books 1 name',
            'description' => 'Books 1 description',
        ]);

        $this->seeStatusCode(201);
        $this->seeJson([
            'message'     => __('books.created'),
            'name'        => 'Books 1 name',
            'description' => 'Books 1 description',
        ]);
    }

    private function getCreateFields(array $overrides = [])
    {
        return array_merge([
            'name'        => 'Books 1 name',
            'description' => 'Books 1 description',
        ], $overrides);
    }

    /** @test */
    public function validate_books_name_is_required()
    {
        $user = $this->createUser();

        // name empty
        $requestBody = $this->getCreateFields(['name' => '']);
        $this->postJson(
            route('api.books.store'),
            $requestBody,
            ['Authorization' => 'Bearer '.$user->api_token]
        );

        $this->seeStatusCode(422);
        $this->seeJsonStructure(['errors' => ['name']]);
    }

    /** @test */
    public function validate_books_name_is_not_more_than_60_characters()
    {
        $user = $this->createUser();

        // name 70 characters
        $requestBody = $this->getCreateFields(['name' => str_repeat('Test Title', 7)]);
        $this->postJson(
            route('api.books.store'),
            $requestBody,
            ['Authorization' => 'Bearer '.$user->api_token]
        );

        $this->seeStatusCode(422);
        $this->seeJsonStructure(['errors' => ['name']]);
    }

    /** @test */
    public function validate_books_description_is_not_more_than_255_characters()
    {
        $user = $this->createUser();

        // description 256 characters
        $requestBody = $this->getCreateFields(['description' => str_repeat('Long description', 16)]);
        $this->postJson(
            route('api.books.store'),
            $requestBody,
            ['Authorization' => 'Bearer '.$user->api_token]
        );

        $this->seeStatusCode(422);
        $this->seeJsonStructure(['errors' => ['description']]);
    }

    /** @test */
    public function user_can_get_a_books_detail()
    {
        $user = $this->createUser();
        $books = Books::factory()->create(['name' => 'Testing 123']);

        $this->getJson(route('api.books.show', $books), [
            'Authorization' => 'Bearer '.$user->api_token
        ]);

        $this->seeJson(['name' => 'Testing 123']);
    }

    /** @test */
    public function user_can_update_a_books()
    {
        $user = $this->createUser();
        $books = Books::factory()->create(['name' => 'Testing 123']);

        $this->patchJson(route('api.books.update', $books), [
            'name'        => 'Books 1 name',
            'description' => 'Books 1 description',
        ], [
            'Authorization' => 'Bearer '.$user->api_token
        ]);

        $this->seeInDatabase('books', [
            'name'        => 'Books 1 name',
            'description' => 'Books 1 description',
        ]);

        $this->seeStatusCode(200);
        $this->seeJson([
            'message'     => __('books.updated'),
            'name'        => 'Books 1 name',
            'description' => 'Books 1 description',
        ]);
    }

    private function getEditFields(array $overrides = [])
    {
        return array_merge([
            'name'        => 'Books 1 name',
            'description' => 'Books 1 description',
        ], $overrides);
    }

    /** @test */
    public function validate_books_name_update_is_required()
    {
        $user = $this->createUser();
        $books = Books::factory()->create();

        // name empty
        $requestBody = $this->getEditFields(['name' => '']);
        $this->patchJson(
            route('api.books.update', $books),
            $requestBody,
            ['Authorization' => 'Bearer '.$user->api_token]
        );

        $this->seeStatusCode(422);
        $this->seeJsonStructure(['errors' => ['name']]);
    }

    /** @test */
    public function validate_books_name_update_is_not_more_than_60_characters()
    {
        $user = $this->createUser();
        $books = Books::factory()->create();

        // name 70 characters
        $requestBody = $this->getEditFields(['name' => str_repeat('Test Title', 7)]);
        $this->patchJson(
            route('api.books.update', $books),
            $requestBody,
            ['Authorization' => 'Bearer '.$user->api_token]
        );

        $this->seeStatusCode(422);
        $this->seeJsonStructure(['errors' => ['name']]);
    }

    /** @test */
    public function validate_books_description_update_is_not_more_than_255_characters()
    {
        $user = $this->createUser();
        $books = Books::factory()->create(['name' => 'Testing 123']);

        // description 256 characters
        $requestBody = $this->getEditFields(['description' => str_repeat('Long description', 16)]);
        $this->patchJson(
            route('api.books.update', $books),
            $requestBody,
            ['Authorization' => 'Bearer '.$user->api_token]
        );

        $this->seeStatusCode(422);
        $this->seeJsonStructure(['errors' => ['description']]);
    }

    /** @test */
    public function user_can_delete_a_books()
    {
        $user = $this->createUser();
        $books = Books::factory()->create();

        $this->deleteJson(route('api.books.destroy', $books), [
            'books_id' => $books->id,
        ], [
            'Authorization' => 'Bearer '.$user->api_token
        ]);

        $this->dontSeeInDatabase('books', [
            'id' => $books->id,
        ]);

        $this->seeStatusCode(200);
        $this->seeJson([
            'message' => __('books.deleted'),
        ]);
    }
}
