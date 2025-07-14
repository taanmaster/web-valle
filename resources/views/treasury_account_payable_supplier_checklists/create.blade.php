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
            Alta de cuenta por pagar
        @endslot
    @endcomponent

    <div class="row layout-spacing">
        <div class="main-content">
            <div class="row">
                <div class="col-12">
                    <div class="card card-body">

                        <form method="POST" action="{{ route('supplier_checklists.store', $supplier->id) }}"
                            enctype="multipart/form-data">
                            {{ csrf_field() }}

                            <div class="row">
                                <!-- Información del checklist -->
                                <div class="col-md-12 mb-3">
                                    <label for="folio" class="form-label">Folio</label>
                                    <input type="text" class="form-control" id="folio" name="folio">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="received_at" class="form-label">Fecha recibido</label>
                                    <input type="date" class="form-control" id="received_at" name="received_at">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="return_date" class="form-label">Fecha devolución</label>
                                    <input type="date" class="form-control" id="return_date" name="return_date">
                                </div>
                                {{--
                            <div class="col-md-6 mb-3">
                                <label for="dependency_id" class="form-label">Dependencia</label>
                                <input type="text" class="form-control" id="dependency_id" name="dependency_id">
                            </div>
                            --}}

                                <div class="col-md-6 mb-3">
                                    <label for="dependency_name" class="form-label">Departamento solicitante</label>
                                    <input type="text" class="form-control" id="dependency_name" name="dependency_name">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="supplier_id" class="form-label">Proveedor</label>
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
                                    <input type="text" class="form-control" id="invoice_number" name="invoice_number">
                                </div>

                                <!-- Selección de checklist -->
                                <div class="col-md-12 mb-3">
                                    <label for="checklist_id" class="form-label">Seleccionar checklist</label>
                                    <select class="form-control" id="checklist_id" name="checklist_id">
                                        <option value="">Seleccione un checklist</option>
                                        @foreach ($checklists as $checklist)
                                            <option value="{{ $checklist->id }}">{{ $checklist->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Elementos del checklist -->
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Elementos del checklist</label>
                                    <div class="row" id="checklist-elements">
                                        <!-- Elementos del checklist se cargarán aquí -->
                                    </div>
                                </div>

                                <!-- Estado -->
                                <div class="col-md-12 mb-3">
                                    <label for="status" class="form-label">Estado <span
                                            class="text-danger tx-12">*</span></label>
                                    <select class="form-control" id="status" name="status" required>
                                        <option value="active">Activa</option>
                                        <option value="overdue">Vencida</option>
                                        <option value="payed">Pagada</option>
                                    </select>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-dark btn-sm">Guardar</button>
                            <a href="{{ URL::previous() }}" class="btn btn-secondary btn-sm">Cancelar</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('checklist_id').addEventListener('change', function() {
            var checklistId = this.value;
            var checklistElementsContainer = document.getElementById('checklist-elements');
            checklistElementsContainer.innerHTML = '';

            if (checklistId) {
                fetch(`/api/checklists/${checklistId}/elements`)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(element => {
                            var div = document.createElement('div');
                            div.className = 'col-md-3 mb-3';
                            div.innerHTML = `
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="checklist_element_${element.id}" name="checklist_elements[]" value="${element.id}">
                            <label class="form-check-label" for="checklist_element_${element.id}">
                                ${element.name}
                            </label>
                        </div>
                    `;
                            checklistElementsContainer.appendChild(div);
                        });
                    });
            }
        });
    </script>
@endsection
