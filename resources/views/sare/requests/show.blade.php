@extends('layouts.master')
@section('title')Intranet @endsection
@section('content')
<!-- this is breadcrumbs -->
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') SARE @endslot
@slot('li_3') <a href="{{ route('sare.request.index') }}">Solicitudes</a> @endslot
@slot('title') Solicitud #{{ $sareRequest->request_num }} @endslot
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
                                <h4 class="mb-1">{{ $sareRequest->commercial_name }}</h4>
                                <p class="text-muted mb-0">
                                    Solicitud #{{ $sareRequest->request_num }} • 
                                    Solicitado por: <strong>{{ $sareRequest->user->name }}</strong>
                                </p>
                                <small class="text-muted">
                                    Creado: {{ $sareRequest->created_at->format('d/m/Y H:i') }}
                                </small>
                            </div>
                            <div class="col-md-4 text-end">
                                <span class="badge bg-{{ $sareRequest->status_color }} fs-6 px-3 py-2">
                                    {{ $sareRequest->status_label }}
                                </span>
                                <br>
                                <small class="text-muted mt-2 d-block">
                                    Actualizado: {{ $sareRequest->updated_at->format('d/m/Y H:i') }}
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
                <div class="card">
                    <div class="card-body">
                        <!-- Información General -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="border-bottom pb-2 mb-3">Información General</h5>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <small class="text-muted">Número de Solicitud:</small>
                                <p class="mb-0"><strong>{{ $sareRequest->request_num }}</strong></p>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <small class="text-muted">Fecha de Solicitud:</small>
                                <p class="mb-0">{{ $sareRequest->request_date }}</p>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <small class="text-muted">Número Catastral:</small>
                                <p class="mb-0">{{ $sareRequest->catastral_num }}</p>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <small class="text-muted">Tipo de Solicitud:</small>
                                <p class="mb-0">
                                    @switch($sareRequest->request_type)
                                        @case('general')
                                            General
                                            @break
                                        @case('nuevo')
                                            Nuevo
                                            @break
                                        @case('renovacion')
                                            Renovación
                                            @break
                                        @case('anuncio')
                                            Anuncio
                                            @break
                                        @default
                                            {{ $sareRequest->request_type }}
                                    @endswitch
                                </p>
                            </div>
                            
                            @if($sareRequest->description)
                            <div class="col-12 mb-3">
                                <small class="text-muted">Descripción:</small>
                                <p class="mb-0">{{ $sareRequest->description }}</p>
                            </div>
                            @endif
                        </div>

                        <!-- Datos del Solicitante -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="border-bottom pb-2 mb-3">Datos del Solicitante</h5>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <small class="text-muted">Nombre/Razón Social:</small>
                                <p class="mb-0">{{ $sareRequest->rfc_name }}</p>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <small class="text-muted">RFC:</small>
                                <p class="mb-0">{{ $sareRequest->rfc_num }}</p>
                            </div>

                            <div class="col-md-6 mb-3">
                                <small class="text-muted">Tipo de Persona:</small>
                                <p class="mb-0">
                                    {{ $sareRequest->person_type == 'moral' ? 'Persona Moral' : ($sareRequest->person_type == 'fisica' ? 'Persona Física' : '—') }}
                                </p>
                            </div>

                            <div class="col-md-6 mb-3">
                                <small class="text-muted">Propietario:</small>
                                <p class="mb-0">{{ $sareRequest->property_owner }}</p>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <small class="text-muted">Teléfono Oficina:</small>
                                <p class="mb-0">{{ $sareRequest->office_phone }}</p>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <small class="text-muted">Teléfono Móvil:</small>
                                <p class="mb-0">{{ $sareRequest->mobile_phone }}</p>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <small class="text-muted">Email:</small>
                                <p class="mb-0">{{ $sareRequest->email }}</p>
                            </div>
                        </div>

                        @if($sareRequest->legal_representative_name)
                        <!-- Datos del Representante Legal -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="border-bottom pb-2 mb-3">Representante Legal</h5>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <small class="text-muted">Nombre:</small>
                                <p class="mb-0">{{ $sareRequest->legal_representative_name }}</p>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <small class="text-muted">Apellido Paterno:</small>
                                <p class="mb-0">{{ $sareRequest->legal_representative_father_last_name }}</p>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <small class="text-muted">Apellido Materno:</small>
                                <p class="mb-0">{{ $sareRequest->legal_representative_mother_last_name }}</p>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <small class="text-muted">Teléfono Oficina:</small>
                                <p class="mb-0">{{ $sareRequest->legal_representative_office_phone }}</p>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <small class="text-muted">Teléfono Móvil:</small>
                                <p class="mb-0">{{ $sareRequest->legal_representative_mobile_phone }}</p>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <small class="text-muted">Email:</small>
                                <p class="mb-0">{{ $sareRequest->legal_representative_email }}</p>
                            </div>
                        </div>
                        @endif

                        <!-- Responsable del Establecimiento -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="border-bottom pb-2 mb-3">Responsable del Establecimiento</h5>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <small class="text-muted">Causa Legal:</small>
                                <p class="mb-0">{{ $sareRequest->establishment_legal_cause }}</p>
                            </div>
                            
                            @if($sareRequest->establishment_legal_cause_addon)
                            <div class="col-md-6 mb-3">
                                <small class="text-muted">Especificación:</small>
                                <p class="mb-0">{{ $sareRequest->establishment_legal_cause_addon }}</p>
                            </div>
                            @endif
                            
                            <div class="col-md-6 mb-3">
                                <small class="text-muted">Cláusula de Buena Fe:</small>
                                <p class="mb-0">{{ $sareRequest->establishment_good_faith_clause }}</p>
                            </div>
                        </div>

                        <!-- Domicilio del Establecimiento -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="border-bottom pb-2 mb-3">Domicilio del Establecimiento</h5>
                            </div>
                            
                            <div class="col-12 mb-3">
                                <small class="text-muted">Dirección Completa:</small>
                                <p class="mb-0">
                                    {{ $sareRequest->establishment_address_street }} 
                                    {{ $sareRequest->establishment_address_number }}, 
                                    {{ $sareRequest->establishment_address_neighborhood }}, 
                                    {{ $sareRequest->establishment_address_municipality }}, 
                                    {{ $sareRequest->establishment_address_state }} 
                                    {{ $sareRequest->establishment_address_postal_code }}
                                </p>
                            </div>
                        </div>

                        <!-- Datos del Uso de la Edificación -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="border-bottom pb-2 mb-3">Datos del Negocio</h5>
                            </div>
                            
                            @if($sareRequest->establishment_use)
                            <div class="col-md-6 mb-3">
                                <small class="text-muted">Uso del Establecimiento:</small>
                                <p class="mb-0">{{ $sareRequest->establishment_use }}</p>
                            </div>
                            @endif
                            
                            <div class="col-md-6 mb-3">
                                <small class="text-muted">Nombre Comercial:</small>
                                <p class="mb-0">{{ $sareRequest->commercial_name }}</p>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <small class="text-muted">Inversión Aproximada:</small>
                                <p class="mb-0">{{ $sareRequest->aprox_investment }}</p>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <small class="text-muted">Empleos a Generar:</small>
                                <p class="mb-0">{{ $sareRequest->jobs_to_generate }}</p>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <small class="text-muted">En Operación:</small>
                                <p class="mb-0">{{ $sareRequest->is_location_in_operation ? 'Sí' : 'No' }}</p>
                            </div>
                            
                            @if($sareRequest->operation_start_date)
                            <div class="col-md-6 mb-3">
                                <small class="text-muted">Fecha de Inicio:</small>
                                <p class="mb-0">{{ $sareRequest->operation_start_date }}</p>
                            </div>
                            @endif
                            
                            @if($sareRequest->business_hours)
                            <div class="col-md-6 mb-3">
                                <small class="text-muted">Horario de Operación:</small>
                                <p class="mb-0">{{ $sareRequest->business_hours }}</p>
                            </div>
                            @endif
                        </div>

                        <!-- Zonificación -->
                        @if($sareRequest->zoning_front || $sareRequest->zoning_rear || $sareRequest->zoning_left || $sareRequest->zoning_right)
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="border-bottom pb-2 mb-3">Zonificación</h5>
                            </div>
                            
                            @if($sareRequest->zoning_front)
                            <div class="col-md-6 mb-3">
                                <small class="text-muted">Frente:</small>
                                <p class="mb-0">{{ $sareRequest->zoning_front }}</p>
                            </div>
                            @endif
                            
                            @if($sareRequest->zoning_rear)
                            <div class="col-md-6 mb-3">
                                <small class="text-muted">Fondo:</small>
                                <p class="mb-0">{{ $sareRequest->zoning_rear }}</p>
                            </div>
                            @endif
                            
                            @if($sareRequest->zoning_left)
                            <div class="col-md-6 mb-3">
                                <small class="text-muted">Izquierda:</small>
                                <p class="mb-0">{{ $sareRequest->zoning_left }}</p>
                            </div>
                            @endif
                            
                            @if($sareRequest->zoning_right)
                            <div class="col-md-6 mb-3">
                                <small class="text-muted">Derecha:</small>
                                <p class="mb-0">{{ $sareRequest->zoning_right }}</p>
                            </div>
                            @endif
                        </div>
                        @endif

                        <!-- Información Municipal -->
                        @if($sareRequest->license_num || $sareRequest->entry_date || $sareRequest->exit_date || $sareRequest->document_type)
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="border-bottom pb-2 mb-3">Información Municipal</h5>
                            </div>
                            
                            @if($sareRequest->license_num)
                            <div class="col-md-6 mb-3">
                                <small class="text-muted">Número de Licencia:</small>
                                <p class="mb-0">{{ $sareRequest->license_num }}</p>
                            </div>
                            @endif
                            
                            @if($sareRequest->document_type)
                            <div class="col-md-6 mb-3">
                                <small class="text-muted">Tipo de Documento:</small>
                                <p class="mb-0">{{ $sareRequest->document_type }}</p>
                            </div>
                            @endif
                            
                            @if($sareRequest->entry_date)
                            <div class="col-md-6 mb-3">
                                <small class="text-muted">Fecha de Ingreso:</small>
                                <p class="mb-0">{{ $sareRequest->entry_date->format('d/m/Y H:i') }}</p>
                            </div>
                            @endif
                            
                            @if($sareRequest->exit_date)
                            <div class="col-md-6 mb-3">
                                <small class="text-muted">Fecha de Resolución:</small>
                                <p class="mb-0">{{ $sareRequest->exit_date->format('d/m/Y H:i') }}</p>
                            </div>
                            @endif
                            
                            <div class="col-md-6 mb-3">
                                <small class="text-muted">VoBo Favorable:</small>
                                <p class="mb-0">{{ $sareRequest->vobo_favorable ? 'Sí' : 'No' }}</p>
                            </div>
                        </div>
                        @endif

                        <!-- Dictámenes de otras dependencias -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="border-bottom pb-2 mb-3">Dictámenes de otras dependencias</h5>
                            </div>
                            <div class="col-12">
                                <div class="d-flex justify-content-between align-items-center border rounded p-3">
                                    <div>
                                        <strong>Desarrollo Urbano</strong> — Solicitud de Inspección
                                        @if($review && $review->sent_at)
                                            <br>
                                            <small class="text-muted">
                                                Enviado a Desarrollo Urbano el {{ $review->sent_at->format('d/m/Y H:i') }}
                                                — <span class="badge bg-{{ $review->status_color }}">{{ $review->status_label }}</span>
                                            </small>
                                        @endif
                                    </div>
                                    <div>
                                        @if(!$review)
                                            <form method="POST" action="{{ route('sare.request.send_to_urban_dev', $sareRequest) }}">
                                                @csrf
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="fas fa-paper-plane"></i> Enviar solicitud a Desarrollo Urbano
                                                </button>
                                            </form>
                                        @else
                                            <a href="{{ route('urban_dev.sare_requests.show', $review) }}" class="btn btn-outline-primary">
                                                <i class="fas fa-external-link-alt"></i> Ver en Desarrollo Urbano
                                            </a>
                                        @endif
                                    </div>
                                </div>

                                @if($review && $review->inspection_date)
                                    <div class="card border-0 shadow-sm mt-3">
                                        <div class="card-header bg-inspection text-white">
                                            <h5 class="text-white mb-0 fw-bold">Inspección</h5>
                                        </div>
                                        <div class="card-body p-4">
                                            <div class="border rounded p-3 mb-3">
                                                <strong>
                                                    {{ $review->inspector ? $review->inspector->name . ' ' . $review->inspector->last_name : '—' }}
                                                </strong>
                                            </div>

                                            @if($review->photos->count() > 0)
                                                <small class="text-muted text-uppercase fw-semibold d-block mb-2">Reporte Fotográfico</small>
                                                <div class="row mb-4">
                                                    @foreach($review->photos as $photo)
                                                        <div class="col-3 mb-2">
                                                            <a href="javascript:void(0)" onclick="previewImage('{{ $photo->s3_asset_url }}')">
                                                                <img src="{{ $photo->s3_asset_url }}" class="img-thumbnail w-100" style="aspect-ratio: 1 / 1; object-fit: cover;" alt="{{ $photo->filename }}">
                                                            </a>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif

                                            <small class="text-muted text-uppercase fw-semibold d-block mb-2">Capturado por el Inspector</small>
                                            <div class="row g-2">
                                                <div class="col-md-6">
                                                    <div class="d-flex align-items-center border rounded overflow-hidden">
                                                        <span class="bg-warning-subtle px-3 py-2 fw-medium">Superficie medida en sitio</span>
                                                        <span class="px-3 py-2">{{ $review->measured_area ?: '—' }}</span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="d-flex align-items-center border rounded overflow-hidden">
                                                        <span class="bg-warning-subtle px-3 py-2 fw-medium">Observaciones</span>
                                                        <span class="px-3 py-2">{{ $review->observations ?: '—' }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Botones de Acción -->
                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex gap-2">
                                    <a href="{{ route('sare.request.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-arrow-left"></i> Volver al Listado
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Panel de Control -->
            <div class="col-md-4">
                <!-- Cambio de Estatus -->
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0">Gestión de Estatus</h6>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('sare.request.update', $sareRequest) }}">
                            @csrf
                            @method('PUT')
                            
                            <div class="mb-3">
                                <label for="status" class="form-label">Cambiar Estatus:</label>
                                <select name="status" id="status" class="form-select" required>
                                    <option value="new" {{ $sareRequest->status == 'new' ? 'selected' : '' }}>Nuevo</option>
                                    <option value="initial_review" {{ $sareRequest->status == 'initial_review' ? 'selected' : '' }}>Revisión Inicial</option>
                                    <option value="requirement_validation" {{ $sareRequest->status == 'requirement_validation' ? 'selected' : '' }}>Validación de Requisitos</option>
                                    <option value="requires_correction" {{ $sareRequest->status == 'requires_correction' ? 'selected' : '' }}>Requiere Corrección</option>
                                    <option value="payment_pending" {{ $sareRequest->status == 'payment_pending' ? 'selected' : '' }}>Espera de Pago</option>
                                    <option value="authorization_process" {{ $sareRequest->status == 'authorization_process' ? 'selected' : '' }}>Proceso de Autorización</option>
                                    <option value="authorized" {{ $sareRequest->status == 'authorized' ? 'selected' : '' }}>Autorizada</option>
                                    <option value="rejected" {{ $sareRequest->status == 'rejected' ? 'selected' : '' }}>Rechazada</option>
                                </select>
                            </div>
                            
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-save"></i> Actualizar Estatus
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Archivos Adjuntos -->
                @if($sareRequest->files->count() > 0)
                <div class="card mt-3">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">
                            <i class="fas fa-folder-open"></i> 
                            Documentos Adjuntos ({{ $sareRequest->files->count() }})
                        </h6>
                        <small class="text-muted">
                            Total: {{ $sareRequest->files->sum('file_size') > 0 ? number_format($sareRequest->files->sum('file_size') / 1024 / 1024, 2) . ' MB' : 'N/A' }}
                        </small>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 30%;">Tipo de Documento</th>
                                        <th style="width: 30%;">Nombre del Archivo</th>
                                        <th style="width: 15%;">Tamaño</th>
                                        <th style="width: 15%;">Fecha</th>
                                        <th style="width: 10%;" class="text-center">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($sareRequest->files as $file)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @php
                                                    $iconMap = [
                                                        'pdf' => 'pdf',
                                                        'doc' => 'word', 
                                                        'docx' => 'word',
                                                        'jpg' => 'image',
                                                        'jpeg' => 'image', 
                                                        'png' => 'image',
                                                        'gif' => 'image',
                                                        'zip' => 'archive',
                                                        'rar' => 'archive'
                                                    ];
                                                    $icon = $iconMap[strtolower($file->file_extension)] ?? 'alt';
                                                @endphp
                                                <i class="fas fa-file-{{ $icon }} text-primary me-2"></i>
                                                <div>
                                                    <div class="fw-medium">
                                                        {{ $file->name ?: 'Documento' }}
                                                    </div>
                                                    @if($file->slug)
                                                    <small class="text-muted">{{ ucfirst(str_replace('-', ' ', $file->slug)) }}</small>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="fw-medium">{{ $file->file_name ?: $file->filename }}</div>
                                            <small class="text-muted">{{ $file->filename }}</small>
                                        </td>
                                        <td>
                                            <span class="badge bg-light text-dark">
                                                {{ $file->formatted_size }}
                                            </span>
                                        </td>
                                        <td>
                                            <small class="text-muted">
                                                {{ $file->created_at->format('d/m/Y') }}<br>
                                                {{ $file->created_at->format('H:i') }}
                                            </small>
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group" role="group">
                                                @if($file->s3_asset_url)
                                                <a href="{{ $file->s3_asset_url }}" 
                                                   target="_blank" 
                                                   class="btn btn-sm btn-outline-primary" 
                                                   title="Ver archivo"
                                                   data-bs-toggle="tooltip">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ $file->s3_asset_url }}" 
                                                   download="{{ $file->file_name ?: $file->filename }}"
                                                   class="btn btn-sm btn-outline-success" 
                                                   title="Descargar archivo"
                                                   data-bs-toggle="tooltip">
                                                    <i class="fas fa-download"></i>
                                                </a>
                                                <button type="button" 
                                                        class="btn btn-sm btn-outline-info" 
                                                        onclick="copyFileUrl('{{ $file->s3_asset_url }}', '{{ $file->file_name ?: $file->filename }}')"
                                                        title="Copiar URL"
                                                        data-bs-toggle="tooltip">
                                                    <i class="fas fa-copy"></i>
                                                </button>
                                                @else
                                                <span class="badge bg-warning">
                                                    <i class="fas fa-exclamation-triangle"></i> Sin URL
                                                </span>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row align-items-center">
                            <div class="col">
                                <small class="text-muted">
                                    <i class="fas fa-info-circle"></i> 
                                    Los archivos se almacenan de forma segura en Amazon S3
                                </small>
                            </div>
                            <div class="col-auto">
                                <button type="button" class="btn btn-sm btn-outline-secondary" onclick="downloadAllFiles()">
                                    <i class="fas fa-download"></i> Descargar Todos
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                @else
                <div class="card mt-3">
                    <div class="card-header">
                        <h6 class="mb-0">
                            <i class="fas fa-folder-open"></i> 
                            Documentos Adjuntos
                        </h6>
                    </div>
                    <div class="card-body text-center text-muted py-4">
                        <i class="fas fa-file-circle-exclamation fa-2x mb-3"></i>
                        <p class="mb-0">No se han subido documentos para esta solicitud</p>
                        <small>Los documentos aparecerán aquí una vez que el solicitante los suba</small>
                    </div>
                </div>
                @endif

                <!-- Lista de Verificación de Documentos -->
                <div class="card mt-3">
                    <div class="card-header">
                        <h6 class="mb-0">
                            <i class="fas fa-check-circle"></i> 
                            Lista de Verificación de Documentos
                        </h6>
                    </div>
                    <div class="card-body">
                        @php
                            $requiredDocs = [
                                'documento-propiedad' => 'Documento que acredite propiedad del inmueble',
                                'id-solicitante' => 'Identificación oficial del solicitante',
                                'id-propietario' => 'Identificación oficial del propietario',
                                'comprobante-domicilio' => 'Comprobante de domicilio (no mayor a 2 meses)',
                                'pago-predial' => 'Pago predial del presente año'
                            ];
                            
                            $moralDocs = [
                                'acta-constitutiva' => 'Acta constitutiva de la Empresa',
                                'poder-representante' => 'Poder simple o notariado del representante legal'
                            ];
                            
                            // Crear mapa de archivos subidos
                            $uploadedFilesByType = [];
                            foreach($sareRequest->files as $file) {
                                if ($file->slug) {
                                    $uploadedFilesByType[$file->slug] = $file;
                                }
                            }
                        @endphp
                        
                        <div class="mb-4">
                            <h6 class="text-primary mb-3">Documentos Requeridos:</h6>
                            @foreach($requiredDocs as $slug => $title)
                                @php $isUploaded = isset($uploadedFilesByType[$slug]); @endphp
                                <div class="d-flex align-items-center mb-2 p-2 border rounded {{ $isUploaded ? 'border-success bg-success bg-opacity-10' : 'border-warning bg-warning bg-opacity-10' }}">
                                    <i class="fas fa-{{ $isUploaded ? 'check-circle text-success' : 'clock text-warning' }} me-2"></i>
                                    <div class="flex-grow-1">
                                        <div class="fw-medium">{{ $title }}</div>
                                        <small class="text-muted">
                                            {{ $isUploaded ? 'Documento subido' : 'Pendiente de subir' }}
                                            @if($isUploaded)
                                                • {{ $uploadedFilesByType[$slug]->created_at->format('d/m/Y H:i') }}
                                            @endif
                                        </small>
                                    </div>
                                    @if($isUploaded)
                                        <a href="{{ $uploadedFilesByType[$slug]->s3_asset_url }}" 
                                           target="_blank" 
                                           class="btn btn-sm btn-outline-success">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                        
                        <div class="mb-3">
                            <h6 class="text-warning mb-3">Documentos para Persona Moral (Opcionales):</h6>
                            @foreach($moralDocs as $slug => $title)
                                @php $isUploaded = isset($uploadedFilesByType[$slug]); @endphp
                                <div class="d-flex align-items-center mb-2 p-2 border rounded {{ $isUploaded ? 'border-success bg-success bg-opacity-10' : 'border-light' }}">
                                    <i class="fas fa-{{ $isUploaded ? 'check-circle text-success' : 'circle text-muted' }} me-2"></i>
                                    <div class="flex-grow-1">
                                        <div class="fw-medium">{{ $title }}</div>
                                        <small class="text-muted">
                                            {{ $isUploaded ? 'Documento subido' : 'Opcional' }}
                                            @if($isUploaded)
                                                • {{ $uploadedFilesByType[$slug]->created_at->format('d/m/Y H:i') }}
                                            @endif
                                        </small>
                                    </div>
                                    @if($isUploaded)
                                        <a href="{{ $uploadedFilesByType[$slug]->s3_asset_url }}" 
                                           target="_blank" 
                                           class="btn btn-sm btn-outline-success">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                        
                        @php
                            $totalRequired = count($requiredDocs);
                            $totalUploaded = count(array_intersect_key($uploadedFilesByType, $requiredDocs));
                            $completionPercentage = $totalRequired > 0 ? round(($totalUploaded / $totalRequired) * 100) : 0;
                        @endphp
                        
                        <div class="progress mb-2" style="height: 20px;">
                            <div class="progress-bar bg-{{ $completionPercentage == 100 ? 'success' : ($completionPercentage >= 50 ? 'warning' : 'danger') }}" 
                                 role="progressbar" 
                                 style="width: {{ $completionPercentage }}%">
                                {{ $completionPercentage }}% Completo
                            </div>
                        </div>
                        
                        <div class="text-center">
                            <small class="text-muted">
                                {{ $totalUploaded }} de {{ $totalRequired }} documentos requeridos subidos
                            </small>
                        </div>
                    </div>
                </div>

                <!-- Información de Usuario -->
                <div class="card mt-3">
                    <div class="card-header">
                        <h6 class="mb-0">Información del Usuario</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-2">
                            <small class="text-muted">Nombre:</small>
                            <p class="mb-1">{{ $sareRequest->user->name }}</p>
                        </div>
                        <div class="mb-2">
                            <small class="text-muted">Email:</small>
                            <p class="mb-1">{{ $sareRequest->user->email }}</p>
                        </div>
                        <div class="mb-2">
                            <small class="text-muted">Fecha de Registro:</small>
                            <p class="mb-0">{{ $sareRequest->user->created_at->format('d/m/Y') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Permiso y entero de pago Desarrollo Urbano -->
                @if($review && ($review->permit_document_s3_url || $review->payment_document_s3_url))
                <div class="card mt-3">
                    <div class="card-header">
                        <h6 class="mb-0">
                            <i class="fas fa-file-contract"></i>
                            Permiso y entero de pago Desarrollo
                        </h6>
                    </div>
                    <div class="card-body">
                        @if($review->permit_document_s3_url)
                        <div class="d-flex align-items-center justify-content-between border rounded p-2 mb-2">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-file-pdf text-danger me-2"></i>
                                <div>
                                    <div class="fw-medium">{{ $review->permit_document_name }}</div>
                                    <small class="text-muted">Permiso sellado y firmado · {{ $review->permit_formatted_size }}</small>
                                </div>
                            </div>
                            <div class="btn-group" role="group">
                                <a href="{{ $review->permit_document_s3_url }}" target="_blank" class="btn btn-sm btn-outline-primary" title="Ver archivo">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ $review->permit_document_s3_url }}" download="{{ $review->permit_document_name }}" class="btn btn-sm btn-outline-success" title="Descargar archivo">
                                    <i class="fas fa-download"></i>
                                </a>
                            </div>
                        </div>
                        @endif

                        @if($review->payment_document_s3_url)
                        <div class="d-flex align-items-center justify-content-between border rounded p-2">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-file-invoice-dollar text-success me-2"></i>
                                <div>
                                    <div class="fw-medium">Entero de pago - ${{ number_format($review->payment_amount, 2) }} MXN</div>
                                    <small class="text-muted">Línea de captura {{ $review->payment_reference }}</small>
                                </div>
                            </div>
                            <div class="btn-group" role="group">
                                <a href="{{ $review->payment_document_s3_url }}" target="_blank" class="btn btn-sm btn-outline-primary" title="Ver archivo">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ $review->payment_document_s3_url }}" download="{{ $review->payment_document_name }}" class="btn btn-sm btn-outline-success" title="Descargar archivo">
                                    <i class="fas fa-download"></i>
                                </a>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Modal de vista previa de imagen -->
