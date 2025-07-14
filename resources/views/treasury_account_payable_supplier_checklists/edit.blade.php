@extends('layouts.master')
@section('title')
    Intranet
@endsection
@section('content')
    <!-- this is breadcrumbs -->
    @component('components.breadcrumb')
        @slot('li_1')
            Intranet
        @endslot
        @slot('li_2')
            Tesorería
        @endslot
        @slot('title')
            Editar Checklist
        @endslot
    @endcomponent

    <div class="row layout-spacing">
        <div class="main-content">
            <div class="row">
                <div class="col-12">
                    <div class="card card-body">
                        <form method="POST"
                            action="{{ route('supplier_checklists.update', [$supplier->id, $checklist->id]) }}"
                            enctype="multipart/form-data">
                            {{ csrf_field() }}
                            {{ method_field('PUT') }}

                            <div class="row">
                                <!-- Información del checklist -->
                                <div class="col-md-12 mb-3">
                                    <label for="folio" class="form-label">Folio</label>
                                    <input type="text" class="form-control" id="folio" name="folio"
                                        value="{{ $checklist->folio }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="received_at" class="form-label">Fecha recibido</label>
                                    <input type="date" class="form-control" id="received_at" name="received_at"
                                        value="{{ $checklist->received_at }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="return_date" class="form-label">Fecha devolución</label>
                                    <input type="date" class="form-control" id="return_date" name="return_date"
                                        value="{{ $checklist->return_date }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="dependency_name" class="form-label">Departamento solicitante</label>
                                    <input type="text" class="form-control" id="dependency_name" name="dependency_name"
                                        value="{{ $checklist->dependency_name }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="supplier_name" class="form-label">Proveedor</label>
                                    <input type="text" class="form-control" id="supplier_name" name="supplier_name"
                                        value="{{ $supplier->name }}" readonly>
                                    <input type="hidden" class="form-control" id="supplier_id" name="supplier_id"
                                        value="{{ $supplier->id }}" readonly>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="supplier_number" class="form-label">No. Proveedor</label>
                                    <input type="text" class="form-control" id="supplier_number" name="supplier_number"
                                        value="{{ $supplier->id }}" readonly>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="invoice_number" class="form-label">No. Factura</label>
                                    <input type="text" class="form-control" id="invoice_number" name="invoice_number"
                                        value="{{ $checklist->invoice_number }}">
                                </div>

                                <!-- Estado -->
                                <div class="col-md-12 mb-3">
                                    <label for="status" class="form-label">Estado <span
                                            class="text-danger tx-12">*</span></label>
                                    <select class="form-control" id="status" name="status" required>
                                        <option value="active" {{ $checklist->status === 'active' ? 'selected' : '' }}>
                                            Activa</option>
                                        <option value="overdue" {{ $checklist->status === 'overdue' ? 'selected' : '' }}>
                                            Vencida</option>
                                        <option value="payed" {{ $checklist->status === 'payed' ? 'selected' : '' }}>
                                            Pagada</option>
                                    </select>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-dark btn-sm">Guardar cambios</button>
                            <a href="{{ URL::previous() }}" class="btn btn-secondary btn-sm">Cancelar</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
