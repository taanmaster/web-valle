@extends('layouts.master')

@section('title')Crear Recibo @endsection

@section('css')
<style>
    .patient-search-container, .concept-search-container {
        position: relative;
    }
    
    .patients-container, .concepts-container {
        background: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        transition: all 0.3s ease;
    }
    
    .patients-container:hover, .concepts-container:hover {
        border-color: #007bff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }
    
    .patient-item, .concept-item {
        transition: all 0.2s ease;
        padding: 12px;
        border-radius: 4px;
        margin-bottom: 8px;
        cursor: pointer;
        border: 1px solid transparent;
    }
    
    .patient-item:hover, .concept-item:hover {
        background-color: #e9ecef;
        border-color: #007bff;
    }
    
    .patient-item.selected, .concept-item.selected {
        background-color: #e7f3ff;
        border-color: #007bff;
    }
    
    .selected-patient-badge, .selected-concept-badge {
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
    
    .concept-list-item {
        border: 1px solid #dee2e6;
        border-radius: 8px;
        background: #fff;
        transition: all 0.2s ease;
        margin-bottom: 10px;
    }
    
    .concept-list-item:hover {
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .concept-search-field {
        border: 2px dashed #dee2e6;
        border-radius: 8px;
        background: #f8f9fa;
        padding: 15px;
        margin-bottom: 15px;
        transition: all 0.3s ease;
    }
    
    .concept-search-field:hover {
        border-color: #007bff;
        background: #e7f3ff;
    }
    
    .concept-checkbox:checked + .form-check-label {
        color: #007bff;
        font-weight: 600;
    }
    
    .selected-concepts-badge {
        animation: fadeIn 0.3s ease;
    }
    
    .patient-info, .concept-info {
        transition: color 0.2s ease;
    }
    
    .patient-item:hover .patient-info,
    .concept-item:hover .concept-info {
        color: #007bff;
    }
    
    #selected-concepts-table {
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    #selected-concepts-table th {
        background-color: #f8f9fa;
        border-bottom: 2px solid #dee2e6;
        font-weight: 600;
        color: #495057;
    }
    
    #selected-concepts-table td {
        vertical-align: middle;
        border-bottom: 1px solid #dee2e6;
    }
    
    #selected-concepts-table .table-info {
        background-color: #e7f3ff !important;
        border-top: 2px solid #007bff;
    }
    
    .selected-concepts-badge {
        animation: fadeIn 0.3s ease;
    }
</style>
@endsection

