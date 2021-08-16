<?php

namespace Tests\Feature\Api;

use App\Models\Editora;
use Tests\BrowserKitTest as TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManageEditoraTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_see_editora_list_in_editora_index_page()
    {
        $user = $this->createUser();
        $editora = Editora::factory()->create();

        $this->getJson(route('api.editoras.index'), [
            'Authorization' => 'Bearer '.$user->api_token
        ]);

        $this->seeJson(['name' => $editora->name]);
    }

    /** @test */
    public function user_can_create_a_editora()
    {
        $user = $this->createUser();

        $this->postJson(route('api.editoras.store'), [
            'name'        => 'Editora 1 name',
            'description' => 'Editora 1 description',
        ], [
            'Authorization' => 'Bearer '.$user->api_token
        ]);

        $this->seeInDatabase('editoras', [
            'name'        => 'Editora 1 name',
            'description' => 'Editora 1 description',
        ]);

        $this->seeStatusCode(201);
        $this->seeJson([
            'message'     => __('editora.created'),
            'name'        => 'Editora 1 name',
            'description' => 'Editora 1 description',
        ]);
    }

    private function getCreateFields(array $overrides = [])
    {
        return array_merge([
            'name'        => 'Editora 1 name',
            'description' => 'Editora 1 description',
        ], $overrides);
    }

    /** @test */
    public function validate_editora_name_is_required()
    {
        $user = $this->createUser();

        // name empty
        $requestBody = $this->getCreateFields(['name' => '']);
        $this->postJson(
            route('api.editoras.store'),
            $requestBody,
            ['Authorization' => 'Bearer '.$user->api_token]
        );

        $this->seeStatusCode(422);
        $this->seeJsonStructure(['errors' => ['name']]);
    }

    /** @test */
    public function validate_editora_name_is_not_more_than_60_characters()
    {
        $user = $this->createUser();

        // name 70 characters
        $requestBody = $this->getCreateFields(['name' => str_repeat('Test Title', 7)]);
        $this->postJson(
            route('api.editoras.store'),
            $requestBody,
            ['Authorization' => 'Bearer '.$user->api_token]
        );

        $this->seeStatusCode(422);
        $this->seeJsonStructure(['errors' => ['name']]);
    }

    /** @test */
    public function validate_editora_description_is_not_more_than_255_characters()
    {
        $user = $this->createUser();

        // description 256 characters
        $requestBody = $this->getCreateFields(['description' => str_repeat('Long description', 16)]);
        $this->postJson(
            route('api.editoras.store'),
            $requestBody,
            ['Authorization' => 'Bearer '.$user->api_token]
        );

        $this->seeStatusCode(422);
        $this->seeJsonStructure(['errors' => ['description']]);
    }

    /** @test */
    public function user_can_get_a_editora_detail()
    {
        $user = $this->createUser();
        $editora = Editora::factory()->create(['name' => 'Testing 123']);

        $this->getJson(route('api.editoras.show', $editora), [
            'Authorization' => 'Bearer '.$user->api_token
        ]);

        $this->seeJson(['name' => 'Testing 123']);
    }

    /** @test */
    public function user_can_update_a_editora()
    {
        $user = $this->createUser();
        $editora = Editora::factory()->create(['name' => 'Testing 123']);

        $this->patchJson(route('api.editoras.update', $editora), [
            'name'        => 'Editora 1 name',
            'description' => 'Editora 1 description',
        ], [
            'Authorization' => 'Bearer '.$user->api_token
        ]);

        $this->seeInDatabase('editoras', [
            'name'        => 'Editora 1 name',
            'description' => 'Editora 1 description',
        ]);

        $this->seeStatusCode(200);
        $this->seeJson([
            'message'     => __('editora.updated'),
            'name'        => 'Editora 1 name',
            'description' => 'Editora 1 description',
        ]);
    }

    private function getEditFields(array $overrides = [])
    {
        return array_merge([
            'name'        => 'Editora 1 name',
            'description' => 'Editora 1 description',
        ], $overrides);
    }

    /** @test */
    public function validate_editora_name_update_is_required()
    {
        $user = $this->createUser();
        $editora = Editora::factory()->create();

        // name empty
        $requestBody = $this->getEditFields(['name' => '']);
        $this->patchJson(
            route('api.editoras.update', $editora),
            $requestBody,
            ['Authorization' => 'Bearer '.$user->api_token]
        );

        $this->seeStatusCode(422);
        $this->seeJsonStructure(['errors' => ['name']]);
    }

    /** @test */
    public function validate_editora_name_update_is_not_more_than_60_characters()
    {
        $user = $this->createUser();
        $editora = Editora::factory()->create();

        // name 70 characters
        $requestBody = $this->getEditFields(['name' => str_repeat('Test Title', 7)]);
        $this->patchJson(
            route('api.editoras.update', $editora),
            $requestBody,
            ['Authorization' => 'Bearer '.$user->api_token]
        );

        $this->seeStatusCode(422);
        $this->seeJsonStructure(['errors' => ['name']]);
    }

    /** @test */
    public function validate_editora_description_update_is_not_more_than_255_characters()
    {
        $user = $this->createUser();
        $editora = Editora::factory()->create(['name' => 'Testing 123']);

        // description 256 characters
        $requestBody = $this->getEditFields(['description' => str_repeat('Long description', 16)]);
        $this->patchJson(
            route('api.editoras.update', $editora),
            $requestBody,
            ['Authorization' => 'Bearer '.$user->api_token]
        );

        $this->seeStatusCode(422);
        $this->seeJsonStructure(['errors' => ['description']]);
    }

    /** @test */
    public function user_can_delete_a_editora()
    {
        $user = $this->createUser();
        $editora = Editora::factory()->create();

        $this->deleteJson(route('api.editoras.destroy', $editora), [
            'editora_id' => $editora->id,
        ], [
            'Authorization' => 'Bearer '.$user->api_token
        ]);

        $this->dontSeeInDatabase('editoras', [
            'id' => $editora->id,
        ]);

        $this->seeStatusCode(200);
        $this->seeJson([
            'message' => __('editora.deleted'),
        ]);
    }
}
