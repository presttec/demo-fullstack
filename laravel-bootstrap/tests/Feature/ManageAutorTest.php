<?php

namespace Tests\Feature;

use App\Models\Autor;
use Tests\BrowserKitTest as TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManageAutorTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_see_autor_list_in_autor_index_page()
    {
        $autor = Autor::factory()->create();

        $this->loginAsUser();
        $this->visitRoute('autors.index');
        $this->see($autor->name);
    }

    private function getCreateFields(array $overrides = [])
    {
        return array_merge([
            'name'        => 'Autor 1 name',
            'description' => 'Autor 1 description',
        ], $overrides);
    }

    /** @test */
    public function user_can_create_a_autor()
    {
        $this->loginAsUser();
        $this->visitRoute('autors.index');

        $this->click(__('autor.create'));
        $this->seeRouteIs('autors.create');

        $this->submitForm(__('autor.create'), $this->getCreateFields());

        $this->seeRouteIs('autors.show', Autor::first());

        $this->seeInDatabase('autors', $this->getCreateFields());
    }

    /** @test */
    public function validate_autor_name_is_required()
    {
        $this->loginAsUser();

        // name empty
        $this->post(route('autors.store'), $this->getCreateFields(['name' => '']));
        $this->assertSessionHasErrors('name');
    }

    /** @test */
    public function validate_autor_name_is_not_more_than_60_characters()
    {
        $this->loginAsUser();

        // name 70 characters
        $this->post(route('autors.store'), $this->getCreateFields([
            'name' => str_repeat('Test Title', 7),
        ]));
        $this->assertSessionHasErrors('name');
    }

    /** @test */
    public function validate_autor_description_is_not_more_than_255_characters()
    {
        $this->loginAsUser();

        // description 256 characters
        $this->post(route('autors.store'), $this->getCreateFields([
            'description' => str_repeat('Long description', 16),
        ]));
        $this->assertSessionHasErrors('description');
    }

    private function getEditFields(array $overrides = [])
    {
        return array_merge([
            'name'        => 'Autor 1 name',
            'description' => 'Autor 1 description',
        ], $overrides);
    }

    /** @test */
    public function user_can_edit_a_autor()
    {
        $this->loginAsUser();
        $autor = Autor::factory()->create(['name' => 'Testing 123']);

        $this->visitRoute('autors.show', $autor);
        $this->click('edit-autor-'.$autor->id);
        $this->seeRouteIs('autors.edit', $autor);

        $this->submitForm(__('autor.update'), $this->getEditFields());

        $this->seeRouteIs('autors.show', $autor);

        $this->seeInDatabase('autors', $this->getEditFields([
            'id' => $autor->id,
        ]));
    }

    /** @test */
    public function validate_autor_name_update_is_required()
    {
        $this->loginAsUser();
        $autor = Autor::factory()->create(['name' => 'Testing 123']);

        // name empty
        $this->patch(route('autors.update', $autor), $this->getEditFields(['name' => '']));
        $this->assertSessionHasErrors('name');
    }

    /** @test */
    public function validate_autor_name_update_is_not_more_than_60_characters()
    {
        $this->loginAsUser();
        $autor = Autor::factory()->create(['name' => 'Testing 123']);

        // name 70 characters
        $this->patch(route('autors.update', $autor), $this->getEditFields([
            'name' => str_repeat('Test Title', 7),
        ]));
        $this->assertSessionHasErrors('name');
    }

    /** @test */
    public function validate_autor_description_update_is_not_more_than_255_characters()
    {
        $this->loginAsUser();
        $autor = Autor::factory()->create(['name' => 'Testing 123']);

        // description 256 characters
        $this->patch(route('autors.update', $autor), $this->getEditFields([
            'description' => str_repeat('Long description', 16),
        ]));
        $this->assertSessionHasErrors('description');
    }

    /** @test */
    public function user_can_delete_a_autor()
    {
        $this->loginAsUser();
        $autor = Autor::factory()->create();
        Autor::factory()->create();

        $this->visitRoute('autors.edit', $autor);
        $this->click('del-autor-'.$autor->id);
        $this->seeRouteIs('autors.edit', [$autor, 'action' => 'delete']);

        $this->press(__('app.delete_confirm_button'));

        $this->dontSeeInDatabase('autors', [
            'id' => $autor->id,
        ]);
    }
}
