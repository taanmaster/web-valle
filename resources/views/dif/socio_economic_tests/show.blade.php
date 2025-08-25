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


                <!-- Documentación de Soporte y Verificación -->
                <div class="card" id="documentFiles">
                    <div class="card-header">
                        <h6 class="mb-0">
                            <i class="fas fa-folder me-2"></i>
                            Documentación de Soporte y Verificación
                        </h6>
                    </div>
                    <div class="card-body">
                        <!-- Documentos del Beneficiario -->
                        <div class="mb-4">
                            <h6 class="text-primary mb-3">
                                <i class="fas fa-user me-2"></i>
                                Beneficiario
                            </h6>
                            <div class="row">
                                <!-- Acta de Nacimiento -->
                                <div class="col-md-3 mb-3">
                                    <div class="document-section">
                                        <div class="text-center mb-2">
                                            <i class="fas fa-file-pdf text-danger fs-2"></i>
                                        </div>
                                        <h6 class="text-center mb-2">Acta de Nacimiento</h6>
                                        @php
                                            $actaNacimiento = $test->files->where('name', 'acta_nacimiento_beneficiario')->first();
                                        @endphp
                                        @if($actaNacimiento)
                                            <div class="text-center">
                                                <a href="{{ $actaNacimiento->s3_asset_url }}" target="_blank" class="btn btn-success btn-sm mb-2">
                                                    <i class="fas fa-eye"></i> Ver
                                                </a>
                                                <button type="button" class="btn btn-danger btn-sm mb-2 delete-file" data-file-id="{{ $actaNacimiento->id }}">
                                                    <i class="fas fa-trash"></i> Eliminar
                                                </button>
                                            </div>
                                        @else
                                            <div class="upload-area text-center p-3 border border-dashed rounded" data-document-type="acta_nacimiento_beneficiario">
                                                <p class="text-muted mb-2">Arrastra o sube archivos</p>
                                                <input type="file" class="form-control d-none file-input" accept=".pdf" data-max-size="10">
                                                <button type="button" class="btn btn-outline-primary btn-sm upload-btn">
                                                    <i class="fas fa-upload"></i> Subir Archivo
                                                </button>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- CURP -->
                                <div class="col-md-3 mb-3">
                                    <div class="document-section">
                                        <div class="text-center mb-2">
                                            <i class="fas fa-file-pdf text-danger fs-2"></i>
                                        </div>
                                        <h6 class="text-center mb-2">CURP</h6>
                                        @php
                                            $curp = $test->files->where('name', 'curp_beneficiario')->first();
                                        @endphp
                                        @if($curp)
                                            <div class="text-center">
                                                <a href="{{ $curp->s3_asset_url }}" target="_blank" class="btn btn-success btn-sm mb-2">
                                                    <i class="fas fa-eye"></i> Ver
                                                </a>
                                                <button type="button" class="btn btn-danger btn-sm mb-2 delete-file" data-file-id="{{ $curp->id }}">
                                                    <i class="fas fa-trash"></i> Eliminar
                                                </button>
                                            </div>
                                        @else
                                            <div class="upload-area text-center p-3 border border-dashed rounded" data-document-type="curp_beneficiario">
                                                <p class="text-muted mb-2">Arrastra o sube archivos</p>
                                                <input type="file" class="form-control d-none file-input" accept=".pdf" data-max-size="10">
                                                <button type="button" class="btn btn-outline-primary btn-sm upload-btn">
                                                    <i class="fas fa-upload"></i> Subir Archivo
                                                </button>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- INE -->
                                <div class="col-md-3 mb-3">
                                    <div class="document-section">
                                        <div class="text-center mb-2">
                                            <i class="fas fa-file-pdf text-danger fs-2"></i>
                                        </div>
                                        <h6 class="text-center mb-2">INE</h6>
                                        @php
                                            $ine = $test->files->where('name', 'ine_beneficiario')->first();
                                        @endphp
                                        @if($ine)
                                            <div class="text-center">
                                                <a href="{{ $ine->s3_asset_url }}" target="_blank" class="btn btn-success btn-sm mb-2">
                                                    <i class="fas fa-eye"></i> Ver
                                                </a>
                                                <button type="button" class="btn btn-danger btn-sm mb-2 delete-file" data-file-id="{{ $ine->id }}">
                                                    <i class="fas fa-trash"></i> Eliminar
                                                </button>
                                            </div>
                                        @else
                                            <div class="upload-area text-center p-3 border border-dashed rounded" data-document-type="ine_beneficiario">
                                                <p class="text-muted mb-2">Arrastra o sube archivos</p>
                                                <input type="file" class="form-control d-none file-input" accept=".pdf" data-max-size="10">
                                                <button type="button" class="btn btn-outline-primary btn-sm upload-btn">
                                                    <i class="fas fa-upload"></i> Subir Archivo
                                                </button>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Comprobante de Domicilio -->
                                <div class="col-md-3 mb-3">
                                    <div class="document-section">
                                        <div class="text-center mb-2">
                                            <i class="fas fa-file-pdf text-danger fs-2"></i>
                                        </div>
                                        <h6 class="text-center mb-2">Comprobante de Domicilio</h6>
                                        @php
                                            $comprobanteDomicilio = $test->files->where('name', 'comprobante_domicilio_beneficiario')->first();
                                        @endphp
                                        @if($comprobanteDomicilio)
                                            <div class="text-center">
                                                <a href="{{ $comprobanteDomicilio->s3_asset_url }}" target="_blank" class="btn btn-success btn-sm mb-2">
                                                    <i class="fas fa-eye"></i> Ver
                                                </a>
                                                <button type="button" class="btn btn-danger btn-sm mb-2 delete-file" data-file-id="{{ $comprobanteDomicilio->id }}">
                                                    <i class="fas fa-trash"></i> Eliminar
                                                </button>
                                            </div>
                                        @else
                                            <div class="upload-area text-center p-3 border border-dashed rounded" data-document-type="comprobante_domicilio_beneficiario">
                                                <p class="text-muted mb-2">Arrastra o sube archivos</p>
                                                <input type="file" class="form-control d-none file-input" accept=".pdf" data-max-size="10">
                                                <button type="button" class="btn btn-outline-primary btn-sm upload-btn">
                                                    <i class="fas fa-upload"></i> Subir Archivo
                                                </button>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Documentos de Dependientes -->
                        @if($test->dependents->count() > 0)
                        <div class="mb-4">
                            <h6 class="text-info mb-3">
                                <i class="fas fa-users me-2"></i>
                                Dependientes
                            </h6>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Nombre</th>
                                            <th class="text-center">Actas de Nacimiento</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($test->dependents as $dependent)
                                        <tr>
                                            <td>
                                                <strong>{{ $dependent->name }}</strong><br>
                                                <small class="text-muted">{{ $dependent->relationship ?? 'Sin relación especificada' }}</small>
                                            </td>
                                            <td class="text-center">
                                                @php
                                                    $actaDependiente = $test->files->where('name', 'acta_nacimiento_dependiente_' . $dependent->id)->first();
                                                @endphp
                                                @if($actaDependiente)
                                                    <div>
                                                        <a href="{{ $actaDependiente->s3_asset_url }}" target="_blank" class="btn btn-success btn-sm me-2">
                                                            <i class="fas fa-eye"></i> Ver
                                                        </a>
                                                        <button type="button" class="btn btn-danger btn-sm delete-file" data-file-id="{{ $actaDependiente->id }}">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                @else
                                                    <div class="upload-area-inline" data-document-type="acta_nacimiento_dependiente_{{ $dependent->id }}">
                                                        <input type="file" class="form-control d-none file-input" accept=".pdf" data-max-size="10">
                                                        <button type="button" class="btn btn-outline-primary btn-sm upload-btn">
                                                            <i class="fas fa-upload"></i> Subir Acta
                                                        </button>
                                                    </div>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @endif

                        <!-- Evidencias Adicionales -->
                        <div class="mb-4">
                            <h6 class="text-warning mb-3">
                                <i class="fas fa-paperclip me-2"></i>
                                Evidencias
                            </h6>
                            <div class="row">
                                <div class="col-md-12">
                                    <!-- Área de subida para evidencias -->
                                    <div class="upload-area-large text-center p-4 border border-dashed rounded mb-3" data-document-type="evidencia">
                                        <i class="fas fa-cloud-upload-alt fs-2 text-muted mb-2"></i>
                                        <p class="text-muted mb-2">Arrastra o sube archivos adicionales</p>
                                        <small class="text-muted">Formatos permitidos: PDF, JPG, PNG, DOC, DOCX (Max: 10MB)</small>
                                        <div class="mt-2">
                                            <input type="file" class="form-control d-none file-input" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx" data-max-size="10" multiple>
                                            <button type="button" class="btn btn-outline-warning upload-btn">
                                                <i class="fas fa-upload"></i> Subir Evidencias
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Lista de evidencias existentes -->
                                    <div class="evidencias-list">
                                        @php
                                            // Obtener todos los archivos que no sean documentos específicos del beneficiario o dependientes
                                            $evidencias = $test->files->reject(function($file) {
                                                return in_array($file->name, [
                                                    'acta_nacimiento_beneficiario',
                                                    'curp_beneficiario', 
                                                    'ine_beneficiario',
                                                    'comprobante_domicilio_beneficiario'
                                                ]) || str_starts_with($file->name, 'acta_nacimiento_dependiente_');
                                            })->sortByDesc('created_at');
                                        @endphp
                                        @if($evidencias->count() > 0)
                                        <div class="row">
                                            @foreach($evidencias as $evidencia)
                                            <div class="col-md-4 mb-2">
                                                <div class="card">
                                                    <div class="card-body p-2">
                                                        <div class="d-flex align-items-center">
                                                            <div class="me-2">
                                                                @if(str_contains($evidencia->file_type, 'pdf'))
                                                                    <i class="fas fa-file-pdf text-danger"></i>
                                                                @elseif(str_contains($evidencia->file_type, 'image'))
                                                                    <i class="fas fa-file-image text-success"></i>
                                                                @else
                                                                    <i class="fas fa-file-alt text-primary"></i>
                                                                @endif
                                                            </div>
                                                            <div class="flex-grow-1">
                                                                <small class="d-block">{{ $evidencia->file_name }}</small>
                                                                <small class="text-muted">
                                                                    {{ number_format($evidencia->file_size / 1024, 1) }} KB - 
                                                                    {{ $evidencia->created_at->format('d/m/Y H:i') }}
                                                                </small>
                                                            </div>
                                                            <div class="btn-group">
                                                                <a href="{{ $evidencia->s3_asset_url }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                                                    <i class="fas fa-eye"></i>
                                                                </a>
                                                                <button type="button" class="btn btn-outline-danger btn-sm delete-file" data-file-id="{{ $evidencia->id }}">
                                                                    <i class="fas fa-trash"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Mensaje informativo -->
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Nota:</strong> Los documentos del beneficiario deben estar en formato PDF. 
                            Para las evidencias adicionales se permiten archivos PDF, imágenes (JPG, PNG) y documentos de Word.
                            Tamaño máximo por archivo: 10 MB.
                        </div>
                    </div>
                </div>

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

