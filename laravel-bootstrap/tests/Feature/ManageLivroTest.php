<?php

namespace Tests\Feature;

use App\Models\Livro;
use Tests\BrowserKitTest as TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManageLivroTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_see_livro_list_in_livro_index_page()
    {
        $livro = Livro::factory()->create();

        $this->loginAsUser();
        $this->visitRoute('livros.index');
        $this->see($livro->name);
    }

    private function getCreateFields(array $overrides = [])
    {
        return array_merge([
            'name'        => 'Livro 1 name',
            'description' => 'Livro 1 description',
        ], $overrides);
    }

    /** @test */
    public function user_can_create_a_livro()
    {
        $this->loginAsUser();
        $this->visitRoute('livros.index');

        $this->click(__('livro.create'));
        $this->seeRouteIs('livros.create');

        $this->submitForm(__('livro.create'), $this->getCreateFields());

        $this->seeRouteIs('livros.show', Livro::first());

        $this->seeInDatabase('livros', $this->getCreateFields());
    }

    /** @test */
    public function validate_livro_name_is_required()
    {
        $this->loginAsUser();

        // name empty
        $this->post(route('livros.store'), $this->getCreateFields(['name' => '']));
        $this->assertSessionHasErrors('name');
    }

    /** @test */
    public function validate_livro_name_is_not_more_than_60_characters()
    {
        $this->loginAsUser();

        // name 70 characters
        $this->post(route('livros.store'), $this->getCreateFields([
            'name' => str_repeat('Test Title', 7),
        ]));
        $this->assertSessionHasErrors('name');
    }

    /** @test */
    public function validate_livro_description_is_not_more_than_255_characters()
    {
        $this->loginAsUser();

        // description 256 characters
        $this->post(route('livros.store'), $this->getCreateFields([
            'description' => str_repeat('Long description', 16),
        ]));
        $this->assertSessionHasErrors('description');
    }

    private function getEditFields(array $overrides = [])
    {
        return array_merge([
            'name'        => 'Livro 1 name',
            'description' => 'Livro 1 description',
        ], $overrides);
    }

    /** @test */
    public function user_can_edit_a_livro()
    {
        $this->loginAsUser();
        $livro = Livro::factory()->create(['name' => 'Testing 123']);

        $this->visitRoute('livros.show', $livro);
        $this->click('edit-livro-'.$livro->id);
        $this->seeRouteIs('livros.edit', $livro);

        $this->submitForm(__('livro.update'), $this->getEditFields());

        $this->seeRouteIs('livros.show', $livro);

        $this->seeInDatabase('livros', $this->getEditFields([
            'id' => $livro->id,
        ]));
    }

    /** @test */
    public function validate_livro_name_update_is_required()
    {
        $this->loginAsUser();
        $livro = Livro::factory()->create(['name' => 'Testing 123']);

        // name empty
        $this->patch(route('livros.update', $livro), $this->getEditFields(['name' => '']));
        $this->assertSessionHasErrors('name');
    }

    /** @test */
    public function validate_livro_name_update_is_not_more_than_60_characters()
    {
        $this->loginAsUser();
        $livro = Livro::factory()->create(['name' => 'Testing 123']);

        // name 70 characters
        $this->patch(route('livros.update', $livro), $this->getEditFields([
            'name' => str_repeat('Test Title', 7),
        ]));
        $this->assertSessionHasErrors('name');
    }

    /** @test */
    public function validate_livro_description_update_is_not_more_than_255_characters()
    {
        $this->loginAsUser();
        $livro = Livro::factory()->create(['name' => 'Testing 123']);

        // description 256 characters
        $this->patch(route('livros.update', $livro), $this->getEditFields([
            'description' => str_repeat('Long description', 16),
        ]));
        $this->assertSessionHasErrors('description');
    }

    /** @test */
    public function user_can_delete_a_livro()
    {
        $this->loginAsUser();
        $livro = Livro::factory()->create();
        Livro::factory()->create();

        $this->visitRoute('livros.edit', $livro);
        $this->click('del-livro-'.$livro->id);
        $this->seeRouteIs('livros.edit', [$livro, 'action' => 'delete']);

        $this->press(__('app.delete_confirm_button'));

        $this->dontSeeInDatabase('livros', [
            'id' => $livro->id,
        ]);
    }
}
