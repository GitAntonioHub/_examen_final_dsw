<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Scenario;

class ApiController extends Controller
{
    // Función para poder renderizar la tabla de forma dinámica una vez el usuario selecciona "mostrar escenarios"
    public function getScenariosJSON() {
        $escenarios = Scenario::with(['desa_trainer'])->get();
                
        return response()->json($escenarios);
    }
}
