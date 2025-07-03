@extends('layouts.master')
@section('title')Intranet @endsection
@section('content')
<!-- this is breadcrumbs -->
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') DIF @endslot
@slot('title') Doctor: {{ $doctor->name }} @endslot
@endcomponent

<div class="row layout-spacing">
    <div class="main-content">
        <a href="{{ route('dif.doctors.index') }}" class="btn btn-outline-secondary flex-fill mb-4">
            <i class="fas fa-arrow-left me-2"></i>Volver
        </a>

        <div class="row">
            <div class="col-md-3">
                <!-- Tarjeta de contacto moderna -->
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <!-- Avatar del doctor -->
                        <div class="mb-4">
                            <div class="rounded-circle bg-primary d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                <i class="fas fa-user-md text-white" style="font-size: 2rem;"></i>
                            </div>
                        </div>
                        
                        <!-- Número de empleado -->
                        <div class="mb-3">
                            <span class="badge bg-light text-dark px-3 py-2">
                                <i class="fas fa-id-badge me-2"></i>
                                {{ $doctor->employee_num }}
                            </span>
                        </div>

                        <!-- Nombre y especialidad -->
                        
                        <h4 class="card-title mb-2 text-dark">{{ $doctor->name }}</h4>
                        <p class="text-muted mb-3">
                            <i class="fas fa-stethoscope me-2"></i>
                            {{ $doctor->specialty->name ?? 'N/A' }}
                        </p>
                        
                        <hr>
                        
                        <!-- Información de contacto -->
                        <div class="contact-info mb-4">
                            @if($doctor->phone)
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-phone text-primary me-2"></i>
                                    <span class="text-muted">{{ $doctor->phone }}</span>
                                </div>
                            @endif
                            
                            @if($doctor->email)
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-envelope text-primary me-2"></i>
                                    <span class="text-muted">{{ $doctor->email }}</span>
                                </div>
                            @endif
                            
                            @if($doctor->full_address)
                                <div class="d-flex align-items-start mb-2">
                                    <i class="fas fa-map-marker-alt text-primary me-2 mt-1"></i>
                                    <span class="text-muted text-start">{{ $doctor->full_address }}</span>
                                </div>
                            @endif
                        </div>

                        
                    </div>
                </div>

                <!-- Información adicional -->
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-transparent border-0 py-3">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-info-circle me-2 text-primary"></i>
                            Información del registro
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="d-flex align-items-center mb-3">
                                    <i class="fas fa-calendar-plus text-primary me-3"></i>
                                    <div>
                                        <small class="text-muted d-block">Fecha de alta</small>
                                        <strong>{{ $doctor->created_at->format('d/m/Y H:i') }}</strong>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="d-flex align-items-center mb-3">
                                    <i class="fas fa-calendar-plus text-warning me-3"></i>
                                    <div>
                                        <small class="text-muted d-block">Última actualización</small>
                                        <strong>{{ $doctor->updated_at->format('d/m/Y H:i') }}</strong>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Botones de acción -->
                        <div class="d-grid gap-2">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal">
                                <i class="fas fa-edit me-2"></i>Editar
                            </button>
                            <div class="d-flex gap-2">
                                <form method="POST" action="{{ route('dif.doctors.destroy', $doctor->id) }}" class="flex-fill">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                    <button type="submit" class="btn btn-outline-danger w-100" onclick="return confirm('¿Estás seguro de que deseas eliminar este doctor?')">
                                        <i class="fas fa-trash me-2"></i>Eliminar
                                    </button>
                                </form>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <!-- Estadísticas del doctor -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body text-center">
                                <div class="mb-3">
                                    <i class="fas fa-stethoscope text-primary" style="font-size: 2.5rem;"></i>
                                </div>
                                <h3 class="text-primary mb-2">{{ $doctor->consultations->count() ?? 0 }}</h3>
                                <p class="text-muted mb-0">Consultas realizadas</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body text-center">
                                <div class="mb-3">
                                    <i class="fas fa-prescription-bottle text-success" style="font-size: 2.5rem;"></i>
                                </div>
                                <h3 class="text-success mb-2">{{ $doctor->prescriptions->count() ?? 0 }}</h3>
                                <p class="text-muted mb-0">Recetas emitidas</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Nueva sección con tabs para listados -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card border-0 shadow-sm">
                            <div class="card-header bg-transparent border-0 py-3">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-list me-2 text-primary"></i>
                                    Listado de Pacientes, Recetas y Recibos
                                </h5>
                            </div>

                            <div class="card-body">
                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs" id="doctorTabs" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="patients-tab" data-bs-toggle="tab" data-bs-target="#patients" type="button" role="tab">
                                            <i class="fas fa-users me-2"></i>Pacientes ({{ $doctor->consultations->count() }})
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="prescriptions-tab" data-bs-toggle="tab" data-bs-target="#prescriptions" type="button" role="tab">
                                            <i class="fas fa-prescription-bottle me-2"></i>Recetas ({{ $doctor->prescriptions->count() }})
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="receipts-tab" data-bs-toggle="tab" data-bs-target="#receipts" type="button" role="tab">
                                            <i class="fas fa-receipt me-2"></i>Recibos ({{ $doctor->receipts->count() }})
                                        </button>
                                    </li>
                                </ul>

                                <!-- Tab content -->
                                <div class="tab-content mt-3" id="doctorTabsContent">
                                    <!-- Pacientes Tab -->
                                    <div class="tab-pane fade show active" id="patients" role="tabpanel">
                                        <div class="d-flex justify-content-between align-items-center mb-3 p-3 bg-light rounded" style="gap: 1rem;">
                                            <div class="flex-grow-1">
                                                <h6 class="mb-0 text-primary">
                                                    <i class="fas fa-stethoscope me-2"></i>Consultas del Doctor
                                                </h6>
                                                <small class="text-muted">Historial de consultas médicas realizadas</small>
                                            </div>
                                            <div class="d-flex" style="flex-shrink:0;">
                                                <a href="{{ route('dif.consults.create', ['doctor_id' => $doctor->id]) }}" class="btn btn-primary btn-sm ms-auto" style="white-space:nowrap;">
                                                    <i class="fas fa-plus me-2"></i>Nueva Consulta
                                                </a>
                                            </div>
                                        </div>
                                        
                                        @if($doctor->consultations->count() > 0)
                                            <div class="table-responsive">
                                                <table class="table table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>Número</th>
                                                            <th>Fecha</th>
                                                            <th>Paciente</th>
                                                            <th>Tipo</th>
                                                            <th>Estado</th>
                                                            <th>Acciones</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($doctor->consultations->take(10) as $consult)
                                                            <tr>
                                                                <td>
                                                                    <span class="badge bg-primary">{{ $consult->consult_num }}</span>
                                                                </td>
                                                                <td>
                                                                    <i class="fas fa-calendar text-muted"></i>
                                                                    {{ $consult->consult_date?->format('d/m/Y') ?? 'N/A' }}
                                                                </td>
                                                                <td>
                                                                    @if($consult->citizen)
                                                                        <strong>{{ $consult->citizen->name }}</strong>
                                                                        <br><small class="text-muted">{{ $consult->citizen->curp }}</small>
                                                                    @else
                                                                        <span class="text-muted">No asignado</span>
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    @if($consult->consultType)
                                                                        <span class="badge bg-info">{{ $consult->consultType->name }}</span>
                                                                    @else
                                                                        <span class="text-muted">N/A</span>
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    <span class="badge {{ $consult->status_badge }}">{{ $consult->status_name }}</span>
                                                                </td>
                                                                <td>
                                                                    <div class="btn-group" role="group">
                                                                        <a href="{{ route('dif.consults.show', $consult) }}" class="btn btn-info btn-sm" title="Ver">
                                                                            <i class="fas fa-eye"></i>
                                                                        </a>
                                                                        <a href="{{ route('dif.consults.edit', $consult) }}" class="btn btn-warning btn-sm" title="Editar">
                                                                            <i class="fas fa-edit"></i>
                                                                        </a>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            @if($doctor->consultations->count() > 10)
                                                <div class="text-center mt-3">
                                                    <a href="{{ route('dif.consults.index', ['doctor_id' => $doctor->id]) }}" class="btn btn-outline-primary">
                                                        <i class="fas fa-list me-2"></i>Ver todas las consultas ({{ $doctor->consultations->count() }})
                                                    </a>
                                                </div>
                                            @endif
                                        @else
                                            <div class="text-center py-4">
                                                <i class="fas fa-stethoscope fa-3x text-muted mb-3"></i>
                                                <h6 class="text-muted">No hay consultas registradas</h6>
                                                <p class="text-muted mb-0">Este doctor aún no tiene consultas médicas asignadas.</p>
                                                <a href="{{ route('dif.consults.create', ['doctor_id' => $doctor->id]) }}" class="btn btn-primary btn-sm mt-2">
                                                    <i class="fas fa-plus"></i> Crear Primera Consulta
                                                </a>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Recetas Tab -->
                                    <div class="tab-pane fade" id="prescriptions" role="tabpanel">
                                        <div class="d-flex justify-content-between align-items-center mb-3 p-3 bg-light rounded" style="gap: 1rem;">
                                            <div class="flex-grow-1">
                                                <h6 class="mb-0 text-success">
                                                    <i class="fas fa-prescription-bottle me-2"></i>Recetas del Doctor
                                                </h6>
                                                <small class="text-muted">Recetas médicas emitidas por el doctor</small>
                                            </div>
                                            <div class="d-flex" style="flex-shrink:0;">
                                                <a href="{{ route('dif.prescriptions.create', ['doctor_id' => $doctor->id]) }}" class="btn btn-success btn-sm" style="white-space:nowrap;">
                                                    <i class="fas fa-plus me-2"></i>Nueva Receta
                                                </a>
                                            </div>
                                        </div>
                                        
                                        @if($doctor->prescriptions->count() > 0)
                                            <div class="table-responsive">
                                                <table class="table table-hover">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th>Número</th>
                                                            <th>Fecha</th>
                                                            <th>Paciente</th>
                                                            <th>Estado</th>
                                                            <th>Acciones</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($doctor->prescriptions->take(10) as $prescription)
                                                            <tr>
                                                                <td>{{ $prescription->prescription_num }}</td>
                                                                <td>{{ $prescription->prescription_date->format('d/m/Y') }}</td>
                                                                <td>{{ $prescription->patient_name ?? 'N/A' }}</td>
                                                                <td>
                                                                    <span class="badge bg-{{ $prescription->status == 'completed' ? 'success' : ($prescription->status == 'pending' ? 'warning' : 'danger') }}">
                                                                        {{ ucfirst($prescription->status) }}
                                                                    </span>
                                                                </td>
                                                                <td>
                                                                    <a href="{{ route('dif.prescriptions.show', $prescription->id) }}" class="btn btn-sm btn-outline-primary">
                                                                        <i class="fas fa-eye"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            @if($doctor->prescriptions->count() > 10)
                                                <div class="text-center mt-3">
                                                    <a href="{{ route('dif.prescriptions.index', ['doctor_id' => $doctor->id]) }}" class="btn btn-outline-primary">
                                                        Ver todas las recetas
                                                    </a>
                                                </div>
                                            @endif
                                        @else
                                            <div class="text-center py-4">
                                                <i class="fas fa-prescription-bottle text-muted mb-3" style="font-size: 3rem;"></i>
                                                <p class="text-muted">No hay recetas registradas</p>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Recibos Tab -->
                                    <div class="tab-pane fade" id="receipts" role="tabpanel">
                                        <div class="d-flex justify-content-between align-items-center mb-3 p-3 bg-light rounded">
                                            <div>
                                                <h6 class="mb-0 text-info">
                                                    <i class="fas fa-receipt me-2"></i>Recibos del Doctor
                                                </h6>
                                                <small class="text-muted">Recibos de pago generados por el doctor</small>
                                            </div>
                                            <a href="{{ route('dif.receipts.create', ['doctor_id' => $doctor->id]) }}" class="btn btn-info btn-sm">
                                                <i class="fas fa-plus me-2"></i>Nuevo Recibo
                                            </a>
                                        </div>
                                        
                                        @if($doctor->receipts->count() > 0)
                                            <div class="table-responsive">
                                                <table class="table table-hover">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th>Número</th>
                                                            <th>Fecha</th>
                                                            <th>Paciente</th>
                                                            <th>Total</th>
                                                            <th>Estado</th>
                                                            <th>Acciones</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($doctor->receipts->take(10) as $receipt)
                                                            <tr>
                                                                <td>{{ $receipt->receipt_num }}</td>
                                                                <td>{{ $receipt->receipt_date->format('d/m/Y') }}</td>
                                                                <td>{{ $receipt->patient_name ?? 'N/A' }}</td>
                                                                <td>${{ number_format($receipt->total, 2) }}</td>
                                                                <td>
                                                                    <span class="badge bg-{{ $receipt->status == 'paid' ? 'success' : ($receipt->status == 'pending' ? 'warning' : 'danger') }}">
                                                                        {{ ucfirst($receipt->status) }}
                                                                    </span>
                                                                </td>
                                                                <td>
                                                                    <a href="{{ route('dif.receipts.show', $receipt->id) }}" class="btn btn-sm btn-outline-primary">
                                                                        <i class="fas fa-eye"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            @if($doctor->receipts->count() > 10)
                                                <div class="text-center mt-3">
                                                    <a href="{{ route('dif.receipts.index', ['doctor_id' => $doctor->id]) }}" class="btn btn-outline-primary">
                                                        Ver todos los recibos
                                                    </a>
                                                </div>
                                            @endif
                                        @else
                                            <div class="text-center py-4">
                                                <i class="fas fa-receipt text-muted mb-3" style="font-size: 3rem;"></i>
                                                <p class="text-muted">No hay recibos registrados</p>
                                            </div>
                                        @endif
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

