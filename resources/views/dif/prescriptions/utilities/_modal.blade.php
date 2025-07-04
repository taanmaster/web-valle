<div class="modal fade" id="modalCreate" tabindex="-1" role="dialog" aria-labelledby="modalCreate" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h6 class="modal-title m-0 text-white" id="modalCreate">Nueva Receta Médica</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div><!--end modal-header-->

            <form method="POST" action="{{ route('dif.prescriptions.store') }}">
                {{ csrf_field() }}
                <div class="modal-body pd-25">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="modal_prescription_num" class="form-label">Número de Receta <span class="text-danger tx-12">*</span></label>
                            <input type="text" class="form-control" id="modal_prescription_num" name="prescription_num" readonly>
                            <small class="form-text text-muted">Número generado automáticamente</small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="modal_prescription_date" class="form-label">Fecha de la Receta <span class="text-danger tx-12">*</span></label>
                            <input type="date" class="form-control" id="modal_prescription_date" name="prescription_date" readonly>
                            <small class="form-text text-muted">Fecha actual del sistema</small>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="modal_doctor_id" class="form-label">Doctor <span class="text-danger tx-12">*</span></label>
                            <select class="form-control" id="modal_doctor_id" name="doctor_id" required>
                                <option value="">Seleccione un doctor</option>
                                @foreach($doctors as $doctor)
                                    <option value="{{ $doctor->id }}">{{ $doctor->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="modal_patient_id" class="form-label">Paciente <span class="text-danger tx-12">*</span></label>
                            
                            <!-- Buscador de pacientes en modal -->
                            <div class="patient-search-container mb-3">
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-search"></i>
                                    </span>
                                    <input type="text" 
                                        id="modal-patient-search" 
                                        class="form-control" 
                                        placeholder="Buscar paciente..." 
                                        autocomplete="off">
                                </div>
                            </div>

                            <!-- Paciente seleccionado en modal -->
                            <div id="modal-selected-patient" class="mb-3" style="display: none;">
                                <div class="card border-primary">
                                    <div class="card-body py-2">
                                        <div id="modal-selected-patient-info"></div>
                                        <button type="button" class="btn btn-sm btn-outline-secondary mt-2" onclick="clearModalSelectedPatient()">
                                            <i class="fas fa-times"></i> Cambiar
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Contenedor de pacientes en modal -->
                            <div class="modal-patients-container" id="modal-patients-container" style="max-height: 200px; overflow-y: auto; border: 1px solid #dee2e6; border-radius: 4px; padding: 10px;">
                                <div id="modal-patients-list">
                                    <div class="text-center py-3">
                                        <i class="fas fa-user-friends fa-2x text-muted mb-2"></i>
                                        <p class="text-muted mb-0">Buscar pacientes...</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Input oculto para el modal -->
                            <input type="hidden" name="patient_id" id="modal_patient_id">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="modal_status" class="form-label">Estado <span class="text-danger tx-12">*</span></label>
                            <select class="form-control" id="modal_status" name="status" required>
                                <option value="pending">Pendiente</option>
                                <option value="completed">Completada</option>
                                <option value="cancelled">Cancelada</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-dark btn-sm">Guardar datos</button>
                </div>
            </form>
        </div><!--end modal-content-->
    </div><!--end modal-dialog-->
</div><!--end modal-->

<script>
// Variables para el modal
let modalSelectedPatient = null;
let modalSearchTimeout;

// Cuando se abre el modal
$('#modalCreate').on('show.bs.modal', function (e) {
    // Generar número automático
    generatePrescriptionNumber();
    // Establecer fecha actual
    $('#modal_prescription_date').val(new Date().toISOString().split('T')[0]);
    // Limpiar selección previa
    clearModalSelectedPatient();
});

// Función para generar número de receta
function generatePrescriptionNumber() {
    $.ajax({
        url: '{{ route("dif.prescriptions.create") }}',
        type: 'GET',
        success: function(response) {
            // Extraer el número del HTML de respuesta
            const tempDiv = document.createElement('div');
            tempDiv.innerHTML = response;
            const prescriptionInput = tempDiv.querySelector('#prescription_num');
            if (prescriptionInput) {
                $('#modal_prescription_num').val(prescriptionInput.value);
            }
        },
        error: function() {
            console.error('Error al generar número de receta');
        }
    });
}

// Búsqueda de pacientes en modal
$('#modal-patient-search').on('input', function() {
    clearTimeout(modalSearchTimeout);
    const query = $(this).val().trim();
    
    if (query.length === 0) {
        showModalEmptyState();
        return;
    }
    
    if (query.length < 2) {
        $('#modal-patients-list').html(`
            <div class="text-center py-2">
                <p class="text-muted mb-0">Escribe al menos 2 caracteres...</p>
            </div>
        `);
        return;
    }
    
    modalSearchTimeout = setTimeout(function() {
        searchModalPatients(query);
    }, 300);
});

// Función para buscar pacientes en modal
function searchModalPatients(query) {
    showModalLoading();
    
    $.ajax({
        url: '{{ route("dif.patients.search") }}',
        type: 'GET',
        data: { query: query },
        success: function(response) {
            if (response.patients && response.patients.length > 0) {
                displayModalPatients(response.patients);
            } else {
                showModalNoResults();
            }
        },
        error: function(xhr, status, error) {
            console.error('Error al buscar pacientes:', error);
            showModalError();
        }
    });
}

// Función para mostrar pacientes en modal
function displayModalPatients(patients) {
    let html = '';
    
    patients.forEach(function(patient) {
        html += `
            <div class="patient-item mb-2 p-2 border rounded cursor-pointer" onclick="selectModalPatient(${JSON.stringify(patient).replace(/"/g, '&quot;')})">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <strong>${patient.name} ${patient.first_name || ''} ${patient.last_name || ''}</strong>
                        <small class="text-muted d-block">CURP: ${patient.curp || 'No disponible'}</small>
                    </div>
                    <i class="fas fa-user-plus text-primary"></i>
                </div>
            </div>
        `;
    });
    
    $('#modal-patients-list').html(html);
}

// Función para seleccionar paciente en modal
function selectModalPatient(patient) {
    modalSelectedPatient = patient;
    $('#modal_patient_id').val(patient.id);
    
    // Mostrar información del paciente seleccionado
    $('#modal-selected-patient-info').html(`
        <strong>${patient.name} ${patient.first_name || ''} ${patient.last_name || ''}</strong>
        <small class="text-muted d-block">CURP: ${patient.curp || 'No disponible'}</small>
    `);
    
    $('#modal-selected-patient').show();
    $('#modal-patients-container').hide();
    $('#modal-patient-search').val('');
}

// Función para limpiar paciente seleccionado en modal
function clearModalSelectedPatient() {
    modalSelectedPatient = null;
    $('#modal_patient_id').val('');
    $('#modal-selected-patient').hide();
    $('#modal-patients-container').show();
    $('#modal-patient-search').val('');
    showModalEmptyState();
}

// Funciones de estado para modal
function showModalLoading() {
    $('#modal-patients-list').html(`
        <div class="text-center py-2">
            <div class="spinner-border spinner-border-sm" role="status"></div>
            <p class="text-muted mb-0 mt-2">Buscando...</p>
        </div>
    `);
}

function showModalEmptyState() {
    $('#modal-patients-list').html(`
        <div class="text-center py-3">
            <i class="fas fa-user-friends fa-2x text-muted mb-2"></i>
            <p class="text-muted mb-0">Buscar pacientes...</p>
        </div>
    `);
}

function showModalNoResults() {
    $('#modal-patients-list').html(`
        <div class="text-center py-2">
            <i class="fas fa-user-slash fa-2x text-muted mb-2"></i>
            <p class="text-muted mb-0">No se encontraron pacientes</p>
        </div>
    `);
}

function showModalError() {
    $('#modal-patients-list').html(`
        <div class="text-center py-2">
            <i class="fas fa-exclamation-triangle fa-2x text-warning mb-2"></i>
            <p class="text-muted mb-0">Error al buscar pacientes</p>
        </div>
    `);
}

// Validación del formulario del modal
$('#modalCreate form').on('submit', function(e) {
    if (!$('#modal_patient_id').val()) {
        e.preventDefault();
        alert('Por favor selecciona un paciente.');
        return false;
    }
});
</script>