/* Estilos para subida de archivos */
.document-section {
    border: 1px solid #e9ecef;
    border-radius: 8px;
    padding: 15px;
    height: 100%;
    background: #f8f9fa;
}

.upload-area, .upload-area-large {
    cursor: pointer;
    transition: all 0.3s ease;
    min-height: 120px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}

.upload-area:hover, .upload-area-large:hover {
    border-color: #007bff !important;
    background-color: #f8f9ff;
}

.upload-area.dragover, .upload-area-large.dragover {
    border-color: #007bff !important;
    background-color: #e3f2fd;
}

.upload-area-inline {
    display: inline-block;
}

.uploading {
    opacity: 0.6;
    pointer-events: none;
}

@media print {
    .btn-group, .alert, .card-header .btn-group, #documentFiles {
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

<script>
$(document).ready(function() {
    // Token CSRF para las peticiones AJAX
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Función para mostrar notificaciones
    function showNotification(message, type = 'success') {
        let bgClass = type === 'success' ? 'bg-success' : 'bg-danger';
        let notification = `
            <div class="position-fixed top-0 end-0 p-3" style="z-index: 1055;">
                <div class="toast show align-items-center text-white ${bgClass} border-0" role="alert">
                    <div class="d-flex">
                        <div class="toast-body">${message}</div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                    </div>
                </div>
            </div>
        `;
        $('body').append(notification);
        setTimeout(() => {
            $('.toast').fadeOut(() => $('.toast').parent().remove());
        }, 5000);
    }

    // Función para validar archivos
    function validateFile(file, acceptedTypes, maxSize) {
        // Validar tamaño (maxSize en MB)
        if (file.size > maxSize * 1024 * 1024) {
            showNotification(`El archivo ${file.name} es demasiado grande. Máximo ${maxSize}MB.`, 'error');
            return false;
        }

        // Validar tipo
        if (acceptedTypes && !acceptedTypes.includes(file.type)) {
            showNotification(`Tipo de archivo no permitido: ${file.name}`, 'error');
            return false;
        }

        return true;
    }

    // Manejar click en botones de subida
    $(document).on('click', '.upload-btn', function() {
        $(this).siblings('.file-input').click();
    });

    // Manejar selección de archivos
    $(document).on('change', '.file-input', function() {
        let files = this.files;
        let uploadArea = $(this).closest('[data-document-type]');
        let documentType = uploadArea.data('document-type');
        let maxSize = $(this).data('max-size') || 10;
        let accept = $(this).attr('accept');
        
        // Convertir accept a tipos MIME
        let acceptedTypes = null;
        if (accept) {
            acceptedTypes = accept.split(',').map(type => {
                if (type === '.pdf') return 'application/pdf';
                if (type === '.jpg' || type === '.jpeg') return 'image/jpeg';
                if (type === '.png') return 'image/png';
                if (type === '.doc') return 'application/msword';
                if (type === '.docx') return 'application/vnd.openxmlformats-officedocument.wordprocessingml.document';
                return type;
            });
        }

        for (let i = 0; i < files.length; i++) {
            let file = files[i];
            if (validateFile(file, acceptedTypes, maxSize)) {
                uploadFile(file, documentType, uploadArea);
            }
        }

        // Limpiar el input
        $(this).val('');
    });

    // Función para subir archivo
    function uploadFile(file, documentType, uploadArea) {
        let formData = new FormData();
        formData.append('file', file);
        formData.append('socio_economic_test_id', {{ $test->id }});
        formData.append('name', documentType);

        // Mostrar estado de carga
        uploadArea.addClass('uploading');
        let originalHtml = uploadArea.html();
        uploadArea.html(`
            <div class="text-center">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Subiendo...</span>
                </div>
                <p class="mt-2 text-muted">Subiendo ${file.name}...</p>
            </div>
        `);

        $.ajax({
            url: '{{ route("dif.socio_economic_test_files.store") }}',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    showNotification('Archivo subido correctamente');
                    // Recargar la página para mostrar el archivo
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                } else {
                    showNotification('Error al subir el archivo', 'error');
                    uploadArea.removeClass('uploading');
                    uploadArea.html(originalHtml);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', xhr.responseText);
                let errorMessage = 'Error al subir el archivo';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }
                showNotification(errorMessage, 'error');
                uploadArea.removeClass('uploading');
                uploadArea.html(originalHtml);
            }
        });
    }

    // Manejar eliminación de archivos
    $(document).on('click', '.delete-file', function() {
        let fileId = $(this).data('file-id');
        let button = $(this);
        
        if (confirm('¿Está seguro de que desea eliminar este archivo?')) {
            button.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i>');
            
            $.ajax({
                url: `/dif/socio-economic-test-files/${fileId}`,
                type: 'DELETE',
                success: function(response) {
                    showNotification('Archivo eliminado correctamente');
                    // Recargar la página para reflejar los cambios
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                },
                error: function(xhr, status, error) {
                    console.error('Error:', xhr.responseText);
                    showNotification('Error al eliminar el archivo', 'error');
                    button.prop('disabled', false).html('<i class="fas fa-trash"></i>');
                }
            });
        }
    });

    // Manejo de drag & drop
    $(document).on('dragover', '.upload-area, .upload-area-large', function(e) {
        e.preventDefault();
        e.stopPropagation();
        $(this).addClass('dragover');
    });

    $(document).on('dragleave', '.upload-area, .upload-area-large', function(e) {
        e.preventDefault();
        e.stopPropagation();
        $(this).removeClass('dragover');
    });

    $(document).on('drop', '.upload-area, .upload-area-large', function(e) {
        e.preventDefault();
        e.stopPropagation();
        $(this).removeClass('dragover');
        
        let files = e.originalEvent.dataTransfer.files;
        let documentType = $(this).data('document-type');
        let fileInput = $(this).find('.file-input');
        let maxSize = fileInput.data('max-size') || 10;
        let accept = fileInput.attr('accept');
        
        // Convertir accept a tipos MIME
        let acceptedTypes = null;
        if (accept) {
            acceptedTypes = accept.split(',').map(type => {
                if (type === '.pdf') return 'application/pdf';
                if (type === '.jpg' || type === '.jpeg') return 'image/jpeg';
                if (type === '.png') return 'image/png';
                if (type === '.doc') return 'application/msword';
                if (type === '.docx') return 'application/vnd.openxmlformats-officedocument.wordprocessingml.document';
                return type;
            });
        }

        for (let i = 0; i < files.length; i++) {
            let file = files[i];
            if (validateFile(file, acceptedTypes, maxSize)) {
                uploadFile(file, documentType, $(this));
            }
        }
    });
});
</script>
@endsection
