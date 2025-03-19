@extends('layouts.master')
@section('title')Intranet @endsection
@section('content')
<!-- this is breadcrumbs -->
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') Tesorería @endslot
@slot('title') Editar Proveedor @endslot
@endcomponent

<div class="row layout-spacing">
    <div class="main-content">
        <div class="row">
            <div class="col-8">
                <div class="card card-body">
                    <form method="POST" action="{{ route('treasury_account_payable_suppliers.update', $supplier->id) }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <div class="row">
                            <!-- Información básica -->
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Nombre <span class="text-danger tx-12">*</span></label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ $supplier->name }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="rfc" class="form-label">RFC <span class="text-info tx-12">(Opcional)</span></label>
                                <input type="text" class="form-control" id="rfc" name="rfc" value="{{ $supplier->rfc }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Correo Electrónico <span class="text-info tx-12">(Opcional)</span></label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ $supplier->email }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">Teléfono <span class="text-info tx-12">(Opcional)</span></label>
                                <input type="text" class="form-control" id="phone" name="phone" value="{{ $supplier->phone }}">
                            </div>

                            <!-- Información de la cuenta bancaria -->
                            <div class="col-md-6 mb-3">
                                <label for="account_name" class="form-label">Nombre de la Cuenta <span class="text-info tx-12">(Opcional)</span></label>
                                <input type="text" class="form-control" id="account_name" name="account_name" value="{{ $supplier->account_name }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="account_number" class="form-label">Número de Cuenta <span class="text-info tx-12">(Opcional)</span></label>
                                <input type="text" class="form-control" id="account_number" name="account_number" value="{{ $supplier->account_number }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="bank_name" class="form-label">Banco <span class="text-info tx-12">(Opcional)</span></label>
                                <input type="text" class="form-control" id="bank_name" name="bank_name" value="{{ $supplier->bank_name }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="dependency_id" class="form-label">Dependencia <span class="text-info tx-12">(Opcional)</span></label>
                                <input type="number" class="form-control" id="dependency_id" name="dependency_id" value="{{ $supplier->dependency_id }}">
                            </div>

                            <!-- Estado -->
                            <div class="col-md-12 mb-3">
                                <label for="status" class="form-label">Estado <span class="text-danger tx-12">*</span></label>
                                <select class="form-control" id="status" name="status" required>
                                    <option value="active" {{ $supplier->status === 'active' ? 'selected' : '' }}>Activo</option>
                                    <option value="inactive" {{ $supplier->status === 'inactive' ? 'selected' : '' }}>Inactivo</option>
                                </select>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-dark btn-sm">Guardar cambios</button>
                        <a href="{{ route('treasury_account_payable_suppliers.index') }}" class="btn btn-secondary btn-sm">Cancelar</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection