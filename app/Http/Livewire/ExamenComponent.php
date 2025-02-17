<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Scenario;

class ExamenComponent extends Component
{
    public $scenario_id;
    public $scenario;

    public function mount($scenario_id)
    {
        $this->scenario_id = $scenario_id;
        $this->loadScenario();
    }

    public function loadScenario()
    {
        $this->scenario = Scenario::findOrFail($this->scenario_id);
    }

    public function previousScenario()
    {
        $this->scenario_id = Scenario::where('id', '<', $this->scenario_id)->max('id');
        $this->loadScenario();
    }

    public function nextScenario()
    {
        $this->scenario_id = Scenario::where('id', '>', $this->scenario_id)->min('id');
        $this->loadScenario();
    }

    public function render()
    {
        return view('livewire.examencomponent');
    }
}
