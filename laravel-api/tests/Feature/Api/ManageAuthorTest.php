<?php

namespace Tests\Feature\Api;

use App\Models\Author;
use Tests\BrowserKitTest as TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManageAuthorTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_see_author_list_in_author_index_page()
    {
        $user = $this->createUser();
        $author = Author::factory()->create();

        $this->getJson(route('api.authors.index'), [
            'Authorization' => 'Bearer '.$user->api_token
        ]);

        $this->seeJson(['name' => $author->name]);
    }

    /** @test */
    public function user_can_create_a_author()
    {
        $user = $this->createUser();

        $this->postJson(route('api.authors.store'), [
            'name'        => 'Author 1 name',
            'description' => 'Author 1 description',
        ], [
            'Authorization' => 'Bearer '.$user->api_token
        ]);

        $this->seeInDatabase('authors', [
            'name'        => 'Author 1 name',
            'description' => 'Author 1 description',
        ]);

        $this->seeStatusCode(201);
        $this->seeJson([
            'message'     => __('author.created'),
            'name'        => 'Author 1 name',
            'description' => 'Author 1 description',
        ]);
    }

    private function getCreateFields(array $overrides = [])
    {
        return array_merge([
            'name'        => 'Author 1 name',
            'description' => 'Author 1 description',
        ], $overrides);
    }

    /** @test */
    public function validate_author_name_is_required()
    {
        $user = $this->createUser();

        // name empty
        $requestBody = $this->getCreateFields(['name' => '']);
        $this->postJson(
            route('api.authors.store'),
            $requestBody,
            ['Authorization' => 'Bearer '.$user->api_token]
        );

        $this->seeStatusCode(422);
        $this->seeJsonStructure(['errors' => ['name']]);
    }

    /** @test */
    public function validate_author_name_is_not_more_than_60_characters()
    {
        $user = $this->createUser();

        // name 70 characters
        $requestBody = $this->getCreateFields(['name' => str_repeat('Test Title', 7)]);
        $this->postJson(
            route('api.authors.store'),
            $requestBody,
            ['Authorization' => 'Bearer '.$user->api_token]
        );

        $this->seeStatusCode(422);
        $this->seeJsonStructure(['errors' => ['name']]);
    }

    /** @test */
    public function validate_author_description_is_not_more_than_255_characters()
    {
        $user = $this->createUser();

        // description 256 characters
        $requestBody = $this->getCreateFields(['description' => str_repeat('Long description', 16)]);
        $this->postJson(
            route('api.authors.store'),
            $requestBody,
            ['Authorization' => 'Bearer '.$user->api_token]
        );

        $this->seeStatusCode(422);
        $this->seeJsonStructure(['errors' => ['description']]);
    }

    /** @test */
    public function user_can_get_a_author_detail()
    {
        $user = $this->createUser();
        $author = Author::factory()->create(['name' => 'Testing 123']);

        $this->getJson(route('api.authors.show', $author), [
            'Authorization' => 'Bearer '.$user->api_token
        ]);

        $this->seeJson(['name' => 'Testing 123']);
    }

    /** @test */
    public function user_can_update_a_author()
    {
        $user = $this->createUser();
        $author = Author::factory()->create(['name' => 'Testing 123']);

        $this->patchJson(route('api.authors.update', $author), [
            'name'        => 'Author 1 name',
            'description' => 'Author 1 description',
        ], [
            'Authorization' => 'Bearer '.$user->api_token
        ]);

        $this->seeInDatabase('authors', [
            'name'        => 'Author 1 name',
            'description' => 'Author 1 description',
        ]);

        $this->seeStatusCode(200);
        $this->seeJson([
            'message'     => __('author.updated'),
            'name'        => 'Author 1 name',
            'description' => 'Author 1 description',
        ]);
    }

    private function getEditFields(array $overrides = [])
    {
        return array_merge([
            'name'        => 'Author 1 name',
            'description' => 'Author 1 description',
        ], $overrides);
    }

    /** @test */
    public function validate_author_name_update_is_required()
    {
        $user = $this->createUser();
        $author = Author::factory()->create();

        // name empty
        $requestBody = $this->getEditFields(['name' => '']);
        $this->patchJson(
            route('api.authors.update', $author),
            $requestBody,
            ['Authorization' => 'Bearer '.$user->api_token]
        );

        $this->seeStatusCode(422);
        $this->seeJsonStructure(['errors' => ['name']]);
    }

    /** @test */
    public function validate_author_name_update_is_not_more_than_60_characters()
    {
        $user = $this->createUser();
        $author = Author::factory()->create();

        // name 70 characters
        $requestBody = $this->getEditFields(['name' => str_repeat('Test Title', 7)]);
        $this->patchJson(
            route('api.authors.update', $author),
            $requestBody,
            ['Authorization' => 'Bearer '.$user->api_token]
        );

        $this->seeStatusCode(422);
        $this->seeJsonStructure(['errors' => ['name']]);
    }

    /** @test */
    public function validate_author_description_update_is_not_more_than_255_characters()
    {
        $user = $this->createUser();
        $author = Author::factory()->create(['name' => 'Testing 123']);

        // description 256 characters
        $requestBody = $this->getEditFields(['description' => str_repeat('Long description', 16)]);
        $this->patchJson(
            route('api.authors.update', $author),
            $requestBody,
            ['Authorization' => 'Bearer '.$user->api_token]
        );

        $this->seeStatusCode(422);
        $this->seeJsonStructure(['errors' => ['description']]);
    }

    /** @test */
    public function user_can_delete_a_author()
    {
        $user = $this->createUser();
        $author = Author::factory()->create();

        $this->deleteJson(route('api.authors.destroy', $author), [
            'author_id' => $author->id,
        ], [
            'Authorization' => 'Bearer '.$user->api_token
        ]);

        $this->dontSeeInDatabase('authors', [
            'id' => $author->id,
        ]);

        $this->seeStatusCode(200);
        $this->seeJson([
            'message' => __('author.deleted'),
        ]);
    }
}
