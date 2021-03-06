<?php

namespace Tests\Feature\Api;

use App\Models\Autor;
use Tests\BrowserKitTest as TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManageAutorTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_see_autor_list_in_autor_index_page()
    {
        $user = $this->createUser();
        $autor = Autor::factory()->create();

        $this->getJson(route('api.autors.index'), [
            'Authorization' => 'Bearer '.$user->api_token
        ]);

        $this->seeJson(['name' => $autor->name]);
    }

    /** @test */
    public function user_can_create_a_autor()
    {
        $user = $this->createUser();

        $this->postJson(route('api.autors.store'), [
            'name'        => 'Autor 1 name',
            'description' => 'Autor 1 description',
        ], [
            'Authorization' => 'Bearer '.$user->api_token
        ]);

        $this->seeInDatabase('autors', [
            'name'        => 'Autor 1 name',
            'description' => 'Autor 1 description',
        ]);

        $this->seeStatusCode(201);
        $this->seeJson([
            'message'     => __('autor.created'),
            'name'        => 'Autor 1 name',
            'description' => 'Autor 1 description',
        ]);
    }

    private function getCreateFields(array $overrides = [])
    {
        return array_merge([
            'name'        => 'Autor 1 name',
            'description' => 'Autor 1 description',
        ], $overrides);
    }

    /** @test */
    public function validate_autor_name_is_required()
    {
        $user = $this->createUser();

        // name empty
        $requestBody = $this->getCreateFields(['name' => '']);
        $this->postJson(
            route('api.autors.store'),
            $requestBody,
            ['Authorization' => 'Bearer '.$user->api_token]
        );

        $this->seeStatusCode(422);
        $this->seeJsonStructure(['errors' => ['name']]);
    }

    /** @test */
    public function validate_autor_name_is_not_more_than_60_characters()
    {
        $user = $this->createUser();

        // name 70 characters
        $requestBody = $this->getCreateFields(['name' => str_repeat('Test Title', 7)]);
        $this->postJson(
            route('api.autors.store'),
            $requestBody,
            ['Authorization' => 'Bearer '.$user->api_token]
        );

        $this->seeStatusCode(422);
        $this->seeJsonStructure(['errors' => ['name']]);
    }

    /** @test */
    public function validate_autor_description_is_not_more_than_255_characters()
    {
        $user = $this->createUser();

        // description 256 characters
        $requestBody = $this->getCreateFields(['description' => str_repeat('Long description', 16)]);
        $this->postJson(
            route('api.autors.store'),
            $requestBody,
            ['Authorization' => 'Bearer '.$user->api_token]
        );

        $this->seeStatusCode(422);
        $this->seeJsonStructure(['errors' => ['description']]);
    }

    /** @test */
    public function user_can_get_a_autor_detail()
    {
        $user = $this->createUser();
        $autor = Autor::factory()->create(['name' => 'Testing 123']);

        $this->getJson(route('api.autors.show', $autor), [
            'Authorization' => 'Bearer '.$user->api_token
        ]);

        $this->seeJson(['name' => 'Testing 123']);
    }

    /** @test */
    public function user_can_update_a_autor()
    {
        $user = $this->createUser();
        $autor = Autor::factory()->create(['name' => 'Testing 123']);

        $this->patchJson(route('api.autors.update', $autor), [
            'name'        => 'Autor 1 name',
            'description' => 'Autor 1 description',
        ], [
            'Authorization' => 'Bearer '.$user->api_token
        ]);

        $this->seeInDatabase('autors', [
            'name'        => 'Autor 1 name',
            'description' => 'Autor 1 description',
        ]);

        $this->seeStatusCode(200);
        $this->seeJson([
            'message'     => __('autor.updated'),
            'name'        => 'Autor 1 name',
            'description' => 'Autor 1 description',
        ]);
    }

    private function getEditFields(array $overrides = [])
    {
        return array_merge([
            'name'        => 'Autor 1 name',
            'description' => 'Autor 1 description',
        ], $overrides);
    }

    /** @test */
    public function validate_autor_name_update_is_required()
    {
        $user = $this->createUser();
        $autor = Autor::factory()->create();

        // name empty
        $requestBody = $this->getEditFields(['name' => '']);
        $this->patchJson(
            route('api.autors.update', $autor),
            $requestBody,
            ['Authorization' => 'Bearer '.$user->api_token]
        );

        $this->seeStatusCode(422);
        $this->seeJsonStructure(['errors' => ['name']]);
    }

    /** @test */
    public function validate_autor_name_update_is_not_more_than_60_characters()
    {
        $user = $this->createUser();
        $autor = Autor::factory()->create();

        // name 70 characters
        $requestBody = $this->getEditFields(['name' => str_repeat('Test Title', 7)]);
        $this->patchJson(
            route('api.autors.update', $autor),
            $requestBody,
            ['Authorization' => 'Bearer '.$user->api_token]
        );

        $this->seeStatusCode(422);
        $this->seeJsonStructure(['errors' => ['name']]);
    }

    /** @test */
    public function validate_autor_description_update_is_not_more_than_255_characters()
    {
        $user = $this->createUser();
        $autor = Autor::factory()->create(['name' => 'Testing 123']);

        // description 256 characters
        $requestBody = $this->getEditFields(['description' => str_repeat('Long description', 16)]);
        $this->patchJson(
            route('api.autors.update', $autor),
            $requestBody,
            ['Authorization' => 'Bearer '.$user->api_token]
        );

        $this->seeStatusCode(422);
        $this->seeJsonStructure(['errors' => ['description']]);
    }

    /** @test */
    public function user_can_delete_a_autor()
    {
        $user = $this->createUser();
        $autor = Autor::factory()->create();

        $this->deleteJson(route('api.autors.destroy', $autor), [
            'autor_id' => $autor->id,
        ], [
            'Authorization' => 'Bearer '.$user->api_token
        ]);

        $this->dontSeeInDatabase('autors', [
            'id' => $autor->id,
        ]);

        $this->seeStatusCode(200);
        $this->seeJson([
            'message' => __('autor.deleted'),
        ]);
    }
}
