<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DesaTrainer;

class DesaTrainers extends Seeder
{
    public function run(): void
    {
        DesaTrainer::factory()->create([
            'name' => 'Test DesaTrainer',
            'model' => 'v1.0',
            'description' => 'Prueba DesaTrainer',
            'image' => 'image.png',
            'settings' => '{}',
        ]);

        DesaTrainer::factory(10)->create();
    }
}
