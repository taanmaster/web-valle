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
                            <div class="step-title">Economía y Dependientes</div>
                        </div>
                        <div class="step completed">
                            <div class="step-number">✓</div>
                            <div class="step-title">Estructura Económica</div>
                        </div>
                        <div class="step completed">
                            <div class="step-number">✓</div>
                            <div class="step-title">Salud</div>
                        </div>
                        <div class="step active">
                            <div class="step-number">5</div>
                            <div class="step-title">Vivienda y Entorno</div>
                        </div>
                    </div>
                </div>

                <form action="{{ route('dif.socio_economic_tests.step5.store', $test->id) }}" method="POST" class="step-form" data-step="5">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-12">
                            <h6 class="text-white bg-dark p-2 text-uppercase mb-3">
                                <i class="fas fa-check"></i> Condiciones de Vivienda y Entorno Social
                            </h6>
                        </div>

                        <!-- Problema de Vivienda -->
                        <div class="col-md-12">
                            <div class="mb-4">
                                <label class="form-label fw-bold">Grado de marginación social en Terreno/Casa</label>
                                <div class="px-2 d-flex justify-content-between flex-wrap gap-2">
                                    <div class="form-check flex-fill">
                                        <input class="form-check-input" type="radio" name="housing_problem" value="rent-pays" 
                                               data-points="5" id="housing1" {{ old('housing_problem') == 'rent-pays' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="housing1">
                                            Renta/Paga <span class="badge bg-danger ms-2">5 pts</span>
                                        </label>
                                    </div>
                                    <div class="form-check flex-fill">
                                        <input class="form-check-input" type="radio" name="housing_problem" value="borrowed" 
                                               data-points="4" id="housing2" {{ old('housing_problem') == 'borrowed' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="housing2">
                                            Prestado <span class="badge bg-warning ms-2">4 pts</span>
                                        </label>
                                    </div>
                                    <div class="form-check flex-fill">
                                        <input class="form-check-input" type="radio" name="housing_problem" value="irregular" 
                                               data-points="3" id="housing3" {{ old('housing_problem') == 'irregular' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="housing3">
                                            Irregular <span class="badge bg-warning ms-2">3 pts</span>
                                        </label>
                                    </div>
                                    <div class="form-check flex-fill">
                                        <input class="form-check-input" type="radio" name="housing_problem" value="owner" 
                                               data-points="2" id="housing4" {{ old('housing_problem') == 'owner' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="housing4">
                                            Propio <span class="badge bg-info ms-2">2 pts</span>
                                        </label>
                                    </div>
                                </div>
                                @error('housing_problem')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                                <hr class="mt-1">
                            </div>
                        </div>

                        <!-- Problema de Agua -->
                        <div class="col-md-12">
                            <div class="mb-4">
                                <label class="form-label fw-bold">Grado de marginación social en Agua</label>
                                <div class="px-2 d-flex justify-content-between flex-wrap gap-2">
                                    <div class="form-check flex-fill">
                                        <input class="form-check-input" type="radio" name="water_problem" value="no_service" 
                                               data-points="5" id="water1" {{ old('water_problem') == 'no_service' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="water1">
                                            Sin Servicio <span class="badge bg-danger ms-2">5 pts</span>
                                        </label>
                                    </div>
                                    <div class="form-check flex-fill">
                                        <input class="form-check-input" type="radio" name="water_problem" value="irregular" 
                                               data-points="3" id="water3" {{ old('water_problem') == 'irregular' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="water3">
                                            Irregular <span class="badge bg-warning ms-2">3 pts</span>
                                        </label>
                                    </div>
                                    <div class="form-check flex-fill">
                                        <input class="form-check-input" type="radio" name="water_problem" value="with_service" 
                                               data-points="1" id="water4" {{ old('water_problem') == 'with_service' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="water4">
                                            Con Servicio <span class="badge bg-success ms-2">1 pt</span>
                                        </label>
                                    </div>
                                </div>
                                @error('water_problem')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                                <hr class="mt-1">
                            </div>
                        </div>

                        <!-- Problema de Energía -->
                        <div class="col-md-12">
                            <div class="mb-4">
                                <label class="form-label fw-bold">Grado de marginación social en Energía</label>
                                <div class="px-2 d-flex justify-content-between flex-wrap gap-2">
                                    <div class="form-check flex-fill">
                                        <input class="form-check-input" type="radio" name="energy_problem" value="no_service" 
                                               data-points="5" id="energy1" {{ old('energy_problem') == 'no_service' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="energy1">
                                            Sin Servicio <span class="badge bg-danger ms-2">5 pts</span>
                                        </label>
                                    </div>
                                    <div class="form-check flex-fill">
                                        <input class="form-check-input" type="radio" name="energy_problem" value="irregular" 
                                               data-points="3" id="energy3" {{ old('energy_problem') == 'irregular' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="energy3">
                                            Irregular <span class="badge bg-warning ms-2">3 pts</span>
                                        </label>
                                    </div>
                                    <div class="form-check flex-fill">
                                        <input class="form-check-input" type="radio" name="energy_problem" value="with_service" 
                                               data-points="1" id="energy4" {{ old('energy_problem') == 'with_service' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="energy4">
                                            Con Servicio <span class="badge bg-success ms-2">1 pt</span>
                                        </label>
                                    </div>
                                </div>
                                @error('energy_problem')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                                <hr class="mt-1">
                            </div>
                        </div>

                        <!-- Problema de Drenaje -->
                        <div class="col-md-12">
                            <div class="mb-4">
                                <label class="form-label fw-bold">Grado de marginación social en Drenaje</label>
                                <div class="px-2 d-flex justify-content-between flex-wrap gap-2">
                                    <div class="form-check flex-fill">
                                        <input class="form-check-input" type="radio" name="drainage_problem" value="other" 
                                               data-points="5" id="drainage1" {{ old('drainage_problem') == 'other' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="drainage1">
                                            Otro <span class="badge bg-danger ms-2">5 pts</span>
                                        </label>
                                    </div>
                                    <div class="form-check flex-fill">
                                        <input class="form-check-input" type="radio" name="drainage_problem" value="letrine" 
                                               data-points="3" id="drainage3" {{ old('drainage_problem') == 'letrine' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="drainage3">
                                            Letrina <span class="badge bg-warning ms-2">3 pts</span>
                                        </label>
                                    </div>
                                    <div class="form-check flex-fill">
                                        <input class="form-check-input" type="radio" name="drainage_problem" value="with_service" 
                                               data-points="1" id="drainage4" {{ old('drainage_problem') == 'with_service' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="drainage4">
                                            Con Servicio <span class="badge bg-success ms-2">1 pt</span>
                                        </label>
                                    </div>
                                </div>
                                @error('drainage_problem')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                                <hr class="mt-1">
                            </div>
                        </div>

                        <!-- Problema de Gas -->
                        <div class="col-md-12">
                            <div class="mb-4">
                                <label class="form-label fw-bold">Grado de marginación social en Gas</label>
                                <div class="px-2 d-flex justify-content-between flex-wrap gap-2">
                                    <div class="form-check flex-fill">
                                        <input class="form-check-input" type="radio" name="gas_problem" value="wood" 
                                               data-points="5" id="gas1" {{ old('gas_problem') == 'wood' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="gas1">
                                            Leña <span class="badge bg-danger ms-2">5 pts</span>
                                        </label>
                                    </div>
                                    <div class="form-check flex-fill">
                                        <input class="form-check-input" type="radio" name="gas_problem" value="butane" 
                                               data-points="3" id="gas3" {{ old('gas_problem') == 'butane' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="gas3">
                                            Butano <span class="badge bg-warning ms-2">3 pts</span>
                                        </label>
                                    </div>
                                    <div class="form-check flex-fill">
                                        <input class="form-check-input" type="radio" name="gas_problem" value="natural" 
                                               data-points="1" id="gas4" {{ old('gas_problem') == 'natural' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="gas4">
                                            Natural <span class="badge bg-success ms-2">1 pt</span>
                                        </label>
                                    </div>
                                </div>
                                @error('gas_problem')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                                <hr class="mt-1">
                            </div>
                        </div>

                        <!-- Problema de Techo -->
                        <div class="col-md-12">
                            <div class="mb-4">
                                <label class="form-label fw-bold">Grado de marginación social en Techo</label>
                                <div class="px-2 d-flex justify-content-between flex-wrap gap-2">
                                    <div class="form-check flex-fill">
                                        <input class="form-check-input" type="radio" name="roof_problem" value="other" 
                                               data-points="5" id="roof1" {{ old('roof_problem') == 'other' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="roof1">
                                            Otro <span class="badge bg-danger ms-2">5 pts</span>
                                        </label>
                                    </div>
                                    <div class="form-check flex-fill">
                                        <input class="form-check-input" type="radio" name="roof_problem" value="metal" 
                                               data-points="3" id="roof3" {{ old('roof_problem') == 'metal' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="roof3">
                                            Lamina <span class="badge bg-warning ms-2">3 pts</span>
                                        </label>
                                    </div>
                                    <div class="form-check flex-fill">
                                        <input class="form-check-input" type="radio" name="roof_problem" value="cement" 
                                               data-points="1" id="roof4" {{ old('roof_problem') == 'cement' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="roof4">
                                            Plancha <span class="badge bg-success ms-2">1 pt</span>
                                        </label>
                                    </div>
                                </div>
                                @error('roof_problem')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                                <hr class="mt-1">
                            </div>
                        </div>

                        <!-- Problema de Pared -->
                        <div class="col-md-12">
                            <div class="mb-4">
                                <label class="form-label fw-bold">Grado de marginación social en Pared</label>
                                <div class="px-2 d-flex justify-content-between flex-wrap gap-2">
                                    <div class="form-check flex-fill">
                                        <input class="form-check-input" type="radio" name="wall_problem" value="wood" 
                                               data-points="5" id="wall1" {{ old('wall_problem') == 'wood' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="wall1">
                                            Madera/Otros <span class="badge bg-danger ms-2">5 pts</span>
                                        </label>
                                    </div>
                                    <div class="form-check flex-fill">
                                        <input class="form-check-input" type="radio" name="wall_problem" value="cardboard" 
                                               data-points="3" id="wall2" {{ old('wall_problem') == 'cardboard' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="wall2">
                                            Cartón <span class="badge bg-warning ms-2">3 pts</span>
                                        </label>
                                    </div>
                                    <div class="form-check flex-fill">
                                        <input class="form-check-input" type="radio" name="wall_problem" value="cement" 
                                               data-points="1" id="wall4" {{ old('wall_problem') == 'cement' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="wall4">
                                            Material <span class="badge bg-success ms-2">1 pt</span>
                                        </label>
                                    </div>
                                </div>
                                @error('wall_problem')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                                <hr class="mt-1">
                            </div>
                        </div>

                        <!-- Problema de Piso -->
                        <div class="col-md-12">
                            <div class="mb-4">
                                <label class="form-label fw-bold">Grado de marginación social en Piso</label>
                                <div class="px-2 d-flex justify-content-between flex-wrap gap-2">
                                    <div class="form-check flex-fill">
                                        <input class="form-check-input" type="radio" name="floor_problem" value="dirt" 
                                               data-points="5" id="floor1" {{ old('floor_problem') == 'dirt' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="floor1">
                                            Tierra <span class="badge bg-danger ms-2">5 pts</span>
                                        </label>
                                    </div>
                                    <div class="form-check flex-fill">
                                        <input class="form-check-input" type="radio" name="floor_problem" value="cement" 
                                               data-points="3" id="floor2" {{ old('floor_problem') == 'cement' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="floor2">
                                            Concreto <span class="badge bg-warning ms-2">3 pts</span>
                                        </label>
                                    </div>
                                    <div class="form-check flex-fill">
                                        <input class="form-check-input" type="radio" name="floor_problem" value="with_finish" 
                                               data-points="1" id="floor4" {{ old('floor_problem') == 'with_finish' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="floor4">
                                            Con Acabado <span class="badge bg-success ms-2">1 pt</span>
                                        </label>
                                    </div>
                                </div>
                                @error('floor_problem')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                                <hr class="mt-1">
                            </div>
                        </div>

                        <!-- Problema de Habitaciones -->
                        <div class="col-md-12">
                            <div class="mb-4">
                                <label class="form-label fw-bold">Grado de marginación social en Habitaciones</label>
                                <div class="px-2 d-flex justify-content-between flex-wrap gap-2">
                                    <div class="form-check flex-fill">
                                        <input class="form-check-input" type="radio" name="room_problem" value="one_room" 
                                               data-points="4" id="room1" {{ old('room_problem') == 'one_room' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="room1">
                                            Cuarto redondo <span class="badge bg-warning ms-2">4 pts</span>
                                        </label>
                                    </div>
                                    <div class="form-check flex-fill">
                                        <input class="form-check-input" type="radio" name="room_problem" value="two_three_rooms" 
                                               data-points="3" id="room2" {{ old('room_problem') == 'two_three_rooms' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="room2">
                                            Dos / Tres <span class="badge bg-warning ms-2">3 pts</span>
                                        </label>
                                    </div>
                                    <div class="form-check flex-fill">
                                        <input class="form-check-input" type="radio" name="room_problem" value="full_house" 
                                               data-points="1" id="room4" {{ old('room_problem') == 'full_house' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="room4">
                                            Cuatro o más <span class="badge bg-success ms-2">1 pt</span>
                                        </label>
                                    </div>
                                </div>
                                @error('room_problem')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                                <hr class="mt-1">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <h6 class="text-white bg-dark p-2 text-uppercase mb-3">
                                <i class="fas fa-check"></i> Observaciones y Notas
                            </h6>
                        </div>

                        <div class="col-md-12">
                            <!-- Observaciones finales -->
                            <div class="mb-4">
                                <label for="final_observations" class="form-label fw-bold">Observaciones Adicionales</label>
                                <textarea name="final_observations" id="final_observations" 
                                        class="form-control @error('final_observations') is-invalid @enderror" 
                                        rows="4" placeholder="Recibe usted alguna ayuda de algún programa de asistencia (especifique cual)...">{{ old('final_observations') }}</textarea>
                                @error('final_observations')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-12">
                            <!-- Diagnostico Social -->
                            <div class="mb-4">
                                <label for="approval_notes" class="form-label fw-bold">Diagnostico Social</label>
                                <textarea name="approval_notes" id="approval_notes" 
                                        class="form-control @error('approval_notes') is-invalid @enderror" 
                                        rows="4" placeholder="Describa cualquier situación adicional relevante para la evaluación socioeconómica...">{{ old('approval_notes') }}</textarea>
                                @error('approval_notes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
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
                                            <td>Paso 2 - Economía y Dependientes:</td>
                                            <td class="text-end"><span class="badge bg-secondary">{{ $test->step_2_score ?? 0 }} pts</span></td>
                                        </tr>
                                        <tr>
                                            <td>Paso 3 - Estructura Económica:</td>
                                            <td class="text-end"><span class="badge bg-secondary">{{ $test->step_3_score ?? 0 }} pts</span></td>
                                        </tr>
                                        <tr>
                                            <td>Paso 4 - Salud:</td>
                                            <td class="text-end"><span class="badge bg-secondary">{{ $test->step_4_score ?? 0 }} pts</span></td>
                                        </tr>
                                        <tr>
                                            <td>Paso 5 - Vivienda y Entorno:</td>
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
    updateCardStyles();

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
