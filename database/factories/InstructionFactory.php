<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Instruction>
 */
class InstructionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'scenario_id' => 1,
            'title' => $this->faker->unique()->name(),
            'content' => $this->faker->paragraph(),
            'audio_file' => 'audio.mp3',
        ];
    }
}
