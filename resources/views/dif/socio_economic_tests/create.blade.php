@extends('layouts.master')
@section('title')Nuevo Estudio Socioeconómico @endsection

@section('content')
<!-- Breadcrumbs -->
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') DIF @endslot
@slot('li_3') Estudios Socioeconómicos @endslot
@slot('title') Nuevo Estudio @endslot
@endcomponent

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h4 class="card-title mb-0">Paso 1: Datos Generales</h4>
                        <p class="text-muted mb-0">Información básica del beneficiario y coordinación responsable</p>
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('dif.socio_economic_tests.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left"></i> Volver
                        </a>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <!-- Barra de progreso -->
                <div class="progress-steps mb-4">
                    <div class="step-progress">
                        <div class="step active">
                            <div class="step-number">1</div>
                            <div class="step-title">Datos Generales</div>
                        </div>
                        <div class="step">
                            <div class="step-number">2</div>
                            <div class="step-title">Economía y Dependientes</div>
                        </div>
                        <div class="step">
                            <div class="step-number">3</div>
                            <div class="step-title">Estructura Económica</div>
                        </div>
                        <div class="step">
                            <div class="step-number">4</div>
                            <div class="step-title">Salud</div>
                        </div>
                        <div class="step">
                            <div class="step-number">5</div>
                            <div class="step-title">Vivienda y Entorno</div>
                        </div>
                    </div>
                </div>

                <form action="{{ route('dif.socio_economic_tests.store') }}" method="POST">
                    @csrf
                        
                    <div class="row">
                        <div class="col-md-12">
                            <hr>
                            <h6 class="text-white bg-dark p-2 text-uppercase mb-3">
                                <i class="fas fa-check"></i> Datos Generales
                            </h5>
                        </div>
                        
                        <!-- Información de responsabilidad -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="coordination_id" class="form-label">Coordinación Responsable <span class="text-danger">*</span></label>
                                <select name="coordination_id" id="coordination_id" class="form-control @error('coordination_id') is-invalid @enderror" required>
                                    <option value="">Seleccione una coordinación</option>
                                    @foreach($coordinations as $coordination)
                                        <option value="{{ $coordination->id }}" {{ old('coordination_id') == $coordination->id ? 'selected' : '' }}>
                                            {{ $coordination->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('coordination_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="citizen_id" class="form-label">Usuario/Ciudadano <span class="text-danger">*</span></label>
                                <select name="citizen_id" id="citizen_id" class="form-control @error('citizen_id') is-invalid @enderror" required>
                                    <option value="">Seleccione un usuario</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" {{ old('citizen_id') == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }} ({{ $user->email }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('citizen_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="date" class="form-label">Fecha</label>
                                <input type="date" readonly disabled name="date" id="date" class="form-control" value="{{ Carbon\Carbon::now()->format('Y-m-d') }}" required maxlength="255">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="reference_phone" class="form-label">Teléfono de Referencia</label>
                                <input type="tel" name="reference_phone" id="reference_phone" 
                                       class="form-control @error('reference_phone') is-invalid @enderror"
                                       value="{{ old('reference_phone') }}" maxlength="20"
                                       placeholder="Teléfono de contacto alternativo">
                                @error('reference_phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="support_type" class="form-label">Tipo de Apoyo Solicitado <span class="text-danger">*</span></label>
                                <input type="text" name="support_type" id="support_type" 
                                       class="form-control @error('support_type') is-invalid @enderror"
                                       value="{{ old('support_type') }}" required maxlength="255"
                                       placeholder="Ej: Apoyo económico, Despensa, Material de construcción">
                                @error('support_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="col-md-12">
                        <hr>
                        <h6 class="text-white bg-dark p-2 text-uppercase mb-3">
                            <i class="fas fa-check"></i> Información del Beneficiario
                        </h6>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="citizen_last_name" class="form-label">Apellido Paterno <span class="text-danger">*</span></label>
                                <input type="text" name="citizen_last_name" id="citizen_last_name" 
                                       class="form-control @error('citizen_last_name') is-invalid @enderror"
                                       value="{{ old('citizen_last_name') }}" required maxlength="255">
                                @error('citizen_last_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="citizen_last_name_mother" class="form-label">Apellido Materno <span class="text-danger">*</span></label>
                                <input type="text" name="citizen_last_name_mother" id="citizen_last_name_mother" 
                                       class="form-control @error('citizen_last_name_mother') is-invalid @enderror"
                                       value="{{ old('citizen_last_name_mother') }}" required maxlength="255">
                                @error('citizen_last_name_mother')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="citizen_name" class="form-label">Nombre(s) <span class="text-danger">*</span></label>
                                <input type="text" name="citizen_name" id="citizen_name" 
                                       class="form-control @error('citizen_name') is-invalid @enderror"
                                       value="{{ old('citizen_name') }}" required maxlength="255">
                                @error('citizen_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="citizen_curp" class="form-label">CURP <span class="text-danger">*</span></label>
                                <input type="text" name="citizen_curp" id="citizen_curp" 
                                       class="form-control @error('citizen_curp') is-invalid @enderror"
                                       value="{{ old('citizen_curp') }}" required
                                       placeholder="AAAA######HMMMMM##">
                                @error('citizen_curp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="citizen_phone" class="form-label">Teléfono <span class="text-danger">*</span></label>
                                <input type="tel" name="citizen_phone" id="citizen_phone" 
                                       class="form-control @error('citizen_phone') is-invalid @enderror"
                                       value="{{ old('citizen_phone') }}" required maxlength="20">
                                @error('citizen_phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="citizen_address" class="form-label">Dirección Completa <span class="text-danger">*</span></label>
                        <textarea name="citizen_address" id="citizen_address" 
                                  class="form-control @error('citizen_address') is-invalid @enderror"
                                  rows="3" required>{{ old('citizen_address') }}</textarea>
                        @error('citizen_address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>


                    <!-- Botones de acción -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('dif.socio_economic_tests.index') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-times"></i> Cancelar
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    Continuar al Paso 2 <i class="fas fa-arrow-right"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script>
    // Validación de CURP en tiempo real
    document.getElementById('citizen_curp').addEventListener('input', function(e) {
        this.value = this.value.toUpperCase();
    });
    </script>

    <style>
    .progress-steps {
        margin-bottom: 2rem;
    }

    .step-progress {
        display: flex;
        justify-content: space-between;
        position: relative;
    }

    .step-progress::before {
        content: '';
        position: absolute;
        top: 20px;
        left: 20px;
        right: 20px;
        height: 2px;
        background: #e9ecef;
        z-index: 1;
    }

    .step {
        display: flex;
        flex-direction: column;
        align-items: center;
        position: relative;
        z-index: 2;
    }

    .step-number {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: #e9ecef;
        color: #6c757d;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        margin-bottom: 8px;
    }

    .step-title {
        font-size: 12px;
        text-align: center;
        color: #6c757d;
        max-width: 120px;
    }

    .step.active .step-number {
        background: #0d6efd;
        color: white;
    }

    .step.active .step-title {
        color: #0d6efd;
        font-weight: 600;
    }

    .step.completed .step-number {
        background: #198754;
        color: white;
    }

    .step.completed .step-title {
        color: #198754;
    }
    </style>
@endpush
