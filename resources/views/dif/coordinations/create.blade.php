@extends('layouts.master')

@section('title')Agregar Coordinación @endsection

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
</style>
@endsection

@section('content')
    <!-- this is breadcrumbs -->
    @component('components.breadcrumb')
        @slot('li_1') Intranet @endslot
        @slot('li_2') DIF @endslot
        @slot('li_3') <a href="{{ route('dif.coordinations.index') }}">Coordinaciones</a> @endslot
        @slot('title') Agregar Coordinación @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <h5 class="card-title">
                            <i class="fas fa-plus"></i> Agregar Coordinación
                        </h5>
                        <div class="d-flex">
                            <a href="{{ route('dif.coordinations.index') }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-arrow-left"></i> Volver
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('dif.coordinations.store') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="name">Nombre:</label>
                                    <input type="text" name="name" id="name" class="form-control" placeholder="Ingresa el nombre de la coordinación" value="{{ old('name') }}">
                                </div>
                                
                                <div class="form-group mb-3">
                                    <label for="description">Descripción:</label>
                                    <textarea name="description" id="description" class="form-control" placeholder="Ingresa la descripción de la coordinación (opcional)" rows="4">{{ old('description') }}</textarea>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="is_active">Estado:</label>
                                    <select name="is_active" id="is_active" class="form-control">
                                        <option value="1" {{ old('is_active', '1') == '1' ? 'selected' : '' }}>Activo</option>
                                        <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>Inactivo</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <h5><i class="fas fa-folder"></i> Programas Asociados</h5>
                                <p class="text-muted">Selecciona los programas que pertenecen a esta coordinación:</p>
                                
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
                                               placeholder="Ej: educación, salud, apoyo alimentario..." 
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

                        <div class="form-group mt-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-1"></i>Guardar Coordinación
                                    </button>
                                    <a href="{{ route('dif.coordinations.index') }}" class="btn btn-secondary">
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
</script>
@endsection
