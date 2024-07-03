@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Pacientes</h1>
@stop

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"> Nuevo Paciente</div>
                    <div class="card-body">

                        <form action="{{ route('guardar.paciente') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{ $paciente->id }}">
                            <div class="form-group">
                                <label for="nombre">Nombre</label>
                                <input type="text" class="form-control mt-1" id="nombre" name="nombre" required
                                    placeholder="Nombre" value="{{ $paciente->nombre }}" />
                            </div>
                            <div class="form-group">
                                <label for="ApPat">Apellido Paterno</label>
                                <input type="text" class="form-control mt-1" id="ApPat"
                                    name="ApPat" required placeholder="Apellido Paterno" value="{{ $paciente->ApPat }}" />
                            </div>
                            <div class="form-group">
                                <label for="ApMat">Apellido Materno</label>
                                <input type="text" class="form-control mt-1" id="ApMat"
                                    name="ApMat" required placeholder="Apellido Materno" value="{{ $paciente->ApMat }}" />
                            </div>
                            <div class="form-group">
                                <label for="telefono">Teléfono</label>
                                <input type="text" class="form-control mt-1" id="telefono" inputmode="numeric"
                                    pattern="\d*" name="telefono" placeholder="Teléfono" value="{{ $paciente->telefono }}" />
                            </div>
                            <button type="submit" class="btn btn-outline-success">Guardar</button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>

@stop
