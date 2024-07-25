<?php

use App\Http\Controllers\CitasController;
use App\Http\Controllers\ConsultorioController;
use App\Http\Controllers\EspecialidadController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\HelloController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\MedicamentoController;
use App\Http\Controllers\PacienteController;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Opcodes\LogViewer\LogViewerController;
use App\Http\Middleware\AdminMiddleware;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/hola',[HelloController::class,'index']);
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('admin')->group(function () {
    Route::get('especialidad/nueva',[EspecialidadController::class,'index']) ->name('nueva.especialidad');
    Route::post('especialidad/guardar',[EspecialidadController::class,'save'])->name('guardar.especialidades');
    Route::get('especialidades',[EspecialidadController::class,'list'])->name('especialidades');
    Route::post('especialidad/borrar',[EspecialidadController::class,'delete'])->name('borrar.especialidad');


    Route::get('doctor/nueva',[DoctorController::class,'index']) ->name('nuevo.doctor');
    Route::post('doctor/guardar',[DoctorController::class,'save'])->name('guardar.doctor');
    Route::get('doctores/{idEspecialidad?}', [DoctorController::class, 'list'])->name('doctores');
    Route::post('doctor/borrar',[DoctorController::class,'delete'])->name('borrar.doctor');

    Route::get('consultorio/nuevo',[ConsultorioController::class,'index']) ->name('nuevo.consultorio');
    Route::post('consultorio/guardar',[ConsultorioController::class,'save'])->name('guardar.consultorio');
    Route::get('consultorios', [ConsultorioController::class, 'list'])->name('consultorios');
    Route::post('consultorio/borrar',[ConsultorioController::class,'delete'])->name('borrar.consultorio');

    Route::get('paciente/nuevo', [PacienteController::class, 'index'])->name('nuevo.paciente');
    Route::post('paciente/guardar', [PacienteController::class, 'save'])->name('guardar.paciente');
    Route::get('pacientes', [PacienteController::class, 'list'])->name('pacientes');
    Route::post('paciente/borrar', [PacienteController::class, 'delete'])->name('borrar.paciente');

    Route::get('medicamento/nuevo',[MedicamentoController::class,'index']) ->name('nuevo.medicamento');
    Route::post('medicamento/guardar',[MedicamentoController::class,'save'])->name('guardar.medicamento');
    Route::get('medicamentos', [MedicamentoController::class, 'list'])->name('medicamentos');
    Route::post('medicamento/borrar',[MedicamentoController::class,'delete'])->name('borrar.medicamento');

    Route::get('material/nuevo', [MaterialController::class,'index'])->name('nuevo.material');
    Route::post('material/guardar', [MaterialController::class,'save'])->name('guardar.material');
    Route::get('materiales', [MaterialController::class, 'list'])->name('materiales');
    Route::post('material/borrar', [MaterialController::class,'delete'])->name('borrar.material');
});

Route::middleware('doctor')->group(function () {
    Route::get('citas/nuevo', [CitasController::class,'index'])->name('nuevo.cita');
    Route::post('citas/guardar', [CitasController::class,'save'])->name('guardar.citas');
    Route::get('citas', [CitasController::class, 'list'])->name('citas');
    Route::post('cita/borrar', [CitasController::class,'delete'])->name('borrar.cita');

    Route::delete('/eliminar-medicamento/{id}', [CitasController::class, 'eliminarMedicamentoRecetado'])->name('eliminar.medicamentorecetado');
});