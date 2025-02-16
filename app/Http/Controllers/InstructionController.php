<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Instruction;


class InstructionController extends Controller
{
    public function createInstruction($escenario_id)
    {
        return view('admin/scenarios/instructions/instruction-create', compact('escenario_id'));
    }

    public function saveInstruction(Request $request,$escenario_id)
    {
        $validatedData = $request->validate([
            'title' => 'required|string',
            'content' => 'required|string',
            'audio_file' => 'nullable|mimes:mp3,wav|max:5120', // Múltiples formatos de audio
        ],
        [
            'audio_file.mimes' => 'Archivo con formato inválido',
            'audio_file.max' => 'El archivo no debe superar el máximo de 5MB',
        ]);

        $instruction = new Instruction();
        $instruction->title = $validatedData['title'];
        $instruction->content = $validatedData['content'];
        $instruction->scenario_id = $escenario_id;

        if ($request->hasFile('audio_file'))
        {
            $path = $request->file('audio_file')->store('audio_files', 'public');
            $instruction->audio_file = $path;
        }

        $instruction->save();

        return redirect()->route('scenario.edit', $escenario_id)->with('success', 'Instrucción creada correctamente.');
    }

    public function destroyInstruction($scenario_id, $instruction_id)
    {
        $instruction = Instruction::findOrFail($instruction_id);
        $instruction->delete();
        return redirect()->route('scenario.edit', $scenario_id)->with('success', 'Instrucción eliminada correctamente.');
    }

    public function editInstruction($escenario_id,$instruction_id)
    {
        $instruction = Instruction::findOrFail($instruction_id);
        return view('admin/scenarios/instructions/instruction-edit', compact('instruction','escenario_id'));
    }

    // NO eliminar la variable $escenario_id
    public function updateInstruction(Request $request, $escenario_id,$instruction_id)
    {
        $instruction = Instruction::findOrFail($instruction_id);

        $validated = $request->validate([
            'title' => 'required',
            'content' => 'required|string',
            'audio_file' => 'nullable|mimes:mp3,wav|max:5120', // Múltiples formatos de audio
        ],
        [
            'audio_file.mimes' => 'Archivo con formato inválido',
            'audio_file.max' => 'El archivo no debe superar el máximo de 5MB',
        ]);

        if ($request->hasFile('audio_file'))
        {
            $path = $request->file('audio_file')->store('audio_files', 'public');
            $instruction->audio_file = $path;
        }

        $instruction->update($validated);

        // Prueba
        // Devolver JSON con la instrucción actualizada
        return response()->json([
            'success' => true,
            'message' => 'Instrucción actualizada correctamente.',
            'data' => $instruction,
        ], 200);
    }
}
