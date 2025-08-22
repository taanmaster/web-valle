@extends('layouts.master')
@section('title')Paso 2: Proveedor Económico @endsection

@section('content')
<!-- Breadcrumbs -->
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') DIF @endslot
@slot('li_3') Estudios Socioeconómicos @endslot
@slot('title') Paso 2: Proveedor Económico @endslot
@endcomponent

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h4 class="card-title mb-0">Paso 2: Datos del Proveedor Económico</h4>
                        <p class="text-muted mb-0">{{ $test->citizen_name }} {{ $test->citizen_last_name }}</p>
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('dif.socio_economic_tests.show', $test->id) }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left"></i> Volver
                        </a>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <!-- Barra de progreso -->
                <div class="progress-steps mb-4">
                    <div class="step-progress">
                        <div class="step completed">
                            <div class="step-number">✓</div>
                            <div class="step-title">Datos Generales</div>
                        </div>
                        <div class="step active">
                            <div class="step-number">2</div>
                            <div class="step-title">Proveedor Económico</div>
                        </div>
                        <div class="step">
                            <div class="step-number">3</div>
                            <div class="step-title">Estructura Familiar</div>
                        </div>
                        <div class="step">
                            <div class="step-number">4</div>
                            <div class="step-title">Estructura Económica</div>
                        </div>
                        <div class="step">
                            <div class="step-number">5</div>
                            <div class="step-title">Salud y Vivienda</div>
                        </div>
                    </div>
                </div>

                <form action="{{ route('dif.socio_economic_tests.step2.store', $test->id) }}" method="POST" class="step-form" data-step="2">
                    @csrf
                    
                    <div class="row">
                        <!-- Estado Civil -->
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label class="form-label fw-bold">Estado Civil</label>
                                <div class="mt-2">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="civil_status" value="single_mother_children" 
                                               data-points="5" id="civil1" {{ old('civil_status') == 'single_mother_children' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="civil1">
                                            Madre soltera con hijos / Viuda con hijos <span class="badge bg-danger ms-2">5 pts</span>
                                        </label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="civil_status" value="single_mother" 
                                               data-points="3" id="civil2" {{ old('civil_status') == 'single_mother' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="civil2">
                                            Madre soltera / Viuda sin hijos <span class="badge bg-warning ms-2">3 pts</span>
                                        </label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="civil_status" value="other" 
                                               data-points="1" id="civil3" {{ old('civil_status') == 'other' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="civil3">
                                            Unión libre sin hijos / Divorciada sin hijos / Soltera sin hijos <span class="badge bg-success ms-2">1 pt</span>
                                        </label>
                                    </div>
                                </div>
                                @error('civil_status')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Edad -->
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label class="form-label fw-bold">Edad</label>
                                <div class="mt-2">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="age_range" value="65_plus" 
                                               data-points="5" id="age1" {{ old('age_range') == '65_plus' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="age1">
                                            65 años o más <span class="badge bg-danger ms-2">5 pts</span>
                                        </label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="age_range" value="38_64" 
                                               data-points="4" id="age2" {{ old('age_range') == '38_64' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="age2">
                                            38 a 64 años <span class="badge bg-warning ms-2">4 pts</span>
                                        </label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="age_range" value="17_37" 
                                               data-points="2" id="age3" {{ old('age_range') == '17_37' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="age3">
                                            17 a 37 años <span class="badge bg-info ms-2">2 pts</span>
                                        </label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="age_range" value="under_17" 
                                               data-points="1" id="age4" {{ old('age_range') == 'under_17' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="age4">
                                            Menor a 17 años <span class="badge bg-success ms-2">1 pt</span>
                                        </label>
                                    </div>
                                </div>
                                @error('age_range')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Ocupación -->
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label class="form-label fw-bold">Ocupación</label>
                                <div class="mt-2">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="occupation" value="unemployed" 
                                               data-points="5" id="occ1" {{ old('occupation') == 'unemployed' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="occ1">
                                            Desempleado <span class="badge bg-danger ms-2">5 pts</span>
                                        </label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="occupation" value="eventual" 
                                               data-points="3" id="occ2" {{ old('occupation') == 'eventual' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="occ2">
                                            Eventual <span class="badge bg-warning ms-2">3 pts</span>
                                        </label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="occupation" value="retired" 
                                               data-points="2" id="occ3" {{ old('occupation') == 'retired' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="occ3">
                                            Jubilado/Pensionado <span class="badge bg-info ms-2">2 pts</span>
                                        </label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="occupation" value="employed" 
                                               data-points="1" id="occ4" {{ old('occupation') == 'employed' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="occ4">
                                            Empleado <span class="badge bg-success ms-2">1 pt</span>
                                        </label>
                                    </div>
                                </div>
                                @error('occupation')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Escolaridad -->
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label class="form-label fw-bold">Escolaridad</label>
                                <div class="mt-2">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="education" value="none" 
                                               data-points="5" id="edu1" {{ old('education') == 'none' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="edu1">
                                            Sin estudios <span class="badge bg-danger ms-2">5 pts</span>
                                        </label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="education" value="primary" 
                                               data-points="3" id="edu2" {{ old('education') == 'primary' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="edu2">
                                            Primaria <span class="badge bg-warning ms-2">3 pts</span>
                                        </label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="education" value="secondary" 
                                               data-points="2" id="edu3" {{ old('education') == 'secondary' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="edu3">
                                            Secundaria <span class="badge bg-info ms-2">2 pts</span>
                                        </label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="education" value="high_school" 
                                               data-points="1" id="edu4" {{ old('education') == 'high_school' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="edu4">
                                            Preparatoria/Técnica <span class="badge bg-success ms-2">1 pt</span>
                                        </label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="education" value="professional" 
                                               data-points="1" id="edu5" {{ old('education') == 'professional' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="edu5">
                                            Profesionista <span class="badge bg-success ms-2">1 pt</span>
                                        </label>
                                    </div>
                                </div>
                                @error('education')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Caja de subtotal -->
                    <div class="subtotal-box mt-4">
                        <div class="card bg-light">
                            <div class="card-body text-center">
                                <h5 class="mb-1">Subtotal Paso 2: <span id="step-score">0</span> puntos</h5>
                                <small class="text-muted">Total acumulado: <span id="total-score">{{ $test->step_1_score ?? 0 }}</span> puntos</small>
                            </div>
                        </div>
                    </div>

                    <!-- Botones de acción -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('dif.socio_economic_tests.show', $test->id) }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-arrow-left"></i> Volver al resumen
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    Continuar al Paso 3 <i class="fas fa-arrow-right"></i>
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
        $(document).ready(function() {
            // Cálculo en tiempo real de puntajes
            $('input[type="radio"][data-points]').on('change', function() {
                calculateStepScore();
            });

            function calculateStepScore() {
                let stepScore = 0;
                
                // Sumar puntos de todas las opciones seleccionadas
                $('.step-form input[type="radio"]:checked').each(function() {
                    stepScore += parseInt($(this).data('points') || 0);
                });
                
                // Actualizar subtotal del paso
                $('#step-score').text(stepScore);
                
                // Calcular total acumulado
                let totalScore = {{ $test->step_1_score ?? 0 }} + stepScore;
                $('#total-score').text(totalScore);
            }

            // Calcular puntaje inicial si hay valores seleccionados
            calculateStepScore();
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

        .form-check {
            padding: 10px;
            border-radius: 5px;
            transition: background-color 0.2s;
        }

        .form-check:hover {
            background-color: #f8f9fa;
        }

        .form-check-input:checked ~ .form-check-label {
            font-weight: 600;
        }

        .subtotal-box {
            position: sticky;
            bottom: 20px;
        }
    </style>
@endpush
