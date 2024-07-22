<?php

use App\Http\Controllers\CitasController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\EspecialidadController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PacienteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('citas', [CitasController::class, 'listApi']);


    Route::post('especialidad', [EspecialidadController::class, 'getApi']);
    Route::post('especialidad/guardar', [EspecialidadController::class, 'saveApi']);
    Route::post('especialidad/eliminar', [EspecialidadController::class, 'deleteApi']);

    Route::get('doctores', [DoctorController::class, 'listApi']);
    Route::post('doctor', [DoctorController::class, 'getApi']);
    Route::post('doctores/guardar', [DoctorController::class, 'saveApi']);
    Route::post('doctores/eliminar', [DoctorController::class, 'deleteApi']);

    Route::post('cita/guardar', [CitasController::class, 'saveApi']);
    Route::post('citas/paciente', [CitasController::class, 'indexApi']);

    Route::get('pacientes', [PacienteController::class, 'listApi']);
    Route::post('paciente', [PacienteController::class, 'getApi']);
    Route::get('especialidades', [EspecialidadController::class, 'listApi']);
    Route::post('pacientes/eliminar', [PacienteController::class, 'listApi']);
});

Route::post('paciente/guardar', [PacienteController::class, 'saveApi']);
Route::post('login', [LoginController::class, 'login']);
Route::post('register', [LoginController::class, 'registro']);



