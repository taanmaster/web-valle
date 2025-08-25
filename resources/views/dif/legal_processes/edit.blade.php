@extends('layouts.master')
@section('title')Intranet @endsection
@section('content')
<!-- this is breadcrumbs -->
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') DIF @endslot
@slot('title') Editar Caso Legal @endslot
@endcomponent

<div class="row layout-spacing">
    <div class="main-content">
        <div class="row">
            <div class="col-8">
                <div class="card card-body">
                    <form method="POST" action="{{ route('dif.legal_processes.update', $process->id) }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="case_num" class="form-label">Número de expediente <span class="text-danger tx-12">*</span></label>
                                <input type="text" class="form-control" id="case_num" name="case_num" value="{{ old('case_num', $process->case_num) }}" required readonly>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="status" class="form-label">Estado</label>
                                <select class="form-select" id="status" name="status">
                                    <option value="">Seleccione...</option>
                                    <option value="Pre-evaluación" {{ old('status', $process->status) == 'Pre-evaluación' ? 'selected' : '' }}>Pre-evaluación</option>
                                    <option value="Evaluación formal" {{ old('status', $process->status) == 'Evaluación formal' ? 'selected' : '' }}>Evaluación formal</option>
                                    <option value="Pago de asesoría" {{ old('status', $process->status) == 'Pago de asesoría' ? 'selected' : '' }}>Pago de asesoría</option>
                                    <option value="Inicio de la asesoría" {{ old('status', $process->status) == 'Inicio de la asesoría' ? 'selected' : '' }}>Inicio de la asesoría</option>
                                    <option value="Llenado de cédula" {{ old('status', $process->status) == 'Llenado de cédula' ? 'selected' : '' }}>Llenado de cédula</option>
                                    <option value="Entrega de documentación" {{ old('status', $process->status) == 'Entrega de documentación' ? 'selected' : '' }}>Entrega de documentación</option>
                                    <option value="Estudio socioeconómico" {{ old('status', $process->status) == 'Estudio socioeconómico' ? 'selected' : '' }}>Estudio socioeconómico</option>
                                    <option value="Gestión ante el municipio" {{ old('status', $process->status) == 'Gestión ante el municipio' ? 'selected' : '' }}>Gestión ante el municipio</option>
                                </select>
                            </div>

                            <div class="col-12"><h6>Asesorado</h6></div>
                            <div class="col-md-6 mb-3">
                                <label for="advised_person" class="form-label">Persona asesorada <span class="text-danger tx-12">*</span></label>
                                <input type="text" class="form-control" id="advised_person" name="advised_person" value="{{ old('advised_person', $process->advised_person) }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="advised_phone" class="form-label">Teléfono</label>
                                <input type="text" class="form-control" id="advised_phone" name="advised_phone" value="{{ old('advised_phone', $process->advised_phone) }}">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="advised_age" class="form-label">Edad</label>
                                <input type="text" class="form-control" id="advised_age" name="advised_age" value="{{ old('advised_age', $process->advised_age) }}">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="advised_ocupation" class="form-label">Ocupación</label>
                                <input type="text" class="form-control" id="advised_ocupation" name="advised_ocupation" value="{{ old('advised_ocupation', $process->advised_ocupation) }}">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="advised_gender" class="form-label">Género</label>
                                <select class="form-select" id="advised_gender" name="advised_gender">
                                    <option value="">Seleccione...</option>
                                    <option value="Masculino" {{ old('advised_gender', $process->advised_gender) == 'Masculino' ? 'selected' : '' }}>Masculino</option>
                                    <option value="Femenino" {{ old('advised_gender', $process->advised_gender) == 'Femenino' ? 'selected' : '' }}>Femenino</option>
                                </select>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="advised_median_income" class="form-label">Ingreso semanal</label>
                                <input type="text" class="form-control" id="advised_median_income" name="advised_median_income" value="{{ old('advised_median_income', $process->advised_median_income) }}">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="advised_children_qty" class="form-label"># Hijos</label>
                                <input type="number" class="form-control" id="advised_children_qty" name="advised_children_qty" value="{{ old('advised_children_qty', $process->advised_children_qty) }}">
                            </div>

                            <div class="col-12"><h6>Demandado</h6></div>
                            <div class="col-md-6 mb-3">
                                <label for="sued_person" class="form-label">Persona demandada <span class="text-danger tx-12">*</span></label>
                                <input type="text" class="form-control" id="sued_person" name="sued_person" value="{{ old('sued_person', $process->sued_person) }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="sued_age" class="form-label">Edad</label>
                                <input type="text" class="form-control" id="sued_age" name="sued_age" value="{{ old('sued_age', $process->sued_age) }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="sued_gender" class="form-label">Género</label>
                                <select class="form-select" id="sued_gender" name="sued_gender">
                                    <option value="">Seleccione...</option>
                                    <option value="Masculino" {{ old('sued_gender', $process->sued_gender) == 'Masculino' ? 'selected' : '' }}>Masculino</option>
                                    <option value="Femenino" {{ old('sued_gender', $process->sued_gender) == 'Femenino' ? 'selected' : '' }}>Femenino</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="relation_with_advised" class="form-label">Parentesco con asesorado</label>
                                <input type="text" class="form-control" id="relation_with_advised" name="relation_with_advised" value="{{ old('relation_with_advised', $process->relation_with_advised) }}">
                            </div>

                            <div class="col-12 mb-3">
                                <label for="reason_for_advisory" class="form-label">Motivo de la asesoría</label>
                                <textarea class="form-control" id="reason_for_advisory" name="reason_for_advisory" rows="3">{{ old('reason_for_advisory', $process->reason_for_advisory) }}</textarea>
                            </div>

                            <div class="col-12 mb-3">
                                <label for="observations" class="form-label">Observaciones</label>
                                <textarea class="form-control" id="observations" name="observations" rows="3">{{ old('observations', $process->observations) }}</textarea>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="cost" class="form-label">Costo (si aplica)</label>
                                <input type="text" class="form-control" id="cost" name="cost" value="{{ old('cost', $process->cost) }}">
                            </div>
                            <div class="col-md-4 mb-3">
                                @php
                                    $socioTests = \App\Models\DIFSocioEconomicTest::orderBy('id', 'desc')->limit(500)->get();
                                @endphp
                                <label for="socio_economic_test_id" class="form-label">ID Estudio socioeconómico <span class="text-info tx-12">(Buscar y seleccionar)</span></label>
                                <input list="socio_tests" class="form-control" id="socio_economic_test_id" name="socio_economic_test_id" value="{{ old('socio_economic_test_id', $process->socio_economic_test_id) }}" placeholder="Buscar por ID o persona relacionada">
                                <datalist id="socio_tests">
                                    @foreach($socioTests as $test)
                                        <option value="{{ $test->id }}">{{ $test->id }} - {{ $test->advised_person ?? $test->name ?? '—' }}</option>
                                    @endforeach
                                </datalist>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-dark btn-sm">Actualizar Caso</button>
                                <a href="{{ route('dif.legal_processes.show', $process->id) }}" class="btn btn-secondary btn-sm">Cancelar</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
