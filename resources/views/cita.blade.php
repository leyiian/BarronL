@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Autorizacion Cita / Asignacion doctor</h1>
@stop
@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('guardar.citas') }}" method="POST">
            @csrf
            <input type="hidden" name="id" value="{{ $cita->id }}">
            <input type="hidden" name="id_paciente" value="{{ $cita->id_paciente }}">
            <input type="hidden" name="fecha" value="{{ $cita->fecha }}">
            <input type="hidden" name="Observaciones" value="{{ $cita->Observaciones }}">
            <input type="hidden" name="id_especialidades" value="{{ $cita->id_especialidades }}">
            <div class="form-group">
                <label for="nombreCompletoPaciente">Paciente</label>
                <input type="text" class="form-control" id="nombreCompletoPaciente" value="{{ $cita->nombreCompletoPaciente }}" readonly>
            </div>
            <div class="form-group">
                <label for="nombreCompletoPaciente">Especialidad</label>
                <input type="text" class="form-control" id="nombreCompletoPaciente" value="{{ $cita->nombreEspecialidad }}" readonly>
            </div>
            <div class="form-group">
                <label for="id_doctor">Doctor</label>
                <select name="id_doctor" id="id_doctor" class="form-control">
                    <option value="">Seleccionar Doctor</option>
                    @foreach($doctores as $doctor)
                        <option value="{{ $doctor->id }}" {{ $cita->id_doctor == $doctor->id ? 'selected' : '' }}>
                            {{ $doctor->nombre }} {{ $doctor->apellido_paterno }} {{ $doctor->apellido_materno }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="estado">Estado</label>
                <select name="estado" id="estado" class="form-control">
                    <option value="Pendiente" {{ $cita->estado == 'Pendiente' ? 'selected' : '' }}>Pendiente</option>
                    <option value="Autorizado" {{ $cita->estado == 'Autorizado' ? 'selected' : '' }}>Autorizado</option>
                    <option value="Rechazado" {{ $cita->estado == 'Rechazado' ? 'selected' : '' }}>Rechazado</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Guardar</button>
        </form>
    </div>
</div>
@stop
