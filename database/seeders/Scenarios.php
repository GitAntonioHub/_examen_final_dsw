<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Scenario;

class Scenarios extends Seeder
{
    public function run(): void
    {
        // Scenario::factory()->create([
        //     'desa_trainer_id' => 1,
        //     'title' => 'Test Escenario',
        //     'description' => 'Prueba Escenario',
        // ]);

        Scenario::factory(10)->create();
    }
}
