<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DesaTrainer;
use App\Models\DesaButton;
use App\Models\Scenario;
use App\Models\Instruction;
use App\Models\Transition;

class ScenarioController extends Controller
{
    // Mostrar los escenarios
    public function index()
    {
        $escenarios = Scenario::all();
        $desa_trainers_escenarios = DesaTrainer::all();
        $instructions = Instruction::all();

        return view('admin.scenarios.scenarios', compact('escenarios', 'desa_trainers_escenarios', 'instructions'));
    }

    // Mostrar vista para crear un escenario
    public function create()
    {
        $desa_trainers = DesaTrainer::all();

        return view('admin.scenarios.create-scenarios', compact('desa_trainers'));
    }

    // Guardar un nuevo escenario
    public function store(Request $request)
    {
        try {
            $nuevo_escenario = $request -> validate([
                'title' => 'required|max:255',
                'descripcion-escenario' => 'string|nullable|max:2000',
                'desa-trainers-escenario' => 'required|exists:desa_trainers,id',
            ], [
                'title.required' => 'Campo título obligatorio',
                'title.max' => 'No más de 255 caracteres',
                'descripcion-escenario' => 'No más de 2000 caracteres',
                'desa-trainers-escenario.required' => 'DESA Trainer obligatorio',
                'desa-trainers-escenario.exists' => 'DESA Trainer no válido'
            ]);
    
            Scenario::create([
                'desa_trainer_id' => $nuevo_escenario['desa-trainers-escenario'],
                'title' => $nuevo_escenario['title'],
                'description' => $nuevo_escenario['descripcion-escenario']
            ]);
    
            // Devolver JSON
            return response() -> json([
                'success' => true,
                'message' => 'Escenario creado exitosamente',
                'data' => $nuevo_escenario,
            ], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Capturar errores de validación
            return response()->json([
                'success' => false,
                'message' => 'Errores de validación',
                'errors' => $e->errors(),
            ], 422); // Código 422 para errores de validación
        }
    }

    // Borrar un escenario
    public function destroy($id)
    {
        try
        {
            $escenario_borrar = Scenario::findOrFail($id);
            $escenario_borrar -> delete();
    
            return response() -> json([
                'success' => true,
                'message' => 'Escenario eliminado correctamente.'
            ]);
        } catch (\Exception $e)
        {
            // Manejo de errores
            return response() -> json([
                'success' => false,
                'message' => 'Error al eliminar el escenario.',
                'error' => $e -> getMessage()
            ], 500);
        }
    }

    // Actualiza los valores de un escenario
    public function update(Request $request, $id)
    {
        try
        {
            $escenario_modificar = Scenario::findOrFail($id);
            
            $nuevos_datos_escenario = $request -> validate([
                'title' => 'required|max:255',
                'descripcion-escenario' => 'string|nullable|max:2000',
                'desa-trainers-escenario' => 'required|exists:desa_trainers,id',
            ], [
                'title.required' => 'Campo requerido',
                'title.max' => 'No más de 255 caracteres',
                'descripcion-escenario' => 'No más de 2000 caracteres',
                'desa-trainers-escenario.required' => 'Campo requerido',
                'desa-trainers-escenario.exists' => 'DESA TRAINER no válido',
            ]);

            // Guardar datos modificados
            $escenario_modificar->update([
                'desa_trainer_id' => $nuevos_datos_escenario['desa-trainers-escenario'],
                'title' => $nuevos_datos_escenario['title'],
                'description' => $nuevos_datos_escenario['descripcion-escenario'],
            ]);

            return response() -> json([
                'escenario_modificar' => $escenario_modificar,
                'success' => true,
                'message' => 'Escenario modificado correctamente.',
            ]);
        }
        catch(\Exception $e)
        {
            return response() -> json([
                'success' => false,
                'message' => 'Error al modificar el escenario',
                'error' => $e -> getMessage()
            ], 500);
        }
    }

    // Editar un escenario Deja el fondo de los iconos de la columna transparente.
    public function editScenario($id)
    {
        $escenario = Scenario::findOrFail($id);
        $desa_trainers = DesaTrainer::all();
        $desa_buttons = DesaButton::all();

        $instructions = Instruction::where('scenario_id', $id)->get(); // Filtra instrucciones por scenario_id      
        $transitions = Transition::whereIn('from_instruction_id', $instructions->pluck('id'))->orWhereIn('to_instruction_id', $instructions->pluck('id'))->get();

        return view('admin.scenarios.edit-scenario', compact('escenario', 'desa_trainers', 'instructions', 'transitions', 'desa_buttons'));
    }

    // Informacion escenario dado
    public function infoScenario($id)
    {
        $escenario = Scenario::findOrFail($id);
        $desa_trainers = DesaTrainer::all();
        $instructions = Instruction::where('scenario_id', $id)->get(); // Filtrar instrucciones por scenario_id
        $transitions = Transition::whereIn('from_instruction_id', $instructions->pluck('id'))->orWhereIn('to_instruction_id', $instructions->pluck('id'))->get();

        return view('admin.scenarios.info-scenarios', compact('escenario', 'desa_trainers','instructions','transitions'));
    }


    // IMPLEMENTACIÓN DE LA SIMULACIÓN DE ESCENARIOS

    public function playlist()
    {
        $scenarios = Scenario::all();

        return view('playList', compact('scenarios'));
    }

    public function play($scenario_id, $desa_trainer_id)
    {
        $scenario = Scenario::findOrFail($scenario_id);
        $desaTrainers = DesaTrainer::findOrFail($desa_trainer_id);
        $instructions = Instruction::where('scenario_id', $scenario_id)->get(); // Filtra instrucciones por scenario_id
        $transitions = Transition::whereIn('from_instruction_id', $instructions->pluck('id'))->orWhereIn('to_instruction_id', $instructions->pluck('id'))->get();
        
        return view('livewire.scenario-simulation', compact('scenario', 'instructions','transitions', 'desaTrainers'));
    }
}
