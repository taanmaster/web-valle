@extends('layouts.master')
@section('title')Intranet @endsection
@section('content')
<!-- this is breadcrumbs -->
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') DIF @endslot
@slot('title') Nuevo Caso Legal @endslot
@endcomponent

<div class="row layout-spacing">
    <div class="main-content">
        <div class="row">
            <div class="col-8">
                    <div class="card card-body">
                    @php
                        // Calcular el siguiente folio: total registros + 1, formateado a 3 dígitos (001)
                        $next = \App\Models\DIFLegalProcess::count() + 1;
                        $caseNum = str_pad($next, 3, '0', STR_PAD_LEFT);
                    @endphp
                    <form method="POST" action="{{ route('dif.legal_processes.store') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="case_num" class="form-label">Número de expediente <span class="text-danger tx-12">*</span></label>
                                <input type="text" class="form-control disabled" id="case_num" name="case_num" value="{{ old('case_num', $caseNum) }}" readonly required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="status" class="form-label">Estado <span class="text-info tx-12">(Opcional)</span></label>
                                <select class="form-select" id="status" name="status">
                                    <option value="">Seleccione...</option>
                                    <option value="Pre-evaluación">Pre-evaluación</option>
                                    <option value="Evaluación formal">Evaluación formal</option>
                                    <option value="Pago de asesoría">Pago de asesoría</option>
                                    <option value="Inicio de la asesoría">Inicio de la asesoría</option>
                                    <option value="Llenado de cédula">Llenado de cédula</option>
                                    <option value="Entrega de documentación">Entrega de documentación</option>
                                    <option value="Estudio socioeconómico">Estudio socioeconómico</option>
                                    <option value="Gestión ante el municipio">Gestión ante el municipio</option>
                                </select>
                            </div>

                            <div class="col-12"><h6>Asesorado</h6></div>
                            <div class="col-md-6 mb-3">
                                <label for="advised_person" class="form-label">Persona asesorada <span class="text-danger tx-12">*</span></label>
                                <input type="text" class="form-control" id="advised_person" name="advised_person" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="advised_phone" class="form-label">Teléfono</label>
                                <input type="text" class="form-control" id="advised_phone" name="advised_phone">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="advised_age" class="form-label">Edad</label>
                                <input type="text" class="form-control" id="advised_age" name="advised_age">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="advised_ocupation" class="form-label">Ocupación</label>
                                <input type="text" class="form-control" id="advised_ocupation" name="advised_ocupation">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="advised_gender" class="form-label">Género</label>
                                <select class="form-select" id="advised_gender" name="advised_gender">
                                    <option value="">Seleccione...</option>
                                    <option value="Masculino">Masculino</option>
                                    <option value="Femenino">Femenino</option>
                                </select>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="advised_median_income" class="form-label">Ingreso semanal</label>
                                <input type="text" class="form-control" id="advised_median_income" name="advised_median_income">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="advised_children_qty" class="form-label"># Hijos</label>
                                <input type="number" class="form-control" id="advised_children_qty" name="advised_children_qty">
                            </div>

                            <div class="col-12"><h6>Demandado</h6></div>
                            <div class="col-md-6 mb-3">
                                <label for="sued_person" class="form-label">Persona demandada <span class="text-danger tx-12">*</span></label>
                                <input type="text" class="form-control" id="sued_person" name="sued_person" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="sued_age" class="form-label">Edad</label>
                                <input type="text" class="form-control" id="sued_age" name="sued_age">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="sued_gender" class="form-label">Género</label>
                                <select class="form-select" id="sued_gender" name="sued_gender">
                                    <option value="">Seleccione...</option>
                                    <option value="Masculino">Masculino</option>
                                    <option value="Femenino">Femenino</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="relation_with_advised" class="form-label">Parentesco con asesorado</label>
                                <input type="text" class="form-control" id="relation_with_advised" name="relation_with_advised">
                            </div>

                            <div class="col-12 mb-3">
                                <label for="reason_for_advisory" class="form-label">Motivo de la asesoría</label>
                                <textarea class="form-control" id="reason_for_advisory" name="reason_for_advisory" rows="3"></textarea>
                            </div>

                            <div class="col-12 mb-3">
                                <label for="observations" class="form-label">Observaciones</label>
                                <textarea class="form-control" id="observations" name="observations" rows="3"></textarea>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="cost" class="form-label">Costo (si aplica)</label>
                                <input type="text" class="form-control" id="cost" name="cost">
                            </div>
                            <div class="col-md-4 mb-3">
                                @php
                                    // Cargar estudios socioeconómicos recientes para el selector
                                    $socioTests = \App\Models\DIFSocioEconomicTest::orderBy('id', 'desc')->limit(500)->get();
                                @endphp
                                <label for="socio_economic_test_id" class="form-label">ID Estudio socioeconómico <span class="text-info tx-12">(Buscar y seleccionar)</span></label>
                                <input list="socio_tests" class="form-control" id="socio_economic_test_id" name="socio_economic_test_id" value="{{ old('socio_economic_test_id') }}" placeholder="Buscar por ID o persona relacionada">
                                <datalist id="socio_tests">
                                    @foreach($socioTests as $test)
                                        <option value="{{ $test->id }}">{{ $test->id }} - {{ $test->advised_person ?? $test->name ?? '—' }}</option>
                                    @endforeach
                                </datalist>
                                <small class="form-text text-muted">Escribe para buscar y selecciona el ID del estudio para vincularlo al caso.</small>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-dark btn-sm">Guardar Caso</button>
                                <a href="{{ route('dif.services.index') }}" class="btn btn-secondary btn-sm">Cancelar</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
