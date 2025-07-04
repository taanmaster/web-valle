@extends('layouts.master')

@section('title')Editar Perfil Médico @endsection

@section('css')
<style>
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
    
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
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
        @slot('title') Editar Perfil Médico @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <h5 class="card-title">
                            <i class="fas fa-edit"></i> Editar Perfil Médico
                        </h5>
                        <div class="d-flex">
                            <a href="{{ route('dif.medical_profiles.show', $medicalProfile->id) }}" class="btn btn-secondary btn-sm me-2">
                                <i class="fas fa-eye"></i> Ver
                            </a>
                            <a href="{{ route('dif.medical_profiles.index') }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-arrow-left"></i> Volver
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('dif.medical_profiles.update', $medicalProfile->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <h5><i class="fas fa-user"></i> Información del Ciudadano</h5>
                                
                                <div class="form-group mb-3">
                                    <label for="citizen_id">Ciudadano:</label>
                                    <select name="citizen_id" id="citizen_id" class="form-control" required>
                                        <option value="">Selecciona un ciudadano</option>
                                        @foreach($citizens as $citizen)
                                            <option value="{{ $citizen->id }}" {{ old('citizen_id', $medicalProfile->citizen_id) == $citizen->id ? 'selected' : '' }}>
                                                {{ $citizen->name }} {{ $citizen->first_name }} {{ $citizen->last_name }} (ID: {{ $citizen->id }})
                                            </option>
                                        @endforeach
                                    </select>
                                    <small class="form-text text-muted">Al cambiar el ciudadano, se pre-llenará automáticamente la información disponible.</small>
                                </div>

                                <h5><i class="fas fa-id-card"></i> Información Médica</h5>
                                
                                <div class="form-group mb-3">
                                    <label for="medical_num">Número Médico:</label>
                                    <input type="text" name="medical_num" id="medical_num" class="form-control" 
                                           placeholder="Ingresa el número médico" value="{{ old('medical_num', $medicalProfile->medical_num) }}" required>
                                </div>
                                
                                <div class="form-group mb-3">
                                    <label for="blood_type">Tipo de Sangre:</label>
                                    <select name="blood_type" id="blood_type" class="form-control">
                                        <option value="">Selecciona tipo de sangre</option>
                                        <option value="A+" {{ old('blood_type', $medicalProfile->blood_type) == 'A+' ? 'selected' : '' }}>A+</option>
                                        <option value="A-" {{ old('blood_type', $medicalProfile->blood_type) == 'A-' ? 'selected' : '' }}>A-</option>
                                        <option value="B+" {{ old('blood_type', $medicalProfile->blood_type) == 'B+' ? 'selected' : '' }}>B+</option>
                                        <option value="B-" {{ old('blood_type', $medicalProfile->blood_type) == 'B-' ? 'selected' : '' }}>B-</option>
                                        <option value="AB+" {{ old('blood_type', $medicalProfile->blood_type) == 'AB+' ? 'selected' : '' }}>AB+</option>
                                        <option value="AB-" {{ old('blood_type', $medicalProfile->blood_type) == 'AB-' ? 'selected' : '' }}>AB-</option>
                                        <option value="O+" {{ old('blood_type', $medicalProfile->blood_type) == 'O+' ? 'selected' : '' }}>O+</option>
                                        <option value="O-" {{ old('blood_type', $medicalProfile->blood_type) == 'O-' ? 'selected' : '' }}>O-</option>
                                    </select>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="gender">Género:</label>
                                    <select name="gender" id="gender" class="form-control" required>
                                        <option value="">Selecciona género</option>
                                        <option value="Masculino" {{ old('gender', $medicalProfile->gender) == 'Masculino' ? 'selected' : '' }}>Masculino</option>
                                        <option value="Femenino" {{ old('gender', $medicalProfile->gender) == 'Femenino' ? 'selected' : '' }}>Femenino</option>
                                        <option value="Otro" {{ old('gender', $medicalProfile->gender) == 'Otro' ? 'selected' : '' }}>Otro</option>
                                    </select>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="age">Edad:</label>
                                    <input type="number" name="age" id="age" class="form-control" 
                                           placeholder="Ingresa la edad" value="{{ old('age', $medicalProfile->age) }}" min="0" max="150">
                                </div>

                                <div class="form-group mb-3">
                                    <label for="phone">Teléfono:</label>
                                    <input type="text" name="phone" id="phone" class="form-control" 
                                           placeholder="Ingresa el teléfono" value="{{ old('phone', $medicalProfile->phone) }}">
                                </div>

                                <div class="form-group mb-3">
                                    <label for="email">Correo Electrónico:</label>
                                    <input type="email" name="email" id="email" class="form-control" 
                                           placeholder="Ingresa el correo electrónico" value="{{ old('email', $medicalProfile->email) }}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <h5><i class="fas fa-notes-medical"></i> Información Médica Adicional</h5>
                                
                                <div class="form-group mb-3">
                                    <label for="allergies">Alergias:</label>
                                    <input type="text" name="allergies" id="allergies" class="form-control" 
                                           placeholder="Ingresa las alergias (opcional)" value="{{ old('allergies', $medicalProfile->allergies) }}">
                                </div>
                                
                                <div class="form-group mb-3">
                                    <label for="medical_conditions">Condiciones Médicas:</label>
                                    <textarea name="medical_conditions" id="medical_conditions" class="form-control" 
                                              placeholder="Ingresa las condiciones médicas (opcional)" rows="3">{{ old('medical_conditions', $medicalProfile->medical_conditions) }}</textarea>
                                </div>
                                
                                <div class="form-group mb-3">
                                    <label for="medications">Medicamentos:</label>
                                    <textarea name="medications" id="medications" class="form-control" 
                                              placeholder="Ingresa los medicamentos (opcional)" rows="3">{{ old('medications', $medicalProfile->medications) }}</textarea>
                                </div>

                                <hr>

                                <h5><i class="fas fa-folder"></i> Programas Asociados</h5>
                                <p class="text-muted">Selecciona los programas médicos para este perfil:</p>
                                
                                @if($programs->count() > 0)
                                    <div class="programs-container" style="max-height: 300px; overflow-y: auto; border: 1px solid #ddd; padding: 15px; border-radius: 5px;">
                                        @foreach($programs as $program)
                                            <div class="form-check mb-2">
                                                <input type="checkbox" name="program_ids[]" value="{{ $program->id }}" class="form-check-input" id="program_{{ $program->id }}" {{ in_array($program->id, old('program_ids', $selectedPrograms)) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="program_{{ $program->id }}">
                                                    <strong>{{ $program->name }}</strong>
                                                    @if($program->description)
                                                        <br><small class="text-muted">{{ Str::limit($program->description, 60) }}</small>
                                                    @endif
                                                    @if($program->full_address)
                                                        <br><small class="text-info"><i class="fas fa-map-marker-alt"></i> {{ $program->full_address }}</small>
                                                    @endif
                                                </label>
                                            </div>
                                            <hr class="my-2">
                                        @endforeach
                                    </div>
                                    
                                    <div class="mt-3">
                                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="selectAllPrograms()">
                                            <i class="fas fa-check-double"></i> Seleccionar Todos
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="deselectAllPrograms()">
                                            <i class="fas fa-times"></i> Deseleccionar Todos
                                        </button>
                                    </div>
                                @else
                                    <div class="alert alert-warning">
                                        <i class="fas fa-exclamation-triangle"></i> No hay programas disponibles.
                                        <a href="{{ route('dif.programs.create') }}" class="btn btn-sm btn-primary ms-2">
                                            <i class="fas fa-plus"></i> Crear Programa
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i>Actualizar Perfil Médico
                            </button>
                            <a href="{{ route('dif.medical_profiles.show', $medicalProfile->id) }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-1"></i>Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
<script>
$(document).ready(function() {
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

function selectAllPrograms() {
    $('.programs-container input[type="checkbox"]').prop('checked', true);
}

function deselectAllPrograms() {
    $('.programs-container input[type="checkbox"]').prop('checked', false);
}

// Funciones para manejar el pre-llenado del formulario con datos del ciudadano
function preFillFormWithCitizenData(citizen) {
    // Pre-llenar campos de contacto si están vacíos
    if (!$('#phone').val()) {
        $('#phone').val(citizen.phone || '');
    }
    if (!$('#email').val()) {
        $('#email').val(citizen.email || '');
    }
    
    // Mostrar información del ciudadano seleccionado
    showCitizenInfo(citizen);
}

function clearCitizenFields() {
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
