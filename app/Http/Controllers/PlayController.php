<?php
namespace App\Http\Controllers;

use App\Models\Scenario;
use App\Models\DesaTrainer;
use Illuminate\Http\Request;

class PlayController extends Controller
{
    public function show($scenario_id, $desa_trainer_id)
    {
        $scenario = Scenario::where('id', $scenario_id)->where('is_active', true)->firstOrFail();
        $desaTrainer = DesaTrainer::findOrFail($desa_trainer_id);
        $scenarios = Scenario::where('is_simulable', true)->get();

        return view('livewire.play', compact('scenario', 'desaTrainer'));
    }
}
