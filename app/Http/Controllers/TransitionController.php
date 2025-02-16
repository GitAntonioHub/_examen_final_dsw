<?php

namespace App\Http\Controllers;

use App\Models\DesaButton;
use Illuminate\Http\Request;
use App\Models\Transition;
use App\Models\Instruction;


class TransitionController extends Controller
{
    public function createTransition($escenario_id)
    {
        $instructions = Instruction::where('scenario_id', $escenario_id)->get(); // Filtra instrucciones por scenario_id
        $desaButtons = DesaButton::all();

        return view('admin/scenarios/transitions/transition-create', compact('instructions','desaButtons','escenario_id'));
    }

    // Validación de la cantidad máxima de caracteres en el campo de texto seconds y loops
    public function saveTransition(Request $request,$escenario_id)
    {
        $validatedData = $request->validate([
            'from_instruction_id' => 'required|integer',
            'to_instruction_id' => 'required|integer|different:from_instruction_id',
            'trigger' => 'required|in:time,desaButton,loop',
            'time_seconds' => 'nullable|integer', // opcional (si el trigger es time)
            'desa_button_id' => 'nullable|integer', // opcional (si el trigger es desaButton)
            'loop_count' => 'nullable|integer', // opcional (si el trigger es loop)
        ], [
            // Mensajes de error personalizados (opcional):
            'from_instruction_id.required' => 'Debes seleccionar una instrucción previa.',
            'to_instruction_id.required' => 'Debes seleccionar una instrucción posterior.',
            'to_instruction_id.different'  => 'Las instrucciones no pueden coincidir.',
            'trigger.required' => 'El desencadenante es obligatorio.',
            'trigger.in' => 'El desencadenante debe ser uno de: time, desaButton o loop.',
        ]);

        $transition = new Transition();
        $transition->from_instruction_id = $validatedData['from_instruction_id'];
        $transition->to_instruction_id = $validatedData['to_instruction_id'];
        
        $transition->trigger = $validatedData['trigger'];

        // En función del trigger, limpiar campos:
        if ($validatedData['trigger'] === 'time')
        {
            $transition->time_seconds = $validatedData['time_seconds'];
            $transition->desa_button_id = null;
            $transition->loop_count = null;
        }
        elseif ($validatedData['trigger'] === 'desaButton')
        {
            $transition->time_seconds = null;
            $transition->desa_button_id = $validatedData['desa_button_id'];
            $transition->loop_count = null;
        }
        elseif ($validatedData['trigger'] === 'loop')
        {
            $transition->time_seconds = null;
            $transition->desa_button_id = null;
            $transition->loop_count = $validatedData['loop_count'];
        }
        
        $transition->save();

        return redirect()->route('scenario.edit', $escenario_id)->with('success', 'Transición creada correctamente.');
    }

    public function destroyTransition($scenario_id, $transition_id)
    {
        $transition = Transition::findOrFail($transition_id);
        $transition->delete();
        return redirect()->route('scenario.edit', $scenario_id)->with('success', 'Transición eliminada correctamente.');
    }

    public function editTransition($escenario_id,$transition_id)
    {
        $instructions = Instruction::where('scenario_id', $escenario_id)->get(); // Filtra instrucciones por scenario_id

        $transition = Transition::findOrFail($transition_id);

        $from_instruction = Instruction::findOrFail($transition->from_instruction_id);
        $to_instruction = Instruction::findOrFail($transition->to_instruction_id);
        $desaButtons = DesaButton::all();

        return view('admin/scenarios/transitions/transition-edit', compact('transition','instructions','from_instruction','to_instruction','escenario_id','desaButtons'));
    }

    // NO eliminar la variable $escenario_id
    public function updateTransition(Request $request, $escenario_id,$transition_id)
    {
        $transition = Transition::findOrFail($transition_id);

        $validatedData = $request->validate([
            'from_instruction_id' => 'required|integer',
            'to_instruction_id' => 'required|integer|different:from_instruction_id',
            'trigger' => 'required|in:time,desaButton,loop',
            'time_seconds' => 'nullable|integer', // opcional (si el trigger es time)
            'desa_button_id' => 'nullable|integer', // opcional (si el trigger es desaButton)
            'loop_count' => 'nullable|integer', // opcional (si el trigger es loop)
        ], [
            // Mensajes de error personalizados (opcional):
            'from_instruction_id.required' => '<br>Debes seleccionar una instrucción previa.',
            'to_instruction_id.required' => 'Debes seleccionar una instrucción posterior.',
            'to_instruction_id.different'  => 'Las instrucciones no pueden coincidir.',
            'trigger.required' => 'El desencadenante es obligatorio.',
            'trigger.in' => 'El desencadenante debe ser uno de: time, desaButton o loop.',
        ]);

        $transition->from_instruction_id = $validatedData['from_instruction_id'];
        $transition->to_instruction_id = $validatedData['to_instruction_id'];
        $transition->trigger = $validatedData['trigger'];

        // En función del trigger, limpiar campos:
        if ($validatedData['trigger'] === 'time')
        {
            $transition->time_seconds = $validatedData['time_seconds'];
            $transition->desa_button_id = null;
            $transition->loop_count = null;
        }
        elseif ($validatedData['trigger'] === 'desaButton')
        {
            $transition->time_seconds = null;
            $transition->desa_button_id = $validatedData['desa_button_id'];
            $transition->loop_count = null;
        }
        elseif ($validatedData['trigger'] === 'loop')
        {
            $transition->time_seconds = null;
            $transition->desa_button_id = null;
            $transition->loop_count = $validatedData['loop_count'];
        }

        $transition->save();

        // Devolver JSON con la instrucción actualizada
        return response()->json([
            'success' => true,
            'message' => 'Transición actualizada correctamente.',
            'data' => $transition,
        ], 200);
    }
}
