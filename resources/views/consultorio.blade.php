@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Consultorios</h1>
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
                    <div class="card-header"> Nuevo Consultorio</div>
                    <div class="card-body">

                        <form action="{{ route('guardar.consultorio') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{ $consultorio->id }}">
                            <div class="form-group">
                                <label for="numero">Número</label>
                                <input type="number" class="form-control mt-1" id="numero" name="numero" required
                                    placeholder="Número" value="{{ $consultorio->numero }}" />
                            </div>
                            <button type="submit" class="btn btn-outline-success">Guardar</button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>

@stop
