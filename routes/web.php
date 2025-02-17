<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DESATrainerController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ScenarioController;
use App\Http\Controllers\InstructionController;
use App\Http\Controllers\TransitionController;
use App\Http\Middleware\CheckRole;
use App\Http\Controllers\ExamenController;


//Ruta de vista pública HOME
Route::get('/Inicio', function () {
    return view('home');
})->name('home');

Route::get('/', function () {
    return redirect()->route('home');
});

// Ruta para usuarios, a playList
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/playList', [ScenarioController::class, 'playlist'])->name('playList');
});

// Ruta para administradores, a admin/dashboard
Route::middleware(['auth', 'verified'])->prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
});

// Rutas para administrador
Route::middleware(['auth', CheckRole::class . ':Administrador'])->prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    // Ruta DESA
    Route::resource('desa-trainers', DESATrainerController::class);

    // Rutas para Scenarios
    Route::resource('scenarios', ScenarioController::class);
    // Rutas personalizadas para los Scenarios
    Route::get('/scenario/{id}/edit', [ScenarioController::class, 'editScenario'])->name('scenario.edit');
    Route::get('/scenario/{id}/info', [ScenarioController::class, 'infoScenario'])->name('scenario.info');

    // Rutas para Usuarios
    Route::get("/users", [UserController::class, 'showUsers'])->name("users");
    Route::get("/user/{id}/info", [UserController::class, 'showUserInfo'])->name("user.info");
    Route::get("/user/create", [UserController::class, 'createUser'])->name("user.create");
    Route::post("/user/save", [UserController::class, 'saveUser'])->name("user.save");
    Route::delete("/user/{id}/delete", [UserController::class, 'destroyUser'])->name("user.destroy");
    Route::get("/user/{id}/edit", [UserController::class, 'editUser'])->name("user.edit");
    Route::put("/user/{id}/update", [UserController::class, 'updateUser'])->name("user.update");

    // Rutas para Instruction
    Route::get("/scenario/{scenario_id}/instruction/create", [InstructionController::class, 'createInstruction'])->name("instruction.create");
    Route::post("/scenario/{scenario_id}/instruction/save", [InstructionController::class, 'saveInstruction'])->name("instruction.save");
    Route::delete("/scenario/{scenario_id}/instruction/{instruction_id}/delete", [InstructionController::class, 'destroyInstruction'])->name("instruction.destroy");
    Route::get("/scenario/{scenario_id}/edit/instruction/{instruction_id}/edit", [InstructionController::class, 'editInstruction'])->name("instruction.edit");
    Route::put("/scenario/{scenario_id}/edit/instruction/{instruction_id}/update", [InstructionController::class, 'updateInstruction'])->name("instruction.update");

    // Rutas para Transiciones
    Route::get("/scenario/{scenario_id}/transition/create", [TransitionController::class, 'createTransition'])->name("transition.create");
    Route::post("/scenario/{scenario_id}/transition/save", [TransitionController::class, 'saveTransition'])->name("transition.save");
    Route::delete("/scenario/{scenario_id}/transition/{transition_id}/delete", [TransitionController::class, 'destroyTransition'])->name("transition.destroy");
    Route::get("/scenario/{scenario_id}/edit/transition/{transition_id}/edit", [TransitionController::class, 'editTransition'])->name("transition.edit");
    Route::put("/scenario/{scenario_id}/edit/transition/{transition_id}/update", [TransitionController::class, 'updateTransition'])->name("transition.update");

});

// Filtrado de Scenarios según DESA Trainer
Route::prefix('admin')->group(function () {
    Route::get('scenarios/desa/{id_desaTrainer}', [DESATrainerController::class, 'scenariosDesa']);
});

// Simulaciones de escenarios
Route::get('/scenario/{id_scenario}/simulation/desa_trainer/{id_desa}', [ScenarioController::class, 'play'])->name('scenarios.play');

Route::get('/play/{scenario_id}/{desa_trainer_id}', [PlayController::class, 'show']);


Route::middleware(['auth', CheckRole::class . ':Administrador'])->prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
    // Ruta DESA
    Route::resource('desa-trainers', DESATrainerController::class);

    // Rutas para Scenarios
    Route::resource('scenarios', ScenarioController::class);

    Route::get('/examen/{scenario_id}', [ScenarioController::class, 'examenScenario'])->name('scenario.examen');

});

Route::middleware(['auth', CheckRole::class . ':Administrador'])->prefix('admin')->group(function () {
    Route::get('/examen/{scenario_id}', [ExamenController::class, 'show']);
});