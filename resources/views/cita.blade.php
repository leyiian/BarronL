@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Autorizacion Cita / Asignacion doctor</h1>
@stop
@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('guardar.citas') }}" method="POST">
            @csrf
            <input type="hidden" name="id" value="{{ $cita->id }}">
            <input type="hidden" name="id_paciente" value="{{ $cita->id_paciente }}">
            <input type="hidden" name="fecha" value="{{ $cita->fecha }}">
            <input type="hidden" name="id_especialidades" value="{{ $cita->id_especialidades }}">
            <div class="form-group">
                <label for="nombreCompletoPaciente">Paciente</label>
                <input type="text" class="form-control" id="nombreCompletoPaciente" value="{{ $cita->nombreCompletoPaciente }}" readonly>
            </div>
            <div class="form-group">
                <label for="nombreCompletoPaciente">Especialidad</label>
                <input type="text" class="form-control" id="nombreCompletoPaciente" value="{{ $cita->nombreEspecialidad }}" readonly>
            </div>
            <div class="form-group">
                <label for="nombreCompletoPaciente">Observaciones</label>
                <input  class="form-control" name="Observaciones" value="{{ $cita->Observaciones }}">
            </div>
            <div class="form-group">
                <label for="id_doctor">Doctor</label>
                <select name="id_doctor" id="id_doctor" class="form-control">
                    <option value="">Seleccionar Doctor</option>
                    @foreach($doctores as $doctor)
                        <option value="{{ $doctor->id }}" {{ $cita->id_doctor == $doctor->id ? 'selected' : '' }}>
                            {{ $doctor->nombre }} {{ $doctor->apellido_paterno }} {{ $doctor->apellido_materno }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <!-- Botón para abrir el modal de medicamentos -->
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#medicamentoModal">
                Agregar Medicamento
            </button>

            <!-- Modal de medicamentos -->
            <div class="modal fade" id="medicamentoModal" tabindex="-1" role="dialog" aria-labelledby="medicamentoModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="medicamentoModalLabel">Agregar Medicamento</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="medicamentos">Medicamentos</label>
                                <select id="medicamentos" class="form-select" aria-label="Seleccionar medicamento">
                                    <option>Seleccionar medicamento</option>
                                    @foreach($medicamentos as $medicamento)
                                        <option value="{{ $medicamento->id }}">
                                            ({{ $medicamento->codigo }}) {{ $medicamento->descripcion }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="cantidad">Cantidad</label>
                                <input type="number" id="cantidad" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="unidad">Unidad</label>
                                <input type="text" id="unidad" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="cadaCuando">Cada Cuándo</label>
                                <input type="text" id="cadaCuando" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="cuantosDias">Cuántos Días</label>
                                <input type="text" id="cuantosDias" class="form-control">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="button" id="agregarMedicamento" class="btn btn-primary">Agregar</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Lista de medicamentos seleccionados -->
            <div class="form-group">
                <label>Medicamentos Seleccionados</label>
                <ul id="listaMedicamentos" class="list-group">
                    <!-- Los medicamentos seleccionados se agregarán aquí dinámicamente -->
                </ul>
            </div>

            <div class="form-group">
                <label for="estado">Estado</label>
                <select name="estado" id="estado" class="form-control">
                    <option value="Pendiente" {{ $cita->estado == 'Pendiente' ? 'selected' : '' }}>Pendiente</option>
                    <option value="Autorizado" {{ $cita->estado == 'Autorizado' ? 'selected' : '' }}>Autorizado</option>
                    <option value="Rechazado" {{ $cita->estado == 'Rechazado' ? 'selected' : '' }}>Rechazado</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Guardar</button>
        </form>
    </div>
</div>
@stop

@section('js')
<script>
    document.getElementById('agregarMedicamento').addEventListener('click', function() {
        const select = document.getElementById('medicamentos');
        const cantidad = document.getElementById('cantidad').value;
        const unidad = document.getElementById('unidad').value;
        const cadaCuando = document.getElementById('cadaCuando').value;
        const cuantosDias = document.getElementById('cuantosDias').value;
        const lista = document.getElementById('listaMedicamentos');

        Array.from(select.selectedOptions).forEach(option => {
            const li = document.createElement('li');
            li.textContent = `${option.text} - ${cantidad} ${unidad} - Cada ${cadaCuando} - ${cuantosDias} días`;
            li.classList.add('list-group-item');
            lista.appendChild(li);

            // Crear campos ocultos para enviar con el formulario
            const inputMedicamento = document.createElement('input');
            inputMedicamento.type = 'hidden';
            inputMedicamento.name = 'medicamentos[]';
            inputMedicamento.value = JSON.stringify({
                id: option.value,
                cantidad: cantidad,
                unidad: unidad,
                cadaCuando: cadaCuando,
                cuantosDias: cuantosDias
            });
            lista.appendChild(inputMedicamento);
        });

        // Limpiar selección después de agregar
        select.selectedIndex = 0;
        document.getElementById('cantidad').value = '';
        document.getElementById('unidad').value = '';
        document.getElementById('cadaCuando').value = '';
        document.getElementById('cuantosDias').value = '';
    });
</script>
@stop