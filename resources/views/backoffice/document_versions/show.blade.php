@extends('layouts.master')
@section('title')Intranet @endsection

@section('css')
<style>
    .field-changed {
        border: 2px solid #dc3545 !important;
        border-radius: 8px;
        background-color: rgba(220, 53, 69, 0.05);
    }
    .change-indicator {
        position: absolute;
        top: -10px;
        right: 10px;
        font-size: 0.75rem;
    }
    .field-wrapper {
        position: relative;
    }
</style>
@endsection

@section('content')
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') Backoffice @endslot
@slot('li_3') <a href="{{ route('backoffice.documents.versions', $document->id) }}">Versiones</a> @endslot
@slot('title') Detalle de Versión @endslot
@endcomponent

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-lg-8">
            <!-- Información de la Versión -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 text-white">
                        <i class="fas fa-clock me-2"></i> 
                        Versión del {{ $version->created_at->format('d/m/Y H:i:s') }}
                    </h5>
                    {!! $version->activity_type_badge !!}
                </div>
                <div class="card-body p-4">
                    <!-- Detalle de la Actividad -->
                    <div class="alert alert-info mb-4">
                        <h6 class="alert-heading"><i class="fas fa-info-circle me-2"></i> Detalle de la Actividad</h6>
                        <p class="mb-0">{{ $version->activity_detail }}</p>
                    </div>

                    @if(count($changes) > 0)
                        <div class="alert alert-warning mb-4">
                            <h6 class="alert-heading"><i class="fas fa-exclamation-triangle me-2"></i> Campos Modificados</h6>
                            <p class="mb-2">Los siguientes campos fueron modificados en esta versión:</p>
                            <ul class="mb-0">
                                @foreach($changes as $field => $change)
                                    <li><strong>{{ $change['label'] }}</strong></li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Estado del Documento en esta Versión -->
                    <h6 class="border-bottom pb-2 mb-3"><i class="fas fa-file-alt me-2 text-primary"></i> Estado del Documento</h6>

                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="field-wrapper p-3 rounded {{ isset($changes['folio']) ? 'field-changed' : 'bg-light' }}">
                                @if(isset($changes['folio']))
                                    <span class="badge bg-danger change-indicator">Modificado</span>
                                @endif
                                <small class="text-muted d-block">Folio</small>
                                <strong>{{ $snapshot['folio'] ?? '-' }}</strong>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="field-wrapper p-3 rounded {{ isset($changes['status']) ? 'field-changed' : 'bg-light' }}">
                                @if(isset($changes['status']))
                                    <span class="badge bg-danger change-indicator">Modificado</span>
                                @endif
                                <small class="text-muted d-block">Estado</small>
                                <strong>{{ ucfirst($snapshot['status'] ?? '-') }}</strong>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="field-wrapper p-3 rounded {{ isset($changes['priority']) ? 'field-changed' : 'bg-light' }}">
                                @if(isset($changes['priority']))
                                    <span class="badge bg-danger change-indicator">Modificado</span>
                                @endif
                                <small class="text-muted d-block">Prioridad</small>
                                <strong>{{ ucfirst($snapshot['priority'] ?? '-') }}</strong>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="field-wrapper p-3 rounded {{ isset($changes['subject']) ? 'field-changed' : 'bg-light' }}">
                                @if(isset($changes['subject']))
                                    <span class="badge bg-danger change-indicator">Modificado</span>
                                @endif
                                <small class="text-muted d-block">Asunto</small>
                                <strong>{{ $snapshot['subject'] ?? '-' }}</strong>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="field-wrapper p-3 rounded {{ isset($changes['sender']) ? 'field-changed' : 'bg-light' }}">
                                @if(isset($changes['sender']))
                                    <span class="badge bg-danger change-indicator">Modificado</span>
                                @endif
                                <small class="text-muted d-block">Remitente</small>
                                <strong>{{ $snapshot['sender'] ?? '-' }}</strong>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="field-wrapper p-3 rounded {{ isset($changes['requester']) ? 'field-changed' : 'bg-light' }}">
                                @if(isset($changes['requester']))
                                    <span class="badge bg-danger change-indicator">Modificado</span>
                                @endif
                                <small class="text-muted d-block">Solicitante</small>
                                <strong>{{ $snapshot['requester'] ?? '-' }}</strong>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="field-wrapper p-3 rounded {{ isset($changes['type']) ? 'field-changed' : 'bg-light' }}">
                                @if(isset($changes['type']))
                                    <span class="badge bg-danger change-indicator">Modificado</span>
                                @endif
                                <small class="text-muted d-block">Tipo</small>
                                <strong>{{ ucfirst($snapshot['type'] ?? '-') }}</strong>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="field-wrapper p-3 rounded {{ isset($changes['body']) ? 'field-changed' : 'bg-light' }}">
                                @if(isset($changes['body']))
                                    <span class="badge bg-danger change-indicator">Modificado</span>
                                @endif
                                <small class="text-muted d-block">Cuerpo del Oficio</small>
                                <div class="mt-2" style="white-space: pre-wrap;">{{ $snapshot['body'] ?? '-' }}</div>
                            </div>
                        </div>
                    </div>

                    @if(isset($snapshot['assigned_user_name']))
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="field-wrapper p-3 rounded {{ isset($changes['assigned_user_name']) ? 'field-changed' : 'bg-light' }}">
                                    @if(isset($changes['assigned_user_name']))
                                        <span class="badge bg-danger change-indicator">Modificado</span>
                                    @endif
                                    <small class="text-muted d-block">Asignado a</small>
                                    <strong>{{ $snapshot['assigned_user_name'] ?? '-' }}</strong>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="field-wrapper p-3 rounded {{ isset($changes['validations_count']) ? 'field-changed' : 'bg-light' }}">
                                    @if(isset($changes['validations_count']))
                                        <span class="badge bg-danger change-indicator">Modificado</span>
                                    @endif
                                    <small class="text-muted d-block">Validaciones</small>
                                    <strong>{{ $snapshot['validations_count'] ?? 0 }}/3</strong>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Información de la Versión -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-light">
                    <h6 class="mb-0"><i class="fas fa-info-circle me-2"></i> Información</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <small class="text-muted d-block">Tipo de Actividad</small>
                        {!! $version->activity_type_badge !!}
                    </div>
                    <div class="mb-3">
                        <small class="text-muted d-block">Modificado por</small>
                        <strong>{{ $version->modifiedByUser->name ?? 'Sistema' }}</strong>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted d-block">Fecha y Hora</small>
                        <strong>{{ $version->created_at->format('d/m/Y H:i:s') }}</strong>
                    </div>
                    @if($version->modified_field)
                        <div class="mb-3">
                            <small class="text-muted d-block">Campos Afectados</small>
                            <span class="badge bg-warning text-dark">{{ $version->modified_field_label }}</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Comparación de Cambios -->
            @if(count($changes) > 0)
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-warning text-dark">
                        <h6 class="mb-0"><i class="fas fa-exchange-alt me-2"></i> Cambios Detectados</h6>
                    </div>
                    <div class="card-body p-0">
                        <ul class="list-group list-group-flush">
                            @foreach($changes as $field => $change)
                                <li class="list-group-item">
                                    <strong class="d-block text-primary">{{ $change['label'] }}</strong>
                                    <div class="row mt-2">
                                        <div class="col-6">
                                            <small class="text-muted d-block">Anterior:</small>
                                            <span class="text-danger">{{ Str::limit($change['previous'] ?? 'Vacío', 50) }}</span>
                                        </div>
                                        <div class="col-6">
                                            <small class="text-muted d-block">Nuevo:</small>
                                            <span class="text-success">{{ Str::limit($change['current'] ?? 'Vacío', 50) }}</span>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <!-- Acciones -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light">
                    <h6 class="mb-0"><i class="fas fa-bolt me-2"></i> Acciones</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('backoffice.documents.versions', $document->id) }}" class="btn btn-outline-secondary">
                            <i class="fas fa-list me-2"></i> Ver Todas las Versiones
                        </a>
                        <a href="{{ route('backoffice.documents.show', $document->id) }}" class="btn btn-outline-primary">
                            <i class="fas fa-file-alt me-2"></i> Ver Oficio Actual
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
