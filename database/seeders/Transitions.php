<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Transition;

class Transitions extends Seeder
{
    public function run(): void
    {
        Transition::create([
            'from_instruction_id' => 1,
            'to_instruction_id' => 2,
            'trigger' => 'time',
            'time_seconds' => 5,
            'desa_button_id' => null, // Puede ser null si no usas user_choice
            'loop_count' => null      // Puede ser null si no usas loop
        ]);
    }
}
