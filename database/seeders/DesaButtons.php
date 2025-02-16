<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DesaButton;


class DesaButtons extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DesaButton::create([
            'desa_trainer_id' => 1,
            'label' => 'Test DesaButton',
            'area' => '25',
            'color' => 'red',
            'is_blinking' => false,
        ]);

        DesaButton::create([
            'desa_trainer_id' => 1,
            'label' => 'Test DesaButton 2',
            'area' => '25',
            'color' => 'red',
            'is_blinking' => false,
        ]);
    }
}
