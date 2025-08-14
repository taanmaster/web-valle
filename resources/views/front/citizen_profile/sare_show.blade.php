@extends('front.layouts.app')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12 mb-4">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h2 class="mb-0">
                        <ion-icon name="document-text-outline"></ion-icon>
                        Solicitud SARE #{{ $sareRequest->request_num }}
                    </h2>
                    <small class="text-muted">
                        Creada el {{ $sareRequest->created_at->format('d/m/Y \a \l\a\s H:i') }}
                    </small>
                </div>
                <div class="col-md-4 text-end">
                    <span class="badge bg-{{ $sareRequest->status_color }} fs-6 px-3 py-2">
                        {{ $sareRequest->status_label }}
                    </span>
                    <br>
                    <small class="text-muted mt-2 d-block">
                        Última actualización: {{ $sareRequest->updated_at->format('d/m/Y H:i') }}
                    </small>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card card-body">
                <!-- Información General -->
                <div class="row mb-4">
                    <div class="col-12">
                        <h6 class="fw-bold text-primary">
                            <ion-icon name="information-circle-outline"></ion-icon> Información General
                        </h6>
                        <hr class="mt-2 mb-3">
                    </div>
                    
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Número de Solicitud:</label>
                        <p class="mb-0">{{ $sareRequest->request_num }}</p>
                    </div>
                    
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Fecha de Solicitud:</label>
                        <p class="mb-0">{{ $sareRequest->request_date }}</p>
                    </div>
                    
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Estado:</label>
                        <p class="mb-0">
                            <span class="badge bg-{{ $sareRequest->status === 'new' ? 'primary' : ($sareRequest->status === 'authorized' ? 'success' : ($sareRequest->status === 'rejected' ? 'danger' : 'warning')) }}">
                                {{ ucfirst(str_replace('_', ' ', $sareRequest->status)) }}
                            </span>
                        </p>
                    </div>
                    
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Número Catastral:</label>
                        <p class="mb-0">{{ $sareRequest->catastral_num }}</p>
                    </div>
                    
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Tipo de Solicitud:</label>
                        <p class="mb-0">{{ ucfirst($sareRequest->request_type) }}</p>
                    </div>
                    
                    @if($sareRequest->description)
                    <div class="col-12 mb-3">
                        <label class="form-label fw-bold">Descripción:</label>
                        <p class="mb-0">{{ $sareRequest->description }}</p>
                    </div>
                    @endif
                </div>

                <!-- Datos del Solicitante -->
                <div class="row mb-4">
                    <div class="col-12">
                        <h6 class="fw-bold text-primary">
                            <ion-icon name="person-outline"></ion-icon> Datos del Solicitante
                        </h6>
                        <hr class="mt-2 mb-3">
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Nombre/Razón Social RFC:</label>
                        <p class="mb-0">{{ $sareRequest->rfc_name }}</p>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">RFC:</label>
                        <p class="mb-0">{{ $sareRequest->rfc_num }}</p>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Propietario del Inmueble:</label>
                        <p class="mb-0">{{ $sareRequest->property_owner }}</p>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Correo Electrónico:</label>
                        <p class="mb-0">{{ $sareRequest->email }}</p>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Teléfono de Oficina:</label>
                        <p class="mb-0">{{ $sareRequest->office_phone }}</p>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Teléfono Móvil:</label>
                        <p class="mb-0">{{ $sareRequest->mobile_phone }}</p>
                    </div>
                </div>

                @if($sareRequest->legal_representative_name)
                <!-- Datos del Representante Legal -->
                <div class="row mb-4">
                    <div class="col-12">
                        <h6 class="fw-bold text-primary">
                            <ion-icon name="person-add-outline"></ion-icon> Datos del Representante Legal
                        </h6>
                        <hr class="mt-2 mb-3">
                    </div>
                    
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Nombre Completo:</label>
                        <p class="mb-0">{{ $sareRequest->legal_representative_name }} {{ $sareRequest->legal_representative_father_last_name }} {{ $sareRequest->legal_representative_mother_last_name }}</p>
                    </div>
                    
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Teléfono de Oficina:</label>
                        <p class="mb-0">{{ $sareRequest->legal_representative_office_phone }}</p>
                    </div>
                    
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Teléfono Móvil:</label>
                        <p class="mb-0">{{ $sareRequest->legal_representative_mobile_phone }}</p>
                    </div>
                    
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Teléfono Personal:</label>
                        <p class="mb-0">{{ $sareRequest->legal_representative_personal_phone }}</p>
                    </div>
                    
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Correo Electrónico:</label>
                        <p class="mb-0">{{ $sareRequest->legal_representative_email }}</p>
                    </div>
                    
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Documento de Propiedad:</label>
                        <p class="mb-0">{{ $sareRequest->legal_representative_ownership_document }}</p>
                    </div>
                </div>
                @endif

                <!-- Responsable del Establecimiento -->
                <div class="row mb-4">
                    <div class="col-12">
                        <h6 class="fw-bold text-primary">
                            <ion-icon name="business-outline"></ion-icon> Responsable del Establecimiento
                        </h6>
                        <hr class="mt-2 mb-3">
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Causa Legal:</label>
                        <p class="mb-0">{{ $sareRequest->establishment_legal_cause }}</p>
                    </div>
                    
                    @if($sareRequest->establishment_legal_cause_addon)
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Especificar Otro:</label>
                        <p class="mb-0">{{ $sareRequest->establishment_legal_cause_addon }}</p>
                    </div>
                    @endif
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Cláusula de Buena Fe:</label>
                        <p class="mb-0">{{ $sareRequest->establishment_good_faith_clause }}</p>
                    </div>
                </div>

                <!-- Domicilio del Establecimiento -->
                <div class="row mb-4">
                    <div class="col-12">
                        <h6 class="fw-bold text-primary">
                            <ion-icon name="location-outline"></ion-icon> Domicilio del Establecimiento
                        </h6>
                        <hr class="mt-2 mb-3">
                    </div>
                    
                    <div class="col-12 mb-3">
                        <label class="form-label fw-bold">Dirección Completa:</label>
                        <p class="mb-0">
                            {{ $sareRequest->establishment_address_street }} #{{ $sareRequest->establishment_address_number }}
                            <br>
                            Col. {{ $sareRequest->establishment_address_neighborhood }}, 
                            C.P. {{ $sareRequest->establishment_address_postal_code }}<br>
                            {{ $sareRequest->establishment_address_municipality }}, {{ $sareRequest->establishment_address_state }}
                        </p>
                    </div>
                </div>

                <!-- Datos del Uso de la Edificación -->
                <div class="row mb-4">
                    <div class="col-12">
                        <h6 class="fw-bold text-primary">
                            <ion-icon name="briefcase-outline"></ion-icon> Datos del Uso de la Edificación
                        </h6>
                        <hr class="mt-2 mb-3">
                    </div>
                    
                    @if($sareRequest->establishment_use)
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Uso del Establecimiento:</label>
                        <p class="mb-0">{{ $sareRequest->establishment_use }}</p>
                    </div>
                    @endif
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Nombre Comercial:</label>
                        <p class="mb-0">{{ $sareRequest->commercial_name }}</p>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Inversión Aproximada:</label>
                        <p class="mb-0">{{ $sareRequest->aprox_investment }}</p>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Empleos a Generar:</label>
                        <p class="mb-0">{{ $sareRequest->jobs_to_generate }}</p>
                    </div>
                    
                    @if($sareRequest->operation_start_date)
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Fecha de Inicio de Operaciones:</label>
                        <p class="mb-0">{{ $sareRequest->operation_start_date }}</p>
                    </div>
                    @endif
                    
                    @if($sareRequest->business_hours)
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Horario de Negocio:</label>
                        <p class="mb-0">{{ $sareRequest->business_hours }}</p>
                    </div>
                    @endif
                    
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Local en Operación:</label>
                        <p class="mb-0">{{ $sareRequest->is_location_in_operation ? 'Sí' : 'No' }}</p>
                    </div>
                </div>

                <!-- Zonificación -->
                @if($sareRequest->zoning_front || $sareRequest->zoning_rear || $sareRequest->zoning_left || $sareRequest->zoning_right)
                <div class="row mb-4">
                    <div class="col-12">
                        <h6 class="fw-bold text-primary">
                            <ion-icon name="location-outline"></ion-icon> Zonificación
                        </h6>
                        <hr class="mt-2 mb-3">
                    </div>
                    
                    @if($sareRequest->zoning_front)
                    <div class="col-md-3 mb-3">
                        <label class="form-label fw-bold">Frente:</label>
                        <p class="mb-0">{{ $sareRequest->zoning_front }}</p>
                    </div>
                    @endif
                    
                    @if($sareRequest->zoning_rear)
                    <div class="col-md-3 mb-3">
                        <label class="form-label fw-bold">Fondo:</label>
                        <p class="mb-0">{{ $sareRequest->zoning_rear }}</p>
                    </div>
                    @endif
                    
                    @if($sareRequest->zoning_left)
                    <div class="col-md-3 mb-3">
                        <label class="form-label fw-bold">Izquierda:</label>
                        <p class="mb-0">{{ $sareRequest->zoning_left }}</p>
                    </div>
                    @endif
                    
                    @if($sareRequest->zoning_right)
                    <div class="col-md-3 mb-3">
                        <label class="form-label fw-bold">Derecha:</label>
                        <p class="mb-0">{{ $sareRequest->zoning_right }}</p>
                    </div>
                    @endif
                </div>
                @endif

                <!-- Información Municipal -->
                @if($sareRequest->license_num || $sareRequest->entry_date || $sareRequest->exit_date || $sareRequest->document_type)
                <div class="row mb-4">
                    <div class="col-12">
                        <h6 class="fw-bold text-primary">
                            <ion-icon name="home-outline"></ion-icon> Información Municipal
                        </h6>
                        <hr class="mt-2 mb-3">
                    </div>
                    
                    @if($sareRequest->license_num)
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Número de Licencia:</label>
                        <p class="mb-0">{{ $sareRequest->license_num }}</p>
                    </div>
                    @endif
                    
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Visto Bueno Favorable:</label>
                        <p class="mb-0">{{ $sareRequest->vobo_favorable ? 'Sí' : 'No' }}</p>
                    </div>
                    
                    @if($sareRequest->entry_date)
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Fecha de Ingreso:</label>
                        <p class="mb-0">{{ \Carbon\Carbon::parse($sareRequest->entry_date)->format('d/m/Y H:i') }}</p>
                    </div>
                    @endif
                    
                    @if($sareRequest->exit_date)
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Fecha de Resolución:</label>
                        <p class="mb-0">{{ \Carbon\Carbon::parse($sareRequest->exit_date)->format('d/m/Y H:i') }}</p>
                    </div>
                    @endif
                    
                    @if($sareRequest->document_type)
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Tipo de Documento:</label>
                        <p class="mb-0">{{ $sareRequest->document_type }}</p>
                    </div>
                    @endif
                </div>
                @endif

                <!-- Botones de Acción -->
                <div class="row">
                    <div class="col-12">
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('citizen.profile.requests') }}" class="btn btn-secondary">
                                <ion-icon name="arrow-back-outline"></ion-icon> Volver a Mis Solicitudes
                            </a>
                            
                            <div>
                                @if($sareRequest->status === 'new')
                                    <a href="{{ route('citizen.sare.edit', $sareRequest) }}" class="btn btn-warning me-2">
                                        <ion-icon name="create-outline"></ion-icon> Editar Solicitud
                                    </a>
                                    
                                    <button type="button" class="btn btn-danger me-2" onclick="confirmDelete()">
                                        <ion-icon name="trash-outline"></ion-icon> Eliminar
                                    </button>
                                @endif
                                
                                {{--  
                                <button type="button" class="btn btn-info" onclick="window.print()">
                                    <i class="bx bx-printer me-2"></i>Imprimir
                                </button>
                                --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-body">
                <div class="row mb-4">
                    <div class="col-12">
                        <h6 class="fw-bold text-primary">
                            <ion-icon name="attach-outline"></ion-icon> Archivos Adjuntos
                        </h6>
                        <hr class="mt-2 mb-3">
                    </div>
                    
                    <div class="col-12">
                        <div class="list-group">
                            @foreach($sareRequest->files as $file)
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <ion-icon name="document-outline"></ion-icon>
                                    <strong>{{ $file->file_name }}</strong>
                                    <small class="text-muted d-block">
                                        Tamaño: {{ number_format($file->file_size / 1024, 2) }} KB
                                    </small>
                                </div>
                                <a href="{{ Storage::url($file->file_path) }}" 
                                    target="_blank" 
                                    class="btn btn-sm btn-outline-primary">
                                    <ion-icon name="download-outline"></ion-icon>
                                    Descargar
                                </a>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>

<!-- Modal de Confirmación de Eliminación -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmar Eliminación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>¿Está seguro de que desea eliminar esta solicitud SARE?</p>
                <p class="text-danger"><strong>Esta acción no se puede deshacer.</strong></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" onclick="deleteRequest()">Eliminar</button>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
function confirmDelete() {
    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    modal.show();
}

function deleteRequest() {
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '{{ route("citizen.sare.destroy", $sareRequest) }}';
    
    const methodField = document.createElement('input');
    methodField.type = 'hidden';
    methodField.name = '_method';
    methodField.value = 'DELETE';
    
    const tokenField = document.createElement('input');
    tokenField.type = 'hidden';
    tokenField.name = '_token';
    tokenField.value = '{{ csrf_token() }}';
    
    form.appendChild(methodField);
    form.appendChild(tokenField);
    document.body.appendChild(form);
    form.submit();
}

// Estilo de impresión
@media print {
    .btn, .modal, .card-header .badge {
        display: none !important;
    }
    
    .card {
        border: none !important;
        box-shadow: none !important;
    }
    
    .container-fluid {
        padding: 0 !important;
    }
}
</script>
@endsection
@endsection
