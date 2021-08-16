<?php

namespace Tests\Feature;

use App\Models\Editora;
use Tests\BrowserKitTest as TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManageEditoraTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_see_editora_list_in_editora_index_page()
    {
        $editora = Editora::factory()->create();

        $this->loginAsUser();
        $this->visitRoute('editoras.index');
        $this->see($editora->name);
    }

    private function getCreateFields(array $overrides = [])
    {
        return array_merge([
            'name'        => 'Editora 1 name',
            'description' => 'Editora 1 description',
        ], $overrides);
    }

    /** @test */
    public function user_can_create_a_editora()
    {
        $this->loginAsUser();
        $this->visitRoute('editoras.index');

        $this->click(__('editora.create'));
        $this->seeRouteIs('editoras.create');

        $this->submitForm(__('editora.create'), $this->getCreateFields());

        $this->seeRouteIs('editoras.show', Editora::first());

        $this->seeInDatabase('editoras', $this->getCreateFields());
    }

    /** @test */
    public function validate_editora_name_is_required()
    {
        $this->loginAsUser();

        // name empty
        $this->post(route('editoras.store'), $this->getCreateFields(['name' => '']));
        $this->assertSessionHasErrors('name');
    }

    /** @test */
    public function validate_editora_name_is_not_more_than_60_characters()
    {
        $this->loginAsUser();

        // name 70 characters
        $this->post(route('editoras.store'), $this->getCreateFields([
            'name' => str_repeat('Test Title', 7),
        ]));
        $this->assertSessionHasErrors('name');
    }

    /** @test */
    public function validate_editora_description_is_not_more_than_255_characters()
    {
        $this->loginAsUser();

        // description 256 characters
        $this->post(route('editoras.store'), $this->getCreateFields([
            'description' => str_repeat('Long description', 16),
        ]));
        $this->assertSessionHasErrors('description');
    }

    private function getEditFields(array $overrides = [])
    {
        return array_merge([
            'name'        => 'Editora 1 name',
            'description' => 'Editora 1 description',
        ], $overrides);
    }

    /** @test */
    public function user_can_edit_a_editora()
    {
        $this->loginAsUser();
        $editora = Editora::factory()->create(['name' => 'Testing 123']);

        $this->visitRoute('editoras.show', $editora);
        $this->click('edit-editora-'.$editora->id);
        $this->seeRouteIs('editoras.edit', $editora);

        $this->submitForm(__('editora.update'), $this->getEditFields());

        $this->seeRouteIs('editoras.show', $editora);

        $this->seeInDatabase('editoras', $this->getEditFields([
            'id' => $editora->id,
        ]));
    }

    /** @test */
    public function validate_editora_name_update_is_required()
    {
        $this->loginAsUser();
        $editora = Editora::factory()->create(['name' => 'Testing 123']);

        // name empty
        $this->patch(route('editoras.update', $editora), $this->getEditFields(['name' => '']));
        $this->assertSessionHasErrors('name');
    }

    /** @test */
    public function validate_editora_name_update_is_not_more_than_60_characters()
    {
        $this->loginAsUser();
        $editora = Editora::factory()->create(['name' => 'Testing 123']);

        // name 70 characters
        $this->patch(route('editoras.update', $editora), $this->getEditFields([
            'name' => str_repeat('Test Title', 7),
        ]));
        $this->assertSessionHasErrors('name');
    }

    /** @test */
    public function validate_editora_description_update_is_not_more_than_255_characters()
    {
        $this->loginAsUser();
        $editora = Editora::factory()->create(['name' => 'Testing 123']);

        // description 256 characters
        $this->patch(route('editoras.update', $editora), $this->getEditFields([
            'description' => str_repeat('Long description', 16),
        ]));
        $this->assertSessionHasErrors('description');
    }

    /** @test */
    public function user_can_delete_a_editora()
    {
        $this->loginAsUser();
        $editora = Editora::factory()->create();
        Editora::factory()->create();

        $this->visitRoute('editoras.edit', $editora);
        $this->click('del-editora-'.$editora->id);
        $this->seeRouteIs('editoras.edit', [$editora, 'action' => 'delete']);

        $this->press(__('app.delete_confirm_button'));

        $this->dontSeeInDatabase('editoras', [
            'id' => $editora->id,
        ]);
    }
}
