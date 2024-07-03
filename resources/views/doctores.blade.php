@extends('adminlte::page')

@section('title', 'Lista de Materias')

@section('content_header')
    <h1>Lista de Doctores</h1>
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
                    <div class="card-header">Doctores</div>

                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>apellido paterno</th>
                                    <th>apellido materno</th>
                                    <th>especialidad</th>
                                    <th>telefono</th>
                                    <th>cedula</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($doctores as $doctor)
                                <tr>
                                    <td>{{ $doctor->id }}</td>
                                    <td>{{ $doctor->nombre }}</td>
                                    <td>{{ $doctor->apellido_paterno }}</td>
                                    <td>{{ $doctor->apellido_materno }}</td>
                                    <td>
                                        @if ($especialidadSeleccionada && $doctor->id_especialidad == $especialidadSeleccionada->id)
                                            {{ $especialidadSeleccionada->nombre }}
                                        @else
                                            @foreach ($especialidades as $especialidad)
                                                @if ($doctor->id_especialidad == $especialidad->id)
                                                    {{ $especialidad->nombre }}
                                                    @break
                                                @endif
                                            @endforeach
                                        @endif
                                    </td>
                                    <td>{{ $doctor->telefono }}</td>
                                    <td>{{ $doctor->cedula }}</td>
                                    <td>
                                        <a href="{{ route('nuevo.doctor', ['id' => $doctor->id]) }}" class="btn btn-primary">Editar</a>
                                        <form action="{{ route('borrar.doctor') }}" method="POST" style="display:inline-block;">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $doctor->id }}">
                                            <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de que deseas eliminar este doctor?');">Eliminar</button>
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
