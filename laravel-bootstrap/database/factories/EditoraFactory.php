<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Editora;
use Illuminate\Database\Eloquent\Factories\Factory;

class EditoraFactory extends Factory
{
    protected $model = Editora::class;

    public function definition()
    {
        return [
            'name'        => $this->faker->word,
            'description' => $this->faker->sentence,
            'creator_id'  => function () {
                return User::factory()->create()->id;
            },
        ];
    }
}