<!-- Modal de edición -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="editModalLabel">
                    <i class="fas fa-edit me-2"></i>Editar Doctor
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form method="POST" action="{{ route('dif.doctors.update', $doctor->id) }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="name" class="form-label">Nombre Completo <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ $doctor->name }}" required>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="specialty_id" class="form-label">Especialidad <span class="text-danger">*</span></label>
                            <select class="form-control" id="specialty_id" name="specialty_id" required>
                                <option value="">Seleccionar especialidad...</option>
                                @foreach(\App\Models\DIFSpecialty::all() as $specialty)
                                    <option value="{{ $specialty->id }}" 
                                            {{ $doctor->specialty_id == $specialty->id ? 'selected' : '' }}>
                                        {{ $specialty->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="full_address" class="form-label">Dirección Completa <span class="text-info">(Opcional)</span></label>
                            <textarea class="form-control" id="full_address" name="full_address" rows="3">{{ $doctor->full_address }}</textarea>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Correo Electrónico <span class="text-info">(Opcional)</span></label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ $doctor->email }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="phone" class="form-label">Teléfono <span class="text-info">(Opcional)</span></label>
                            <input type="text" class="form-control" id="phone" name="phone" value="{{ $doctor->phone }}">
                        </div>

                        <hr>

                        <div class="col-md-12 mb-3">
                            <label for="employee_num" class="form-label">Número de Empleado <span class="text-info">(No editable)</span></label>
                            <input type="text" class="form-control" id="employee_num" name="employee_num" value="{{ $doctor->employee_num }}" required readonly>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Actualizar Doctor
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
