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
                            <div class="step-title">Proveedor Económico</div>
                        </div>
                        <div class="step completed">
                            <div class="step-number">✓</div>
                            <div class="step-title">Estructura Familiar</div>
                        </div>
                        <div class="step active">
                            <div class="step-number">4</div>
                            <div class="step-title">Estructura Económica</div>
                        </div>
                        <div class="step">
                            <div class="step-number">5</div>
                            <div class="step-title">Salud y Vivienda</div>
                        </div>
                    </div>
                </div>

                <form action="{{ route('dif.socio_economic_tests.step4.store', $test->id) }}" method="POST" class="step-form" data-step="4">
                    @csrf
                    
                    <!-- Información económica libre -->
                    <div class="mb-4">
                        <h5 class="mb-3">Información Económica General</h5>
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

                    <hr class="my-4">

                    <!-- Parámetros de puntuación -->
                    <h5 class="mb-3">Evaluación Económica</h5>
                    
                    <div class="row">
                        <!-- Ingreso Mensual en Salarios Mínimos -->
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label class="form-label fw-bold">Ingreso Mensual en Salarios Mínimos</label>
                                <div class="mt-2">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="income_level" value="0_1" 
                                               data-points="4" id="income1" {{ old('income_level') == '0_1' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="income1">
                                            0 a 1 salario mínimo <span class="badge bg-danger ms-2">4 pts</span>
                                        </label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="income_level" value="2_3" 
                                               data-points="3" id="income2" {{ old('income_level') == '2_3' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="income2">
                                            2 a 3 salarios mínimos <span class="badge bg-warning ms-2">3 pts</span>
                                        </label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="income_level" value="4_5" 
                                               data-points="2" id="income3" {{ old('income_level') == '4_5' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="income3">
                                            4 a 5 salarios mínimos <span class="badge bg-info ms-2">2 pts</span>
                                        </label>
                                    </div>
                                    <div class="form-check mb-2">
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
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label class="form-label fw-bold">Egresos con Respecto al Ingreso Total</label>
                                <div class="mt-2">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="expense_level" value="borrow" 
                                               data-points="5" id="expense1" {{ old('expense_level') == 'borrow' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="expense1">
                                            Pedir prestado / Situación extraordinaria <span class="badge bg-danger ms-2">5 pts</span>
                                        </label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="expense_level" value="total" 
                                               data-points="3" id="expense2" {{ old('expense_level') == 'total' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="expense2">
                                            Gastos totales <span class="badge bg-warning ms-2">3 pts</span>
                                        </label>
                                    </div>
                                    <div class="form-check mb-2">
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

                    <!-- Información adicional -->
                    <div class="alert alert-info">
                        <div class="d-flex">
                            <i class="fas fa-info-circle me-2 mt-1"></i>
                            <div>
                                <strong>Información sobre Salarios Mínimos</strong><br>
                                <small>El salario mínimo vigente en México para 2025 es de aproximadamente $249.50 pesos diarios ($7,735 pesos mensuales).</small>
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

            // Calcular puntaje inicial si hay valores seleccionados
            calculateStepScore();

            // Formatear números en los campos de entrada
            $('input[type="number"]').on('input', function() {
                const value = parseFloat(this.value);
                if (!isNaN(value)) {
                    this.value = value.toFixed(2);
                }
            });

            // Calcular automáticamente algunos campos
            $('#monthly_expenses, #monthly_debt').on('input', function() {
                const expenses = parseFloat($('#monthly_expenses').val()) || 0;
                const debt = parseFloat($('#monthly_debt').val()) || 0;
                
                // Mostrar indicadores visuales si hay datos
                if (expenses > 0 || debt > 0) {
                    updateFinancialIndicators(expenses, debt);
                }
            });

            function updateFinancialIndicators(expenses, debt) {
                // Esta función podría calcular indicadores financieros adicionales
                // Por ejemplo, ratio de endeudamiento, etc.
                const totalOutflow = expenses + debt;
                
                if (totalOutflow > 15000) {
                    $('#expense_level_borrow').prop('checked', true);
                } else if (totalOutflow > 7500) {
                    $('#expense_level_total').prop('checked', true);
                }
                
                // Recalcular puntaje
                calculateStepScore();
            }
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

        .input-group .form-control {
            text-align: right;
        }
    </style>
@endpush
