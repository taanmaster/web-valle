@extends('layouts.master')
@section('title')Intranet @endsection
@section('content')
<!-- this is breadcrumbs -->
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') DIF @endslot
@slot('title') Caso: {{ $process->case_num }} @endslot
@endcomponent

<div class="row layout-spacing">
    <div class="main-content">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Expediente: {{ $process->case_num }}</h5>
                        <div class="mb-3">
                            <span class="badge bg-info">{{ $process->status }}</span>
                        </div>

                        <div class="mb-3">
                            <strong>Asesorado:</strong> {{ $process->advised_person }}<br>
                            <strong>Teléfono:</strong> {{ $process->advised_phone ?? '—' }}
                        </div>

                        {{-- Bloque rápido para actualizar estatus --}}
                        <div class="mb-3">
                            <form method="POST" action="{{ route('dif.legal_processes.update', $process->id) }}" class="d-flex" style="gap:8px;">
                                {{ csrf_field() }}
                                {{ method_field('PUT') }}
                                {{-- Incluir campos obligatorios como hidden para evitar fallas de validación en update --}}
                                <input type="hidden" name="case_num" value="{{ $process->case_num }}">
                                <input type="hidden" name="advised_person" value="{{ $process->advised_person }}">
                                <input type="hidden" name="sued_person" value="{{ $process->sued_person }}">

                                <select name="status" class="form-select form-select-sm">
                                    <option value="">Seleccione...</option>
                                    <option value="Pre-evaluación" {{ $process->status == 'Pre-evaluación' ? 'selected' : '' }}>Pre-evaluación</option>
                                    <option value="Evaluación formal" {{ $process->status == 'Evaluación formal' ? 'selected' : '' }}>Evaluación formal</option>
                                    <option value="Pago de asesoría" {{ $process->status == 'Pago de asesoría' ? 'selected' : '' }}>Pago de asesoría</option>
                                    <option value="Inicio de la asesoría" {{ $process->status == 'Inicio de la asesoría' ? 'selected' : '' }}>Inicio de la asesoría</option>
                                    <option value="Llenado de cédula" {{ $process->status == 'Llenado de cédula' ? 'selected' : '' }}>Llenado de cédula</option>
                                    <option value="Entrega de documentación" {{ $process->status == 'Entrega de documentación' ? 'selected' : '' }}>Entrega de documentación</option>
                                    <option value="Estudio socioeconómico" {{ $process->status == 'Estudio socioeconómico' ? 'selected' : '' }}>Estudio socioeconómico</option>
                                    <option value="Gestión ante el municipio" {{ $process->status == 'Gestión ante el municipio' ? 'selected' : '' }}>Gestión ante el municipio</option>
                                </select>
                                <button type="submit" class="btn btn-sm btn-primary">Actualizar estatus</button>
                            </form>
                        </div>

                        <hr>

                        <div class="d-flex gap-2" role="group" aria-label="Basic example">
                            <a href="{{ route('dif.legal_processes.edit', $process->id) }}" class="btn btn-sm btn-secondary">Editar</a>
                            <form method="POST" action="{{ route('dif.legal_processes.destroy', $process->id) }}" style="display: inline-block;">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de que deseas eliminar este caso?')">
                                    Eliminar
                                </button>
                            </form>
                            <a href="{{ route('dif.legal_processes.index') }}" class="btn btn-sm btn-primary">Volver al listado</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Detalle del Caso</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h6>Datos del Asesorado</h6>
                                <p class="text-muted">
                                    <strong>Nombre:</strong> {{ $process->advised_person }}<br>
                                    <strong>Teléfono:</strong> {{ $process->advised_phone ?? '—' }}<br>
                                    <strong>Edad:</strong> {{ $process->advised_age ?? '—' }}<br>
                                    <strong>Ocupación:</strong> {{ $process->advised_ocupation ?? '—' }}<br>
                                    <strong>Género:</strong> {{ $process->advised_gender ?? '—' }}<br>
                                    <strong>Ingreso semanal:</strong> {{ $process->advised_median_income ?? '—' }}<br>
                                    <strong># Hijos:</strong> {{ $process->advised_children_qty ?? '—' }}
                                </p>
                            </div>
                            <div class="col-md-6">
                                <h6>Datos del Demandado</h6>
                                <p class="text-muted">
                                    <strong>Nombre:</strong> {{ $process->sued_person }}<br>
                                    <strong>Edad:</strong> {{ $process->sued_age ?? '—' }}<br>
                                    <strong>Género:</strong> {{ $process->sued_gender ?? '—' }}<br>
                                    <strong>Parentesco:</strong> {{ $process->relation_with_advised ?? '—' }}
                                </p>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-md-6">
                                <h6>Información del Caso</h6>
                                <p class="text-muted">
                                    <strong>Estado:</strong> {{ $process->status ?? '—' }}<br>
                                    <strong>Costo:</strong> {{ $process->cost ?? '—' }}<br>
                                    <strong>Registrado:</strong> {{ $process->created_at ? $process->created_at->format('d/m/Y H:i') : '—' }}<br>
                                    <strong>Última actualización:</strong> {{ $process->updated_at ? $process->updated_at->format('d/m/Y H:i') : '—' }}
                                </p>
                            </div>
                            <div class="col-md-6">
                                <h6>Estudios y notas</h6>
                                <p class="text-muted">
                                    <strong>Motivo de la asesoría:</strong><br> {{ $process->reason_for_advisory ?? '—' }}<br><br>
                                    <strong>Observaciones:</strong><br> {{ $process->observations ?? '—' }}<br><br>
                                    <strong>ID Estudio socioeconómico:</strong>
                                    @if($process->socio_economic_test_id)
                                        @php $test = \App\Models\DIFSocioEconomicTest::find($process->socio_economic_test_id); @endphp
                                        @if($test)
                                            <a href="{{ route('dif.socio_economic_tests.show', $test->id) }}">{{ $test->id }} - {{ $test->advised_person ?? $test->name ?? '—' }}</a>
                                        @else
                                            {{ $process->socio_economic_test_id }}
                                        @endif
                                    @else
                                        —
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
