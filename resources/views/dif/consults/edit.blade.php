@extends('layouts.master')

@section('content')
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="fas fa-stethoscope"></i>
            </span>
            Editar Consulta Médica
        </h3>
        <nav aria-label="breadcrumb">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('dif.consults.index') }}">Consultas Médicas</a></li>
                <li class="breadcrumb-item"><a href="{{ route('dif.consults.show', $consult) }}">{{ $consult->consult_num }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">Editar</li>
            </ul>
        </nav>
    </div>

    <div class="row">
        <div class="col-12 grid-margin">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">Editar Consulta: {{ $consult->consult_num }}</h4>
                        <div>
                            <a href="{{ route('dif.consults.show', $consult) }}" class="btn btn-info btn-sm">
                                <i class="fas fa-eye"></i> Ver Consulta
                            </a>
                            <a href="{{ route('dif.consults.index') }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-arrow-left"></i> Regresar
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('dif.consults.update', $consult) }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <!-- Información de la Consulta -->
                            <div class="col-md-6">
                                <h5 class="mb-3">Información de la Consulta</h5>
                                
                                <div class="form-group mb-3">
                                    <label for="consult_num">Número de Consulta <span class="text-danger">*</span></label>
                                    <input type="text" name="consult_num" id="consult_num" class="form-control" 
                                           value="{{ old('consult_num', $consult->consult_num) }}" readonly>
                                    <small class="form-text text-muted">Número generado automáticamente</small>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="consult_date">Fecha de Consulta <span class="text-danger">*</span></label>
                                    <input type="date" name="consult_date" id="consult_date" class="form-control" 
                                           value="{{ old('consult_date', $consult->consult_date?->format('Y-m-d')) }}" required>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="status">Estado <span class="text-danger">*</span></label>
                                    <select name="status" id="status" class="form-control" required>
                                        <option value="">Seleccionar estado...</option>
                                        <option value="pending" {{ old('status', $consult->status) == 'pending' ? 'selected' : '' }}>Pendiente</option>
                                        <option value="completed" {{ old('status', $consult->status) == 'completed' ? 'selected' : '' }}>Completada</option>
                                        <option value="cancelled" {{ old('status', $consult->status) == 'cancelled' ? 'selected' : '' }}>Cancelada</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Asignaciones -->
                            <div class="col-md-6">
                                <h5 class="mb-3">Asignaciones</h5>
                                
                                <div class="form-group mb-3">
                                    <label for="doctor_id">Doctor <span class="text-danger">*</span></label>
                                    <select name="doctor_id" id="doctor_id" class="form-control" required>
                                        <option value="">Seleccionar doctor...</option>
                                        @foreach($doctors as $doctor)
                                            <option value="{{ $doctor->id }}" {{ old('doctor_id', $consult->doctor_id) == $doctor->id ? 'selected' : '' }}>
                                                {{ $doctor->name }} - {{ $doctor->specialty->name ?? 'Sin especialidad' }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="patient_id">Paciente <span class="text-danger">*</span></label>
                                    <select name="patient_id" id="patient_id" class="form-control" required>
                                        <option value="">Seleccionar paciente...</option>
                                        @foreach($citizens as $citizen)
                                            <option value="{{ $citizen->id }}" {{ old('patient_id', $consult->patient_id) == $citizen->id ? 'selected' : '' }}>
                                                {{ $citizen->name }} ({{ $citizen->curp }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="consult_type_id">Tipo de Consulta <span class="text-info">(Opcional)</span></label>
                                    <select name="consult_type_id" id="consult_type_id" class="form-control">
                                        <option value="">Seleccionar tipo...</option>
                                        @foreach($consultTypes as $type)
                                            <option value="{{ $type->id }}" {{ old('consult_type_id', $consult->consult_type_id) == $type->id ? 'selected' : '' }}>
                                                {{ $type->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Descripción -->
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group mb-3">
                                    <label for="consult_description">Descripción de la Consulta <span class="text-info">(Opcional)</span></label>
                                    <textarea name="consult_description" id="consult_description" class="form-control" 
                                              rows="4" placeholder="Ingresa los detalles de la consulta, diagnóstico, observaciones, etc.">{{ old('consult_description', $consult->consult_description) }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Actualizar Consulta
                            </button>
                            <a href="{{ route('dif.consults.show', $consult) }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Cancelar
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
        // Select2 para mejor UX en los selectores
        if (typeof $.fn.select2 !== 'undefined') {
            $('#doctor_id, #patient_id, #consult_type_id').select2({
                placeholder: function(){
                    return $(this).data('placeholder');
                },
                allowClear: true
            });
        }
    });
</script>
@endsection
