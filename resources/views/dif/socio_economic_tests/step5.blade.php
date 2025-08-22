@extends('layouts.master')
@section('title')Paso 5: Salud y Vivienda @endsection

@section('content')
<!-- Breadcrumbs -->
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') DIF @endslot
@slot('li_3') Estudios Socioeconómicos @endslot
@slot('title') Paso 5: Salud y Vivienda @endslot
@endcomponent

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h4 class="card-title mb-0">Paso 5: Salud y Vivienda</h4>
                        <p class="text-muted mb-0">{{ $test->citizen_name }} {{ $test->citizen_last_name }} - Paso Final</p>
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
                        <div class="step completed">
                            <div class="step-number">✓</div>
                            <div class="step-title">Estructura Económica</div>
                        </div>
                        <div class="step active">
                            <div class="step-number">5</div>
                            <div class="step-title">Salud y Vivienda</div>
                        </div>
                    </div>
                </div>

                <form action="{{ route('dif.socio_economic_tests.step5.store', $test->id) }}" method="POST" class="step-form" data-step="5">
                    @csrf
                    
                    <div class="row">
                        <!-- Problema de Salud -->
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label class="form-label fw-bold">¿Algún miembro de la familia tiene un problema de salud?</label>
                                <div class="mt-2">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="health_problem" value="serious_chronic" 
                                               data-points="5" id="health1" {{ old('health_problem') == 'serious_chronic' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="health1">
                                            Grave crónico que requiere tratamiento permanente <span class="badge bg-danger ms-2">5 pts</span>
                                        </label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="health_problem" value="serious_treatable" 
                                               data-points="4" id="health2" {{ old('health_problem') == 'serious_treatable' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="health2">
                                            Grave tratable <span class="badge bg-warning ms-2">4 pts</span>
                                        </label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="health_problem" value="moderate" 
                                               data-points="3" id="health3" {{ old('health_problem') == 'moderate' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="health3">
                                            Moderado <span class="badge bg-info ms-2">3 pts</span>
                                        </label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="health_problem" value="minor" 
                                               data-points="2" id="health4" {{ old('health_problem') == 'minor' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="health4">
                                            Menor <span class="badge bg-secondary ms-2">2 pts</span>
                                        </label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="health_problem" value="none" 
                                               data-points="0" id="health5" {{ old('health_problem') == 'none' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="health5">
                                            Ninguno <span class="badge bg-success ms-2">0 pts</span>
                                        </label>
                                    </div>
                                </div>
                                @error('health_problem')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Problema de Vivienda -->
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label class="form-label fw-bold">¿La familia presenta algún problema de vivienda?</label>
                                <div class="mt-2">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="housing_problem" value="no_housing" 
                                               data-points="5" id="housing1" {{ old('housing_problem') == 'no_housing' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="housing1">
                                            No tiene <span class="badge bg-danger ms-2">5 pts</span>
                                        </label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="housing_problem" value="serious_condition" 
                                               data-points="4" id="housing2" {{ old('housing_problem') == 'serious_condition' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="housing2">
                                            Mal estado que requiere reparación inmediata <span class="badge bg-warning ms-2">4 pts</span>
                                        </label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="housing_problem" value="regular_condition" 
                                               data-points="3" id="housing3" {{ old('housing_problem') == 'regular_condition' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="housing3">
                                            Regular estado <span class="badge bg-info ms-2">3 pts</span>
                                        </label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="housing_problem" value="good_condition" 
                                               data-points="1" id="housing4" {{ old('housing_problem') == 'good_condition' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="housing4">
                                            Buen estado <span class="badge bg-success ms-2">1 pt</span>
                                        </label>
                                    </div>
                                </div>
                                @error('housing_problem')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <!-- Observaciones finales -->
                    <div class="mb-4">
                        <label for="final_observations" class="form-label fw-bold">Observaciones Adicionales</label>
                        <textarea name="final_observations" id="final_observations" 
                                  class="form-control @error('final_observations') is-invalid @enderror" 
                                  rows="4" placeholder="Describa cualquier situación adicional relevante para la evaluación socioeconómica...">{{ old('final_observations') }}</textarea>
                        @error('final_observations')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Resumen de puntajes -->
                    <div class="card bg-light mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">Resumen de Evaluación</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <table class="table table-sm">
                                        <tr>
                                            <td>Paso 1 - Datos Generales:</td>
                                            <td class="text-end"><span class="badge bg-secondary">{{ $test->step_1_score ?? 0 }} pts</span></td>
                                        </tr>
                                        <tr>
                                            <td>Paso 2 - Proveedor Económico:</td>
                                            <td class="text-end"><span class="badge bg-secondary">{{ $test->step_2_score ?? 0 }} pts</span></td>
                                        </tr>
                                        <tr>
                                            <td>Paso 3 - Estructura Familiar:</td>
                                            <td class="text-end"><span class="badge bg-secondary">{{ $test->step_3_score ?? 0 }} pts</span></td>
                                        </tr>
                                        <tr>
                                            <td>Paso 4 - Estructura Económica:</td>
                                            <td class="text-end"><span class="badge bg-secondary">{{ $test->step_4_score ?? 0 }} pts</span></td>
                                        </tr>
                                        <tr>
                                            <td>Paso 5 - Salud y Vivienda:</td>
                                            <td class="text-end"><span class="badge bg-primary" id="step5-score">0 pts</span></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <div class="text-center">
                                        <h3 class="mb-1">Puntaje Total</h3>
                                        <h1 class="text-primary mb-2" id="final-total-score">{{ ($test->step_1_score ?? 0) + ($test->step_2_score ?? 0) + ($test->step_3_score ?? 0) + ($test->step_4_score ?? 0) }}</h1>
                                        <div id="vulnerability-level" class="badge fs-6 mb-2">
                                            <!-- Se actualiza con JavaScript -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Caja de subtotal del paso -->
                    <div class="subtotal-box mb-4">
                        <div class="card bg-light">
                            <div class="card-body text-center">
                                <h5 class="mb-1">Subtotal Paso 5: <span id="step-score">0</span> puntos</h5>
                                <small class="text-muted">Este es el último paso de la evaluación</small>
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
                                <button type="submit" class="btn btn-success btn-lg">
                                    <i class="fas fa-check"></i> Finalizar Evaluación
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal de confirmación -->
<div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmModalLabel">Confirmar Finalización</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-3">
                    <i class="fas fa-exclamation-triangle text-warning fa-3x mb-3"></i>
                    <h4>¿Está seguro de finalizar la evaluación?</h4>
                    <p class="text-muted">Una vez finalizada, no podrá modificar los datos del estudio socioeconómico.</p>
                </div>
                
                <div class="row">
                    <div class="col-md-12">
                        <div class="card border-primary">
                            <div class="card-body text-center">
                                <h5 class="text-primary">Puntaje Final</h5>
                                <h2 class="text-primary" id="modal-total-score">0</h2>
                                <span id="modal-vulnerability-badge" class="badge fs-6"></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="card border-info">
                            <div class="card-body">
                                <h6 class="text-info">Siguientes Pasos:</h6>
                                <p>En la siguiente pantalla podrás:</p>
                                <ul class="mb-0">
                                    <li>Subir la documentación de Soporte y Verificación</li>
                                    <li>Documentación particular de dependientes (si aplica)</li>
                                    <li>Evidencias adicionales</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-success" id="confirmFinalize">
                    <i class="fas fa-check"></i> Sí, Finalizar Evaluación
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
$(document).ready(function() {
    // Cálculo en tiempo real de puntajes
    $('input[type="radio"][data-points]').on('change', function() {
        calculateStepScore();
        updateVulnerabilityLevel();
    });

    function calculateStepScore() {
        let stepScore = 0;
        
        // Sumar puntos de todas las opciones seleccionadas en este paso
        $('.step-form input[type="radio"]:checked').each(function() {
            stepScore += parseInt($(this).data('points') || 0);
        });
        
        // Actualizar subtotal del paso
        $('#step-score').text(stepScore);
        $('#step5-score').text(stepScore + ' pts');
        
        // Calcular total final
        let totalScore = {{ ($test->step_1_score ?? 0) + ($test->step_2_score ?? 0) + ($test->step_3_score ?? 0) + ($test->step_4_score ?? 0) }} + stepScore;
        $('#final-total-score').text(totalScore);
        
        return { stepScore, totalScore };
    }

    function updateVulnerabilityLevel() {
        const scores = calculateStepScore();
        const totalScore = scores.totalScore;
        
        let level, badge, support;
        
        if (totalScore >= 63) {
            level = 'VULNERABILIDAD MUY ALTA';
            badge = 'bg-danger';
        } else if (totalScore >= 50) {
            level = 'VULNERABILIDAD ALTA';
            badge = 'bg-warning';
        } else if (totalScore >= 37) {
            level = 'VULNERABILIDAD MEDIA';
            badge = 'bg-info';
        } else if (totalScore >= 25) {
            level = 'VULNERABILIDAD BAJA';
            badge = 'bg-success';
        } else {
            level = 'SIN VULNERABILIDAD';
            badge = 'bg-secondary';
        }
        
        $('#vulnerability-level').removeClass().addClass('badge fs-6 mb-2 ' + badge).text(level);
        
        // Actualizar modal
        $('#modal-total-score').text(totalScore);
        $('#modal-vulnerability-badge').removeClass().addClass('badge fs-6 ' + badge).text(level);
    }

    // Calcular puntaje inicial si hay valores seleccionados
    calculateStepScore();
    updateVulnerabilityLevel();

    // Interceptar el envío del formulario para mostrar modal de confirmación
    $('.step-form').on('submit', function(e) {
        e.preventDefault();
        $('#confirmModal').modal('show');
    });

    // Confirmar finalización
    $('#confirmFinalize').on('click', function() {
        $('.step-form')[0].submit();
    });

    // Validación antes de envío
    function validateForm() {
        let isValid = true;
        
        // Verificar que se haya seleccionado problema de salud
        if (!$('input[name="health_problem"]:checked').length) {
            alert('Por favor seleccione una opción para el problema de salud');
            isValid = false;
        }
        
        // Verificar que se haya seleccionado problema de vivienda
        if (!$('input[name="housing_problem"]:checked').length) {
            alert('Por favor seleccione una opción para el problema de vivienda');
            isValid = false;
        }
        
        return isValid;
    }

    // Aplicar validación al confirmar
    $('#confirmFinalize').on('click', function() {
        if (validateForm()) {
            $('.step-form')[0].submit();
        } else {
            $('#confirmModal').modal('hide');
        }
    });
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
    background: #198754;
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

.vulnerability-indicator {
    font-size: 1.2em;
    font-weight: bold;
    padding: 10px;
    border-radius: 8px;
    text-align: center;
}

.table td {
    border: none;
    padding: 0.5rem;
}
</style>
@endsection
