<?php

namespace Tests\Feature\Api;

use App\Models\Genero;
use Tests\BrowserKitTest as TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManageGeneroTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_see_genero_list_in_genero_index_page()
    {
        $user = $this->createUser();
        $genero = Genero::factory()->create();

        $this->getJson(route('api.generos.index'), [
            'Authorization' => 'Bearer '.$user->api_token
        ]);

        $this->seeJson(['name' => $genero->name]);
    }

    /** @test */
    public function user_can_create_a_genero()
    {
        $user = $this->createUser();

        $this->postJson(route('api.generos.store'), [
            'name'        => 'Genero 1 name',
            'description' => 'Genero 1 description',
        ], [
            'Authorization' => 'Bearer '.$user->api_token
        ]);

        $this->seeInDatabase('generos', [
            'name'        => 'Genero 1 name',
            'description' => 'Genero 1 description',
        ]);

        $this->seeStatusCode(201);
        $this->seeJson([
            'message'     => __('genero.created'),
            'name'        => 'Genero 1 name',
            'description' => 'Genero 1 description',
        ]);
    }

    private function getCreateFields(array $overrides = [])
    {
        return array_merge([
            'name'        => 'Genero 1 name',
            'description' => 'Genero 1 description',
        ], $overrides);
    }

    /** @test */
    public function validate_genero_name_is_required()
    {
        $user = $this->createUser();

        // name empty
        $requestBody = $this->getCreateFields(['name' => '']);
        $this->postJson(
            route('api.generos.store'),
            $requestBody,
            ['Authorization' => 'Bearer '.$user->api_token]
        );

        $this->seeStatusCode(422);
        $this->seeJsonStructure(['errors' => ['name']]);
    }

    /** @test */
    public function validate_genero_name_is_not_more_than_60_characters()
    {
        $user = $this->createUser();

        // name 70 characters
        $requestBody = $this->getCreateFields(['name' => str_repeat('Test Title', 7)]);
        $this->postJson(
            route('api.generos.store'),
            $requestBody,
            ['Authorization' => 'Bearer '.$user->api_token]
        );

        $this->seeStatusCode(422);
        $this->seeJsonStructure(['errors' => ['name']]);
    }

    /** @test */
    public function validate_genero_description_is_not_more_than_255_characters()
    {
        $user = $this->createUser();

        // description 256 characters
        $requestBody = $this->getCreateFields(['description' => str_repeat('Long description', 16)]);
        $this->postJson(
            route('api.generos.store'),
            $requestBody,
            ['Authorization' => 'Bearer '.$user->api_token]
        );

        $this->seeStatusCode(422);
        $this->seeJsonStructure(['errors' => ['description']]);
    }

    /** @test */
    public function user_can_get_a_genero_detail()
    {
        $user = $this->createUser();
        $genero = Genero::factory()->create(['name' => 'Testing 123']);

        $this->getJson(route('api.generos.show', $genero), [
            'Authorization' => 'Bearer '.$user->api_token
        ]);

        $this->seeJson(['name' => 'Testing 123']);
    }

    /** @test */
    public function user_can_update_a_genero()
    {
        $user = $this->createUser();
        $genero = Genero::factory()->create(['name' => 'Testing 123']);

        $this->patchJson(route('api.generos.update', $genero), [
            'name'        => 'Genero 1 name',
            'description' => 'Genero 1 description',
        ], [
            'Authorization' => 'Bearer '.$user->api_token
        ]);

        $this->seeInDatabase('generos', [
            'name'        => 'Genero 1 name',
            'description' => 'Genero 1 description',
        ]);

        $this->seeStatusCode(200);
        $this->seeJson([
            'message'     => __('genero.updated'),
            'name'        => 'Genero 1 name',
            'description' => 'Genero 1 description',
        ]);
    }

    private function getEditFields(array $overrides = [])
    {
        return array_merge([
            'name'        => 'Genero 1 name',
            'description' => 'Genero 1 description',
        ], $overrides);
    }

    /** @test */
    public function validate_genero_name_update_is_required()
    {
        $user = $this->createUser();
        $genero = Genero::factory()->create();

        // name empty
        $requestBody = $this->getEditFields(['name' => '']);
        $this->patchJson(
            route('api.generos.update', $genero),
            $requestBody,
            ['Authorization' => 'Bearer '.$user->api_token]
        );

        $this->seeStatusCode(422);
        $this->seeJsonStructure(['errors' => ['name']]);
    }

    /** @test */
    public function validate_genero_name_update_is_not_more_than_60_characters()
    {
        $user = $this->createUser();
        $genero = Genero::factory()->create();

        // name 70 characters
        $requestBody = $this->getEditFields(['name' => str_repeat('Test Title', 7)]);
        $this->patchJson(
            route('api.generos.update', $genero),
            $requestBody,
            ['Authorization' => 'Bearer '.$user->api_token]
        );

        $this->seeStatusCode(422);
        $this->seeJsonStructure(['errors' => ['name']]);
    }

    /** @test */
    public function validate_genero_description_update_is_not_more_than_255_characters()
    {
        $user = $this->createUser();
        $genero = Genero::factory()->create(['name' => 'Testing 123']);

        // description 256 characters
        $requestBody = $this->getEditFields(['description' => str_repeat('Long description', 16)]);
        $this->patchJson(
            route('api.generos.update', $genero),
            $requestBody,
            ['Authorization' => 'Bearer '.$user->api_token]
        );

        $this->seeStatusCode(422);
        $this->seeJsonStructure(['errors' => ['description']]);
    }

    /** @test */
    public function user_can_delete_a_genero()
    {
        $user = $this->createUser();
        $genero = Genero::factory()->create();

        $this->deleteJson(route('api.generos.destroy', $genero), [
            'genero_id' => $genero->id,
        ], [
            'Authorization' => 'Bearer '.$user->api_token
        ]);

        $this->dontSeeInDatabase('generos', [
            'id' => $genero->id,
        ]);

        $this->seeStatusCode(200);
        $this->seeJson([
            'message' => __('genero.deleted'),
        ]);
    }
}
