<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ApiController;
use App\Http\Controllers\Api\DesaTrainerController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


// Renderiza TODOS los escenarios
Route::get('admin/scenarios/json', [ApiController::class, 'getScenariosJSON']);

Route::get('desa_trainers', [DesaTrainerController::class, 'index']);
