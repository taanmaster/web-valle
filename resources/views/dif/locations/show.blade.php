@extends('layouts.master')
@section('title')Intranet @endsection
@section('content')
<!-- this is breadcrumbs -->
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') DIF @endslot
@slot('title') Locación: {{ $location->name }} @endslot
@endcomponent

<div class="row layout-spacing">
    <div class="main-content">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $location->name }}</h5>

                        <p class="card-text">
                            <strong>Tipo:</strong> {{ $location->type }}
                        </p>

                        <p class="card-text">
                            <strong>Dirección:</strong><br>
                            {{ $location->street_name }} #{{ $location->street_num }}<br>
                            {{ $location->colony ? $location->colony . ' - ' : '' }} {{ $location->zip_code }}
                        </p>

                        @if($location->phone)
                            <p class="card-text"><strong>Teléfono:</strong> {{ $location->phone }}</p>
                        @endif
                        @if($location->email)
                            <p class="card-text"><strong>Correo:</strong> {{ $location->email }}</p>
                        @endif

                        <hr>

                        <div class="d-flex gap-2" role="group" aria-label="Basic example">
                            <a href="{{ route('dif.locations.edit', $location->id) }}" class="btn btn-sm btn-secondary">Editar</a>
                            <form method="POST" action="{{ route('dif.locations.destroy', $location->id) }}" style="display: inline-block;">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de que deseas eliminar esta locación?')">
                                    Eliminar
                                </button>
                            </form>
                            <a href="{{ route('dif.locations.index') }}" class="btn btn-sm btn-primary">Volver al listado</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Información adicional</h5>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h6>Dirección completa</h6>
                                <p class="text-muted">
                                    {{ $location->street_name }} #{{ $location->street_num }}<br>
                                    {{ $location->colony ?? 'Sin colonia' }} - {{ $location->zip_code }}
                                </p>
                            </div>
                            <div class="col-md-6">
                                <h6>Contacto</h6>
                                <p class="text-muted">
                                    {{ $location->phone ? $location->phone : 'Sin teléfono' }}<br>
                                    {{ $location->email ? $location->email : 'Sin correo' }}
                                </p>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-md-6">
                                <h6>Características</h6>
                                <p class="text-muted">
                                    <strong>Nombre:</strong> {{ $location->name }}<br>
                                    <strong>Tipo:</strong> {{ $location->type }}
                                </p>
                            </div>
                            <div class="col-md-6">
                                <h6>Fechas importantes</h6>
                                <p class="text-muted">
                                    <strong>Registrado:</strong> {{ $location->created_at->format('d/m/Y H:i') }}<br>
                                    <strong>Última actualización:</strong> {{ $location->updated_at->format('d/m/Y H:i') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    // Prepare data arrays from server-side variables
                    const programs = @json($programs ?? []);
                    const assistances = @json($assistances ?? []);

                    const typeEl = document.getElementById('assignmentType');
                    const nameEl = document.getElementById('assignmentName');

                    function clearOptions() {
                        nameEl.innerHTML = '<option value="">Seleccione...</option>';
                    }

                    function populate(list) {
                        clearOptions();
                        list.forEach(item => {
                            const opt = document.createElement('option');
                            opt.value = item.id;
                            opt.textContent = item.name;
                            nameEl.appendChild(opt);
                        });
                    }

                    typeEl && typeEl.addEventListener('change', function () {
                        const val = this.value;
                        if (val === 'program') {
                            populate(programs);
                        } else if (val === 'assistance') {
                            populate(assistances);
                        } else {
                            clearOptions();
                            nameEl.innerHTML = '<option value="">Seleccione un tipo primero</option>';
                        }
                    });

                    // Reset modal on close
                    const modalEl = document.getElementById('modalAddAssignment');
                    if (modalEl) {
                        modalEl.addEventListener('hidden.bs.modal', function () {
                            typeEl.value = '';
                            nameEl.innerHTML = '<option value="">Seleccione un tipo primero</option>';
                        });
                    }
                });
            </script>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <h5>Asignaciones</h5>

                            <div class="text-end">
                                <a href="javascript:void(0)" class="btn btn-primary d-block" data-bs-toggle="modal" data-bs-target="#modalAddAssignment">Agregar Asignación</a>
                            </div>
                        </div>

                        <!-- Modal: Agregar Asignación -->
                        <div class="modal fade" id="modalAddAssignment" tabindex="-1" aria-labelledby="modalAddAssignmentLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form method="POST" action="{{ route('dif.location_assignments.store') }}">
                                        @csrf
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modalAddAssignmentLabel">Agregar Asignación</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                        </div>
                                        <div class="modal-body">
                                            <input type="hidden" name="location_id" value="{{ $location->id }}">

                                            <div class="mb-3">
                                                <label class="form-label">Tipo</label>
                                                <select name="type" id="assignmentType" class="form-select" required>
                                                    <option value="">Seleccione...</option>
                                                    <option value="program">Programa</option>
                                                    <option value="assistance">Asistencia</option>
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Nombre</label>
                                                <select name="model_id" id="assignmentName" class="form-select" required>
                                                    <option value="">Seleccione un tipo primero</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                            <button type="submit" class="btn btn-primary">Guardar Asignación</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        
                        <hr>
                        <div class="table-responsive mb-0" >
                            <table class="table table-sm table-striped">
                                <thead>
                                    <tr>
                                        <th>Tipo</th>
                                        <th>Nombre</th>
                                        <th>Fecha y Hora</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                        
                                <tbody>
                                    @foreach($assignments as $assignment)
                                    <tr>
                                           <td>{{ class_basename($assignment->model_type) }}</td>
                                           <td>{{ optional($assignment->model)->name ?? '—' }}</td>
                                           <td class="text-muted"><i class="far fa-calendar-alt"></i> {{ Carbon\Carbon::parse($assignment->created_at)->translatedFormat('d M Y H:i a') }}</td>
                                           <td>
                                               <form method="POST" action="{{ route('dif.location_assignments.destroy', $assignment->id) }}" style="display:inline-block;">
                                                   {{ csrf_field() }}
                                                   {{ method_field('DELETE') }}
                                                   <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar esta asignación?')">Eliminar</button>
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

            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <h5>Historial y Notas</h5>

                            <div class="text-end">
                                <a href="javascript:void(0)" class="btn btn-primary d-block">Crear Nota Manual</a>
                            </div>
                        </div>

                        <!-- Modal: Crear Nota Manual -->
                        <div class="modal fade" id="createManualNoteModal" tabindex="-1" aria-labelledby="createManualNoteModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <form method="POST" action="{{ route('create.manual.notification') }}">
                                        @csrf

                                        <div class="modal-header">
                                            <h5 class="modal-title" id="createManualNoteModalLabel">Crear Nota Manual</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                        </div>

                                        <div class="modal-body">
                                            <input type="hidden" name="model_id" value="{{ $location->id }}">
                                            <input type="hidden" name="type" value="location">
                                            <input type="hidden" name="model_action" value="update">
                                            <input type="hidden" name="data" value="creó una nota interna">

                                            <div class="mb-3">
                                                <label class="form-label">Nota</label>
                                                <textarea name="note" class="form-control" rows="4" placeholder="Detalle de la nota"></textarea>
                                            </div>

                                            <small>La nota se asocia directamente a tu perfil y al registro del elemento padre.</small>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                            <button type="submit" class="btn btn-primary">Crear Nota</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Script: abrir modal desde el botón "Crear Nota Manual" -->
                        <script>
                            document.addEventListener('DOMContentLoaded', function () {
                                document.querySelectorAll('a').forEach(function (el) {
                                    if (el.textContent.trim() === 'Crear Nota Manual') {
                                        el.addEventListener('click', function (e) {
                                            e.preventDefault();
                                            var modalEl = document.getElementById('createManualNoteModal');
                                            if (modalEl && typeof bootstrap !== 'undefined') {
                                                var modal = new bootstrap.Modal(modalEl);
                                                modal.show();
                                            }
                                        });
                                    }
                                });
                            });
                        </script>

                        <hr>
                        <div class="table-responsive mb-0" >
                            <table class="table table-sm table-striped">
                                <thead>
                                    <tr>
                                        <th>Acción</th>
                                        <th>Información</th>
                                        <th>Nota</th>
                                        <th>Fecha y Hora</th>
                                    </tr>
                                </thead>
                        
                                <tbody>
                                    @foreach($logs as $log)
                                    <tr>
                                        <td>
                                            @switch($log->model_action)
                                                @case('destroy')
                                                    <i class='bx bx-minus-circle'></i> Eliminación
                                                    @break
                                    
                                                @case('update')
                                                    <i class='bx bxs-edit'></i> Actualización
                                                    @break
                        
                                                @case('create')
                                                    <i class='bx bx-check-square' ></i> Creación
                                                    @break
                                    
                                                @default
                                                    <i class='bx bx-bell' ></i> Notificación
                                            @endswitch
                                        </td>
                                        <td>{{ $log->user->name ?? 'Invitado' }} {{ $log->data }}</td>
                                        <td>{{ $log->note ?? 'n/a' }}</td>
                                        <td class="text-muted"><i class="far fa-calendar-alt"></i> {{ Carbon\Carbon::parse($log->created_at)->translatedFormat('d M Y H:i a') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
