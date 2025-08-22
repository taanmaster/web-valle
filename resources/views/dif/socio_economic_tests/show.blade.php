@extends('layouts.master')
@section('title')Estudio Socioeconómico - {{ $test->citizen_name }} {{ $test->citizen_last_name }} @endsection

@section('content')
<!-- Breadcrumbs -->
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') DIF @endslot
@slot('li_3') Estudios Socioeconómicos @endslot
@slot('title') Detalle del Estudio @endslot
@endcomponent

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h4 class="card-title mb-0">Estudio Socioeconómico</h4>
                        <div class="d-flex align-items-center mt-2">
                            <p class="text-muted mb-0 me-3">{{ $test->citizen_name }} {{ $test->citizen_last_name }}</p>
                            @if($test->status == 'completed')
                                <span class="badge bg-success">Completado</span>
                            @elseif($test->status == 'in_progress')
                                <span class="badge bg-warning">En Progreso</span>
                            @else
                                <span class="badge bg-secondary">Borrador</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="btn-group" role="group">
                            <a href="{{ route('dif.socio_economic_tests.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left"></i> Volver al listado
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <!-- Resumen del resultado -->
                @if($test->status == 'completed')
                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="card border-primary">
                            <div class="card-body text-center">
                                <h5 class="text-primary mb-1">Puntaje Total</h5>
                                <h2 class="text-primary mb-2">{{ $test->total_score }}</h2>
                                @php
                                    $level = $test->getVulnerabilityLevelText();
                                    $badgeClass = '';
                                    switch($level) {
                                        case 'ALTA VULNERABILIDAD': $badgeClass = 'bg-danger'; break;
                                        case 'MEDIA VULNERABILIDAD': $badgeClass = 'bg-warning'; break;
                                        case 'BAJA VULNERABILIDAD': $badgeClass = 'bg-info'; break;
                                        case 'NO SUJETO A ASISTENCIA SOCIAL': $badgeClass = 'bg-success'; break;
                                        default: $badgeClass = 'bg-secondary';
                                    }
                                @endphp
                                <span class="badge {{ $badgeClass }} fs-6">{{ $level }}</span>
                            </div>
                        </div>
                    </div>

                    {{--  
                    <div class="col-md-8">
                        <div class="card border-info">
                            <div class="card-body">
                                <h6 class="text-info mb-2">Resultado de la Evaluación:</h6>
                                @php 
                                    $support = $test->getRecommendedSupport();
                                @endphp
                                @if($test->vulnerability_level)
                                    <p class="mb-1"><strong>Nivel de vulnerabilidad:</strong> {{ $test->vulnerability_level }}</p>
                                @endif
                                @if($test->recommended_support_type)
                                    <p class="mb-1"><strong>Tipo de apoyo recomendado:</strong> {{ $test->recommended_support_type }}</p>
                                @endif
                                @if($test->recommended_amount)
                                    <p class="mb-1"><strong>Monto recomendado:</strong> ${{ number_format($test->recommended_amount, 2) }}</p>
                                @endif
                                @if(is_array($support) && isset($support['description']))
                                    <p class="mb-1"><strong>Descripción:</strong> {{ $support['description'] }}</p>
                                @elseif(is_string($support))
                                    <p class="mb-1"><strong>Descripción:</strong> {{ $support }}</p>
                                @endif
                                <small class="text-muted">
                                    Evaluación completada el {{ $test->updated_at->format('d/m/Y H:i') }}
                                </small>
                            </div>
                        </div>
                    </div>
                    --}}
                </div>
                @endif

                <!-- Progreso de pasos -->
                <div class="progress-overview mb-4">
                    <div class="step-progress-detailed">
                        <div class="step {{ $test->step_1_score !== null ? 'completed' : 'pending' }}">
                            <div class="step-number">
                                @if($test->step_1_score !== null)
                                    ✓
                                @else
                                    1
                                @endif
                            </div>
                            <div class="step-info">
                                <div class="step-title">Datos Generales</div>
                                <div class="step-score">{{ $test->step_1_score ?? 0 }} pts</div>
                            </div>
                        </div>
                        <div class="step {{ $test->step_2_score !== null ? 'completed' : 'pending' }}">
                            <div class="step-number">
                                @if($test->step_2_score !== null)
                                    ✓
                                @else
                                    2
                                @endif
                            </div>
                            <div class="step-info">
                                <div class="step-title">Proveedor Económico</div>
                                <div class="step-score">{{ $test->step_2_score ?? 0 }} pts</div>
                            </div>
                        </div>
                        <div class="step {{ $test->step_3_score !== null ? 'completed' : 'pending' }}">
                            <div class="step-number">
                                @if($test->step_3_score !== null)
                                    ✓
                                @else
                                    3
                                @endif
                            </div>
                            <div class="step-info">
                                <div class="step-title">Estructura Familiar</div>
                                <div class="step-score">{{ $test->step_3_score ?? 0 }} pts</div>
                            </div>
                        </div>
                        <div class="step {{ $test->step_4_score !== null ? 'completed' : 'pending' }}">
                            <div class="step-number">
                                @if($test->step_4_score !== null)
                                    ✓
                                @else
                                    4
                                @endif
                            </div>
                            <div class="step-info">
                                <div class="step-title">Estructura Económica</div>
                                <div class="step-score">{{ $test->step_4_score ?? 0 }} pts</div>
                            </div>
                        </div>
                        <div class="step {{ $test->step_5_score !== null ? 'completed' : 'pending' }}">
                            <div class="step-number">
                                @if($test->step_5_score !== null)
                                    ✓
                                @else
                                    5
                                @endif
                            </div>
                            <div class="step-info">
                                <div class="step-title">Salud y Vivienda</div>
                                <div class="step-score">{{ $test->step_5_score ?? 0 }} pts</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Botones de acción según el estado -->
                @if($test->status == 'draft' || $test->status == 'in_progress')
                <div class="alert alert-info mb-4">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-info-circle me-2"></i>
                        <div class="flex-grow-1">
                            <strong>Estudio en progreso</strong><br>
                            <small>Complete todos los pasos para obtener la evaluación final.</small>
                        </div>
                        <div>
                            @if($test->step_1_score === null)
                                <a href="{{ route('dif.socio_economic_tests.edit', $test->id) }}" class="btn btn-primary">
                                    Comenzar Paso 1
                                </a>
                            @elseif($test->step_2_score === null)
                                <a href="{{ route('dif.socio_economic_tests.step2', $test->id) }}" class="btn btn-primary">
                                    Continuar Paso 2
                                </a>
                            @elseif($test->step_3_score === null)
                                <a href="{{ route('dif.socio_economic_tests.step3', $test->id) }}" class="btn btn-primary">
                                    Continuar Paso 3
                                </a>
                            @elseif($test->step_4_score === null)
                                <a href="{{ route('dif.socio_economic_tests.step4', $test->id) }}" class="btn btn-primary">
                                    Continuar Paso 4
                                </a>
                            @elseif($test->step_5_score === null)
                                <a href="{{ route('dif.socio_economic_tests.step5', $test->id) }}" class="btn btn-primary">
                                    Finalizar Paso 5
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
                @endif

                <!-- Detalles del estudio -->
                <div class="row">
                    <!-- Datos Generales -->
                    <div class="col-md-6">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h6 class="mb-0">
                                    <i class="fas fa-user me-2"></i>
                                    Datos Generales
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <strong>Nombre:</strong><br>
                                        {{ $test->citizen_name }} {{ $test->citizen_last_name }}
                                    </div>
                                    <div class="col-sm-6">
                                        <strong>CURP:</strong><br>
                                        {{ $test->citizen_curp ?: 'No especificado' }}
                                    </div>
                                    <div class="col-sm-6 mt-2">
                                        <strong>Coordinación:</strong><br>
                                        {{ $test->coordination->name ?? 'No asignada' }}
                                    </div>
                                    <div class="col-sm-6 mt-2">
                                        <strong>Ciudadano:</strong><br>
                                        {{ $test->user->name ?? 'No asignado' }}
                                    </div>
                                    @if($test->citizen_age)
                                    <div class="col-sm-6 mt-2">
                                        <strong>Edad:</strong><br>
                                        {{ $test->citizen_age }} años
                                    </div>
                                    @endif
                                    @if($step1Answers && isset($step1Answers['support_type']))
                                    <div class="col-sm-6 mt-2">
                                        <strong>Tipo de apoyo:</strong><br>
                                        {{ $step1Answers['support_type'] }}
                                    </div>
                                    @endif
                                    @if($step1Answers && isset($step1Answers['reference_phone']))
                                    <div class="col-sm-6 mt-2">
                                        <strong>Teléfono de referencia:</strong><br>
                                        {{ $step1Answers['reference_phone'] }}
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Información Económica -->
                    <div class="col-md-6">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h6 class="mb-0">
                                    <i class="fas fa-dollar-sign me-2"></i>
                                    Información Económica
                                    @if($test->step_2_score !== null || $test->step_4_score !== null)
                                        <span class="badge bg-secondary ms-2">{{ ($test->step_2_score ?? 0) + ($test->step_4_score ?? 0) }} pts</span>
                                    @endif
                                </h6>
                            </div>
                            <div class="card-body">
                                <!-- Datos del Paso 2: Proveedor Económico -->
                                @if($step2Answers)
                                <div class="mb-3">
                                    <strong>Proveedor Económico (Paso 2):</strong><br>
                                    @if(isset($step2Answers['civil_status']))
                                        <small>Estado Civil: {{ $translateField('civil_status', $step2Answers['civil_status']) }}</small><br>
                                    @endif
                                    @if(isset($step2Answers['age_range']))
                                        <small>Rango de Edad: {{ $translateField('age_range', $step2Answers['age_range']) }}</small><br>
                                    @endif
                                    @if(isset($step2Answers['occupation']))
                                        <small>Ocupación: {{ $translateField('occupation', $step2Answers['occupation']) }}</small><br>
                                    @endif
                                    @if(isset($step2Answers['education']))
                                        <small>Educación: {{ $translateField('education', $step2Answers['education']) }}</small><br>
                                    @endif
                                    @if(isset($step2Answers['dependents_count']))
                                        <small>Dependientes: {{ $step2Answers['dependents_count'] }}</small>
                                    @endif
                                </div>
                                @endif

                                <!-- Datos del Paso 3: Estructura Económica -->
                                @if($step3Answers || $test->monthly_expenses || $test->monthly_debt || $test->monthly_savings)
                                <div>
                                    <strong>Situación Financiera (Paso 3):</strong><br>
                                    @if($test->monthly_expenses)
                                        <small>Gastos mensuales: ${{ number_format($test->monthly_expenses, 2) }}</small><br>
                                    @endif
                                    @if($test->monthly_debt)
                                        <small>Deudas mensuales: ${{ number_format($test->monthly_debt, 2) }}</small><br>
                                    @endif
                                    @if($test->monthly_savings)
                                        <small>Ahorros mensuales: ${{ number_format($test->monthly_savings, 2) }}</small><br>
                                    @endif
                                    @if(isset($step3Answers['income_level']))
                                        <small>Nivel de Ingresos: {{ $translateField('income_level', $step3Answers['income_level']) }}</small><br>
                                    @endif
                                    @if(isset($step3Answers['expense_level']))
                                        <small>Nivel de Gastos: {{ $translateField('expense_level', $step3Answers['expense_level']) }}</small>
                                    @endif
                                </div>
                                @endif

                                @if(!$step2Answers && !$step3Answers && !$test->monthly_expenses)
                                    <p class="text-muted">Sin información económica registrada</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Dependientes y Familia -->
                @if($test->dependents->count() > 0 || $test->step_3_score !== null)
                <div class="row">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h6 class="mb-0">
                                <i class="fas fa-users me-2"></i>
                                Estructura Familiar
                                @if($test->step_3_score !== null)
                                    <span class="badge bg-secondary ms-2">{{ $test->step_3_score }} pts</span>
                                @endif
                                <span class="badge bg-info ms-2">{{ $test->dependents->count() }} dependientes</span>
                            </h6>
                        </div>
                        <div class="card-body">
                            @if($test->dependents->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered">
                                    <thead class="table-light">
                                        <tr>
                                            <th width="18%">Nombre</th>
                                            <th width="8%">Edad</th>
                                            <th width="12%">Parentesco</th>
                                            <th width="12%">Escolaridad</th>
                                            <th width="12%">Estado Civil</th>
                                            <th width="12%">Ocupación</th>
                                            <th width="10%">Ingreso Sem.</th>
                                            <th width="10%">Ingreso Men.</th>
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
                                            <td>{{ $dependent->occupation }}</td>
                                            <td>
                                                @if($dependent->weekly_income)
                                                    ${{ number_format($dependent->weekly_income) }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>
                                                @if($dependent->monthly_income)
                                                    ${{ number_format($dependent->monthly_income) }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot class="table-secondary">
                                        <tr class="fw-bold">
                                            <td colspan="6" class="text-end">
                                                <strong>TOTAL INGRESOS DEPENDIENTES:</strong>
                                            </td>
                                            <td class="text-center">
                                                @php 
                                                    $totalWeekly = $test->dependents->sum('weekly_income');
                                                @endphp
                                                <span class="badge bg-primary fs-6">${{ number_format($totalWeekly, 2) }}</span>
                                            </td>
                                            <td class="text-center">
                                                @php 
                                                    $totalMonthly = $test->dependents->sum('monthly_income');
                                                @endphp
                                                <span class="badge bg-success fs-6">${{ number_format($totalMonthly, 2) }}</span>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            @else
                            <p class="text-muted">Sin dependientes registrados</p>
                            @endif
                        </div>
                    </div>
                </div>
                @endif

                <!-- Resumen detallado de respuestas (solo si está completado) -->
                @if($test->status == 'completed' && ($step2Answers || $step3Answers || $step4Answers || $step5Answers))
                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="mb-0">
                            <i class="fas fa-clipboard-list me-2"></i>
                            Detalle de Evaluación por Pasos
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @if($step2Answers)
                            <div class="col-md-6 mb-3">
                                <div class="border rounded p-3">
                                    <h6 class="text-primary mb-2">
                                        Paso 2: Proveedor Económico 
                                        <span class="badge bg-primary">{{ $test->step_2_score ?? 0 }} pts</span>
                                    </h6>
                                    <div class="small">
                                        @foreach($step2Answers as $key => $value)
                                            <div class="mb-1">
                                                <strong>{{ ucfirst(str_replace('_', ' ', $key)) }}:</strong> 
                                                {{ $translateField($key, $value) }}
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            @endif

                            @if($step3Answers)
                            <div class="col-md-6 mb-3">
                                <div class="border rounded p-3">
                                    <h6 class="text-info mb-2">
                                        Paso 3: Estructura Económica 
                                        <span class="badge bg-info">{{ $test->step_3_score ?? 0 }} pts</span>
                                    </h6>
                                    <div class="small">
                                        @foreach($step3Answers as $key => $value)
                                            <div class="mb-1">
                                                <strong>{{ ucfirst(str_replace('_', ' ', $key)) }}:</strong> 
                                                @if(is_numeric($value))
                                                    ${{ number_format($value, 2) }}
                                                @else
                                                    {{ $translateField($key, $value) }}
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            @endif

                            @if($step4Answers)
                            <div class="col-md-6 mb-3">
                                <div class="border rounded p-3">
                                    <h6 class="text-warning mb-2">
                                        Paso 4: Condiciones de Salud 
                                        <span class="badge bg-warning">{{ $test->step_4_score ?? 0 }} pts</span>
                                    </h6>
                                    <div class="small">
                                        @foreach($step4Answers as $key => $value)
                                            <div class="mb-1">
                                                <strong>{{ ucfirst(str_replace('_', ' ', $key)) }}:</strong> 
                                                {{ $translateField($key, $value) }}
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            @endif

                            @if($step5Answers)
                            <div class="col-md-6 mb-3">
                                <div class="border rounded p-3">
                                    <h6 class="text-success mb-2">
                                        Paso 5: Condiciones de Vivienda 
                                        <span class="badge bg-success">{{ $test->step_5_score ?? 0 }} pts</span>
                                    </h6>
                                    <div class="small">
                                        @foreach($step5Answers as $key => $value)
                                            @if($key !== 'final_observations' && $key !== 'approval_notes')
                                            <div class="mb-1">
                                                <strong>{{ ucfirst(str_replace('_', ' ', $key)) }}:</strong> 
                                                {{ $translateField($key, $value) }}
                                            </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                @endif

                <!-- Observaciones -->
                @if($test->final_observations || $test->approval_notes)
                <div class="row">
                    @if($test->final_observations)
                    <div class="col-md-6">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h6 class="mb-0">
                                    <i class="fas fa-comment me-2"></i>
                                    Observaciones Finales
                                </h6>
                            </div>
                            <div class="card-body">
                                <p class="mb-0">{{ $test->final_observations }}</p>
                            </div>
                        </div>
                    </div>
                    @endif
                    
                    @if($test->approval_notes)
                    <div class="col-md-6">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h6 class="mb-0">
                                    <i class="fas fa-clipboard-check me-2"></i>
                                    Notas de Aprobación
                                </h6>
                            </div>
                            <div class="card-body">
                                <p class="mb-0">{{ $test->approval_notes }}</p>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
                @endif

                <!-- Archivos adjuntos -->
                @if($test->files->count() > 0)
                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="mb-0">
                            <i class="fas fa-paperclip me-2"></i>
                            Documentos Adjuntos
                            <span class="badge bg-info ms-2">{{ $test->files->count() }}</span>
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach($test->files as $file)
                            <div class="col-md-4 mb-2">
                                <div class="d-flex align-items-center p-2 border rounded">
                                    <i class="fas fa-file-alt me-2 text-primary"></i>
                                    <div class="flex-grow-1">
                                        <small class="d-block">{{ $file->original_name }}</small>
                                        <small class="text-muted">{{ $file->created_at->format('d/m/Y') }}</small>
                                    </div>
                                    <a href="{{ $file->url }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif

                <!-- Información del sistema -->
                <div class="card bg-light">
                    <div class="card-body">
                        <div class="row text-sm">
                            <div class="col-md-3">
                                <strong>Creado:</strong><br>
                                <small>{{ $test->created_at->format('d/m/Y H:i') }}</small>
                            </div>
                            <div class="col-md-3">
                                <strong>Última actualización:</strong><br>
                                <small>{{ $test->updated_at->format('d/m/Y H:i') }}</small>
                            </div>
                            <div class="col-md-3">
                                <strong>ID del estudio:</strong><br>
                                <small>#{{ $test->id }}</small>
                            </div>
                            <div class="col-md-3">
                                <strong>Estado:</strong><br>
                                <small>{{ ucfirst(str_replace('_', ' ', $test->status)) }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<style>
.progress-overview {
    padding: 1rem;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-radius: 8px;
}

.step-progress-detailed {
    display: flex;
    justify-content: space-between;
    position: relative;
}

.step-progress-detailed::before {
    content: '';
    position: absolute;
    top: 20px;
    left: 20px;
    right: 20px;
    height: 2px;
    background: #dee2e6;
    z-index: 1;
}

.step {
    display: flex;
    align-items: center;
    position: relative;
    z-index: 2;
    background: white;
    padding: 0 10px;
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
    margin-right: 10px;
}

.step-info {
    text-align: left;
}

.step-title {
    font-size: 14px;
    font-weight: 600;
    color: #495057;
}

.step-score {
    font-size: 12px;
    color: #6c757d;
}

.step.completed .step-number {
    background: #198754;
    color: white;
}

.step.completed .step-title {
    color: #198754;
}

.step.completed .step-score {
    color: #198754;
    font-weight: 600;
}

.step.pending .step-number {
    background: #e9ecef;
    color: #6c757d;
}

@media print {
    .btn-group, .alert, .card-header .btn-group {
        display: none !important;
    }
    
    .card {
        border: 1px solid #dee2e6 !important;
        box-shadow: none !important;
    }
}

.badge {
    font-size: 0.75em;
}

.text-sm small {
    font-size: 0.875rem;
}
</style>
@endsection
