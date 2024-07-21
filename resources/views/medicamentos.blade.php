@extends('adminlte::page')

@section('title', 'Lista de Medicamentos')

@section('content_header')
    <h1>Lista de Medicamentos</h1>
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

                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="card">
                    <div class="card-header">Medicamentos</div>

                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Código</th>
                                    <th>Descripción</th>
                                    <th>Precio</th>
                                    <th>Existencia</th>
                                    <th>Fecha de Caducidad</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($medicamentos as $medicamento)
                                <tr>
                                    <td>{{ $medicamento->id }}</td>
                                    <td>{{ $medicamento->codigo }}</td>
                                    <td>{{ $medicamento->descripcion }}</td>
                                    <td>{{ $medicamento->precio }}</td>
                                    <td>{{ $medicamento->existencia }}</td>
                                    <td>{{ $medicamento->fecha_caducidad }}</td>
                                    <td>
                                        <a href="{{ route('nuevo.medicamento', ['id' => $medicamento->id]) }}" class="btn btn-primary">Editar</a>
                                        <form action="{{ route('borrar.medicamento') }}" method="POST" style="display:inline-block;">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $medicamento->id }}">
                                            <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de que deseas eliminar este medicamento?');">Eliminar</button>
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

