@extends('adminlte::page')

@section('title', 'Lista de Consultorios')

@section('content_header')
    <h1>Lista de Consultorios</h1>
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
                    <div class="card-header">Consultorios</div>

                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Número</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($consultorios as $consultorio)
                                <tr>
                                    <td>{{ $consultorio->id }}</td>
                                    <td>{{ $consultorio->numero }}</td>
                                    <td>
                                        <a href="{{ route('nuevo.consultorio', ['id' => $consultorio->id]) }}" class="btn btn-primary">Editar</a>
                                        <form action="{{ route('borrar.consultorio') }}" method="POST" style="display:inline-block;">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $consultorio->id }}">
                                            <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de que deseas eliminar este consultorio?');">Eliminar</button>
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
