@extends('adminlte::page')

@section('title', 'Nuevo Material')

@section('content_header')
    <h1>Nuevo Material</h1>
@stop

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Nuevo Material</div>
                    <div class="card-body">
                        <form action="{{ route('guardar.material') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{ $material->id }}">
                            <div class="form-group">
                                <label for="codigo">Código</label>
                                <input type="text" class="form-control"  value="{{ $material->codigo }}" id="codigo" name="codigo" required>
                            </div>
                            <div class="form-group">
                                <label for="descripcion">Descripción</label>
                                <input type="text" class="form-control" value="{{ $material->descripcion }}"  id="descripcion" name="descripcion" required>
                            </div>
                            <div class="form-group">
                                <label for="precio">Precio</label>
                                <input type="number" class="form-control" value="{{ $material->precio }}" id="precio" name="precio" step="0.01" required>
                            </div>
                            <div class="form-group">
                                <label for="existencia">Existencia</label>
                                <input type="number" class="form-control" value="{{ $material->existencia }}" id="existencia" name="existencia" required>
                            </div>
                            <div class="form-group">
                                <label for="fecha_caducidad">Fecha de Caducidad</label>
                                <input type="date" class="form-control" id="fecha_caducidad" value="{{ $material->fecha_caducidad }}" name="fecha_caducidad" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
