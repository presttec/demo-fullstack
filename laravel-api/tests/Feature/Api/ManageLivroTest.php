<?php

namespace Tests\Feature\Api;

use App\Models\Livro;
use Tests\BrowserKitTest as TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManageLivroTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_see_livro_list_in_livro_index_page()
    {
        $user = $this->createUser();
        $livro = Livro::factory()->create();

        $this->getJson(route('api.livros.index'), [
            'Authorization' => 'Bearer '.$user->api_token
        ]);

        $this->seeJson(['name' => $livro->name]);
    }

    /** @test */
    public function user_can_create_a_livro()
    {
        $user = $this->createUser();

        $this->postJson(route('api.livros.store'), [
            'name'        => 'Livro 1 name',
            'description' => 'Livro 1 description',
        ], [
            'Authorization' => 'Bearer '.$user->api_token
        ]);

        $this->seeInDatabase('livros', [
            'name'        => 'Livro 1 name',
            'description' => 'Livro 1 description',
        ]);

        $this->seeStatusCode(201);
        $this->seeJson([
            'message'     => __('livro.created'),
            'name'        => 'Livro 1 name',
            'description' => 'Livro 1 description',
        ]);
    }

    private function getCreateFields(array $overrides = [])
    {
        return array_merge([
            'name'        => 'Livro 1 name',
            'description' => 'Livro 1 description',
        ], $overrides);
    }

    /** @test */
    public function validate_livro_name_is_required()
    {
        $user = $this->createUser();

        // name empty
        $requestBody = $this->getCreateFields(['name' => '']);
        $this->postJson(
            route('api.livros.store'),
            $requestBody,
            ['Authorization' => 'Bearer '.$user->api_token]
        );

        $this->seeStatusCode(422);
        $this->seeJsonStructure(['errors' => ['name']]);
    }

    /** @test */
    public function validate_livro_name_is_not_more_than_60_characters()
    {
        $user = $this->createUser();

        // name 70 characters
        $requestBody = $this->getCreateFields(['name' => str_repeat('Test Title', 7)]);
        $this->postJson(
            route('api.livros.store'),
            $requestBody,
            ['Authorization' => 'Bearer '.$user->api_token]
        );

        $this->seeStatusCode(422);
        $this->seeJsonStructure(['errors' => ['name']]);
    }

    /** @test */
    public function validate_livro_description_is_not_more_than_255_characters()
    {
        $user = $this->createUser();

        // description 256 characters
        $requestBody = $this->getCreateFields(['description' => str_repeat('Long description', 16)]);
        $this->postJson(
            route('api.livros.store'),
            $requestBody,
            ['Authorization' => 'Bearer '.$user->api_token]
        );

        $this->seeStatusCode(422);
        $this->seeJsonStructure(['errors' => ['description']]);
    }

    /** @test */
    public function user_can_get_a_livro_detail()
    {
        $user = $this->createUser();
        $livro = Livro::factory()->create(['name' => 'Testing 123']);

        $this->getJson(route('api.livros.show', $livro), [
            'Authorization' => 'Bearer '.$user->api_token
        ]);

        $this->seeJson(['name' => 'Testing 123']);
    }

    /** @test */
    public function user_can_update_a_livro()
    {
        $user = $this->createUser();
        $livro = Livro::factory()->create(['name' => 'Testing 123']);

        $this->patchJson(route('api.livros.update', $livro), [
            'name'        => 'Livro 1 name',
            'description' => 'Livro 1 description',
        ], [
            'Authorization' => 'Bearer '.$user->api_token
        ]);

        $this->seeInDatabase('livros', [
            'name'        => 'Livro 1 name',
            'description' => 'Livro 1 description',
        ]);

        $this->seeStatusCode(200);
        $this->seeJson([
            'message'     => __('livro.updated'),
            'name'        => 'Livro 1 name',
            'description' => 'Livro 1 description',
        ]);
    }

    private function getEditFields(array $overrides = [])
    {
        return array_merge([
            'name'        => 'Livro 1 name',
            'description' => 'Livro 1 description',
        ], $overrides);
    }

    /** @test */
    public function validate_livro_name_update_is_required()
    {
        $user = $this->createUser();
        $livro = Livro::factory()->create();

        // name empty
        $requestBody = $this->getEditFields(['name' => '']);
        $this->patchJson(
            route('api.livros.update', $livro),
            $requestBody,
            ['Authorization' => 'Bearer '.$user->api_token]
        );

        $this->seeStatusCode(422);
        $this->seeJsonStructure(['errors' => ['name']]);
    }

    /** @test */
    public function validate_livro_name_update_is_not_more_than_60_characters()
    {
        $user = $this->createUser();
        $livro = Livro::factory()->create();

        // name 70 characters
        $requestBody = $this->getEditFields(['name' => str_repeat('Test Title', 7)]);
        $this->patchJson(
            route('api.livros.update', $livro),
            $requestBody,
            ['Authorization' => 'Bearer '.$user->api_token]
        );

        $this->seeStatusCode(422);
        $this->seeJsonStructure(['errors' => ['name']]);
    }

    /** @test */
    public function validate_livro_description_update_is_not_more_than_255_characters()
    {
        $user = $this->createUser();
        $livro = Livro::factory()->create(['name' => 'Testing 123']);

        // description 256 characters
        $requestBody = $this->getEditFields(['description' => str_repeat('Long description', 16)]);
        $this->patchJson(
            route('api.livros.update', $livro),
            $requestBody,
            ['Authorization' => 'Bearer '.$user->api_token]
        );

        $this->seeStatusCode(422);
        $this->seeJsonStructure(['errors' => ['description']]);
    }

    /** @test */
    public function user_can_delete_a_livro()
    {
        $user = $this->createUser();
        $livro = Livro::factory()->create();

        $this->deleteJson(route('api.livros.destroy', $livro), [
            'livro_id' => $livro->id,
        ], [
            'Authorization' => 'Bearer '.$user->api_token
        ]);

        $this->dontSeeInDatabase('livros', [
            'id' => $livro->id,
        ]);

        $this->seeStatusCode(200);
        $this->seeJson([
            'message' => __('livro.deleted'),
        ]);
    }
}
