<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\DesaTrainer;
use App\Models\Scenario;

class DESATrainerController extends Controller
{
    /**
     * Muestra la lista de DESA Trainers.
     */
    public function index()
    {
        $trainers = DesaTrainer::all();
        return view('admin.desas.desa-trainers', compact('trainers'));
    }

    /**
     * Muestra el formulario para crear un nuevo DESA Trainer.
     */
    public function create()
    {
        return view('admin.desas.desa-trainersCreate');
    }

    /**
     * Almacena un nuevo DESA Trainer en la base de datos.
     */
    public function store(Request $request)
    {
        // Validación con los campos solicitados
        $request->validate([
            'name' => 'required|string|max:255',
            'model' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:255',
            'image' => 'nullable|mimes:jpeg,png,jpg,gif|image|max:2048',
            'settings' => 'nullable|json',
        ], [
            'name.required' => 'El campo nombre es requerido.',
            'name.string' => 'El nombre ha de ser de tipo String.',
            'name.max' => 'El nombre no puede ser más largo de 255 caracteres.',
            'model.string' => 'El modelo ha de ser de tipo String.',
            'model.max' => 'El modelo no puede ser más largo de 255 caracteres.',
            'description.string' => 'La descripción ha de ser de tipo Stirng.',
            'description.max' => 'La descripción no puede ser más larga de 255 caracteres.',
            'image.image' => 'La imagen no es una imagen',
            'image.mimes' => 'La imagen ha de tener un formato jpg,jpeg,png o gif',
            'image.max' => 'La imagen no puede tener más de 2048 caracteres.',
            'settings.json' => 'Los ajustes tienen que estar en formato JSON válido.',
        ]);

        $path = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('desa-trainers', 'public');
        }
    
        DesaTrainer::create([
            'name' => $request->input('name'),
            'model' => $request->input('model'),
            'description' => $request->input('description'),
            'image' => $path, // Guarda el path
        ]);

        //return redirect()->route('desa-trainers')->with('success', 'DESA Trainer creado correctamente.');
        return redirect()->route('desa-trainers.index')
            ->with('success', 'DESA Trainer creado correctamente.');
    }


    /**
     * Muestra el formulario para editar un DESA Trainer.
     */
    public function edit(DesaTrainer $desaTrainer)
    {
        return view('admin.desas.desa-trainersEdit', compact('desaTrainer'));
    }

    /**
     * Actualiza los datos de un DESA Trainer en la base de datos.
     */
    public function update(Request $request, DesaTrainer $desaTrainer)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'model' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:255',
            'image' => 'nullable|mimes:jpeg,png,jpg,gif|image|max:2048',
            'settings' => 'nullable|json',
        ], [
            'name.required' => 'El campo nombre es requerido.',
            'name.string' => 'El nombre ha de ser de tipo String.',
            'name.max' => 'El nombre no puede ser más largo de 255 caracteres.',
            'model.string' => 'El modelo ha de ser de tipo String.',
            'model.max' => 'El modelo no puede ser más largo de 255 caracteres.',
            'description.string' => 'La descripción ha de ser de tipo Stirng.',
            'description.max' => 'La descripción no puede ser más larga de 255 caracteres.',
            'image.image' => 'La imagen no es una imagen',
            'image.mimes' => 'La imagen ha de tener un formato jpg,jpeg,png o gif',
            'image.max' => 'La imagen no puede tener más de 2048 caracteres.',
            'settings.json' => 'Los ajustes tienen que estar en formato JSON válido.',
        ]);

        $desaTrainer->name = $request->input('name');
        $desaTrainer->model = $request->input('model');
        $desaTrainer->description = $request->input('description');
        $desaTrainer->settings = $request->input('settings');

        // Handle image upload
        if ($request->hasFile('image')) {
        // Delete old image
        if ($desaTrainer->image) {
            Storage::disk('public')->delete($desaTrainer->image);
        }
        // Store new image
        $path = $request->file('image')->store('desa-trainers', 'public');
        $desaTrainer->image = $path;
    }

        $desaTrainer->save();

        return redirect()->route('desa-trainers.index')->with('success', 'DESA Trainer actualizado correctamente.');
    }

    /**
     * Elimina un DESA Trainer de la base de datos.
     */
    public function destroy(DesaTrainer $desaTrainer)
    {
        if ($desaTrainer->image) {
            Storage::disk('public')->delete($desaTrainer->image);
        }
        
        $desaTrainer->delete();

        return redirect()->route('desa-trainers.index')->with('success', 'DESA Trainer eliminado correctamente.');
    }

    // Devolver Scenarios asociados a un DESA TRAINER
    public function scenariosDesa($id_desa_trainer)
    {
        if ($id_desa_trainer == 0) {
            $scenarios = Scenario::with(['desa_trainer'])->get();
        } else {
            $scenarios = Scenario::where('desa_trainer_id', $id_desa_trainer)
                ->with(['desa_trainer'])
                ->get();
        }

        // Devolver los escenarios asociados
        return response()->json($scenarios);
    }
    public function show(DesaTrainer $desaTrainer)
    {
        return view('admin.desas.show', compact('desaTrainer'));
    }
}
