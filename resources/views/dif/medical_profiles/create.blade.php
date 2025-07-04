@extends('layouts.master')

@section('title')Agregar Perfil Médico @endsection

@section('css')
<style>
    .program-search-container {
        position: relative;
    }
    
    .programs-container {
        background: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        transition: all 0.3s ease;
    }
    
    .programs-container:hover {
        border-color: #007bff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }
    
    .program-item {
        transition: all 0.2s ease;
        padding: 8px;
        border-radius: 4px;
        margin-bottom: 8px;
    }
    
    .program-item:hover {
        background-color: #e9ecef;
    }
    
    .program-checkbox:checked + .form-check-label {
        color: #007bff;
        font-weight: 600;
    }
    
    .selected-programs-badge {
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
    
    #program-search:focus + .search-icon {
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
    
    /* Estilos para información del ciudadano */
    #citizen-info {
        border-left: 4px solid #007bff;
        background: linear-gradient(135deg, #e3f2fd 0%, #f8f9fa 100%);
        border-radius: 8px;
        animation: slideInDown 0.3s ease;
    }
    
    @keyframes slideInDown {
        from {
            transform: translateY(-10px);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }
    
    #citizen-loading {
        animation: fadeIn 0.3s ease;
    }
    
    .form-control:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }
</style>
@endsection

@section('content')
    <!-- this is breadcrumbs -->
    @component('components.breadcrumb')
        @slot('li_1') Intranet @endslot
        @slot('li_2') DIF @endslot
        @slot('li_3') <a href="{{ route('dif.medical_profiles.index') }}">Perfiles Médicos</a> @endslot
        @slot('title') Agregar Perfil Médico @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <h5 class="card-title">
                            <i class="fas fa-plus"></i> Agregar Perfil Médico
                        </h5>
                        <div class="d-flex">
                            <a href="{{ route('dif.medical_profiles.index') }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-arrow-left"></i> Volver
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('dif.medical_profiles.store') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <h5><i class="fas fa-user"></i> Información del Ciudadano</h5>
                                
                                <div class="form-group mb-3">
                                    <label for="citizen_id">Ciudadano:</label>
                                    <select name="citizen_id" id="citizen_id" class="form-control" required>
                                        <option value="">Selecciona un ciudadano</option>
                                        @foreach($citizens as $citizen)
                                            <option value="{{ $citizen->id }}" {{ old('citizen_id') == $citizen->id ? 'selected' : '' }}>
                                                {{ $citizen->name }} {{ $citizen->first_name }} {{ $citizen->last_name }} (ID: {{ $citizen->id }})
                                            </option>
                                        @endforeach
                                    </select>
                                    <small class="form-text text-muted">Al seleccionar un ciudadano, se pre-llenará automáticamente la información disponible.</small>
                                </div>

                                <h5><i class="fas fa-id-card"></i> Información Médica</h5>
                                
                                <div class="form-group mb-3">
                                    <label for="medical_num">Número Médico:</label>
                                    <input type="text" name="medical_num" id="medical_num" class="form-control" 
                                           placeholder="Ingresa el número médico" value="{{ old('medical_num') }}" required>
                                </div>
                                
                                <div class="form-group mb-3">
                                    <label for="blood_type">Tipo de Sangre:</label>
                                    <select name="blood_type" id="blood_type" class="form-control">
                                        <option value="">Selecciona tipo de sangre</option>
                                        <option value="A+" {{ old('blood_type') == 'A+' ? 'selected' : '' }}>A+</option>
                                        <option value="A-" {{ old('blood_type') == 'A-' ? 'selected' : '' }}>A-</option>
                                        <option value="B+" {{ old('blood_type') == 'B+' ? 'selected' : '' }}>B+</option>
                                        <option value="B-" {{ old('blood_type') == 'B-' ? 'selected' : '' }}>B-</option>
                                        <option value="AB+" {{ old('blood_type') == 'AB+' ? 'selected' : '' }}>AB+</option>
                                        <option value="AB-" {{ old('blood_type') == 'AB-' ? 'selected' : '' }}>AB-</option>
                                        <option value="O+" {{ old('blood_type') == 'O+' ? 'selected' : '' }}>O+</option>
                                        <option value="O-" {{ old('blood_type') == 'O-' ? 'selected' : '' }}>O-</option>
                                    </select>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="gender">Género:</label>
                                    <select name="gender" id="gender" class="form-control" required>
                                        <option value="">Selecciona género</option>
                                        <option value="Masculino" {{ old('gender') == 'Masculino' ? 'selected' : '' }}>Masculino</option>
                                        <option value="Femenino" {{ old('gender') == 'Femenino' ? 'selected' : '' }}>Femenino</option>
                                        <option value="Otro" {{ old('gender') == 'Otro' ? 'selected' : '' }}>Otro</option>
                                    </select>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="age">Edad:</label>
                                    <input type="number" name="age" id="age" class="form-control" 
                                           placeholder="Ingresa la edad" value="{{ old('age') }}" min="0" max="150">
                                </div>

                                <div class="form-group mb-3">
                                    <label for="phone">Teléfono:</label>
                                    <input type="text" name="phone" id="phone" class="form-control" 
                                           placeholder="Ingresa el teléfono" value="{{ old('phone') }}">
                                </div>

                                <div class="form-group mb-3">
                                    <label for="email">Correo Electrónico:</label>
                                    <input type="email" name="email" id="email" class="form-control" 
                                           placeholder="Ingresa el correo electrónico" value="{{ old('email') }}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <h5><i class="fas fa-notes-medical"></i> Información Médica Adicional</h5>
                                
                                <div class="form-group mb-3">
                                    <label for="allergies">Alergias:</label>
                                    <input type="text" name="allergies" id="allergies" class="form-control" 
                                           placeholder="Ingresa las alergias (opcional)" value="{{ old('allergies') }}">
                                </div>
                                
                                <div class="form-group mb-3">
                                    <label for="medical_conditions">Condiciones Médicas:</label>
                                    <textarea name="medical_conditions" id="medical_conditions" class="form-control" 
                                              placeholder="Ingresa las condiciones médicas (opcional)" rows="3">{{ old('medical_conditions') }}</textarea>
                                </div>
                                
                                <div class="form-group mb-3">
                                    <label for="medications">Medicamentos:</label>
                                    <textarea name="medications" id="medications" class="form-control" 
                                              placeholder="Ingresa los medicamentos (opcional)" rows="3">{{ old('medications') }}</textarea>
                                </div>

                                <hr>

                                <div class="mb-3">
                                    <h5><i class="fas fa-folder"></i> Programas Asociados</h5>
                                    <p class="text-muted">Selecciona los programas médicos para este perfil:</p>
                                    
                                    <!-- Buscador de programas -->
                                    <div class="form-group mb-3">
                                        <label for="program-search" class="form-label">
                                            <i class="fas fa-search me-1"></i>Buscar Programas
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="fas fa-search search-icon"></i>
                                            </span>
                                            <input type="text" 
                                                id="program-search" 
                                                class="form-control" 
                                                placeholder="Ej: salud, medicina, rehabilitación..." 
                                                autocomplete="off"
                                                aria-describedby="search-help">
                                        </div>
                                        <small id="search-help" class="form-text text-muted">
                                            Escribe el nombre, descripción o dirección del programa que buscas
                                        </small>
                                    </div>

                                    <!-- Programas seleccionados -->
                                    <div id="selected-programs" class="mb-3" style="display: none;">
                                        <h6><i class="fas fa-check-circle text-success"></i> Programas Seleccionados:</h6>
                                        <div id="selected-programs-list" class="d-flex flex-wrap gap-2"></div>
                                    </div>
                                    
                                    <!-- Contenedor de programas -->
                                    <div class="programs-container" style="max-height: 300px; overflow-y: auto; padding: 15px;">
                                        <div id="programs-list">
                                            <!-- Los programas se cargarán aquí dinámicamente -->
                                            <div class="text-center py-4">
                                                <i class="fas fa-search fa-3x text-muted mb-3"></i>
                                                <h6 class="text-muted">Buscar Programas</h6>
                                                <p class="text-muted mb-0">Comienza a escribir para buscar programas disponibles...</p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="mt-3">
                                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="selectAllVisiblePrograms()">
                                            <i class="fas fa-check-double"></i> Seleccionar Visibles
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="deselectAllPrograms()">
                                            <i class="fas fa-times"></i> Deseleccionar Todos
                                        </button>
                                    </div>

                                    <!-- Inputs ocultos para enviar al controlador -->
                                    <div id="hidden-inputs"></div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mt-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-1"></i>Guardar Perfil Médico
                                    </button>
                                    <a href="{{ route('dif.medical_profiles.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-arrow-left me-1"></i>Cancelar
                                    </a>
                                </div>
                                <div>
                                    <small class="text-muted">
                                        <span id="programs-count">0 programas seleccionados</span>
                                    </small>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
<script>
let selectedPrograms = [];
let searchTimeout;

$(document).ready(function() {
    // Cargar programas seleccionados del old input
    @if(old('program_ids'))
        selectedPrograms = @json(old('program_ids'));
        updateSelectedProgramsDisplay();
        updateHiddenInputs();
    @endif

    // Manejar cambio de ciudadano para pre-llenar formulario
    $('#citizen_id').on('change', function() {
        const citizenId = $(this).val();
        
        if (citizenId) {
            // Mostrar indicador de carga
            showCitizenLoadingIndicator();
            
            // Obtener información del ciudadano
            $.ajax({
                url: `{{ route('dif.medical_profiles.citizen_info', '') }}/${citizenId}`,
                type: 'GET',
                success: function(response) {
                    if (response.success) {
                        preFillFormWithCitizenData(response.citizen);
                        showCitizenLoadingSuccess();
                    } else {
                        showCitizenLoadingError('No se pudo cargar la información del ciudadano');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error al obtener información del ciudadano:', error);
                    showCitizenLoadingError('Error al cargar la información del ciudadano');
                }
            });
        } else {
            // Limpiar campos si no hay ciudadano seleccionado
            clearCitizenFields();
            hideCitizenLoadingIndicator();
        }
    });
});

// Función de búsqueda con debounce
$('#program-search').on('input', function() {
    clearTimeout(searchTimeout);
    const query = $(this).val().trim();
    
    if (query.length === 0) {
        showEmptyState();
        return;
    }
    
    if (query.length < 2) {
        $('#programs-list').html(`
            <div class="text-center py-3">
                <i class="fas fa-keyboard fa-2x text-muted mb-2"></i>
                <p class="text-muted">Escribe al menos 2 caracteres para buscar...</p>
            </div>
        `);
        return;
    }
    
    searchTimeout = setTimeout(function() {
        searchPrograms(query);
    }, 300);
});

// Función para buscar programas
function searchPrograms(query) {
    showLoading();
    
    $.ajax({
        url: '{{ route("dif.programs.search") }}',
        type: 'GET',
        data: {
            query: query
        },
        success: function(response) {
            hideLoading();
            if (response.programs && response.programs.length > 0) {
                displayPrograms(response.programs);
                
                // Mostrar contador de resultados
                const resultsText = response.programs.length === 1 ? 
                    '1 programa encontrado' : 
                    `${response.programs.length} programas encontrados`;
                    
                $('#programs-list').prepend(`
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
            console.error('Error al buscar programas:', error);
            console.error('Status:', status);
            console.error('Response:', xhr.responseText);
            
            let errorMessage = 'Error al buscar programas. Inténtalo de nuevo.';
            
            if (xhr.status === 500) {
                errorMessage = 'Error interno del servidor. Contacta al administrador.';
            } else if (xhr.status === 404) {
                errorMessage = 'Servicio de búsqueda no encontrado.';
            }
            
            showError(errorMessage);
        }
    });
}

// Función para mostrar los programas
function displayPrograms(programs) {
    let html = '';
    
    programs.forEach(function(program) {
        const isSelected = selectedPrograms.includes(program.id.toString());
        
        html += `
            <div class="form-check mb-3 program-item" data-program-id="${program.id}">
                <input type="checkbox" class="form-check-input program-checkbox" 
                       id="program_${program.id}" 
                       value="${program.id}"
                       ${isSelected ? 'checked' : ''}
                       onchange="toggleProgram(${program.id}, '${program.name.replace(/'/g, "\\'")}')">
                <label class="form-check-label w-100" for="program_${program.id}">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="flex-grow-1">
                            <strong class="d-block">${program.name}</strong>
                            ${program.description ? `<small class="text-muted d-block mt-1">${program.description.length > 80 ? program.description.substring(0, 80) + '...' : program.description}</small>` : ''}
                            ${program.full_address ? `<small class="text-info d-block mt-1"><i class="fas fa-map-marker-alt me-1"></i>${program.full_address}</small>` : ''}
                        </div>
                        ${isSelected ? '<i class="fas fa-check-circle text-success ms-2"></i>' : ''}
                    </div>
                </label>
            </div>
        `;
    });
    
    $('#programs-list').html(html);
    $('#no-programs').hide();
}

// Función para alternar selección de programa
function toggleProgram(programId, programName) {
    const programIdStr = programId.toString();
    
    if (selectedPrograms.includes(programIdStr)) {
        // Remover de seleccionados
        selectedPrograms = selectedPrograms.filter(id => id !== programIdStr);
    } else {
        // Agregar a seleccionados
        selectedPrograms.push(programIdStr);
    }
    
    updateSelectedProgramsDisplay();
    updateHiddenInputs();
}

// Función para actualizar la visualización de programas seleccionados
function updateSelectedProgramsDisplay() {
    const count = selectedPrograms.length;
    
    // Actualizar contador
    const countText = count === 0 ? '0 programas seleccionados' : 
                     count === 1 ? '1 programa seleccionado' : 
                     `${count} programas seleccionados`;
    $('#programs-count').text(countText);
    
    if (count === 0) {
        $('#selected-programs').hide();
        return;
    }
    
    $('#selected-programs').show();
    
    let html = '';
    selectedPrograms.forEach(function(programId) {
        const programElement = $(`.program-item[data-program-id="${programId}"]`);
        if (programElement.length > 0) {
            const programName = programElement.find('label strong').text();
            html += `
                <span class="badge bg-primary me-1 mb-1 selected-programs-badge" style="font-size: 0.85em; padding: 0.5em 0.75em;">
                    <i class="fas fa-folder me-1"></i>${programName}
                    <button type="button" class="btn-close btn-close-white ms-2" 
                            style="font-size: 0.7em; padding: 0;" 
                            onclick="removeSelectedProgram('${programId}')" 
                            title="Remover programa"></button>
                </span>
            `;
        }
    });
    
    $('#selected-programs-list').html(html);
}

// Función para remover programa seleccionado
function removeSelectedProgram(programId) {
    selectedPrograms = selectedPrograms.filter(id => id !== programId);
    
    // Desmarcar checkbox si está visible
    $(`#program_${programId}`).prop('checked', false);
    
    updateSelectedProgramsDisplay();
    updateHiddenInputs();
}

// Función para actualizar inputs ocultos
function updateHiddenInputs() {
    let html = '';
    selectedPrograms.forEach(function(programId) {
        html += `<input type="hidden" name="program_ids[]" value="${programId}">`;
    });
    $('#hidden-inputs').html(html);
}

// Función para seleccionar todos los programas visibles
function selectAllVisiblePrograms() {
    $('.program-checkbox:visible').each(function() {
        if (!$(this).prop('checked')) {
            $(this).prop('checked', true);
            const programId = $(this).val();
            if (!selectedPrograms.includes(programId)) {
                selectedPrograms.push(programId);
            }
        }
    });
    
    updateSelectedProgramsDisplay();
    updateHiddenInputs();
}

// Función para deseleccionar todos los programas
function deselectAllPrograms() {
    selectedPrograms = [];
    $('.program-checkbox').prop('checked', false);
    updateSelectedProgramsDisplay();
    updateHiddenInputs();
}

// Funciones de estado de la interfaz
function showLoading() {
    $('#programs-list').html(`
        <div class="text-center py-4">
            <div class="spinner-border text-primary loading-spinner" role="status" style="width: 2rem; height: 2rem;">
                <span class="visually-hidden">Cargando...</span>
            </div>
            <p class="text-muted mt-3 mb-0">Buscando programas...</p>
        </div>
    `);
    $('#no-programs').hide();
}

function hideLoading() {
    // La función displayPrograms se encarga de mostrar el contenido
}

function showEmptyState() {
    $('#programs-list').html(`
        <div class="text-center py-4">
            <i class="fas fa-search fa-3x text-muted mb-3"></i>
            <h6 class="text-muted">Buscar Programas</h6>
            <p class="text-muted mb-0">Comienza a escribir para buscar programas disponibles...</p>
        </div>
    `);
    $('#no-programs').hide();
}

function showNoResults() {
    $('#programs-list').html(`
        <div class="text-center py-4">
            <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
            <h6 class="text-muted">No se encontraron programas</h6>
            <p class="text-muted mb-0">Intenta con otros términos de búsqueda</p>
        </div>
    `);
    $('#no-programs').hide();
}

function showError(message = 'Hubo un problema al conectar con el servidor. Inténtalo de nuevo.') {
    $('#programs-list').html(`
        <div class="text-center py-4">
            <i class="fas fa-exclamation-triangle fa-3x text-warning mb-3"></i>
            <h6 class="text-warning">Error al buscar programas</h6>
            <p class="text-muted mb-0">${message}</p>
            <button class="btn btn-outline-primary btn-sm mt-2" onclick="$('#program-search').trigger('input')">
                <i class="fas fa-redo me-1"></i>Reintentar
            </button>
        </div>
    `);
    $('#no-programs').hide();
}

// Funciones para manejar el pre-llenado del formulario con datos del ciudadano
function preFillFormWithCitizenData(citizen) {
    // Pre-llenar campos de contacto
    $('#phone').val(citizen.phone || '');
    $('#email').val(citizen.email || '');
    
    // Generar número médico automático basado en el ID del ciudadano
    const currentDate = new Date();
    const year = currentDate.getFullYear();
    const month = String(currentDate.getMonth() + 1).padStart(2, '0');
    const citizenIdPadded = String(citizen.id).padStart(4, '0');
    const medicalNum = `MED-${year}${month}-${citizenIdPadded}`;
    
    // Solo pre-llenar el número médico si está vacío
    if (!$('#medical_num').val()) {
        $('#medical_num').val(medicalNum);
    }
    
    // Mostrar información del ciudadano seleccionado
    showCitizenInfo(citizen);
}

function clearCitizenFields() {
    // Solo limpiar si los campos están vacíos o fueron pre-llenados automáticamente
    if ($('#phone').val() === '' || $('#phone').data('auto-filled')) {
        $('#phone').val('').removeData('auto-filled');
    }
    if ($('#email').val() === '' || $('#email').data('auto-filled')) {
        $('#email').val('').removeData('auto-filled');
    }
    
    hideCitizenInfo();
}

function showCitizenInfo(citizen) {
    const citizenInfoHtml = `
        <div id="citizen-info" class="alert alert-info mt-2" style="display: none;">
            <div class="d-flex align-items-center">
                <i class="fas fa-user-circle fa-2x me-3 text-primary"></i>
                <div>
                    <h6 class="mb-1">
                        <i class="fas fa-check-circle text-success me-1"></i>
                        Ciudadano Seleccionado
                    </h6>
                    <p class="mb-0">
                        <strong>${citizen.full_name}</strong><br>
                        <small class="text-muted">
                            ID: ${citizen.id}
                            ${citizen.curp ? ` | CURP: ${citizen.curp}` : ''}
                        </small>
                    </p>
                </div>
            </div>
        </div>
    `;
    
    // Remover info anterior si existe
    $('#citizen-info').remove();
    
    // Agregar nueva info después del select
    $('#citizen_id').parent().append(citizenInfoHtml);
    $('#citizen-info').slideDown();
}

function hideCitizenInfo() {
    $('#citizen-info').slideUp(function() {
        $(this).remove();
    });
}

function showCitizenLoadingIndicator() {
    const loadingHtml = `
        <div id="citizen-loading" class="text-center mt-2">
            <div class="spinner-border spinner-border-sm text-primary me-2" role="status">
                <span class="visually-hidden">Cargando...</span>
            </div>
            <small class="text-muted">Cargando información del ciudadano...</small>
        </div>
    `;
    
    $('#citizen-loading').remove();
    $('#citizen_id').parent().append(loadingHtml);
}

function showCitizenLoadingSuccess() {
    $('#citizen-loading').html(`
        <div class="text-center text-success">
            <i class="fas fa-check-circle me-1"></i>
            <small>Información cargada exitosamente</small>
        </div>
    `);
    
    setTimeout(function() {
        $('#citizen-loading').fadeOut();
    }, 2000);
}

function showCitizenLoadingError(message) {
    $('#citizen-loading').html(`
        <div class="text-center text-danger">
            <i class="fas fa-exclamation-triangle me-1"></i>
            <small>${message}</small>
        </div>
    `);
    
    setTimeout(function() {
        $('#citizen-loading').fadeOut();
    }, 3000);
}

function hideCitizenLoadingIndicator() {
    $('#citizen-loading').remove();
}
</script>
@endsection
