@extends('layouts.master')

@section('title')Intranet @endsection

@section('css')
<style>
    .patient-search-container {
        position: relative;
    }
    
    .patients-container {
        background: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        transition: all 0.3s ease;
    }
    
    .patients-container:hover {
        border-color: #007bff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }
    
    .patient-item {
        transition: all 0.2s ease;
        padding: 12px;
        border-radius: 4px;
        margin-bottom: 8px;
        cursor: pointer;
        border: 1px solid transparent;
    }
    
    .patient-item:hover {
        background-color: #e9ecef;
        border-color: #007bff;
    }
    
    .patient-item.selected {
        background-color: #e7f3ff;
        border-color: #007bff;
    }
    
    .patient-item.selected .patient-info {
        color: #007bff;
    }
    
    .selected-patient-badge {
        animation: fadeIn 0.3s ease;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: scale(0.8); }
        to { opacity: 1; transform: scale(1); }
    }
    
    .search-icon {
        color: #6c757d;
        transition: color 0.2s ease;
    }
    
    #patient-search:focus + .search-icon {
        color: #007bff;
    }
    
    .input-group:focus-within .input-group-text {
        border-color: #007bff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }
    
    .input-group:focus-within .search-icon {
        color: #007bff;
    }
    
    .loading-spinner {
        animation: spin 1s linear infinite;
    }
    
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    
    .patient-info {
        transition: color 0.2s ease;
    }
    
    .patient-item:hover .patient-info {
        color: #007bff;
    }
</style>
@endsection

@section('content')
<!-- this is breadcrumbs -->
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') DIF @endslot
@slot('title') Recetas Médicas @endslot
@endcomponent

<div class="row layout-spacing">
    <div class="main-content">
        <div class="row">
            <div class="col-8">
                <div class="card card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="card-title mb-0">Nueva Receta Médica</h5>
                        <a href="{{ route('dif.prescriptions.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Regresar
                        </a>
                    </div>

                    <form method="POST" action="{{ route('dif.prescriptions.store') }}">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="prescription_num" class="form-label">Folio <span class="text-danger tx-12">*</span></label>
                                <input type="text" class="form-control" id="prescription_num" name="prescription_num" 
                                       value="{{ old('prescription_num', $prescriptionNum) }}" readonly>
                                <small class="form-text text-muted">Número generado automáticamente</small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="prescription_date" class="form-label">Fecha de la Receta <span class="text-danger tx-12">*</span></label>
                                <input type="date" class="form-control" id="prescription_date" name="prescription_date" 
                                       value="{{ old('prescription_date', date('Y-m-d')) }}" readonly>
                                <small class="form-text text-muted">Fecha actual del sistema</small>
                            </div>

                            @php
                                $doctorIdFromRequest = request()->input('doctor_id');
                                $doctorReadonly = !empty($doctorIdFromRequest);
                            @endphp

                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label for="doctor_id">Doctor <span class="text-danger">*</span></label>
                                    <select name="doctor_id" id="doctor_id" class="form-control" required {{ $doctorReadonly ? 'readonly disabled' : '' }}>
                                        <option value="">Seleccionar doctor...</option>
                                        @foreach($doctors as $doctor)
                                            <option value="{{ $doctor->id }}"
                                                @if($doctorReadonly)
                                                    {{ $doctorIdFromRequest == $doctor->id ? 'selected' : '' }}
                                                @else
                                                    {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}
                                                @endif
                                            >
                                                {{ $doctor->name }} - {{ $doctor->specialty->name ?? 'Sin especialidad' }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if($doctorReadonly)
                                        <input type="hidden" name="doctor_id" value="{{ $doctorIdFromRequest }}">
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="patient_id" class="form-label">Paciente <span class="text-danger tx-12">*</span></label>
                                
                                <!-- Buscador de pacientes -->
                                <div class="patient-search-container mb-3">
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-search search-icon"></i>
                                        </span>
                                        <input type="text" 
                                            id="patient-search" 
                                            class="form-control" 
                                            placeholder="Buscar paciente por nombre, CURP o teléfono..." 
                                            autocomplete="off"
                                            aria-describedby="patient-search-help">
                                    </div>
                                    <small id="patient-search-help" class="form-text text-muted">
                                        Escribe el nombre, CURP o teléfono del paciente que buscas
                                    </small>
                                </div>

                                <!-- Paciente seleccionado -->
                                <div id="selected-patient" class="mb-3" style="display: none;">
                                    <h6><i class="fas fa-user-check text-success"></i> Paciente Seleccionado:</h6>
                                    <div id="selected-patient-info" class="selected-patient-badge"></div>
                                    <button type="button" class="btn btn-sm btn-outline-secondary mt-2" onclick="clearSelectedPatient()">
                                        <i class="fas fa-times"></i> Cambiar Paciente
                                    </button>
                                </div>
                                
                                <!-- Contenedor de pacientes -->
                                <div class="patients-container" id="patients-container" style="max-height: 300px; overflow-y: auto; padding: 15px;">
                                    <div id="patients-list">
                                        <!-- Los pacientes se cargarán aquí dinámicamente -->
                                        <div class="text-center py-4">
                                            <i class="fas fa-user-friends fa-3x text-muted mb-3"></i>
                                            <h6 class="text-muted">Buscar Pacientes</h6>
                                            <p class="text-muted mb-0">Comienza a escribir para buscar pacientes disponibles...</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Input oculto para enviar al controlador -->
                                <input type="hidden" name="patient_id" id="patient_id" value="{{ old('patient_id') }}">
                            </div>

                            {{--  
                            <div class="col-md-12 mb-3">
                                <label for="status" class="form-label">Estado <span class="text-danger tx-12">*</span></label>
                                <select class="form-control" id="status" name="status" required>
                                    <option value="pending" {{ old('status', 'pending') == 'pending' ? 'selected' : '' }}>Pendiente</option>
                                    <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completada</option>
                                    <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelada</option>
                                </select>
                            </div>
                            --}}
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary btn-sm">
                                    <i class="fas fa-save"></i> Guardar Receta
                                </button>
                                <a href="{{ route('dif.prescriptions.index') }}" class="btn btn-secondary btn-sm">
                                    <i class="fas fa-times"></i> Cancelar
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
let selectedPatient = null;
let searchTimeout;

$(document).ready(function() {
    // Cargar paciente seleccionado del old input
    @if(old('patient_id'))
        const oldPatientId = '{{ old('patient_id') }}';
        if (oldPatientId) {
            // Buscar información del paciente seleccionado
            searchPatientById(oldPatientId);
        }
    @endif

    // Select2 para mejor UX en otros selectores
    if (typeof $.fn.select2 !== 'undefined') {
        $('#doctor_id').select2({
            placeholder: 'Seleccione un doctor',
            allowClear: true
        });
    }
});

// Función de búsqueda con debounce
$('#patient-search').on('input', function() {
    clearTimeout(searchTimeout);
    const query = $(this).val().trim();
    
    if (query.length === 0) {
        showEmptyState();
        return;
    }
    
    if (query.length < 2) {
        $('#patients-list').html(`
            <div class="text-center py-3">
                <i class="fas fa-keyboard fa-2x text-muted mb-2"></i>
                <p class="text-muted">Escribe al menos 2 caracteres para buscar...</p>
            </div>
        `);
        return;
    }
    
    searchTimeout = setTimeout(function() {
        searchPatients(query);
    }, 300);
});

// Función para buscar pacientes
function searchPatients(query) {
    showLoading();
    
    $.ajax({
        url: '{{ route("dif.patients.search") }}',
        type: 'GET',
        data: {
            query: query
        },
        success: function(response) {
            hideLoading();
            if (response.patients && response.patients.length > 0) {
                displayPatients(response.patients);
                
                // Mostrar contador de resultados
                const resultsText = response.patients.length === 1 ? 
                    '1 paciente encontrado' : 
                    `${response.patients.length} pacientes encontrados`;
                    
                $('#patients-list').prepend(`
                    <div class="alert alert-info alert-sm py-2 mb-3">
                        <i class="fas fa-info-circle me-2"></i>${resultsText}
                    </div>
                `);
            } else {
                showNoResults();
            }
        },
        error: function(xhr, status, error) {
            hideLoading();
            console.error('Error al buscar pacientes:', error);
            console.error('Status:', status);
            console.error('Response:', xhr.responseText);
            
            let errorMessage = 'Error al buscar pacientes. Inténtalo de nuevo.';
            
            if (xhr.status === 500) {
                errorMessage = 'Error interno del servidor. Contacta al administrador.';
            } else if (xhr.status === 404) {
                errorMessage = 'Servicio de búsqueda no encontrado.';
            }
            
            showError(errorMessage);
        }
    });
}

// Función para buscar paciente por ID (para old input)
function searchPatientById(patientId) {
    $.ajax({
        url: '{{ route("dif.patients.show", ":id") }}'.replace(':id', patientId),
        type: 'GET',
        success: function(response) {
            if (response.patient) {
                selectPatient(response.patient);
            }
        },
        error: function(xhr, status, error) {
            console.error('Error al cargar paciente:', error);
        }
    });
}

// Función para mostrar los pacientes
function displayPatients(patients) {
    let html = '';
    
    patients.forEach(function(patient) {
        const isSelected = selectedPatient && selectedPatient.id === patient.id;
        
        html += `
            <div class="patient-item ${isSelected ? 'selected' : ''}" 
                 data-patient-id="${patient.id}" 
                 onclick="selectPatient(${JSON.stringify(patient).replace(/"/g, '&quot;')})">
                <div class="d-flex justify-content-between align-items-start">
                    <div class="flex-grow-1 patient-info">
                        <strong class="d-block">${patient.name} ${patient.first_name || ''} ${patient.last_name || ''}</strong>
                        <small class="text-muted d-block mt-1">
                            <i class="fas fa-id-card me-1"></i>CURP: ${patient.curp || 'No disponible'}
                        </small>
                        ${patient.phone ? `<small class="text-info d-block"><i class="fas fa-phone me-1"></i>${patient.phone}</small>` : ''}
                        ${patient.email ? `<small class="text-info d-block"><i class="fas fa-envelope me-1"></i>${patient.email}</small>` : ''}
                    </div>
                    ${isSelected ? '<i class="fas fa-check-circle text-success ms-2"></i>' : '<i class="fas fa-user-plus text-primary ms-2"></i>'}
                </div>
            </div>
        `;
    });
    
    $('#patients-list').html(html);
}

// Función para seleccionar un paciente
function selectPatient(patient) {
    selectedPatient = patient;
    
    // Actualizar input oculto
    $('#patient_id').val(patient.id);
    
    // Mostrar información del paciente seleccionado
    updateSelectedPatientDisplay();
    
    // Ocultar el contenedor de búsqueda
    $('#patients-container').hide();
    $('#patient-search').val('');
    
    // Limpiar la lista de pacientes
    $('#patients-list').html('');
}

// Función para actualizar la visualización del paciente seleccionado
function updateSelectedPatientDisplay() {
    if (!selectedPatient) {
        $('#selected-patient').hide();
        return;
    }
    
    $('#selected-patient').show();
    
    const patientInfo = `
        <div class="card border-primary">
            <div class="card-body py-3">
                <div class="d-flex justify-content-between align-items-start">
                    <div class="flex-grow-1">
                        <h6 class="card-title mb-2">
                            <i class="fas fa-user text-primary me-2"></i>${selectedPatient.name} ${selectedPatient.first_name || ''} ${selectedPatient.last_name || ''}
                        </h6>
                        <div class="row">
                            <div class="col-md-6">
                                <small class="text-muted d-block">
                                    <i class="fas fa-id-card me-1"></i>CURP: ${selectedPatient.curp || 'No disponible'}
                                </small>
                                ${selectedPatient.phone ? `<small class="text-info d-block"><i class="fas fa-phone me-1"></i>${selectedPatient.phone}</small>` : ''}
                            </div>
                            <div class="col-md-6">
                                ${selectedPatient.email ? `<small class="text-info d-block"><i class="fas fa-envelope me-1"></i>${selectedPatient.email}</small>` : ''}
                            </div>
                        </div>
                    </div>
                    <div class="text-end">
                        <span class="badge bg-success">Seleccionado</span>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    $('#selected-patient-info').html(patientInfo);
}

// Función para limpiar el paciente seleccionado
function clearSelectedPatient() {
    selectedPatient = null;
    $('#patient_id').val('');
    $('#selected-patient').hide();
    $('#patients-container').show();
    $('#patient-search').focus();
    showEmptyState();
}

// Funciones de estado de la interfaz
function showLoading() {
    $('#patients-list').html(`
        <div class="text-center py-4">
            <div class="spinner-border text-primary loading-spinner" role="status" style="width: 2rem; height: 2rem;">
                <span class="visually-hidden">Cargando...</span>
            </div>
            <p class="text-muted mt-3 mb-0">Buscando pacientes...</p>
        </div>
    `);
}

function hideLoading() {
    // La función displayPatients se encarga de mostrar el contenido
}

function showEmptyState() {
    $('#patients-list').html(`
        <div class="text-center py-4">
            <i class="fas fa-user-friends fa-3x text-muted mb-3"></i>
            <h6 class="text-muted">Buscar Pacientes</h6>
            <p class="text-muted mb-0">Comienza a escribir para buscar pacientes disponibles...</p>
        </div>
    `);
}

function showNoResults() {
    $('#patients-list').html(`
        <div class="text-center py-4">
            <i class="fas fa-user-slash fa-3x text-muted mb-3"></i>
            <h6 class="text-muted">No se encontraron pacientes</h6>
            <p class="text-muted mb-0">Intenta con otros términos de búsqueda</p>
        </div>
    `);
}

function showError(message = 'Hubo un problema al conectar con el servidor. Inténtalo de nuevo.') {
    $('#patients-list').html(`
        <div class="text-center py-4">
            <i class="fas fa-exclamation-triangle fa-3x text-warning mb-3"></i>
            <h6 class="text-warning">Error al buscar pacientes</h6>
            <p class="text-muted mb-0">${message}</p>
            <button class="btn btn-outline-primary btn-sm mt-2" onclick="$('#patient-search').trigger('input')">
                <i class="fas fa-redo me-1"></i>Reintentar
            </button>
        </div>
    `);
}

// Validación del formulario
$('form').on('submit', function(e) {
    if (!$('#patient_id').val()) {
        e.preventDefault();
        alert('Por favor selecciona un paciente antes de continuar.');
        $('#patient-search').focus();
        return false;
    }
});
</script>
@endsection