@section('content')
    <!-- this is breadcrumbs -->
    @component('components.breadcrumb')
        @slot('li_1') Intranet @endslot
        @slot('li_2') DIF @endslot
        @slot('li_3') <a href="{{ route('dif.receipts.index') }}">Recibos</a> @endslot
        @slot('title') Crear Recibo @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <h5 class="card-title">
                            <i class="fas fa-plus"></i> Crear Recibo
                        </h5>
                        <div class="d-flex">
                            <a href="{{ route('dif.receipts.index') }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-arrow-left"></i> Volver
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('dif.receipts.store') }}" id="receiptForm">
                        @csrf
                        
                        <!-- Encabezado de la Factura -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h4 class="text-primary">
                                    <i class="fas fa-receipt"></i> RECIBO DE PAGO
                                </h4>
                                <p class="text-muted">Sistema Integral Municipal DIF</p>
                            </div>
                            <div class="col-md-6 text-end">
                                <div class="mb-2">
                                    <strong>Folio:</strong>
                                    <span class="badge bg-primary">{{ $receiptNum }}</span>
                                </div>
                                <div class="mb-2">
                                    <strong>Fecha:</strong>
                                    <span>{{ date('d/m/Y H:i:s') }}</span>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <!-- Información del Recibo -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h5>Información del Doctor</h5>
                                
                                @php
                                    $doctorIdFromRequest = request()->input('doctor_id');
                                    $doctorReadonly = !empty($doctorIdFromRequest);
                                @endphp

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

                                <input type="hidden" readonly name="receipt_num" value="{{ $receiptNum }}">
                                <input type="hidden" readonly name="receipt_date" value="{{ date('Y-m-d') }}">
                                <input type="hidden" readonly name="issued_by" value="{{ Auth::user()->name }}">
                                
                                <div class="form-group mb-3">
                                    <label for="appointment">Cita:</label>
                                    <input type="text" name="appointment" id="appointment" class="form-control" placeholder="Número de cita (opcional)" value="{{ old('appointment') }}">
                                </div>
                                
                                <div class="form-group mb-3">
                                    <label for="location">Ubicación:</label>
                                    <input type="text" name="location" id="location" class="form-control" placeholder="Ubicación del servicio (opcional)" value="{{ old('location') }}">
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <h5>Información del Paciente</h5>
                                
                                <div class="form-group mb-3">
                                    <label for="patient_id">Paciente <span class="text-danger">*</span></label>
                                    
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
                                
                                <div class="form-group mb-3">
                                    <label for="payment_method">Método de Pago:</label>
                                    <select name="payment_method" id="payment_method" class="form-control">
                                        <option value="cash" {{ old('payment_method', 'cash') == 'cash' ? 'selected' : '' }}>Efectivo</option>
                                        <option value="card" {{ old('payment_method') == 'card' ? 'selected' : '' }}>Tarjeta</option>
                                        <option value="transfer" {{ old('payment_method') == 'transfer' ? 'selected' : '' }}>Transferencia</option>
                                        <option value="check" {{ old('payment_method') == 'check' ? 'selected' : '' }}>Cheque</option>
                                    </select>
                                </div>
                                
                                <div class="form-group mb-3">
                                    <label for="status">Estado:</label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pendiente</option>
                                        <option value="completed" {{ old('status', 'completed') == 'completed' ? 'selected' : '' }}>Completado</option>
                                        <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelado</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Conceptos de Pago -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5><i class="fas fa-money-bill"></i> Conceptos de Pago</h5>
                                <p class="text-muted">Busca y selecciona los conceptos de pago aplicables:</p>
                                
                                <!-- Buscador de conceptos -->
                                <div class="form-group mb-3">
                                    <label for="concept-search" class="form-label">
                                        <i class="fas fa-search me-1"></i>Buscar Conceptos de Pago
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-search search-icon"></i>
                                        </span>
                                        <input type="text" 
                                            id="concept-search" 
                                            class="form-control" 
                                            placeholder="Ej: consulta, medicamento, estudio..." 
                                            autocomplete="off"
                                            aria-describedby="concept-search-help">
                                    </div>
                                    <small id="concept-search-help" class="form-text text-muted">
                                        Escribe el nombre o descripción del concepto de pago que buscas
                                    </small>
                                </div>

                                <!-- Conceptos seleccionados -->
                                <div id="selected-concepts" class="mb-3" style="display: none;">
                                    <h6><i class="fas fa-check-circle text-success"></i> Conceptos Seleccionados:</h6>
                                    <div class="table-responsive">
                                        <table class="table table-sm table-bordered" id="selected-concepts-table">
                                            <thead class="table-light">
                                                <tr>
                                                    <th width="60%">Concepto</th>
                                                    <th width="25%">Monto</th>
                                                    <th width="15%">Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody id="selected-concepts-list">
                                                <!-- Los conceptos seleccionados se mostrarán aquí -->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                
                                <!-- Contenedor de conceptos -->
                                <div class="concepts-container" style="max-height: 400px; overflow-y: auto; padding: 15px;">
                                    <div id="concepts-list">
                                        <!-- Los conceptos se cargarán aquí dinámicamente -->
                                        <div class="text-center py-4">
                                            <i class="fas fa-search fa-3x text-muted mb-3"></i>
                                            <h6 class="text-muted">Buscar Conceptos de Pago</h6>
                                            <p class="text-muted mb-0">Comienza a escribir para buscar conceptos disponibles...</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="mt-3">
                                    <button type="button" class="btn btn-sm btn-outline-primary" onclick="selectAllVisibleConcepts()">
                                        <i class="fas fa-check-double"></i> Seleccionar Visibles
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="deselectAllConcepts()">
                                        <i class="fas fa-times"></i> Deseleccionar Todos
                                    </button>
                                </div>

                                <!-- Inputs ocultos para enviar al controlador -->
                                <div id="hidden-concept-inputs"></div>
                            </div>
                        </div>

                        <!-- Totales -->
                        <div class="row mb-4">
                            <div class="col-md-8"></div>
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Resumen</h5>
                                        
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>Subtotal:</span>
                                            <span id="subtotal-display">$0.00</span>
                                        </div>
                                        
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>Descuento:</span>
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-text">$</span>
                                                <input type="number" name="discount" id="discount-input" class="form-control" min="0" step="0.01" value="{{ old('discount', 0) }}">
                                            </div>
                                        </div>
                                        
                                        <hr>
                                        
                                        <div class="d-flex justify-content-between mb-2">
                                            <strong>Total:</strong>
                                            <strong id="total-display">$0.00</strong>
                                        </div>

                                        <input type="hidden" name="subtotal" id="subtotal-hidden" value="{{ old('subtotal', 0) }}">
                                        <input type="hidden" name="total" id="total-hidden" value="{{ old('total', 0) }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Crear Recibo</button>
                            <a href="{{ route('dif.receipts.index') }}" class="btn btn-secondary">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
