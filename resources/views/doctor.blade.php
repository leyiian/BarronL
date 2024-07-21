@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Doctores</h1>
@stop

@section('content')

    <div class="container">
        <div class="row">
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
                    <div class="card-header"> Nuevo Doctor</div>
                    <div class="card-body">

                        <form action="{{ route('guardar.doctor') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{ $doctor->id }}">
                            <div class="form-group">
                                <label for="nombre">Nombre</label>
                                <input type="text" class="form-control mt-1" id="nombre" name="nombre" required
                                    placeholder="nombre" value="{{ $doctor->nombre }}"/>
                            </div>
                            <div class="form-group">
                                <label for="apellido_paterno">Apellido Paterno</label>
                                <input type="text" class="form-control mt-1" id="apellido_paterno"
                                    name="apellido_paterno" required placeholder="apellido paterno" value="{{ $doctor->apellido_paterno }}"/>
                            </div>
                            <div class="form-group">
                                <label for="apellido_materno">Apellido Materno</label>
                                <input type="text" class="form-control mt-1" id="apellido_materno"
                                    name="apellido_materno" required placeholder="apellido materno" value="{{ $doctor->apellido_materno }}" />
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control mt-1" id="email" name="email" required placeholder="Email" value="{{ $user->email ?? '' }}" />
                            </div>

                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control mt-1" id="password" name="password" required placeholder="Password" />
                            </div>
                            <div class="form-group">
                                <label for="id_especialidad">Especialidad</label>
                                <select class="form-control" id="id_especialidad" name="id_especialidad" required>
                                    <option selected >Seleccione una especialidad</option>
                                    @foreach ($especialidades as $especialidad)
                                    <option value="{{ $especialidad->id }}" @if ($especialidad->id == $doctor->id_especialidad) selected @endif>{{ $especialidad->nombre }}</option>
                                @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="cedula">Cédula</label>
                                <input type="text" class="form-control mt-1" id="cedula" name="cedula" required
                                    placeholder="cedula" value="{{ $doctor->cedula }}"/>
                            </div>
                            <div class="form-group">
                                <label for="telefono">Teléfono</label>
                                <input type="text" class="form-control mt-1" id="telefono" inputmode="numeric"
                                    pattern="\d*" name="telefono" required placeholder="teléfono" value="{{ $doctor->telefono }}" />
                            </div>
                            <button type="submit" class="btn btn-outline-success">Guardar</button>
                        </form>

                    </div>

                </div>
            </div>
        </div>
    </div>

@stop
