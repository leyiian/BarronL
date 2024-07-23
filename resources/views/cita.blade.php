@extends('adminlte::page')
@php
    $user = Auth::user();
@endphp
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
                    <input type="text" class="form-control" id="nombreCompletoPaciente"
                        value="{{ $cita->nombreCompletoPaciente }}" readonly>
                </div>
                <div class="form-group">
                    <label for="nombreCompletoPaciente">Especialidad</label>
                    <input type="text" class="form-control" id="nombreCompletoPaciente"
                        value="{{ $cita->nombreEspecialidad }}" readonly>
                </div>
                @if ($user->rol == 'A')
                    <input type="hidden" name="Observaciones" value="{{ $cita->Observaciones }}">

                @endif
                <input type="hidden" name="Observaciones" value="{{ $cita->Observaciones }}">
                @if ($user->rol == 'D')


                <div class="form-group">
                    <label for="nombreCompletoPaciente">Observaciones</label>
                    <input class="form-control" name="Observaciones" value="{{ $cita->Observaciones }}">
                </div>
                @endif
                @if ($user->rol == 'A')
                    <div class="form-group">
                        <label for="id_doctor">Doctor</label>
                        <select name="id_doctor" id="id_doctor" class="form-control">
                            <option value="">Seleccionar Doctor</option>
                            @foreach ($doctores as $doctor)
                                <option value="{{ $doctor->id }}">
                                    {{ $doctor->nombre }} {{ $doctor->apellido_paterno }} {{ $doctor->apellido_materno }}
                                </option>
                            @endforeach
                        </select>
                        @if ($doctores->isEmpty())
                            <p style="color: red">No se encontraron doctores con la especialidad seleccionada.</p>
                        @endif

                    </div>
                @endif

                <div class="form-group">
                    <label for="id_consultorio">Consultorios</label>
                    <select name="id_consultorio" id="id_consultorio" class="form-control">
                        <option value="">Seleccionar Consultorio</option>
                        @foreach ($consultorios as $consultorio)
                            <option value="{{ $consultorio->id }}">
                                {{ $consultorio->numero }}
                            </option>
                        @endforeach
                    </select>
                    @if ($consultorios->isEmpty())
                        <p style="color: red">No se encontraron Consultorios</p>
                    @endif

                </div>

                @if ($user->rol == 'D')
                    <!-- Botón para abrir el modal de medicamentos -->
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#medicamentoModal">
                        Agregar Medicamento
                    </button>

                    <!-- Modal de medicamentos -->
                    <div class="modal fade" id="medicamentoModal" tabindex="-1" role="dialog"
                        aria-labelledby="medicamentoModalLabel" aria-hidden="true">
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
                                        <select id="medicamentos" class="form-control" aria-label="Seleccionar medicamento">
                                            <option>Seleccionar medicamento</option>
                                            @foreach ($medicamentos as $medicamento)
                                                <option value="{{ $medicamento->id }}">
                                                    ({{ $medicamento->codigo }})
                                                    {{ $medicamento->descripcion }}
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
                            @foreach ($medicamentosRecetados as $medicamentoRecetado)
                                <li class="list-group-item exists-in-db" data-id="{{ $medicamentoRecetado->id }}">
                                    ({{ $medicamentoRecetado->medicamento->codigo }})
                                    {{ $medicamentoRecetado->medicamento->descripcion }}
                                    - Cantidad: {{ $medicamentoRecetado->cantidad }}, Unidad:
                                    {{ $medicamentoRecetado->unidad }},
                                    Cada Cuándo: {{ $medicamentoRecetado->cadaCuando }}, Cuántos Días:
                                    {{ $medicamentoRecetado->cuantosDias }}
                                    <button
                                        class="btn btn-danger btn-sm float-right eliminar-medicamento">Eliminar</button>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif


                <div class="form-group">
                    <label for="estado">Estado</label>
                    <select name="estado" id="estado" class="form-control">
                        <option value="Pendiente" {{ $cita->estado == 'Pendiente' ? 'selected' : '' }}>Pendiente</option>
                        <option value="Autorizado" {{ $cita->estado == 'Autorizado' ? 'selected' : '' }}>Autorizado
                        </option>
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
                li.classList.add('list-group-item');
                li.setAttribute('data-id', option.value);
                li.innerHTML = `
                (${option.text}) - ${cantidad} ${unidad} - Cada ${cadaCuando} - ${cuantosDias} días
                <button class="btn btn-danger btn-sm float-right eliminar-medicamento">Eliminar</button>
            `;
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

            // Cerrar el modal
            $('#medicamentoModal').modal('hide');
        });
        document.getElementById('listaMedicamentos').addEventListener('click', function(event) {
            if (event.target.classList.contains('eliminar-medicamento')) {
                event.preventDefault(); // Previene el comportamiento predeterminado
                const listItem = event.target.closest('.list-group-item');
                const medicamentoId = listItem.getAttribute('data-id');

                if (confirm('¿Está seguro de que desea eliminar este medicamento?')) {
                    // Comprueba si el medicamento ya existe en la base de datos
                    if (listItem.classList.contains('exists-in-db')) {
                        fetch(`/eliminar-medicamento/${medicamentoId}`, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Content-Type': 'application/json'
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    listItem.remove();
                                } else {
                                    alert('Error al eliminar el medicamento.');
                                }
                            })
                            .catch(error => console.error('Error:', error));
                    } else {
                        // Si no existe en la base de datos, solo eliminar del DOM y del JSON
                        listItem.remove();
                        // Remover el campo oculto correspondiente
                        const hiddenInput = document.querySelector(
                            `input[name="medicamentos[]"][value*="${medicamentoId}"]`);
                        if (hiddenInput) {
                            hiddenInput.remove();
                        }
                    }
                }
            }
        });
    </script>
@stop
