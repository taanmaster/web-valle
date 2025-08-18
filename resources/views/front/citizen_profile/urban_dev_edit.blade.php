@extends('front.layouts.app')

@section('title', 'Editar Solicitud - Desarrollo Urbano')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12">
            @include('front.citizen_profile.partials._profile_card')

            <div class="card wow fadeInUp">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <ion-icon name="create-outline"></ion-icon>
                        Editar Solicitud #{{ $urbanDevRequest->id }} - Desarrollo Urbano
                    </h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-warning">
                        <ion-icon name="information-circle-outline"></ion-icon>
                        Está editando una solicitud existente. Solo se pueden editar solicitudes en estado "Nuevo".
                    </div>

                    <form id="urbanDevRequestEditForm" method="POST" action="{{ route('citizen.urban_dev.update', $urbanDevRequest) }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <!-- Información básica -->
                            <div class="col-md-8">
                                <div class="card border-primary">
                                    <div class="card-header bg-primary text-white">
                                        <h6 class="mb-0">
                                            <ion-icon name="information-circle-outline"></ion-icon>
                                            Información del Trámite
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="status" class="form-label">Estado Actual</label>
                                                <input type="text" class="form-control" value="{{ $urbanDevRequest->getStatusLabelAttribute() }}" disabled>
                                            </div>
                                            
                                            <div class="col-md-6 mb-3">
                                                <label for="created_at" class="form-label">Fecha de Creación</label>
                                                <input type="text" class="form-control" value="{{ $urbanDevRequest->created_at->format('d/m/Y H:i') }}" disabled>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="request_type" class="form-label">Tipo de Trámite <span class="text-danger">*</span></label>
                                            <select class="form-select" id="request_type" name="request_type" required>
                                                <option value="">Seleccione un trámite</option>
                                                <option value="uso-de-suelo" {{ $urbanDevRequest->request_type === 'uso-de-suelo' ? 'selected' : '' }}>Licencia de Uso de Suelo</option>
                                                <option value="constancia-de-factibilidad" {{ $urbanDevRequest->request_type === 'constancia-de-factibilidad' ? 'selected' : '' }}>Constancia de Factibilidad</option>
                                                <option value="permiso-de-anuncios" {{ $urbanDevRequest->request_type === 'permiso-de-anuncios' ? 'selected' : '' }}>Permiso de Anuncios y Toldos</option>
                                                <option value="certificacion-numero-oficial" {{ $urbanDevRequest->request_type === 'certificacion-numero-oficial' ? 'selected' : '' }}>Certificación de Número Oficial</option>
                                                <option value="permiso-de-division" {{ $urbanDevRequest->request_type === 'permiso-de-division' ? 'selected' : '' }}>Permiso de División</option>
                                                <option value="uso-de-via-publica" {{ $urbanDevRequest->request_type === 'uso-de-via-publica' ? 'selected' : '' }}>Uso de Vía Pública</option>
                                                <option value="licencia-de-construccion" {{ $urbanDevRequest->request_type === 'licencia-de-construccion' ? 'selected' : '' }}>Licencia de Construcción</option>
                                                <option value="permiso-construccion-panteones" {{ $urbanDevRequest->request_type === 'permiso-construccion-panteones' ? 'selected' : '' }}>Permiso de Construcción en Panteones</option>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label for="description" class="form-label">Descripción del proyecto</label>
                                            <textarea class="form-control" id="description" name="description" rows="4" placeholder="Describe brevemente tu proyecto o solicitud...">{{ $urbanDevRequest->description }}</textarea>
                                        </div>

                                        <div class="alert alert-info">
                                            <h6 class="mb-2"><ion-icon name="information-circle-outline"></ion-icon> Información</h6>
                                            <p class="mb-0">Los cambios realizados aquí no afectarán los documentos ya subidos. Si cambias el tipo de trámite, es posible que necesites subir documentos adicionales.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Información adicional -->
                            <div class="col-md-4">
                                <div class="card border-info">
                                    <div class="card-header bg-info text-white">
                                        <h6 class="mb-0">
                                            <ion-icon name="document-text-outline"></ion-icon>
                                            Información Adicional
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <strong>ID de Solicitud:</strong><br>
                                            <span class="text-muted">#{{ $urbanDevRequest->id }}</span>
                                        </div>

                                        <div class="mb-3">
                                            <strong>Tipo Actual:</strong><br>
                                            <span class="text-muted">{{ $urbanDevRequest->getRequestTypeLabelAttribute() }}</span>
                                        </div>

                                        <div class="mb-3">
                                            <strong>Estado:</strong><br>
                                            <span class="badge bg-{{ $urbanDevRequest->getStatusColorAttribute() }}">
                                                {{ $urbanDevRequest->getStatusLabelAttribute() }}
                                            </span>
                                        </div>

                                        <div class="mb-3">
                                            <strong>Archivos Subidos:</strong><br>
                                            <span class="text-muted">{{ $urbanDevRequest->files->count() }} documento(s)</span>
                                        </div>

                                        <div class="alert alert-warning">
                                            <small>
                                                <ion-icon name="warning-outline"></ion-icon>
                                                Solo puedes editar solicitudes en estado "Nuevo"
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Botones de acción -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('citizen.urban_dev.show', $urbanDevRequest) }}" class="btn btn-secondary">
                                        <ion-icon name="arrow-back-outline"></ion-icon> Volver
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <ion-icon name="save-outline"></ion-icon> Actualizar Solicitud
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle form submission
    document.getElementById('urbanDevRequestEditForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const submitBtn = this.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<ion-icon name="sync-outline" class="spinner"></ion-icon> Actualizando...';
        
        fetch(this.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Solicitud actualizada exitosamente');
                window.location.href = '{{ route("citizen.urban_dev.show", $urbanDevRequest) }}';
            } else {
                throw new Error(data.message || 'Error al actualizar la solicitud');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al actualizar la solicitud: ' + error.message);
        })
        .finally(() => {
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
        });
    });
});
</script>

<style>
.spinner {
    animation: spin 1s linear infinite;
}

@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}
</style>
@endsection