<script>
// Variables globales
let selectedPatient = null;
let selectedConcepts = [];
let searchTimeout;
let conceptSearchTimeout;

$(document).ready(function() {
    // Cargar paciente seleccionado del old input
    @if(old('patient_id'))
        const oldPatientId = '{{ old('patient_id') }}';
        if (oldPatientId) {
            // Buscar información del paciente seleccionado
            searchPatientById(oldPatientId);
        }
    @endif

    // Cargar conceptos seleccionados del old input
    @if(old('concept_ids'))
        selectedConcepts = @json(old('concept_ids', []));
        selectedConcepts = selectedConcepts.map(id => id.toString());
        updateSelectedConceptsDisplay();
        updateHiddenConceptInputs();
    @endif

    // Select2 para mejor UX en otros selectores
    if (typeof $.fn.select2 !== 'undefined') {
        $('#doctor_id, #payment_method, #status').select2({
            placeholder: function(){
                return $(this).data('placeholder');
            },
            allowClear: true
        });
    }

    // Calcular totales iniciales
    calculateTotals();
});

// ========== FUNCIONALIDAD DE BÚSQUEDA DE PACIENTES ==========

// Función de búsqueda de pacientes con debounce
$('#patient-search').on('input', function() {
    clearTimeout(searchTimeout);
    const query = $(this).val().trim();
    
    if (query.length === 0) {
        showPatientEmptyState();
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
    showPatientLoading();
    
    $.ajax({
        url: '{{ route("dif.patients.search") }}',
        type: 'GET',
        data: {
            query: query
        },
        success: function(response) {
            hidePatientLoading();
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
                showPatientNoResults();
            }
        },
        error: function(xhr, status, error) {
            hidePatientLoading();
            console.error('Error al buscar pacientes:', error);
            showPatientError('Error al buscar pacientes. Inténtalo de nuevo.');
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
                        <strong class="d-block">${patient.name}</strong>
                        <small class="text-muted d-block mt-1">
                            <i class="fas fa-id-card me-1"></i>CURP: ${patient.curp || 'No disponible'}
                        </small>
                        ${patient.phone ? `<small class="text-info d-block"><i class="fas fa-phone me-1"></i>${patient.phone}</small>` : ''}
                        ${patient.email ? `<small class="text-info d-block"><i class="fas fa-envelope me-1"></i>${patient.email}</small>` : ''}
                        ${patient.address ? `<small class="text-muted d-block"><i class="fas fa-map-marker-alt me-1"></i>${patient.address}</small>` : ''}
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
                            <i class="fas fa-user text-primary me-2"></i>${selectedPatient.name}
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
                                ${selectedPatient.address ? `<small class="text-muted d-block"><i class="fas fa-map-marker-alt me-1"></i>${selectedPatient.address}</small>` : ''}
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
    showPatientEmptyState();
}

// ========== FUNCIONALIDAD DE BÚSQUEDA DE CONCEPTOS ==========

// Función de búsqueda de conceptos con debounce
$('#concept-search').on('input', function() {
    clearTimeout(conceptSearchTimeout);
    const query = $(this).val().trim();
    
    if (query.length === 0) {
        showConceptEmptyState();
        return;
    }
    
    if (query.length < 2) {
        $('#concepts-list').html(`
            <div class="text-center py-3">
                <i class="fas fa-keyboard fa-2x text-muted mb-2"></i>
                <p class="text-muted">Escribe al menos 2 caracteres para buscar...</p>
            </div>
        `);
        return;
    }
    
    conceptSearchTimeout = setTimeout(function() {
        searchConcepts(query);
    }, 300);
});

// Función para buscar conceptos
function searchConcepts(query) {
    showConceptLoading();
    
    $.ajax({
        url: '{{ route("dif.payment-concepts.search") }}',
        type: 'GET',
        data: {
            query: query
        },
        success: function(response) {
            hideConceptLoading();
            if (response.concepts && response.concepts.length > 0) {
                displayConcepts(response.concepts);
                
                // Mostrar contador de resultados
                const resultsText = response.concepts.length === 1 ? 
                    '1 concepto encontrado' : 
                    `${response.concepts.length} conceptos encontrados`;
                    
                $('#concepts-list').prepend(`
                    <div class="alert alert-info alert-sm py-2 mb-3">
                        <i class="fas fa-info-circle me-2"></i>${resultsText}
                    </div>
                `);
            } else {
                showConceptNoResults();
            }
        },
        error: function(xhr, status, error) {
            hideConceptLoading();
            console.error('Error al buscar conceptos:', error);
            showConceptError('Error al buscar conceptos. Inténtalo de nuevo.');
        }
    });
}

// Función para mostrar los conceptos
function displayConcepts(concepts) {
    let html = '';
    
    concepts.forEach(function(concept) {
        const isSelected = selectedConcepts.includes(concept.id.toString());
        
        html += `
            <div class="form-check mb-3 concept-item" data-concept-id="${concept.id}">
                <input type="checkbox" class="form-check-input concept-checkbox" 
                       id="concept_${concept.id}" 
                       value="${concept.id}"
                       data-amount="${concept.amount}"
                       ${isSelected ? 'checked' : ''}
                       onchange="toggleConcept(${concept.id}, '${concept.name.replace(/'/g, "\\'")}', ${concept.amount})">
                <label class="form-check-label w-100" for="concept_${concept.id}">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="flex-grow-1 concept-info">
                            <strong class="d-block">${concept.name}</strong>
                            ${concept.description ? `<small class="text-muted d-block mt-1">${concept.description.length > 80 ? concept.description.substring(0, 80) + '...' : concept.description}</small>` : ''}
                            <small class="text-success d-block mt-1"><i class="fas fa-dollar-sign me-1"></i>$${parseFloat(concept.amount).toFixed(2)}</small>
                        </div>
                        ${isSelected ? '<i class="fas fa-check-circle text-success ms-2"></i>' : ''}
                    </div>
                </label>
            </div>
        `;
    });
    
    $('#concepts-list').html(html);
}

// Función para alternar selección de concepto
function toggleConcept(conceptId, conceptName, conceptAmount) {
    const conceptIdStr = conceptId.toString();
    
    if (selectedConcepts.includes(conceptIdStr)) {
        // Remover de seleccionados
        selectedConcepts = selectedConcepts.filter(id => id !== conceptIdStr);
    } else {
        // Agregar a seleccionados
        selectedConcepts.push(conceptIdStr);
    }
    
    updateSelectedConceptsDisplay();
    updateHiddenConceptInputs();
    calculateTotals();
}

// Función para actualizar la visualización de conceptos seleccionados
function updateSelectedConceptsDisplay() {
    const count = selectedConcepts.length;
    
    if (count === 0) {
        $('#selected-concepts').hide();
        return;
    }
    
    $('#selected-concepts').show();
    
    let html = '';
    let totalAmount = 0;
    
    selectedConcepts.forEach(function(conceptId) {
        const conceptElement = $(`.concept-item[data-concept-id="${conceptId}"]`);
        if (conceptElement.length > 0) {
            const conceptName = conceptElement.find('label strong').text();
            const conceptAmount = parseFloat(conceptElement.find('input').data('amount'));
            totalAmount += conceptAmount;
            
            html += `
                <tr>
                    <td>
                        <strong>${conceptName}</strong>
                        <div class="small text-muted">
                            ${conceptElement.find('label small').first().text() || 'Sin descripción'}
                        </div>
                    </td>
                    <td class="text-end">
                        <span class="badge bg-success">$${conceptAmount.toFixed(2)}</span>
                    </td>
                    <td class="text-center">
                        <button type="button" class="btn btn-outline-danger btn-sm" 
                                onclick="removeSelectedConcept('${conceptId}')" 
                                title="Remover concepto">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
            `;
        }
    });
    
    // Agregar fila de total
    html += `
        <tr class="table-info">
            <td><strong>Total de Conceptos:</strong></td>
            <td class="text-end">
                <strong class="text-primary">$${totalAmount.toFixed(2)}</strong>
            </td>
            <td class="text-center">
                <span class="badge bg-info">${count} concepto${count !== 1 ? 's' : ''}</span>
            </td>
        </tr>
    `;
    
    $('#selected-concepts-list').html(html);
}

// Función para remover concepto seleccionado
function removeSelectedConcept(conceptId) {
    selectedConcepts = selectedConcepts.filter(id => id !== conceptId);
    
    // Desmarcar checkbox si está visible
    $(`#concept_${conceptId}`).prop('checked', false);
    
    updateSelectedConceptsDisplay();
    updateHiddenConceptInputs();
    calculateTotals();
}

// Función para actualizar inputs ocultos de conceptos
function updateHiddenConceptInputs() {
    let html = '';
    selectedConcepts.forEach(function(conceptId) {
        html += `<input type="hidden" name="concept_ids[]" value="${conceptId}">`;
    });
    $('#hidden-concept-inputs').html(html);
}

// Función para seleccionar todos los conceptos visibles
function selectAllVisibleConcepts() {
    $('.concept-checkbox:visible').each(function() {
        if (!$(this).prop('checked')) {
            $(this).prop('checked', true);
            const conceptId = $(this).val();
            if (!selectedConcepts.includes(conceptId)) {
                selectedConcepts.push(conceptId);
            }
        }
    });
    
    updateSelectedConceptsDisplay();
    updateHiddenConceptInputs();
    calculateTotals();
}

// Función para deseleccionar todos los conceptos
function deselectAllConcepts() {
    selectedConcepts = [];
    $('.concept-checkbox').prop('checked', false);
    updateSelectedConceptsDisplay();
    updateHiddenConceptInputs();
    calculateTotals();
}

// ========== FUNCIONES DE CÁLCULO DE TOTALES ==========

// Función para calcular totales
function calculateTotals() {
    let subtotal = 0;
    
    // Calcular con base en los conceptos seleccionados
    selectedConcepts.forEach(function(conceptId) {
        const conceptElement = $(`.concept-item[data-concept-id="${conceptId}"] input`);
        if (conceptElement.length > 0) {
            subtotal += parseFloat(conceptElement.data('amount') || 0);
        }
    });
    
    let discount = parseFloat($('#discount-input').val()) || 0;
    let total = subtotal - discount;
    
    // Actualizar display
    $('#subtotal-display').text('$' + subtotal.toFixed(2));
    $('#total-display').text('$' + total.toFixed(2));
    
    // Actualizar campos ocultos
    $('#subtotal-hidden').val(subtotal.toFixed(2));
    $('#total-hidden').val(total.toFixed(2));
}

// Eventos para recalcular totales
$('#discount-input').on('input', calculateTotals);

// ========== FUNCIONES DE ESTADO DE LA INTERFAZ - PACIENTES ==========

function showPatientLoading() {
    $('#patients-list').html(`
        <div class="text-center py-4">
            <div class="spinner-border text-primary loading-spinner" role="status" style="width: 2rem; height: 2rem;">
                <span class="visually-hidden">Cargando...</span>
            </div>
            <p class="text-muted mt-3 mb-0">Buscando pacientes...</p>
        </div>
    `);
}

function hidePatientLoading() {
    // La función displayPatients se encarga de mostrar el contenido
}

function showPatientEmptyState() {
    $('#patients-list').html(`
        <div class="text-center py-4">
            <i class="fas fa-user-friends fa-3x text-muted mb-3"></i>
            <h6 class="text-muted">Buscar Pacientes</h6>
            <p class="text-muted mb-0">Comienza a escribir para buscar pacientes disponibles...</p>
        </div>
    `);
}

function showPatientNoResults() {
    $('#patients-list').html(`
        <div class="text-center py-4">
            <i class="fas fa-user-slash fa-3x text-muted mb-3"></i>
            <h6 class="text-muted">No se encontraron pacientes</h6>
            <p class="text-muted mb-0">Intenta con otros términos de búsqueda</p>
        </div>
    `);
}

function showPatientError(message = 'Hubo un problema al conectar con el servidor. Inténtalo de nuevo.') {
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

// ========== FUNCIONES DE ESTADO DE LA INTERFAZ - CONCEPTOS ==========

function showConceptLoading() {
    $('#concepts-list').html(`
        <div class="text-center py-4">
            <div class="spinner-border text-primary loading-spinner" role="status" style="width: 2rem; height: 2rem;">
                <span class="visually-hidden">Cargando...</span>
            </div>
            <p class="text-muted mt-3 mb-0">Buscando conceptos...</p>
        </div>
    `);
}

function hideConceptLoading() {
    // La función displayConcepts se encarga de mostrar el contenido
}

function showConceptEmptyState() {
    $('#concepts-list').html(`
        <div class="text-center py-4">
            <i class="fas fa-search fa-3x text-muted mb-3"></i>
            <h6 class="text-muted">Buscar Conceptos de Pago</h6>
            <p class="text-muted mb-0">Comienza a escribir para buscar conceptos disponibles...</p>
        </div>
    `);
}

function showConceptNoResults() {
    $('#concepts-list').html(`
        <div class="text-center py-4">
            <i class="fas fa-money-bill-slash fa-3x text-muted mb-3"></i>
            <h6 class="text-muted">No se encontraron conceptos</h6>
            <p class="text-muted mb-0">Intenta con otros términos de búsqueda</p>
        </div>
    `);
}

function showConceptError(message = 'Hubo un problema al conectar con el servidor. Inténtalo de nuevo.') {
    $('#concepts-list').html(`
        <div class="text-center py-4">
            <i class="fas fa-exclamation-triangle fa-3x text-warning mb-3"></i>
            <h6 class="text-warning">Error al buscar conceptos</h6>
            <p class="text-muted mb-0">${message}</p>
            <button class="btn btn-outline-primary btn-sm mt-2" onclick="$('#concept-search').trigger('input')">
                <i class="fas fa-redo me-1"></i>Reintentar
            </button>
        </div>
    `);
}

// ========== VALIDACIÓN DEL FORMULARIO ==========

// Validación del formulario
$('#receiptForm').on('submit', function(e) {
    if (!$('#patient_id').val()) {
        e.preventDefault();
        alert('Por favor selecciona un paciente antes de continuar.');
        $('#patient-search').focus();
        return false;
    }

    if (selectedConcepts.length === 0) {
        e.preventDefault();
        alert('Debe seleccionar al menos un concepto de pago.');
        $('#concept-search').focus();
        return false;
    }
    
    if (parseFloat($('#total-hidden').val()) < 0) {
        e.preventDefault();
        alert('El total no puede ser negativo.');
        return false;
    }
});
</script>
@endsection
