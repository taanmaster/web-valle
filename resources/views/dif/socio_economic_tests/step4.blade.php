@extends('layouts.master')
@section('title')Paso 4: Estructura Económica @endsection

@section('content')
<!-- Breadcrumbs -->
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') DIF @endslot
@slot('li_3') Estudios Socioeconómicos @endslot
@slot('title') Paso 4: Estructura Económica @endslot
@endcomponent

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h4 class="card-title mb-0">Paso 4: Estructura Económica</h4>
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
                        <div class="step completed">
                            <div class="step-number">✓</div>
                            <div class="step-title">Economía y Dependientes</div>
                        </div>
                        <div class="step completed">
                            <div class="step-number">✓</div>
                            <div class="step-title">Estructura Económica</div>
                        </div>
                        <div class="step active">
                            <div class="step-number">4</div>
                            <div class="step-title">Salud</div>
                        </div>
                        <div class="step">
                            <div class="step-number">5</div>
                            <div class="step-title">Vivienda y Entorno</div>
                        </div>
                    </div>
                </div>

                <form action="{{ route('dif.socio_economic_tests.step4.store', $test->id) }}" method="POST" class="step-form" data-step="4">
                    @csrf
                    
                
                    <div class="row">
                        <div class="col-md-12">
                            <h6 class="text-white bg-dark p-2 text-uppercase mb-3">
                                <i class="fas fa-check"></i> Condiciones de Salud
                            </h6>
                        </div>
                        
                        <!-- Servicios Médicos -->
                        <div class="col-md-12">
                            <div class="mb-4">
                                <label class="form-label fw-bold">¿Cuenta con algún servicio médico o acude a centros de salud?</label>
                                <div class="px-2 d-flex justify-content-between flex-wrap gap-2">
                                    <div class="form-check flex-fill mb-2">
                                        <input class="form-check-input" type="radio" name="medical_center" value="secretaria_salud" 
                                               data-points="5" id="center1" {{ old('medical_center') == 'secretaria_salud' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="center1">
                                            Secretaría de Salud Pública <span class="badge bg-danger ms-2">5 pts</span>
                                        </label>
                                    </div>
                                    <div class="form-check flex-fill mb-2">
                                        <input class="form-check-input" type="radio" name="medical_center" value="private" 
                                               data-points="3" id="center2" {{ old('medical_center') == 'private' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="center2">
                                            Particular <span class="badge bg-warning ms-2">3 pts</span>
                                        </label>
                                    </div>
                                    <div class="form-check flex-fill mb-2">
                                        <input class="form-check-input" type="radio" name="medical_center" value="imss_issste" 
                                               data-points="1" id="center3" {{ old('medical_center') == 'imss_issste' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="center3">
                                            IMSS o ISSSTE <span class="badge bg-success ms-2">1 pt</span>
                                        </label>
                                    </div>
                                </div>
                                @error('medical_center')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Enfermedades -->
                        <div class="col-md-12">
                            <div class="mb-4">
                                <label class="form-label fw-bold">¿Padece algún miembro de su familia alguna enfermedad crónica y/o degenerativa grave?</label>
                                <div class="px-2 d-flex justify-content-between flex-wrap gap-2">
                                    <div class="form-check flex-fill mb-2">
                                        <input class="form-check-input" type="radio" name="health_problem" value="serious_chronic" 
                                               data-points="5" id="health1" {{ old('health_problem') == 'serious_chronic' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="health1">
                                            Tutor que aporta el ingreso mayor <span class="badge bg-danger ms-2">5 pts</span>
                                        </label>
                                    </div>
                                    <div class="form-check flex-fill mb-2">
                                        <input class="form-check-input" type="radio" name="health_problem" value="serious_treatable" 
                                               data-points="4" id="health2" {{ old('health_problem') == 'serious_treatable' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="health2">
                                            Tutor dependiente <span class="badge bg-warning ms-2">4 pts</span>
                                        </label>
                                    </div>
                                    <div class="form-check flex-fill mb-2">
                                        <input class="form-check-input" type="radio" name="health_problem" value="moderate" 
                                               data-points="3" id="health3" {{ old('health_problem') == 'moderate' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="health3">
                                            Hijos <span class="badge bg-warning ms-2">3 pts</span>
                                        </label>
                                    </div>
                                    <div class="form-check flex-fill mb-2">
                                        <input class="form-check-input" type="radio" name="health_problem" value="minor" 
                                               data-points="2" id="health4" {{ old('health_problem') == 'minor' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="health4">
                                            Familia segunda línea <span class="badge bg-info ms-2">2 pts</span>
                                        </label>
                                    </div>
                                </div>
                                @error('health_problem')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Caja de subtotal -->
                    <div class="subtotal-box mt-4">
                        <div class="card bg-light">
                            <div class="card-body text-center">
                                <h5 class="mb-1">Subtotal Paso 4: <span id="step-score">0</span> puntos</h5>
                                <small class="text-muted">Total acumulado: <span id="total-score">{{ ($test->step_1_score ?? 0) + ($test->step_2_score ?? 0) + ($test->step_3_score ?? 0) }}</span> puntos</small>
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
                                    Continuar al Paso 5 <i class="fas fa-arrow-right"></i>
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
                updateCardStyles();
            });

            // Hacer que toda la tarjeta sea clickeable
            $('.form-check').on('click', function(e) {
                if (e.target.type !== 'radio') {
                    $(this).find('input[type="radio"]').prop('checked', true).trigger('change');
                }
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
                let totalScore = {{ ($test->step_1_score ?? 0) + ($test->step_2_score ?? 0) + ($test->step_3_score ?? 0) }} + stepScore;
                $('#total-score').text(totalScore);
            }

            function updateCardStyles() {
                // Remover todas las clases de selección
                $('.form-check').removeClass('selected-danger selected-warning selected-info selected-success');
                
                // Aplicar estilos según la opción seleccionada
                $('.form-check input[type="radio"]:checked').each(function() {
                    const points = $(this).data('points');
                    const card = $(this).closest('.form-check');
                    
                    if (points === 5) {
                        card.addClass('selected-danger');
                    } else if (points === 4) {
                        card.addClass('selected-warning');
                    } else if (points === 3) {
                        card.addClass('selected-warning');
                    } else if (points === 2) {
                        card.addClass('selected-info');
                    } else if (points === 1) {
                        card.addClass('selected-success');
                    }
                });
            }

            // Calcular puntaje inicial si hay valores seleccionados
            calculateStepScore();
            updateCardStyles();
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
            padding: 15px;
            border-radius: 8px;
            border: 2px solid #e9ecef;
            transition: all 0.3s ease;
            cursor: pointer;
            background: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 10px;
            position: relative;
        }

        .form-check:hover {
            border-color: #dee2e6;
            box-shadow: 0 4px 8px rgba(0,0,0,0.15);
            transform: translateY(-1px);
        }

        .form-check-input {
            position: absolute;
            top: 10px;
            right: 10px;
            transform: scale(1.2);
        }

        .form-check-label {
            cursor: pointer;
            margin-bottom: 0;
            padding-right: 30px;
            font-weight: 500;
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
        }

        /* Estilos para tarjetas seleccionadas según el color del badge */
        .form-check:has(.form-check-input:checked) .badge.bg-danger,
        .form-check:has(.form-check-input[data-points="5"]:checked) {
            background-color: #dc3545 !important;
        }

        .form-check:has(.form-check-input[data-points="5"]:checked) {
            border-color: #dc3545;
            background-color: rgba(220, 53, 69, 0.1);
            color: #721c24;
        }

        .form-check:has(.form-check-input[data-points="4"]:checked) {
            border-color: #fd7e14;
            background-color: rgba(253, 126, 20, 0.1);
            color: #8d4700;
        }

        .form-check:has(.form-check-input[data-points="3"]:checked) {
            border-color: #ffc107;
            background-color: rgba(255, 193, 7, 0.1);
            color: #997404;
        }

        .form-check:has(.form-check-input[data-points="2"]:checked) {
            border-color: #0dcaf0;
            background-color: rgba(13, 202, 240, 0.1);
            color: #055160;
        }

        .form-check:has(.form-check-input[data-points="1"]:checked) {
            border-color: #198754;
            background-color: rgba(25, 135, 84, 0.1);
            color: #0f5132;
        }

        .form-check:has(.form-check-input:checked) .form-check-label {
            font-weight: 600;
        }

        .form-check:has(.form-check-input:checked) .badge {
            font-weight: 700;
            font-size: 0.8em;
        }

        /* Fallback para navegadores que no soportan :has() */
        .form-check.selected-danger {
            border-color: #dc3545;
            background-color: rgba(220, 53, 69, 0.1);
            color: #721c24;
        }

        .form-check.selected-warning {
            border-color: #ffc107;
            background-color: rgba(255, 193, 7, 0.1);
            color: #997404;
        }

        .form-check.selected-info {
            border-color: #0dcaf0;
            background-color: rgba(13, 202, 240, 0.1);
            color: #055160;
        }

        .form-check.selected-success {
            border-color: #198754;
            background-color: rgba(25, 135, 84, 0.1);
            color: #0f5132;
        }

        .subtotal-box {
            position: sticky;
            bottom: 20px;
        }

        .input-group .form-control {
            text-align: right;
        }
    </style>
@endpush
