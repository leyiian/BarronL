<?php

use App\Http\Controllers\DoctorController;
use App\Http\Controllers\EspecialidadController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PacienteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('login',[LoginController::class, 'login']);
Route::post('registro',[LoginController::class,'registro']);

Route::get('especialidades', [EspecialidadController::class,'listApi']);
Route::post('especialidad', [EspecialidadController::class,'getApi']);
Route::post('especialidad/guardar', [EspecialidadController::class,'saveApi']);
Route::post('especialidad/eliminar', [EspecialidadController::class,'deleteApi']);

Route::get('doctores', [DoctorController::class,'listApi']);
Route::post('doctores/guardar', [DoctorController::class,'saveApi']);
Route::post('doctores/eliminar', [DoctorController::class,'deleteApi']);


Route::get('pacientes', [PacienteController::class,'listApi']);
Route::post('paciente', [PacienteController::class,'getApi']);
Route::post('paciente/guardar', [PacienteController::class,'saveApi']);
Route::post('pacientes/eliminar', [PacienteController::class,'listApi']);
