<?php

namespace Database\Factories;

use App\Models\Recipe;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class RecipeFactory extends Factory
{
    protected $model = Recipe::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),

            'title' => $this->faker->sentence(),

            'description' => $this->faker->paragraph(),

            'ingredients' => json_encode([
                'Bahan 1',
                'Bahan 2'
            ]),

            'steps' => json_encode([
                'Langkah 1',
                'Langkah 2'
            ]),
        ];
    }
}