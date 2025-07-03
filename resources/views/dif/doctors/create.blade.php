@extends('layouts.master')
@section('title')Intranet @endsection
@section('content')
<!-- this is breadcrumbs -->
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') DIF @endslot
@slot('title') Nuevo Doctor @endslot
@endcomponent

<div class="row layout-spacing">
    <div class="main-content">
        <div class="row">
            <div class="col-8">
                <div class="card card-body">
                    <form method="POST" action="{{ route('dif.doctors.store') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="employee_num" class="form-label">Número de Empleado <span class="text-danger tx-12">*</span></label>
                                <input type="text" class="form-control" id="employee_num" name="employee_num" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Nombre Completo <span class="text-danger tx-12">*</span></label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="specialty_id" class="form-label">Especialidad <span class="text-danger tx-12">*</span></label>
                                <select class="form-control" id="specialty_id" name="specialty_id" required>
                                    <option value="">Seleccionar especialidad...</option>
                                    @foreach($specialties as $specialty)
                                        <option value="{{ $specialty->id }}">{{ $specialty->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="full_address" class="form-label">Dirección Completa <span class="text-info tx-12">(Opcional)</span></label>
                                <textarea class="form-control" id="full_address" name="full_address" rows="3"></textarea>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Correo Electrónico <span class="text-info tx-12">(Opcional)</span></label>
                                <input type="email" class="form-control" id="email" name="email">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">Teléfono <span class="text-info tx-12">(Opcional)</span></label>
                                <input type="text" class="form-control" id="phone" name="phone">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-dark btn-sm">Guardar Doctor</button>
                                <a href="{{ route('dif.doctors.index') }}" class="btn btn-secondary btn-sm">Cancelar</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
