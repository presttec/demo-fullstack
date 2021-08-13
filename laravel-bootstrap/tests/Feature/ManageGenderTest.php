<?php

namespace Tests\Feature;

use App\Models\Gender;
use Tests\BrowserKitTest as TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManageGenderTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_see_gender_list_in_gender_index_page()
    {
        $gender = Gender::factory()->create();

        $this->loginAsUser();
        $this->visitRoute('genders.index');
        $this->see($gender->name);
    }

    private function getCreateFields(array $overrides = [])
    {
        return array_merge([
            'name'        => 'Gender 1 name',
            'description' => 'Gender 1 description',
        ], $overrides);
    }

    /** @test */
    public function user_can_create_a_gender()
    {
        $this->loginAsUser();
        $this->visitRoute('genders.index');

        $this->click(__('gender.create'));
        $this->seeRouteIs('genders.create');

        $this->submitForm(__('gender.create'), $this->getCreateFields());

        $this->seeRouteIs('genders.show', Gender::first());

        $this->seeInDatabase('genders', $this->getCreateFields());
    }

    /** @test */
    public function validate_gender_name_is_required()
    {
        $this->loginAsUser();

        // name empty
        $this->post(route('genders.store'), $this->getCreateFields(['name' => '']));
        $this->assertSessionHasErrors('name');
    }

    /** @test */
    public function validate_gender_name_is_not_more_than_60_characters()
    {
        $this->loginAsUser();

        // name 70 characters
        $this->post(route('genders.store'), $this->getCreateFields([
            'name' => str_repeat('Test Title', 7),
        ]));
        $this->assertSessionHasErrors('name');
    }

    /** @test */
    public function validate_gender_description_is_not_more_than_255_characters()
    {
        $this->loginAsUser();

        // description 256 characters
        $this->post(route('genders.store'), $this->getCreateFields([
            'description' => str_repeat('Long description', 16),
        ]));
        $this->assertSessionHasErrors('description');
    }

    private function getEditFields(array $overrides = [])
    {
        return array_merge([
            'name'        => 'Gender 1 name',
            'description' => 'Gender 1 description',
        ], $overrides);
    }

    /** @test */
    public function user_can_edit_a_gender()
    {
        $this->loginAsUser();
        $gender = Gender::factory()->create(['name' => 'Testing 123']);

        $this->visitRoute('genders.show', $gender);
        $this->click('edit-gender-'.$gender->id);
        $this->seeRouteIs('genders.edit', $gender);

        $this->submitForm(__('gender.update'), $this->getEditFields());

        $this->seeRouteIs('genders.show', $gender);

        $this->seeInDatabase('genders', $this->getEditFields([
            'id' => $gender->id,
        ]));
    }

    /** @test */
    public function validate_gender_name_update_is_required()
    {
        $this->loginAsUser();
        $gender = Gender::factory()->create(['name' => 'Testing 123']);

        // name empty
        $this->patch(route('genders.update', $gender), $this->getEditFields(['name' => '']));
        $this->assertSessionHasErrors('name');
    }

    /** @test */
    public function validate_gender_name_update_is_not_more_than_60_characters()
    {
        $this->loginAsUser();
        $gender = Gender::factory()->create(['name' => 'Testing 123']);

        // name 70 characters
        $this->patch(route('genders.update', $gender), $this->getEditFields([
            'name' => str_repeat('Test Title', 7),
        ]));
        $this->assertSessionHasErrors('name');
    }

    /** @test */
    public function validate_gender_description_update_is_not_more_than_255_characters()
    {
        $this->loginAsUser();
        $gender = Gender::factory()->create(['name' => 'Testing 123']);

        // description 256 characters
        $this->patch(route('genders.update', $gender), $this->getEditFields([
            'description' => str_repeat('Long description', 16),
        ]));
        $this->assertSessionHasErrors('description');
    }

    /** @test */
    public function user_can_delete_a_gender()
    {
        $this->loginAsUser();
        $gender = Gender::factory()->create();
        Gender::factory()->create();

        $this->visitRoute('genders.edit', $gender);
        $this->click('del-gender-'.$gender->id);
        $this->seeRouteIs('genders.edit', [$gender, 'action' => 'delete']);

        $this->press(__('app.delete_confirm_button'));

        $this->dontSeeInDatabase('genders', [
            'id' => $gender->id,
        ]);
    }
}
