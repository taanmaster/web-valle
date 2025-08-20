@extends('layouts.master')
@section('title')Intranet @endsection
@section('content')
<!-- this is breadcrumbs -->
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') DIF @endslot
@slot('title') Nuevo Medicamento @endslot
@endcomponent

<div class="row layout-spacing">
    <div class="main-content">
        <div class="row">
            <div class="col-8">
                <div class="card card-body">
                    <form method="POST" action="{{ route('dif.medications.store') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="generic_name" class="form-label">Nombre genérico <span class="text-danger tx-12">*</span></label>
                                <input type="text" class="form-control" id="generic_name" name="generic_name" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="commercial_name" class="form-label">Nombre comercial <span class="text-info tx-12">(Opcional)</span></label>
                                <input type="text" class="form-control" id="commercial_name" name="commercial_name">
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="description" class="form-label">Descripción <span class="text-info tx-12">(Opcional)</span></label>
                                <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="formula" class="form-label">Fórmula <span class="text-info tx-12">(Opcional)</span></label>
                                <textarea class="form-control" id="formula" name="formula" rows="2"></textarea>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="type" class="form-label">Presentación <span class="text-info tx-12">*</span></label>
                                <select name="type" id="type" class="form-control">
                                    <option value="">-- Seleccionar --</option>
                                    <option value="Tableta">Tableta</option>
                                    <option value="Cápsula">Cápsula</option>
                                    <option value="Píldora">Píldora</option>
                                    <option value="Supositorio">Supositorio</option>
                                    <option value="Jarabe">Jarabe</option>
                                    <option value="Gotas">Gotas</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="type_num" class="form-label">Cantidad <span class="text-info tx-12">(Opcional)</span></label>
                                <input type="text" class="form-control" id="type_num" name="type_num">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="type_dosage" class="form-label">Unidades</label>
                                <select name="type_dosage" id="type_dosage" class="form-control">
                                    <option value="">-- Seleccionar --</option>
                                    <option value="mg">mg</option>
                                    <option value="gr">gr</option>
                                    <option value="ml">ml</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="use_type" class="form-label">Vía de administración</label>
                                <select name="use_type" id="use_type" class="form-control">
                                    <option value="">-- Seleccionar --</option>
                                    <option value="Oral">Oral</option>
                                    <option value="Tópica">Tópica</option>
                                    <option value="Oftálmica">Oftálmica</option>
                                    <option value="Ótica">Ótica</option>
                                    <option value="Inyectable">Inyectable</option>
                                    <option value="Rectal">Rectal</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="expiration_date" class="form-label">Fecha de expiración <span class="text-danger tx-12">*</span></label>
                                <input type="date" class="form-control" id="expiration_date" name="expiration_date" required>
                            </div>

                            <div class="col-md-12 mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" checked>
                                    <label class="form-check-label" for="is_active">Activo</label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-dark btn-sm">Guardar Medicamento</button>
                                <a href="{{ route('dif.medications.index') }}" class="btn btn-secondary btn-sm">Cancelar</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
