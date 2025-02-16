<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DesaTrainer>
 */
class DesaTrainerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->firstName(),
            'model' => $this->faker->company(),
            'description' => $this->faker->paragraph(),
            'image' => $this->faker->image(),
            'settings' => '{}',
        ];
    }
}
