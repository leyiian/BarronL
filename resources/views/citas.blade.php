@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Cita</h1>
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
                            @foreach ($citas as $cita)
                            <tr>
                                <td>{{ $cita->id }}</td>
                                <td>{{ $cita->numero }}</td>
                                <td>
                                    <a href="{{ route('nuevo.cita', ['id' => $cita->id]) }}" class="btn btn-primary">Editar</a>
 
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
