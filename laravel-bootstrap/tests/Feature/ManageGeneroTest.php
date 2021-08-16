<?php

namespace Tests\Feature;

use App\Models\Genero;
use Tests\BrowserKitTest as TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManageGeneroTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_see_genero_list_in_genero_index_page()
    {
        $genero = Genero::factory()->create();

        $this->loginAsUser();
        $this->visitRoute('generos.index');
        $this->see($genero->name);
    }

    private function getCreateFields(array $overrides = [])
    {
        return array_merge([
            'name'        => 'Genero 1 name',
            'description' => 'Genero 1 description',
        ], $overrides);
    }

    /** @test */
    public function user_can_create_a_genero()
    {
        $this->loginAsUser();
        $this->visitRoute('generos.index');

        $this->click(__('genero.create'));
        $this->seeRouteIs('generos.create');

        $this->submitForm(__('genero.create'), $this->getCreateFields());

        $this->seeRouteIs('generos.show', Genero::first());

        $this->seeInDatabase('generos', $this->getCreateFields());
    }

    /** @test */
    public function validate_genero_name_is_required()
    {
        $this->loginAsUser();

        // name empty
        $this->post(route('generos.store'), $this->getCreateFields(['name' => '']));
        $this->assertSessionHasErrors('name');
    }

    /** @test */
    public function validate_genero_name_is_not_more_than_60_characters()
    {
        $this->loginAsUser();

        // name 70 characters
        $this->post(route('generos.store'), $this->getCreateFields([
            'name' => str_repeat('Test Title', 7),
        ]));
        $this->assertSessionHasErrors('name');
    }

    /** @test */
    public function validate_genero_description_is_not_more_than_255_characters()
    {
        $this->loginAsUser();

        // description 256 characters
        $this->post(route('generos.store'), $this->getCreateFields([
            'description' => str_repeat('Long description', 16),
        ]));
        $this->assertSessionHasErrors('description');
    }

    private function getEditFields(array $overrides = [])
    {
        return array_merge([
            'name'        => 'Genero 1 name',
            'description' => 'Genero 1 description',
        ], $overrides);
    }

    /** @test */
    public function user_can_edit_a_genero()
    {
        $this->loginAsUser();
        $genero = Genero::factory()->create(['name' => 'Testing 123']);

        $this->visitRoute('generos.show', $genero);
        $this->click('edit-genero-'.$genero->id);
        $this->seeRouteIs('generos.edit', $genero);

        $this->submitForm(__('genero.update'), $this->getEditFields());

        $this->seeRouteIs('generos.show', $genero);

        $this->seeInDatabase('generos', $this->getEditFields([
            'id' => $genero->id,
        ]));
    }

    /** @test */
    public function validate_genero_name_update_is_required()
    {
        $this->loginAsUser();
        $genero = Genero::factory()->create(['name' => 'Testing 123']);

        // name empty
        $this->patch(route('generos.update', $genero), $this->getEditFields(['name' => '']));
        $this->assertSessionHasErrors('name');
    }

    /** @test */
    public function validate_genero_name_update_is_not_more_than_60_characters()
    {
        $this->loginAsUser();
        $genero = Genero::factory()->create(['name' => 'Testing 123']);

        // name 70 characters
        $this->patch(route('generos.update', $genero), $this->getEditFields([
            'name' => str_repeat('Test Title', 7),
        ]));
        $this->assertSessionHasErrors('name');
    }

    /** @test */
    public function validate_genero_description_update_is_not_more_than_255_characters()
    {
        $this->loginAsUser();
        $genero = Genero::factory()->create(['name' => 'Testing 123']);

        // description 256 characters
        $this->patch(route('generos.update', $genero), $this->getEditFields([
            'description' => str_repeat('Long description', 16),
        ]));
        $this->assertSessionHasErrors('description');
    }

    /** @test */
    public function user_can_delete_a_genero()
    {
        $this->loginAsUser();
        $genero = Genero::factory()->create();
        Genero::factory()->create();

        $this->visitRoute('generos.edit', $genero);
        $this->click('del-genero-'.$genero->id);
        $this->seeRouteIs('generos.edit', [$genero, 'action' => 'delete']);

        $this->press(__('app.delete_confirm_button'));

        $this->dontSeeInDatabase('generos', [
            'id' => $genero->id,
        ]);
    }
}