<div class="modal fade" id="imagePreviewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content bg-dark">
            <div class="modal-header border-0">
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body text-center p-0 pb-3">
                <img id="imagePreviewModalImg" src="" class="img-fluid rounded" alt="Vista previa">
            </div>
        </div>
    </div>
</div>

<style>
    .bg-inspection {
        background-color: #6d1b2b;
    }
</style>

@section('scripts')
<script>
// Función para abrir la imagen en un modal más grande
function previewImage(url) {
    document.getElementById('imagePreviewModalImg').src = url;
    new bootstrap.Modal(document.getElementById('imagePreviewModal')).show();
}

// Función para obtener el icono del archivo según su extensión
function getFileIcon(extension) {
    const iconMap = {
        'pdf': 'pdf',
        'doc': 'word',
        'docx': 'word',
        'jpg': 'image',
        'jpeg': 'image',
        'png': 'image',
        'gif': 'image',
        'zip': 'archive',
        'rar': 'archive'
    };
    
    return iconMap[extension?.toLowerCase()] || 'alt';
}

// Función para descargar todos los archivos
function downloadAllFiles() {
    const files = @json($sareRequest->files->pluck('s3_asset_url', 'file_name'));
    
    if (Object.keys(files).length === 0) {
        alert('No hay archivos disponibles para descargar');
        return;
    }
    
    // Confirmar descarga múltiple
    if (!confirm(`¿Desea descargar ${Object.keys(files).length} archivo(s)?`)) {
        return;
    }
    
    // Crear elementos de descarga temporal
    Object.entries(files).forEach(([fileName, url], index) => {
        if (url) {
            setTimeout(() => {
                const link = document.createElement('a');
                link.href = url;
                link.download = fileName || `archivo_${index + 1}`;
                link.target = '_blank';
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            }, index * 500); // Retrasar cada descarga 500ms
        }
    });
}

