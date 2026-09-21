@extends('layouts.master')
@section('title')Intranet @endsection
@section('content')
<!-- this is breadcrumbs -->
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') Fiscalización @endslot
@slot('li_3') <a href="{{ route('fiscalizacion.advertising_requests.index') }}">Solicitudes</a> @endslot
@slot('title') Solicitud {{ $fiscRequest->folio ?: '#'.$fiscRequest->id }} @endslot
@endcomponent

<div class="row layout-spacing">
    <div class="main-content">

        <!-- Header con información básica -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h4 class="mb-1">SOLICITUD {{ $fiscRequest->folio ?: '#'.$fiscRequest->id }}</h4>
                                <p class="mb-1">Permiso de Publicidad en Vía Pública</p>
                                <p class="text-muted mb-0">
                                    Solicitud #{{ $fiscRequest->id }} ·
                                    Capturada para: <strong>{{ $fiscRequest->user->name ?? '—' }}</strong>
                                </p>
                                <small class="text-muted">
                                    Creado: {{ $fiscRequest->created_at->format('d/m/Y H:i') }}
                                </small>
                            </div>
                            <div class="col-md-4 text-end">
                                <span class="badge bg-{{ $fiscRequest->status_color }} fs-6 px-3 py-2">
                                    {{ $fiscRequest->status_label }}
                                </span>
                                <br>
                                <small class="text-muted mt-2 d-block">
                                    Actualizado: {{ $fiscRequest->updated_at->format('d/m/Y H:i') }}
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Información Principal -->
            <div class="col-md-8">

                <!-- Información del Solicitante -->
                <div class="card mb-3">
                    <div class="card-header bg-primary text-white">
                        <h6 class="mb-0 text-white">Información del Solicitante</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <small class="text-muted">Nombre:</small>
                                <p class="mb-0">{{ $fiscRequest->user->name ?? '—' }}</p>
                            </div>
                            <div class="col-md-4 mb-3">
                                <small class="text-muted">Correo Electrónico:</small>
                                <p class="mb-0">{{ $fiscRequest->user->email ?? '—' }}</p>
                            </div>
                            <div class="col-md-4 mb-3">
                                <small class="text-muted">Fecha de Registro:</small>
                                <p class="mb-0">{{ optional($fiscRequest->user->created_at ?? null)->format('d/m/Y') ?? '—' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Formato de Solicitud -->
                <div class="card mb-3">
                    <div class="card-header text-white" style="background-color:#0d6e6e;">
                        <h6 class="mb-0 text-white">Formato de Solicitud</h6>
                    </div>
                    <div class="card-body">
                        <div class="accordion" id="requestAccordion">

                            <!-- DATOS DE LA PUBLICIDAD -->
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDatos">
                                        Datos de la Publicidad
                                    </button>
                                </h2>
                                <div id="collapseDatos" class="accordion-collapse collapse show" data-bs-parent="#requestAccordion">
                                    <div class="accordion-body">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <small class="text-muted">Tipo de Publicidad:</small>
                                                <p class="mb-0">{{ $fiscRequest->advertising_type }}</p>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <small class="text-muted">Piezas Autorizadas:</small>
                                                <p class="mb-0">{{ $fiscRequest->authorized_pieces ?: '—' }}</p>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <small class="text-muted">Ubicaciones autorizadas:</small>
                                                <p class="mb-0">{{ $fiscRequest->authorized_locations ?: '—' }}</p>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <small class="text-muted">Periodo autorizado:</small>
                                                <p class="mb-0">{{ $fiscRequest->authorized_period ?: '—' }}</p>
                                            </div>
                                            <div class="col-12 mb-3">
                                                <small class="text-muted">Descripción de la publicidad:</small>
                                                <p class="mb-0">{{ $fiscRequest->description ?: '—' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- Lista de Verificación de Documentos -->
                <div class="card mb-3">
                    <div class="card-header bg-success text-white">
                        <h6 class="mb-0 text-white">
                            <i class="fas fa-check-circle"></i> Lista de Verificación de Documentos
                        </h6>
                    </div>
                    <div class="card-body">
                        @php
                            $requiredDocs = [
                                'comprobante-pago' => 'Comprobante de pago',
                            ];

                            $uploadedFilesByType = [];
                            foreach ($fiscRequest->files as $file) {
                                if ($file->slug) {
                                    $uploadedFilesByType[$file->slug] = $file;
                                }
                            }
                        @endphp

                        @foreach ($requiredDocs as $slug => $title)
                            @php $isUploaded = isset($uploadedFilesByType[$slug]); @endphp
                            <div class="d-flex align-items-center mb-2 p-2 border rounded {{ $isUploaded ? 'border-success bg-success bg-opacity-10' : 'border-warning bg-warning bg-opacity-10' }}">
                                <i class="fas fa-{{ $isUploaded ? 'check-circle text-success' : 'clock text-warning' }} me-2"></i>
                                <div class="flex-grow-1">
                                    <div class="fw-medium">{{ strtoupper($title) }}</div>
                                    <small class="text-muted">
                                        {{ $isUploaded ? 'Documento subido' : 'Pendiente de subir' }}
                                        @if ($isUploaded)
                                            · {{ $uploadedFilesByType[$slug]->created_at->format('d/m/Y H:i') }}
                                        @endif
                                    </small>
                                </div>
                                @if ($isUploaded)
                                    <a href="{{ $uploadedFilesByType[$slug]->s3_asset_url }}" target="_blank" class="btn btn-sm btn-outline-success">
                                        <i class="fas fa-eye"></i> Ver
                                    </a>
                                @endif
                            </div>
                        @endforeach

                        @php
                            $totalRequired = count($requiredDocs);
                            $totalUploaded = count(array_intersect_key($uploadedFilesByType, $requiredDocs));
                            $completionPercentage = $totalRequired > 0 ? round(($totalUploaded / $totalRequired) * 100) : 0;
                        @endphp

                        <div class="progress mb-2" style="height: 20px;">
                            <div class="progress-bar bg-{{ $completionPercentage == 100 ? 'success' : ($completionPercentage >= 50 ? 'warning' : 'danger') }}"
                                role="progressbar" style="width: {{ $completionPercentage }}%">
                                {{ $completionPercentage }}%
                            </div>
                        </div>
                        <div class="text-center">
                            <small class="text-muted">{{ $totalUploaded }}/{{ $totalRequired }} documentos subidos</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Panel de Control -->
            <div class="col-md-4">
                <!-- Gestión de Estatus -->
                <div class="card">
                    <div class="card-header bg-warning">
                        <h6 class="mb-0">Gestión de Estatus</h6>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('fiscalizacion.advertising_requests.update_status', $fiscRequest) }}">
                            @csrf

                            <div class="mb-3">
                                <label for="status" class="form-label">Cambiar Estatus:</label>
                                <select name="status" id="status" class="form-select" required>
                                    <option value="nueva_solicitud" {{ $fiscRequest->status == 'nueva_solicitud' ? 'selected' : '' }}>Nuevo</option>
                                    <option value="inspeccion" {{ $fiscRequest->status == 'inspeccion' ? 'selected' : '' }}>Inspección</option>
                                    <option value="aprobada" {{ $fiscRequest->status == 'aprobada' ? 'selected' : '' }}>Aprobada</option>
                                    <option value="denegada" {{ $fiscRequest->status == 'denegada' ? 'selected' : '' }}>Denegada</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-save"></i> Actualizar Estatus
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Detalles de la Solicitud -->
                <div class="card mt-3">
                    <div class="card-header">
                        <h6 class="mb-0">Detalles de la Solicitud</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-2">
                            <small class="text-muted">ID de Solicitud:</small>
                            <p class="mb-1">{{ $fiscRequest->folio ?: '#'.$fiscRequest->id }}</p>
                        </div>
                        <div class="mb-2">
                            <small class="text-muted">Tipo de Trámite:</small>
                            <p class="mb-1">Permiso de Publicidad en Vía Pública</p>
                        </div>
                        <div class="mb-2">
                            <small class="text-muted">Fecha de creación:</small>
                            <p class="mb-1">{{ $fiscRequest->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        <div class="mb-0">
                            <small class="text-muted">Última Actualización:</small>
                            <p class="mb-0">{{ $fiscRequest->updated_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Resumen de Archivos -->
                <div class="card mt-3">
                    <div class="card-header text-white" style="background-color:#6f42c1;">
                        <h6 class="mb-0 text-white">
                            <i class="fas fa-folder-open"></i> Resumen de Archivos
                        </h6>
                    </div>
                    <div class="card-body p-0">
                        @if ($fiscRequest->files->count() > 0)
                            <table class="table table-hover mb-0">
                                <tbody>
                                    @foreach ($fiscRequest->files as $file)
                                        <tr>
                                            <td>
                                                <div class="fw-medium">{{ $file->name }}</div>
                                                <small class="text-muted">{{ $file->formatted_size }}</small>
                                            </td>
                                            <td class="text-end">
                                                @if ($file->s3_asset_url)
                                                    <a href="{{ $file->s3_asset_url }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="text-center text-muted py-4">
                                <p class="mb-0">No hay archivos adjuntos</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Acciones Administrativas -->
                <div class="card mt-3">
                    <div class="card-header bg-dark text-white">
                        <h6 class="mb-0 text-white">Acciones Administrativas</h6>
                    </div>
                    <div class="card-body d-flex flex-column gap-2">
                        <a href="{{ route('fiscalizacion.advertising_requests.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Volver al Listado
                        </a>
                        @if ($fiscRequest->user && $fiscRequest->user->email)
                            <a href="mailto:{{ $fiscRequest->user->email }}" class="btn btn-outline-dark">
                                <i class="fas fa-envelope"></i> Contactar al Solicitante
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
