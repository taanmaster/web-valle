@extends('front.layouts.app')

@section('title', 'Editar Solicitud SARE')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <ion-icon name="create-outline"></ion-icon>
                        Editar Solicitud SARE #{{ $sareRequest->request_num }}                      
                        <!-- Botones -->
                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('citizen.sare.show', $sareRequest) }}" class="btn btn-secondary">
                                        <i class="bx bx-arrow-back me-2"></i>Volver
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bx bx-save me-2"></i>Actualizar Solicitud
                                    </button>
                                </div>
                            </div>
                        </div>                 
                    </h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-warning">
                        <ion-icon name="information-circle-outline"></ion-icon>
                        Está editando una solicitud existente. Solo se pueden editar solicitudes en estado "Nuevo".
                    </div>

                    <form id="sareRequestForm" method="POST" action="{{ route('citizen.sare.update', $sareRequest) }}">
                        @csrf
                        @method('PUT')
                        
                        <!-- Información General -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="fw-bold text-primary">
                                    <ion-icon name="information-circle-outline"></ion-icon> Información General
                                </h6>
                                <hr class="mt-2 mb-3">
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label for="request_num" class="form-label">Número de Solicitud <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="request_num" name="request_num" value="{{ $sareRequest->request_num }}" required>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label for="request_date" class="form-label">Fecha de Solicitud <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="request_date" name="request_date" value="{{ $sareRequest->request_date }}" required>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label for="catastral_num" class="form-label">Número Catastral <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="catastral_num" name="catastral_num" value="{{ $sareRequest->catastral_num }}" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="request_type" class="form-label">Tipo de Solicitud <span class="text-danger">*</span></label>
                                <select class="form-select" id="request_type" name="request_type" required>
                                    <option value="">Seleccione un tipo</option>
                                    <option value="general" {{ $sareRequest->request_type === 'general' ? 'selected' : '' }}>General</option>
                                    <option value="nuevo" {{ $sareRequest->request_type === 'nuevo' ? 'selected' : '' }}>Permiso Nuevo</option>
                                    <option value="renovacion" {{ $sareRequest->request_type === 'renovacion' ? 'selected' : '' }}>Renovación</option>
                                    <option value="anuncio" {{ $sareRequest->request_type === 'anuncio' ? 'selected' : '' }}>Anuncio</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="status" class="form-label">Estado</label>
                                <select class="form-select" id="status" name="status" disabled>
                                    <option value="new" {{ $sareRequest->status === 'new' ? 'selected' : '' }}>Nuevo</option>
                                    <option value="in_progress" {{ $sareRequest->status === 'in_progress' ? 'selected' : '' }}>En Progreso</option>
                                    <option value="cancelled" {{ $sareRequest->status === 'cancelled' ? 'selected' : '' }}>Cancelado</option>
                                    <option value="payment_pending" {{ $sareRequest->status === 'payment_pending' ? 'selected' : '' }}>Pago Pendiente</option>
                                    <option value="authorized" {{ $sareRequest->status === 'authorized' ? 'selected' : '' }}>Autorizado</option>
                                    <option value="rejected" {{ $sareRequest->status === 'rejected' ? 'selected' : '' }}>Rechazado</option>
                                    <option value="validation" {{ $sareRequest->status === 'validation' ? 'selected' : '' }}>Validación</option>
                                </select>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="description" class="form-label">Descripción</label>
                                <textarea class="form-control" id="description" name="description" rows="3">{{ $sareRequest->description }}</textarea>
                            </div>
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
                                <label for="rfc_name" class="form-label">Nombre/Razón Social RFC <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="rfc_name" name="rfc_name" value="{{ $sareRequest->rfc_name }}" required>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="rfc_num" class="form-label">RFC <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="rfc_num" name="rfc_num" value="{{ $sareRequest->rfc_num }}" required>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="property_owner" class="form-label">Propietario del Inmueble <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="property_owner" name="property_owner" value="{{ $sareRequest->property_owner }}" required>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ $sareRequest->email }}" required>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="office_phone" class="form-label">Teléfono de Oficina <span class="text-danger">*</span></label>
                                <input type="tel" class="form-control" id="office_phone" name="office_phone" value="{{ $sareRequest->office_phone }}" required>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="mobile_phone" class="form-label">Teléfono Móvil <span class="text-danger">*</span></label>
                                <input type="tel" class="form-control" id="mobile_phone" name="mobile_phone" value="{{ $sareRequest->mobile_phone }}" required>
                            </div>
                        </div>

                        <!-- Datos del Representante Legal -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="fw-bold text-primary">
                                    <ion-icon name="person-add-outline"></ion-icon> Representante Legal
                                </h6>
                                <hr class="mt-2 mb-3">
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label for="legal_representative_name" class="form-label">Nombre <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="legal_representative_name" name="legal_representative_name" value="{{ $sareRequest->legal_representative_name }}" required>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label for="legal_representative_father_last_name" class="form-label">Apellido Paterno <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="legal_representative_father_last_name" name="legal_representative_father_last_name" value="{{ $sareRequest->legal_representative_father_last_name }}" required>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label for="legal_representative_mother_last_name" class="form-label">Apellido Materno <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="legal_representative_mother_last_name" name="legal_representative_mother_last_name" value="{{ $sareRequest->legal_representative_mother_last_name }}" required>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label for="legal_representative_office_phone" class="form-label">Teléfono Oficina <span class="text-danger">*</span></label>
                                <input type="tel" class="form-control" id="legal_representative_office_phone" name="legal_representative_office_phone" value="{{ $sareRequest->legal_representative_office_phone }}" required>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label for="legal_representative_mobile_phone" class="form-label">Teléfono Móvil <span class="text-danger">*</span></label>
                                <input type="tel" class="form-control" id="legal_representative_mobile_phone" name="legal_representative_mobile_phone" value="{{ $sareRequest->legal_representative_mobile_phone }}" required>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label for="legal_representative_personal_phone" class="form-label">Teléfono Personal <span class="text-danger">*</span></label>
                                <input type="tel" class="form-control" id="legal_representative_personal_phone" name="legal_representative_personal_phone" value="{{ $sareRequest->legal_representative_personal_phone }}" required>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="legal_representative_email" class="form-label">Email Representante <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="legal_representative_email" name="legal_representative_email" value="{{ $sareRequest->legal_representative_email }}" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="legal_representative_ownership_document" class="form-label">Documento de Propiedad <span class="text-danger">*</span></label>
                                <select class="form-select" id="legal_representative_ownership_document" name="legal_representative_ownership_document" required>
                                    <option value="">Seleccione un documento</option>
                                    <option value="Apoderado Especial" {{ $sareRequest->legal_representative_ownership_document === 'Apoderado Especial' ? 'selected' : '' }}>Apoderado Especial</option>
                                    <option value="Apoderado General" {{ $sareRequest->legal_representative_ownership_document === 'Apoderado General' ? 'selected' : '' }}>Apoderado General</option>
                                    <option value="Gestor de Trámite" {{ $sareRequest->legal_representative_ownership_document === 'Gestor de Trámite' ? 'selected' : '' }}>Gestor de Trámite</option>
                                    <option value="Poder Notariado" {{ $sareRequest->legal_representative_ownership_document === 'Poder Notariado' ? 'selected' : '' }}>Poder Notariado</option>
                                    <option value="Escritura Pública" {{ $sareRequest->legal_representative_ownership_document === 'Escritura Pública' ? 'selected' : '' }}>Escritura Pública</option>
                                    <option value="Poder Simple" {{ $sareRequest->legal_representative_ownership_document === 'Poder Simple' ? 'selected' : '' }}>Poder Simple</option>
                                </select>
                            </div>
                        </div>

                        <!-- Responsable del Establecimiento -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="fw-bold text-primary">
                                    <ion-icon name="business-outline"></ion-icon> Responsable del Establecimiento
                                </h6>
                                <hr class="mt-2 mb-3">
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="establishment_legal_cause" class="form-label">Causa Legal <span class="text-danger">*</span></label>
                                <select class="form-select" id="establishment_legal_cause" name="establishment_legal_cause" required>
                                    <option value="">Seleccione una opción</option>
                                    <option value="Proprietario" {{ $sareRequest->establishment_legal_cause === 'Proprietario' ? 'selected' : '' }}>Propietario</option>
                                    <option value="Arrendatario" {{ $sareRequest->establishment_legal_cause === 'Arrendatario' ? 'selected' : '' }}>Arrendatario</option>
                                    <option value="Otro" {{ $sareRequest->establishment_legal_cause === 'Otro' ? 'selected' : '' }}>Otro</option>
                                </select>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="establishment_legal_cause_addon" class="form-label">Especificar Otro</label>
                                <input type="text" class="form-control" id="establishment_legal_cause_addon" name="establishment_legal_cause_addon" value="{{ $sareRequest->establishment_legal_cause_addon }}">
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="establishment_good_faith_clause" class="form-label">Cláusula de Buena Fe <span class="text-danger">*</span></label>
                                <select class="form-select" id="establishment_good_faith_clause" name="establishment_good_faith_clause" required>
                                    <option value="">Seleccione una opción</option>
                                    <option value="Si" {{ $sareRequest->establishment_good_faith_clause === 'Si' ? 'selected' : '' }}>Sí</option>
                                    <option value="No" {{ $sareRequest->establishment_good_faith_clause === 'No' ? 'selected' : '' }}>No</option>
                                    <option value="N/A" {{ $sareRequest->establishment_good_faith_clause === 'N/A' ? 'selected' : '' }}>N/A</option>
                                </select>
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
                            
                            <div class="col-md-6 mb-3">
                                <label for="establishment_address_street" class="form-label">Calle <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="establishment_address_street" name="establishment_address_street" value="{{ $sareRequest->establishment_address_street }}" required>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="establishment_address_number" class="form-label">Número <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="establishment_address_number" name="establishment_address_number" value="{{ $sareRequest->establishment_address_number }}" required>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label for="establishment_address_neighborhood" class="form-label">Colonia <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="establishment_address_neighborhood" name="establishment_address_neighborhood" value="{{ $sareRequest->establishment_address_neighborhood }}" required>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label for="establishment_address_municipality" class="form-label">Municipio <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="establishment_address_municipality" name="establishment_address_municipality" value="{{ $sareRequest->establishment_address_municipality }}" required>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label for="establishment_address_state" class="form-label">Estado <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="establishment_address_state" name="establishment_address_state" value="{{ $sareRequest->establishment_address_state }}" required>
                            </div>
                            
                            <div class="col-md-12 mb-3">
                                <label for="establishment_address_postal_code" class="form-label">Código Postal <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="establishment_address_postal_code" name="establishment_address_postal_code" value="{{ $sareRequest->establishment_address_postal_code }}" required>
                            </div>
                        </div>                        

                        <!-- Datos del uso de la edificación -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="fw-bold text-primary">
                                    <ion-icon name="hammer-outline"></ion-icon> Datos del Uso de la Edificación
                                </h6>
                                <hr class="mt-2 mb-3">
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="establishment_use" class="form-label">Uso del Establecimiento</label>
                                <input type="text" class="form-control" id="establishment_use" name="establishment_use" value="{{ $sareRequest->establishment_use }}">
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="commercial_name" class="form-label">Nombre Comercial <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="commercial_name" name="commercial_name" value="{{ $sareRequest->commercial_name }}" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="aprox_investment" class="form-label">Inversión Aproximada <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="aprox_investment" name="aprox_investment" value="{{ $sareRequest->aprox_investment }}" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="jobs_to_generate" class="form-label">Empleos a Generar <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="jobs_to_generate" name="jobs_to_generate" value="{{ $sareRequest->jobs_to_generate }}" required>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="operation_start_date" class="form-label">Fecha Inicio Operaciones</label>
                                <input type="date" class="form-control" id="operation_start_date" name="operation_start_date" value="{{ $sareRequest->operation_start_date }}">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="business_hours" class="form-label">Horario de Negocio</label>
                                <input type="text" class="form-control" id="business_hours" name="business_hours" value="{{ $sareRequest->business_hours }}" placeholder="Ej: 8:00 - 18:00">
                            </div>

                            <div class="col-md-4 mb-3">
                                <div class="form-check mt-4">
                                    <input class="form-check-input" type="checkbox" id="is_location_in_operation" name="is_location_in_operation" value="1" {{ $sareRequest->is_location_in_operation ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_location_in_operation">
                                        Local en operación
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Zonificación -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="fw-bold text-primary">
                                    <i class="bx bx-map me-2"></i>Zonificación
                                </h6>
                                <hr class="mt-2 mb-3">
                            </div>

                            <div class="col-md-3 mb-3">
                                <label for="zoning_front" class="form-label">Frente</label>
                                <input type="text" class="form-control" id="zoning_front" name="zoning_front" value="{{ $sareRequest->zoning_front }}">
                            </div>

                            <div class="col-md-3 mb-3">
                                <label for="zoning_rear" class="form-label">Fondo</label>
                                <input type="text" class="form-control" id="zoning_rear" name="zoning_rear" value="{{ $sareRequest->zoning_rear }}">
                            </div>

                            <div class="col-md-3 mb-3">
                                <label for="zoning_left" class="form-label">Izquierda</label>
                                <input type="text" class="form-control" id="zoning_left" name="zoning_left" value="{{ $sareRequest->zoning_left }}">
                            </div>

                            <div class="col-md-3 mb-3">
                                <label for="zoning_right" class="form-label">Derecha</label>
                                <input type="text" class="form-control" id="zoning_right" name="zoning_right" value="{{ $sareRequest->zoning_right }}">
                            </div>
                        </div>                        <!-- Archivos Adjuntos Existentes -->
                        @if($sareRequest->files && $sareRequest->files->count() > 0)
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="fw-bold text-primary">
                                    <i class="bx bx-paperclip me-2"></i>Archivos Adjuntos Existentes
                                </h6>
                                <hr class="mt-2 mb-3">
                            </div>
                            
                            <div class="col-12">
                                <div class="list-group">
                                    @foreach($sareRequest->files as $file)
                                    <div class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <i class="bx bx-file me-2"></i>
                                            <strong>{{ $file->file_name }}</strong>
                                            <small class="text-muted d-block">
                                                Tamaño: {{ number_format($file->file_size / 1024, 2) }} KB
                                            </small>
                                        </div>
                                        <div>
                                            <a href="{{ Storage::url($file->file_path) }}" 
                                               target="_blank" 
                                               class="btn btn-sm btn-outline-primary me-2">
                                                <i class="bx bx-download me-1"></i>
                                                Ver
                                            </a>
                                            <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeFile({{ $file->id }})">
                                                <i class="bx bx-trash me-1"></i>
                                                Eliminar
                                            </button>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- Botones -->
                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('citizen.sare.show', $sareRequest) }}" class="btn btn-secondary">
                                        <i class="bx bx-arrow-back me-2"></i>Cancelar
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bx bx-check me-2"></i>Actualizar Solicitud
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
$(document).ready(function() {
    // Validación del formulario
    $('#sareRequestForm').on('submit', function(e) {
        e.preventDefault();
        
        const form = this;
        const formData = new FormData(form);
        
        // Mostrar loading
        const submitBtn = $(form).find('button[type="submit"]');
        const originalText = submitBtn.html();
        submitBtn.html('<i class="bx bx-loader-alt bx-spin me-2"></i>Actualizando...').prop('disabled', true);
        
        $.ajax({
            url: $(form).attr('action'),
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    window.location.href = response.redirect;
                } else {
                    alert('Error: ' + response.message);
                }
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    let errorMessage = 'Por favor corrija los siguientes errores:\n\n';
                    
                    Object.keys(errors).forEach(field => {
                        errorMessage += '• ' + errors[field][0] + '\n';
                    });
                    
                    alert(errorMessage);
                } else {
                    alert('Error al actualizar la solicitud. Por favor, inténtelo de nuevo.');
                }
            },
            complete: function() {
                submitBtn.html(originalText).prop('disabled', false);
            }
        });
    });
});

function removeFile(fileId) {
    if (confirm('¿Está seguro de que desea eliminar este archivo?')) {
        // Aquí puedes implementar la funcionalidad para eliminar archivos
        // Por ahora solo mostramos un mensaje
        alert('Funcionalidad de eliminación de archivos por implementar');
    }
}
</script>
@endsection
@endsection
