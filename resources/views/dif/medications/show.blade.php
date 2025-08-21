@extends('layouts.master')
@section('title')Intranet @endsection
@section('content')
<!-- this is breadcrumbs -->
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') DIF @endslot
@slot('title') Medicamento: {{ $medication->generic_name }} @endslot
@endcomponent

<div class="row layout-spacing">
    <div class="main-content">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $medication->generic_name }}</h5>

                        <p class="card-text"><strong>Nombre comercial:</strong> {{ $medication->commercial_name ?? 'N/A' }}</p>

                        <div class="mb-3">
                            @if($medication->is_active)
                                <span class="badge bg-success">Activo</span>
                            @else
                                <span class="badge bg-danger">Inactivo</span>
                            @endif
                        </div>

                        @if($medication->description)
                            <p class="card-text"><strong>Descripción:</strong></p>
                            <p class="card-text">{{ $medication->description }}</p>
                        @endif

                        @if($medication->formula)
                            <p class="card-text"><strong>Fórmula:</strong></p>
                            <p class="card-text">{{ $medication->formula }}</p>
                        @endif

                        <hr>

                        <div class="d-flex gap-2" role="group" aria-label="Basic example">
                            <a href="{{ route('dif.medications.edit', $medication->id) }}" class="btn btn-sm btn-secondary">Editar</a>
                            <form method="POST" action="{{ route('dif.medications.destroy', $medication->id) }}" style="display: inline-block;">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de que deseas eliminar este medicamento?')">
                                    Eliminar
                                </button>
                            </form>
                            <a href="{{ route('dif.medications.index') }}" class="btn btn-sm btn-primary">Volver al listado</a>
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
                                <h6>Presentación</h6>
                                <p class="text-muted">
                                    {{ $medication->type ?? 'N/A' }} {{ $medication->type_num ? ' - ' . $medication->type_num : '' }} {{ $medication->type_dosage ?? '' }}
                                </p>
                            </div>
                            <div class="col-md-6">
                                <h6>Vía de administración</h6>
                                <p class="text-muted">{{ $medication->use_type ?? 'N/A' }}</p>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-md-6">
                                <h6>Fechas</h6>
                                @php
                                    $exp = \Carbon\Carbon::parse($medication->expiration_date);
                                    $isExpired = $exp->lt(\Carbon\Carbon::now());
                                    $isSoon = !$isExpired && $exp->lte(\Carbon\Carbon::now()->addMonth());
                                @endphp
                                
                                <p class="text-muted">
                                    <strong>Expira:</strong>
                                    @if($isExpired)
                                        <span class="text-danger fw-bold">{{ $exp->format('d/m/Y') }}</span>
                                        <span class="badge bg-danger ms-2">Vencido</span>
                                    @elseif($isSoon)
                                        <span class="text-danger fw-bold">{{ $exp->format('d/m/Y') }}</span>
                                        <span class="badge bg-danger ms-2">Caduca pronto</span>
                                    @else
                                        {{ $exp->format('d/m/Y') }}
                                    @endif
                                </p>
                            </div>
                            <div class="col-md-6">
                                <h6>Metadatos</h6>
                                <p class="text-muted">
                                    <strong>Registrado:</strong> {{ $medication->created_at->format('d/m/Y H:i') }}<br>
                                    <strong>Última actualización:</strong> {{ $medication->updated_at->format('d/m/Y H:i') }}
                                </p>
                            </div>
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
                                            <input type="hidden" name="model_id" value="{{ $medication->id }}">
                                            <input type="hidden" name="type" value="medication">
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
