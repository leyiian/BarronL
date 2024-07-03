@extends('adminlte::page')

@section('title', 'Editar Medicamento')

@section('content_header')
    <h1>Editar Medicamento</h1>
@stop

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Editar Medicamento</div>
                    <div class="card-body">
                        <form action="{{ route('guardar.medicamento', $medicamento->id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{ $medicamento->id }}">
                            <div class="form-group">
                                <label for="codigo">Código</label>
                                <input type="text" class="form-control" id="codigo" name="codigo" required
                                    value="{{ $medicamento->codigo }}">
                            </div>
                            <div class="form-group">
                                <label for="descripcion">Descripción</label>
                                <input type="text" class="form-control" id="descripcion" name="descripcion" required
                                    value="{{ $medicamento->descripcion }}">
                            </div>
                            <div class="form-group">
                                <label for="precio">Precio</label>
                                <input type="number" class="form-control" id="precio" step="0.01" name="precio" required
                                    value="{{ $medicamento->precio }}">
                            </div>
                            <div class="form-group">
                                <label for="existencia">Existencia</label>
                                <input type="number" class="form-control" id="existencia" name="existencia" required
                                    value="{{ $medicamento->existencia }}">
                            </div>
                            <div class="form-group">
                                <label for="fecha_caducidad">Fecha de Caducidad</label>
                                <input type="date" class="form-control" id="fecha_caducidad" name="fecha_caducidad" required
                                    value="{{ $medicamento->fecha_caducidad }}">
                            </div>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
