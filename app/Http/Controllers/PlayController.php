<?php
namespace App\Http\Controllers;

use App\Models\Scenario;
use App\Models\DesaTrainer;
use Illuminate\Http\Request;

class PlayController extends Controller
{
    public function show($scenario_id, $desa_trainer_id)
    {
        $scenario = Scenario::findOrFail($scenario_id);
        $desaTrainer = DesaTrainer::findOrFail($desa_trainer_id);

        return view('livewire.play', compact('scenario', 'desaTrainer'));
    }
}
