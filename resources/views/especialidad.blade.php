@extends('adminlte::page')
<link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

@section('title', 'Especialidad')

@section('content_header')
    <h1>Especialidades</h1>
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
                    <div class="card-header"> Nueva Especialidad</div>
                    <div class="card-body">

                        <form action="{{ route('guardar.especialidades') }}"method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{ $especialidad->id }}">
                            <div class="form-group">
                                <input type="text" id="nombre" name="nombre" required
                                    value="{{ $especialidad->nombre }}" placeholder="nombre"
                                    style="width: 80%; padding: 10px; margin: 10px 0; border: 1px solid #ccc; border-radius: 5px; box-sizing: border-box; font-size: 16px;" />

                            </div>
                            <button type="submit" class="btn btn-outline-success">Guardar</button>
                        </form>

                    </div>

                </div>
            </div>
        </div>
    </div>

@stop
