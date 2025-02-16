<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Instruction;

class Instructions extends Seeder
{
    public function run(): void
    {
        Instruction::factory()->create([
            'scenario_id' => 1,
            'title' => 'Test Instruction',
            'content' => 'Prueba Instruction',
            'audio_file' => 'audio.mp3',
        ]);
        
        Instruction::factory(10)->create();
    }
}
