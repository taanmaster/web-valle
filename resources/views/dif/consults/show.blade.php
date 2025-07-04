@extends('layouts.master')

@section('content')
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="fas fa-stethoscope"></i>
            </span>
            Detalle de Consulta Médica
        </h3>
        <nav aria-label="breadcrumb">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('dif.consults.index') }}">Consultas Médicas</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $consult->consult_num }}</li>
            </ul>
        </nav>
    </div>

    <div class="row">
        <div class="col-12 grid-margin">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">
                            Consulta: {{ $consult->consult_num }}
                            <span class="badge {{ $consult->status_badge }} ms-2">{{ $consult->status_name }}</span>
                        </h4>
                        <div>
                            <a href="{{ route('dif.consults.edit', $consult) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i> Editar
                            </a>
                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                <i class="fas fa-trash"></i> Eliminar
                            </button>
                            <a href="{{ URL::previous() }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-arrow-left"></i> Regresar
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Información Principal -->
                        <div class="col-md-6">
                            <h5 class="mb-3">
                                <i class="fas fa-info-circle text-primary"></i> Información de la Consulta
                            </h5>
                            
                            <div class="table-responsive">
                                <table class="table table-borderless">
                                    <tr>
                                        <th width="35%">Número de Consulta:</th>
                                        <td>
                                            <span class="badge bg-primary">{{ $consult->consult_num }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Fecha de Consulta:</th>
                                        <td>
                                            <i class="fas fa-calendar text-info"></i>
                                            {{ $consult->consult_date?->format('d/m/Y') ?? 'No especificada' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Estado:</th>
                                        <td>
                                            <span class="badge {{ $consult->status_badge }}">{{ $consult->status_name }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Fecha de Registro:</th>
                                        <td>
                                            <i class="fas fa-clock text-muted"></i>
                                            {{ $consult->created_at->format('d/m/Y H:i:s') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Última Actualización:</th>
                                        <td>
                                            <i class="fas fa-clock text-muted"></i>
                                            {{ $consult->updated_at->format('d/m/Y H:i:s') }}
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <!-- Asignaciones -->
                        <div class="col-md-6">
                            <h5 class="mb-3">
                                <i class="fas fa-users text-success"></i> Asignaciones
                            </h5>
                            
                            <div class="table-responsive">
                                <table class="table table-borderless">
                                    <tr>
                                        <th width="35%">Doctor:</th>
                                        <td>
                                            @if($consult->doctor)
                                                <div class="d-flex align-items-center">
                                                    <i class="fas fa-user-md text-primary me-2"></i>
                                                    <div>
                                                        <strong>{{ $consult->doctor->name }}</strong>
                                                        @if($consult->doctor->specialty)
                                                            <br><small class="text-muted">{{ $consult->doctor->specialty->name }}</small>
                                                        @endif
                                                    </div>
                                                </div>
                                            @else
                                                <span class="text-muted">No asignado</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Paciente:</th>
                                        <td>
                                            @if($consult->citizen)
                                                <div class="d-flex align-items-center">
                                                    <i class="fas fa-user text-info me-2"></i>
                                                    <div>
                                                        <strong>{{ $consult->citizen->name }} {{ $consult->citizen->first_name }} {{ $consult->citizen->last_name }}</strong>
                                                        <br><small class="text-muted">ID: {{ $consult->citizen->id }}</small>
                                                        @if($consult->citizen->curp)
                                                            <br><small class="text-muted">CURP: {{ $consult->citizen->curp }}</small>
                                                        @endif
                                                    </div>
                                                </div>
                                            @else
                                                <span class="text-muted">No asignado</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Tipo de Consulta:</th>
                                        <td>
                                            @if($consult->consultType)
                                                <span class="badge bg-info">{{ $consult->consultType->name }}</span>
                                            @else
                                                <span class="text-muted">No especificado</span>
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Descripción -->
                    @if($consult->consult_description)
                        <div class="row mt-4">
                            <div class="col-12">
                                <h5 class="mb-3">
                                    <i class="fas fa-file-alt text-warning"></i> Descripción de la Consulta
                                </h5>
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <p class="mb-0">{{ $consult->consult_description }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Perfil Médico del Paciente -->
                    @if($consult->citizen && $consult->citizen->medicalProfile)
                        <div class="row mt-4">
                            <div class="col-12">
                                <h5 class="mb-3">
                                    <i class="fas fa-user-md text-success"></i> Perfil Médico del Paciente
                                </h5>
                                <div class="card border-success">
                                    <div class="card-body">
                                        <div class="row">
                                            <!-- Información Personal del Perfil -->
                                            <div class="col-md-6">
                                                <h6 class="text-success mb-3">
                                                    <i class="fas fa-id-card"></i> Información Personal
                                                </h6>
                                                <div class="table-responsive">
                                                    <table class="table table-sm table-borderless">
                                                        <tr>
                                                            <th width="40%">Número Médico:</th>
                                                            <td>
                                                                <span class="badge bg-success">{{ $consult->citizen->medicalProfile->medical_num }}</span>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>Género:</th>
                                                            <td>
                                                                @if($consult->citizen->medicalProfile->gender == 'Masculino')
                                                                    <span class="badge bg-primary">{{ $consult->citizen->medicalProfile->gender }}</span>
                                                                @elseif($consult->citizen->medicalProfile->gender == 'Femenino')
                                                                    <span class="badge bg-pink">{{ $consult->citizen->medicalProfile->gender }}</span>
                                                                @else
                                                                    <span class="badge bg-secondary">{{ $consult->citizen->medicalProfile->gender }}</span>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>Edad:</th>
                                                            <td>
                                                                @if($consult->citizen->medicalProfile->age)
                                                                    <i class="fas fa-birthday-cake text-info me-1"></i>
                                                                    {{ $consult->citizen->medicalProfile->age }} años
                                                                @else
                                                                    <span class="text-muted">No especificada</span>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>Teléfono:</th>
                                                            <td>
                                                                @if($consult->citizen->medicalProfile->phone)
                                                                    <i class="fas fa-phone text-success me-1"></i>
                                                                    {{ $consult->citizen->medicalProfile->phone }}
                                                                @else
                                                                    <span class="text-muted">No especificado</span>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>Email:</th>
                                                            <td>
                                                                @if($consult->citizen->medicalProfile->email)
                                                                    <i class="fas fa-envelope text-primary me-1"></i>
                                                                    {{ $consult->citizen->medicalProfile->email }}
                                                                @else
                                                                    <span class="text-muted">No especificado</span>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>

                                            <!-- Información Médica -->
                                            <div class="col-md-6">
                                                <h6 class="text-danger mb-3">
                                                    <i class="fas fa-heartbeat"></i> Información Médica
                                                </h6>
                                                <div class="table-responsive">
                                                    <table class="table table-sm table-borderless">
                                                        <tr>
                                                            <th width="40%">Tipo de Sangre:</th>
                                                            <td>
                                                                @if($consult->citizen->medicalProfile->blood_type)
                                                                    <span class="badge bg-danger">{{ $consult->citizen->medicalProfile->blood_type }}</span>
                                                                @else
                                                                    <span class="text-muted">No especificado</span>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>Alergias:</th>
                                                            <td>
                                                                @if($consult->citizen->medicalProfile->allergies)
                                                                    <span class="text-warning">
                                                                        <i class="fas fa-exclamation-triangle me-1"></i>
                                                                        {{ $consult->citizen->medicalProfile->allergies }}
                                                                    </span>
                                                                @else
                                                                    <span class="text-success">
                                                                        <i class="fas fa-check-circle me-1"></i>
                                                                        Sin alergias conocidas
                                                                    </span>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>Condiciones Médicas:</th>
                                                            <td>
                                                                @if($consult->citizen->medicalProfile->medical_conditions)
                                                                    <div class="alert alert-warning py-1 px-2 mb-0">
                                                                        <small>{{ Str::limit($consult->citizen->medicalProfile->medical_conditions, 80) }}</small>
                                                                    </div>
                                                                @else
                                                                    <span class="text-muted">Sin condiciones médicas registradas</span>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>Medicamentos:</th>
                                                            <td>
                                                                @if($consult->citizen->medicalProfile->medications)
                                                                    <div class="alert alert-info py-1 px-2 mb-0">
                                                                        <small>{{ Str::limit($consult->citizen->medicalProfile->medications, 80) }}</small>
                                                                    </div>
                                                                @else
                                                                    <span class="text-muted">Sin medicamentos registrados</span>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Botón para ver perfil completo -->
                                        <div class="text-center mt-3 pt-3 border-top">
                                            <a href="{{ route('dif.medical_profiles.show', $consult->citizen->medicalProfile->id) }}" 
                                               class="btn btn-outline-success btn-sm">
                                                <i class="fas fa-eye me-1"></i>
                                                Ver Perfil Médico Completo
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @elseif($consult->citizen)
                        <div class="row mt-4">
                            <div class="col-12">
                                <h5 class="mb-3">
                                    <i class="fas fa-user-md text-warning"></i> Perfil Médico del Paciente
                                </h5>
                                <div class="alert alert-warning">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-exclamation-triangle fa-2x me-3"></i>
                                        <div>
                                            <h6 class="mb-1">No hay perfil médico disponible</h6>
                                            <p class="mb-2">Este paciente no tiene un perfil médico registrado en el sistema.</p>
                                            <a href="{{ route('dif.medical_profiles.create') }}?citizen_id={{ $consult->citizen->id }}" 
                                               class="btn btn-warning btn-sm">
                                                <i class="fas fa-plus me-1"></i>
                                                Crear Perfil Médico
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Información Adicional -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <h5 class="mb-3">
                                <i class="fas fa-chart-line text-info"></i> Información Adicional
                            </h5>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="card bg-primary text-white">
                                        <div class="card-body text-center">
                                            <i class="fas fa-hashtag fa-2x mb-2"></i>
                                            <h6>ID Consulta</h6>
                                            <h4>{{ $consult->id }}</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card bg-success text-white">
                                        <div class="card-body text-center">
                                            <i class="fas fa-user-injured fa-2x mb-2"></i>
                                            <h6>ID Paciente</h6>
                                            <h4>{{ $consult->patient_id }}</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card bg-warning text-white">
                                        <div class="card-body text-center">
                                            <i class="fas fa-user-md fa-2x mb-2"></i>
                                            <h6>ID Doctor</h6>
                                            <h4>{{ $consult->doctor_id }}</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card bg-info text-white">
                                        <div class="card-body text-center">
                                            <i class="fas fa-clipboard-check fa-2x mb-2"></i>
                                            <h6>Estado</h6>
                                            <h4>{{ $consult->status_name }}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Eliminación -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteModalLabel">Confirmar Eliminación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle"></i>
                        <strong>¿Está seguro que desea eliminar esta consulta médica?</strong>
                    </div>
                    <p><strong>Consulta:</strong> {{ $consult->consult_num }}</p>
                    <p><strong>Paciente:</strong> {{ $consult->citizen->name ?? 'No asignado' }}</p>
                    <p><strong>Doctor:</strong> {{ $consult->doctor->name ?? 'No asignado' }}</p>
                    <p class="text-danger"><strong>Esta acción no se puede deshacer.</strong></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <form method="POST" action="{{ route('dif.consults.destroy', $consult) }}" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
<script>
    $(document).ready(function() {
        // Confirmación adicional antes de eliminar
        $('#deleteModal form').on('submit', function(e) {
            if (!confirm('¿Está completamente seguro? Esta acción eliminará permanentemente la consulta médica.')) {
                e.preventDefault();
            }
        });
    });
</script>
@endsection
