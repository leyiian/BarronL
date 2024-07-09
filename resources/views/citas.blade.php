@extends('adminlte::page')

@section('title', 'Citas')

@section('content_header')
    <h1>Citas</h1>
@stop

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="card">
                <div class="card-header">Citas</div>

                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Paciente</th>
                                <th>Doctor</th>
                                <th>Especialidad</th>
                                <th>Consultorio</th>
                                <th>Fecha</th>
                                <th>Observaciones</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($citas as $cita)
                            <tr>
                                <td>{{ $cita->id }}</td>
                                <td>{{ $nompaciente }}</td>
                                <td>{{ $cita->nombreCompletoDoctor }}</td>
                                <td>{{ $cita->nombreEspecialidad }}</td>
                                <td>{{ $cita->numeroConsultorio }}</td>
                                <td>{{ $cita->fecha }}</td>
                                <td>{{ $cita->Observaciones }}</td>
                                <td>{{ $cita->estado }}</td>
                                <td>
                                    <a href="{{ route('nuevo.cita', ['id' => $cita->id]) }}" class="btn btn-primary">Editar</a>
                                    <form action="{{ route('borrar.cita') }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $cita->id }}">
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de que deseas eliminar esta cita?');">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
