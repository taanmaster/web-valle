@extends('layouts.master')
@section('title')Intranet @endsection
@section('content')
<!-- this is breadcrumbs -->
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') DIF @endslot
@slot('title') Recetas Médicas @endslot
@endcomponent

<div class="row layout-spacing">
    <div class="main-content">
        <div class="row">
            <div class="col-8">
                <div class="card card-body">
                    <h5 class="card-title mb-4">Editar Receta Médica</h5>
                    <form method="POST" action="{{ route('dif.prescriptions.update', $prescription->id) }}">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="prescription_num" class="form-label">Número de Receta <span class="text-danger tx-12">*</span></label>
                                <input type="text" class="form-control" id="prescription_num" name="prescription_num" value="{{ $prescription->prescription_num }}" required>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="doctor_id" class="form-label">Doctor <span class="text-danger tx-12">*</span></label>
                                <select class="form-control" id="doctor_id" name="doctor_id" required>
                                    <option value="">Seleccione un doctor</option>
                                    @foreach($doctors as $doctor)
                                        <option value="{{ $doctor->id }}" {{ $prescription->doctor_id == $doctor->id ? 'selected' : '' }}>
                                            {{ $doctor->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="patient_id" class="form-label">Paciente <span class="text-danger tx-12">*</span></label>
                                <select class="form-control" id="patient_id" name="patient_id" required>
                                    <option value="">Seleccione un paciente</option>
                                    @foreach($patients as $patient)
                                        <option value="{{ $patient->id }}" {{ $prescription->patient_id == $patient->id ? 'selected' : '' }}>
                                            {{ $patient->name }} {{ $patient->first_name }} {{ $patient->last_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="prescription_date" class="form-label">Fecha de la Receta <span class="text-danger tx-12">*</span></label>
                                <input type="date" class="form-control" id="prescription_date" name="prescription_date" value="{{ $prescription->prescription_date->format('Y-m-d') }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="status" class="form-label">Estado <span class="text-danger tx-12">*</span></label>
                                <select class="form-control" id="status" name="status" required>
                                    <option value="pending" {{ $prescription->status == 'pending' ? 'selected' : '' }}>Pendiente</option>
                                    <option value="completed" {{ $prescription->status == 'completed' ? 'selected' : '' }}>Completada</option>
                                    <option value="cancelled" {{ $prescription->status == 'cancelled' ? 'selected' : '' }}>Cancelada</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-dark btn-sm">Actualizar datos</button>
                                <a href="{{ route('dif.prescriptions.show', $prescription->id) }}" class="btn btn-secondary btn-sm">Cancelar</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
