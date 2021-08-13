<?php

namespace Tests\Feature\Api;

use App\Models\Gender;
use Tests\BrowserKitTest as TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManageGenderTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_see_gender_list_in_gender_index_page()
    {
        $user = $this->createUser();
        $gender = Gender::factory()->create();

        $this->getJson(route('api.genders.index'), [
            'Authorization' => 'Bearer '.$user->api_token
        ]);

        $this->seeJson(['name' => $gender->name]);
    }

    /** @test */
    public function user_can_create_a_gender()
    {
        $user = $this->createUser();

        $this->postJson(route('api.genders.store'), [
            'name'        => 'Gender 1 name',
            'description' => 'Gender 1 description',
        ], [
            'Authorization' => 'Bearer '.$user->api_token
        ]);

        $this->seeInDatabase('genders', [
            'name'        => 'Gender 1 name',
            'description' => 'Gender 1 description',
        ]);

        $this->seeStatusCode(201);
        $this->seeJson([
            'message'     => __('gender.created'),
            'name'        => 'Gender 1 name',
            'description' => 'Gender 1 description',
        ]);
    }

    private function getCreateFields(array $overrides = [])
    {
        return array_merge([
            'name'        => 'Gender 1 name',
            'description' => 'Gender 1 description',
        ], $overrides);
    }

    /** @test */
    public function validate_gender_name_is_required()
    {
        $user = $this->createUser();

        // name empty
        $requestBody = $this->getCreateFields(['name' => '']);
        $this->postJson(
            route('api.genders.store'),
            $requestBody,
            ['Authorization' => 'Bearer '.$user->api_token]
        );

        $this->seeStatusCode(422);
        $this->seeJsonStructure(['errors' => ['name']]);
    }

    /** @test */
    public function validate_gender_name_is_not_more_than_60_characters()
    {
        $user = $this->createUser();

        // name 70 characters
        $requestBody = $this->getCreateFields(['name' => str_repeat('Test Title', 7)]);
        $this->postJson(
            route('api.genders.store'),
            $requestBody,
            ['Authorization' => 'Bearer '.$user->api_token]
        );

        $this->seeStatusCode(422);
        $this->seeJsonStructure(['errors' => ['name']]);
    }

    /** @test */
    public function validate_gender_description_is_not_more_than_255_characters()
    {
        $user = $this->createUser();

        // description 256 characters
        $requestBody = $this->getCreateFields(['description' => str_repeat('Long description', 16)]);
        $this->postJson(
            route('api.genders.store'),
            $requestBody,
            ['Authorization' => 'Bearer '.$user->api_token]
        );

        $this->seeStatusCode(422);
        $this->seeJsonStructure(['errors' => ['description']]);
    }

    /** @test */
    public function user_can_get_a_gender_detail()
    {
        $user = $this->createUser();
        $gender = Gender::factory()->create(['name' => 'Testing 123']);

        $this->getJson(route('api.genders.show', $gender), [
            'Authorization' => 'Bearer '.$user->api_token
        ]);

        $this->seeJson(['name' => 'Testing 123']);
    }

    /** @test */
    public function user_can_update_a_gender()
    {
        $user = $this->createUser();
        $gender = Gender::factory()->create(['name' => 'Testing 123']);

        $this->patchJson(route('api.genders.update', $gender), [
            'name'        => 'Gender 1 name',
            'description' => 'Gender 1 description',
        ], [
            'Authorization' => 'Bearer '.$user->api_token
        ]);

        $this->seeInDatabase('genders', [
            'name'        => 'Gender 1 name',
            'description' => 'Gender 1 description',
        ]);

        $this->seeStatusCode(200);
        $this->seeJson([
            'message'     => __('gender.updated'),
            'name'        => 'Gender 1 name',
            'description' => 'Gender 1 description',
        ]);
    }

    private function getEditFields(array $overrides = [])
    {
        return array_merge([
            'name'        => 'Gender 1 name',
            'description' => 'Gender 1 description',
        ], $overrides);
    }

    /** @test */
    public function validate_gender_name_update_is_required()
    {
        $user = $this->createUser();
        $gender = Gender::factory()->create();

        // name empty
        $requestBody = $this->getEditFields(['name' => '']);
        $this->patchJson(
            route('api.genders.update', $gender),
            $requestBody,
            ['Authorization' => 'Bearer '.$user->api_token]
        );

        $this->seeStatusCode(422);
        $this->seeJsonStructure(['errors' => ['name']]);
    }

    /** @test */
    public function validate_gender_name_update_is_not_more_than_60_characters()
    {
        $user = $this->createUser();
        $gender = Gender::factory()->create();

        // name 70 characters
        $requestBody = $this->getEditFields(['name' => str_repeat('Test Title', 7)]);
        $this->patchJson(
            route('api.genders.update', $gender),
            $requestBody,
            ['Authorization' => 'Bearer '.$user->api_token]
        );

        $this->seeStatusCode(422);
        $this->seeJsonStructure(['errors' => ['name']]);
    }

    /** @test */
    public function validate_gender_description_update_is_not_more_than_255_characters()
    {
        $user = $this->createUser();
        $gender = Gender::factory()->create(['name' => 'Testing 123']);

        // description 256 characters
        $requestBody = $this->getEditFields(['description' => str_repeat('Long description', 16)]);
        $this->patchJson(
            route('api.genders.update', $gender),
            $requestBody,
            ['Authorization' => 'Bearer '.$user->api_token]
        );

        $this->seeStatusCode(422);
        $this->seeJsonStructure(['errors' => ['description']]);
    }

    /** @test */
    public function user_can_delete_a_gender()
    {
        $user = $this->createUser();
        $gender = Gender::factory()->create();

        $this->deleteJson(route('api.genders.destroy', $gender), [
            'gender_id' => $gender->id,
        ], [
            'Authorization' => 'Bearer '.$user->api_token
        ]);

        $this->dontSeeInDatabase('genders', [
            'id' => $gender->id,
        ]);

        $this->seeStatusCode(200);
        $this->seeJson([
            'message' => __('gender.deleted'),
        ]);
    }
}
