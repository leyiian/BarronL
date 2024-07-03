<?php

use App\Http\Controllers\ConsultorioController;
use App\Http\Controllers\EspecialidadController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\HelloController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\MedicamentoController;
use App\Http\Controllers\PacienteController;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/hola',[HelloController::class,'index']);
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('especialidad/nueva',[EspecialidadController::class,'index']) ->name('nueva.especialidad')->middleware('auth');
Route::post('especialidad/guardar',[EspecialidadController::class,'save'])->name('guardar.especialidades')->middleware('auth');
Route::get('especialidades',[EspecialidadController::class,'list'])->name('especialidades')->middleware('auth');
Route::post('especialidad/borrar',[EspecialidadController::class,'delete'])->name('borrar.especialidad')->middleware('auth');


Route::get('doctor/nueva',[DoctorController::class,'index']) ->name('nuevo.doctor')->middleware('auth');
Route::post('doctor/guardar',[DoctorController::class,'save'])->name('guardar.doctor')->middleware('auth');
Route::get('doctores/{idEspecialidad?}', [DoctorController::class, 'list'])->name('doctores')->middleware('auth');
Route::post('doctor/borrar',[DoctorController::class,'delete'])->name('borrar.doctor')->middleware('auth');

Route::get('consultorio/nuevo',[ConsultorioController::class,'index']) ->name('nuevo.consultorio')->middleware('auth');
Route::post('consultorio/guardar',[ConsultorioController::class,'save'])->name('guardar.consultorio')->middleware('auth');
Route::get('consultorios', [ConsultorioController::class, 'list'])->name('consultorios')->middleware('auth');
Route::post('consultorio/borrar',[ConsultorioController::class,'delete'])->name('borrar.consultorio')->middleware('auth');

Route::get('paciente/nuevo', [PacienteController::class, 'index'])->name('nuevo.paciente')->middleware('auth');
Route::post('paciente/guardar', [PacienteController::class, 'save'])->name('guardar.paciente')->middleware('auth');
Route::get('pacientes', [PacienteController::class, 'list'])->name('pacientes')->middleware('auth');
Route::post('paciente/borrar', [PacienteController::class, 'delete'])->name('borrar.paciente')->middleware('auth');

Route::get('medicamento/nuevo',[MedicamentoController::class,'index']) ->name('nuevo.medicamento')->middleware('auth');
Route::post('medicamento/guardar',[MedicamentoController::class,'save'])->name('guardar.medicamento')->middleware('auth');
Route::get('medicamentos', [MedicamentoController::class, 'list'])->name('medicamentos')->middleware('auth');
Route::post('medicamento/borrar',[MedicamentoController::class,'delete'])->name('borrar.medicamento')->middleware('auth');

Route::get('material/nuevo', [MaterialController::class,'index'])->name('nuevo.material')->middleware('auth');
Route::post('material/guardar', [MaterialController::class,'save'])->name('guardar.material')->middleware('auth');
Route::get('materiales', [MaterialController::class, 'list'])->name('materiales')->middleware('auth');
Route::post('material/borrar', [MaterialController::class,'delete'])->name('borrar.material')->middleware('auth');