// Función para copiar URL de archivo al portapapeles
function copyFileUrl(url, fileName) {
    navigator.clipboard.writeText(url).then(() => {
        // Mostrar mensaje temporal
        const toast = document.createElement('div');
        toast.className = 'position-fixed top-0 end-0 m-3 alert alert-success alert-dismissible fade show';
        toast.innerHTML = `
            <strong>¡Copiado!</strong> URL de "${fileName}" copiada al portapapeles.
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        document.body.appendChild(toast);
        
        // Auto eliminar después de 3 segundos
        setTimeout(() => {
            if (toast.parentNode) {
                toast.parentNode.removeChild(toast);
            }
        }, 3000);
    }).catch(() => {
        alert('No se pudo copiar la URL al portapapeles');
    });
}

// Estilo de impresión
document.addEventListener('DOMContentLoaded', function() {
    // Inicializar tooltips de Bootstrap
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    
    const style = document.createElement('style');
    style.innerHTML = `
        @media print {
            .btn, .card-header, .breadcrumb-item a, .card-footer {
                display: none !important;
            }
            .card {
                border: none !important;
                box-shadow: none !important;
            }
            .container-fluid {
                padding: 0 !important;
            }
            .col-md-4:last-child {
                display: none !important;
            }
            .col-md-8 {
                width: 100% !important;
            }
            .table {
                font-size: 12px !important;
            }
        }
        
        /* Estilos adicionales para la tabla de archivos */
        .table td {
            vertical-align: middle;
        }
        
        .btn-group .btn {
            border-radius: 0.25rem !important;
        }
        
        .file-icon {
            width: 20px;
            text-align: center;
        }
        
        /* Hover effect para las filas de archivos */
        .table tbody tr:hover {
            background-color: rgba(0, 123, 255, 0.05);
        }
    `;
    document.head.appendChild(style);
});
</script>
@endsection
@endsection
