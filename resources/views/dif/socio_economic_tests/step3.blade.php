@extends('layouts.master')
@section('title')Paso 3: Estructura Familiar @endsection

@section('content')
<!-- Breadcrumbs -->
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') DIF @endslot
@slot('li_3') Estudios Socioeconómicos @endslot
@slot('title') Paso 3: Estructura Familiar @endslot
@endcomponent

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h4 class="card-title mb-0">Paso 3: Estructura Familiar</h4>
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
                        <div class="step active">
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

                <form action="{{ route('dif.socio_economic_tests.step3.store', $test->id) }}" method="POST" class="step-form" data-step="3">
                    @csrf

                    <div class="row">
                        <div class="col-md-12">
                            <h6 class="text-white bg-dark p-2 text-uppercase mb-3">
                                <i class="fas fa-check"></i> Estructura Económica
                            </h6>
                        </div>
                        
                        <!-- Información económica libre -->
                        <div class="mb-4">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="monthly_expenses" class="form-label">¿Cuánto dinero se gasta al mes?</label>
                                        <div class="input-group">
                                            <span class="input-group-text">$</span>
                                            <input type="text" name="monthly_expenses" id="monthly_expenses" 
                                                class="form-control @error('monthly_expenses') is-invalid @enderror"
                                                value="{{ old('monthly_expenses') }}" min="0" step="0.01"
                                                placeholder="0.00">
                                        </div>
                                        @error('monthly_expenses')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="monthly_debt" class="form-label">¿Cuánto dinero se debe al mes?</label>
                                        <div class="input-group">
                                            <span class="input-group-text">$</span>
                                            <input type="text" name="monthly_debt" id="monthly_debt" 
                                                class="form-control @error('monthly_debt') is-invalid @enderror"
                                                value="{{ old('monthly_debt') }}" min="0" step="0.01"
                                                placeholder="0.00">
                                        </div>
                                        @error('monthly_debt')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="monthly_savings" class="form-label">¿Cuánto ahorra mensualmente?</label>
                                        <div class="input-group">
                                            <span class="input-group-text">$</span>
                                            <input type="text" name="monthly_savings" id="monthly_savings" 
                                                class="form-control @error('monthly_savings') is-invalid @enderror"
                                                value="{{ old('monthly_savings') }}" min="0" step="0.01"
                                                placeholder="0.00">
                                        </div>
                                        @error('monthly_savings')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Ingreso Mensual en Salarios Mínimos -->
                        <!-- Ingreso Mensual en Salarios Mínimos -->
                        <div class="col-md-12">
                            <div class="mb-4">
                                <label class="form-label fw-bold">Ingreso Mensual en Salarios Mínimos</label>
                                <div class="px-2 d-flex justify-content-between flex-wrap gap-2">
                                    <div class="form-check flex-fill mb-2">
                                        <input class="form-check-input" type="radio" name="income_level" value="0_1" 
                                               data-points="4" id="income1" {{ old('income_level') == '0_1' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="income1">
                                            0 a 1 salario mínimo <span class="badge bg-danger ms-2">4 pts</span>
                                        </label>
                                    </div>
                                    <div class="form-check flex-fill mb-2">
                                        <input class="form-check-input" type="radio" name="income_level" value="2_3" 
                                               data-points="3" id="income2" {{ old('income_level') == '2_3' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="income2">
                                            2 a 3 salarios mínimos <span class="badge bg-warning ms-2">3 pts</span>
                                        </label>
                                    </div>
                                    <div class="form-check flex-fill mb-2">
                                        <input class="form-check-input" type="radio" name="income_level" value="4_5" 
                                               data-points="2" id="income3" {{ old('income_level') == '4_5' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="income3">
                                            4 a 5 salarios mínimos <span class="badge bg-info ms-2">2 pts</span>
                                        </label>
                                    </div>
                                    <div class="form-check flex-fill mb-2">
                                        <input class="form-check-input" type="radio" name="income_level" value="6_plus" 
                                               data-points="1" id="income4" {{ old('income_level') == '6_plus' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="income4">
                                            6 o más salarios mínimos <span class="badge bg-success ms-2">1 pt</span>
                                        </label>
                                    </div>
                                </div>
                                @error('income_level')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Egresos con Respecto al Ingreso Total -->
                        <div class="col-md-12">
                            <div class="mb-4">
                                <label class="form-label fw-bold">Egresos con Respecto al Ingreso Total</label>
                                <div class="px-2 d-flex justify-content-between flex-wrap gap-2">
                                    <div class="form-check flex-fill mb-2">
                                        <input class="form-check-input" type="radio" name="expense_level" value="borrow" 
                                               data-points="5" id="expense1" {{ old('expense_level') == 'borrow' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="expense1">
                                            Pedir prestado / Situación extraordinaria <span class="badge bg-danger ms-2">5 pts</span>
                                        </label>
                                    </div>
                                    <div class="form-check flex-fill mb-2">
                                        <input class="form-check-input" type="radio" name="expense_level" value="total" 
                                               data-points="3" id="expense2" {{ old('expense_level') == 'total' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="expense2">
                                            Gastos totales <span class="badge bg-warning ms-2">3 pts</span>
                                        </label>
                                    </div>
                                    <div class="form-check flex-fill mb-2">
                                        <input class="form-check-input" type="radio" name="expense_level" value="partial" 
                                               data-points="1" id="expense3" {{ old('expense_level') == 'partial' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="expense3">
                                            Gastos parciales <span class="badge bg-success ms-2">1 pt</span>
                                        </label>
                                    </div>
                                </div>
                                @error('expense_level')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Caja de subtotal -->
                    <div class="subtotal-box mt-4">
                        <div class="card bg-light">
                            <div class="card-body text-center">
                                <h5 class="mb-1">Subtotal Paso 3: <span id="step-score">0</span> puntos</h5>
                                <small class="text-muted">Total acumulado: <span id="total-score">{{ ($test->step_1_score ?? 0) + ($test->step_2_score ?? 0) }}</span> puntos</small>
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
                                    Continuar al Paso 4 <i class="fas fa-arrow-right"></i>
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
                let totalScore = {{ ($test->step_1_score ?? 0) + ($test->step_2_score ?? 0) }} + stepScore;
                $('#total-score').text(totalScore);
            }

            // Función para actualizar estilos de tarjetas (fallback para navegadores sin :has())
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

            // Mostrar modal si hay errores de validación de dependientes
            @if($errors->has('name') || $errors->has('age') || $errors->has('relationship'))
                $('#dependentModal').modal('show');
            @endif
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
    </style>
@endpush
