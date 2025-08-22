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
                            <div class="step-title">Proveedor Económico</div>
                        </div>
                        <div class="step active">
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

                <!-- Dependientes existentes -->
                @if($test->dependents->count() > 0)
                <div class="mb-4">
                    <h5>Dependientes Registrados</h5>
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>Nombre</th>
                                    <th>Edad</th>
                                    <th>Parentesco</th>
                                    <th>Escolaridad</th>
                                    <th>Estado Civil</th>
                                    <th>Ingresos</th>
                                    <th>Ocupación</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($test->dependents as $dependent)
                                <tr>
                                    <td>{{ $dependent->name }}</td>
                                    <td>{{ $dependent->age }}</td>
                                    <td>{{ $dependent->relationship }}</td>
                                    <td>{{ $dependent->schooling }}</td>
                                    <td>{{ $dependent->marital_status }}</td>
                                    <td>
                                        @if($dependent->monthly_income)
                                            ${{ number_format($dependent->monthly_income) }}/mes
                                        @elseif($dependent->weekly_income)
                                            ${{ number_format($dependent->weekly_income) }}/sem
                                        @else
                                            Sin ingresos
                                        @endif
                                    </td>
                                    <td>{{ $dependent->occupation }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif

                <form action="{{ route('dif.socio_economic_tests.step3.store', $test->id) }}" method="POST" class="step-form" data-step="3">
                    @csrf
                    
                    <!-- Dependencia Económica -->
                    <div class="mb-4">
                        <label class="form-label fw-bold">Dependencia Económica (Número total de personas que dependen económicamente)</label>
                        <div class="mt-3">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="dependents_count" value="10" 
                                       data-points="5" id="dep1" {{ old('dependents_count') == '10' ? 'checked' : '' }}>
                                <label class="form-check-label" for="dep1">
                                    10 o más personas <span class="badge bg-danger ms-2">5 pts</span>
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="dependents_count" value="9" 
                                       data-points="3" id="dep2" {{ old('dependents_count') == '9' ? 'checked' : '' }}>
                                <label class="form-check-label" for="dep2">
                                    6 a 9 personas <span class="badge bg-warning ms-2">3 pts</span>
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="dependents_count" value="5" 
                                       data-points="2" id="dep3" {{ old('dependents_count') == '5' ? 'checked' : '' }}>
                                <label class="form-check-label" for="dep3">
                                    3 a 5 personas <span class="badge bg-info ms-2">2 pts</span>
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="dependents_count" value="2" 
                                       data-points="1" id="dep4" {{ old('dependents_count') == '2' ? 'checked' : '' }}>
                                <label class="form-check-label" for="dep4">
                                    1 a 2 personas <span class="badge bg-success ms-2">1 pt</span>
                                </label>
                            </div>
                        </div>
                        @error('dependents_count')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Botón para agregar dependientes -->
                    <div class="mb-4">
                        <div class="alert alert-info">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-info-circle me-2"></i>
                                <div class="flex-grow-1">
                                    <strong>Información adicional de dependientes</strong><br>
                                    Puede agregar información detallada de cada dependiente para un mejor análisis.
                                </div>
                                <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#dependentModal">
                                    <i class="fas fa-plus"></i> Agregar Dependiente
                                </button>
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

<!-- Modal para agregar dependiente -->
<div class="modal fade" id="dependentModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Agregar Dependiente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('dif.socio_economic_test_dependents.store') }}" method="POST">
                @csrf
                <input type="hidden" name="socio_economic_test_id" value="{{ $test->id }}">
                
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="dependent_name" class="form-label">Nombre completo</label>
                                <input type="text" class="form-control" id="dependent_name" name="name" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="dependent_age" class="form-label">Edad</label>
                                <input type="number" class="form-control" id="dependent_age" name="age" min="0" max="120">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="dependent_relationship" class="form-label">Parentesco</label>
                                <select class="form-control" id="dependent_relationship" name="relationship">
                                    <option value="">Seleccionar</option>
                                    <option value="Hijo/a">Hijo/a</option>
                                    <option value="Padre/Madre">Padre/Madre</option>
                                    <option value="Hermano/a">Hermano/a</option>
                                    <option value="Abuelo/a">Abuelo/a</option>
                                    <option value="Nieto/a">Nieto/a</option>
                                    <option value="Tío/a">Tío/a</option>
                                    <option value="Primo/a">Primo/a</option>
                                    <option value="Otro">Otro</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="dependent_schooling" class="form-label">Escolaridad</label>
                                <select class="form-control" id="dependent_schooling" name="schooling">
                                    <option value="">Seleccionar</option>
                                    <option value="Sin estudios">Sin estudios</option>
                                    <option value="Preescolar">Preescolar</option>
                                    <option value="Primaria">Primaria</option>
                                    <option value="Secundaria">Secundaria</option>
                                    <option value="Preparatoria">Preparatoria</option>
                                    <option value="Técnica">Técnica</option>
                                    <option value="Universidad">Universidad</option>
                                    <option value="Posgrado">Posgrado</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="dependent_marital_status" class="form-label">Estado civil</label>
                                <select class="form-control" id="dependent_marital_status" name="marital_status">
                                    <option value="">Seleccionar</option>
                                    <option value="Soltero/a">Soltero/a</option>
                                    <option value="Casado/a">Casado/a</option>
                                    <option value="Unión libre">Unión libre</option>
                                    <option value="Divorciado/a">Divorciado/a</option>
                                    <option value="Viudo/a">Viudo/a</option>
                                    <option value="Menor de edad">Menor de edad</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="dependent_occupation" class="form-label">Ocupación</label>
                                <input type="text" class="form-control" id="dependent_occupation" name="occupation" 
                                       placeholder="Estudiante, Empleado, Desempleado, etc.">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="dependent_weekly_income" class="form-label">Ingreso semanal</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" class="form-control" id="dependent_weekly_income" 
                                           name="weekly_income" min="0" step="0.01">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="dependent_monthly_income" class="form-label">Ingreso mensual</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" class="form-control" id="dependent_monthly_income" 
                                           name="monthly_income" min="0" step="0.01">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar Dependiente</button>
                </div>
            </form>
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
                let totalScore = {{ ($test->step_1_score ?? 0) + ($test->step_2_score ?? 0) }} + stepScore;
                $('#total-score').text(totalScore);
            }

            // Calcular puntaje inicial si hay valores seleccionados
            calculateStepScore();

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
