@extends('layouts.master')
@section('title')Intranet @endsection
@section('content')
<!-- this is breadcrumbs -->
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') Tesorería @endslot
@slot('title') Editar Checklist @endslot
@endcomponent

<div class="row layout-spacing">
    <div class="main-content">
        <div class="row">
            <div class="col-12">
                <div class="card card-body">
                    <form method="POST" action="{{ route('contractor_checklists.update', [$contractor->id, $checklist->id]) }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}

                        <div class="row">
                            <!-- Información del checklist -->
                            <div class="col-md-6 mb-3">
                                <label for="program_code" class="form-label">Código De Programa</label>
                                <input type="text" class="form-control" id="program_code" name="program_code" value="{{ $checklist->program_code }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="program_name" class="form-label">Nombre Del Programa</label>
                                <input type="text" class="form-control" id="program_name" name="program_name" value="{{ $checklist->program_name }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="funding_source" class="form-label">Fuente Del Financiamiento</label>
                                <input type="text" class="form-control" id="funding_source" name="funding_source" value="{{ $checklist->funding_source }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="budget_item" class="form-label">Partida</label>
                                <input type="text" class="form-control" id="budget_item" name="budget_item" value="{{ $checklist->budget_item }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="work_number" class="form-label">No. De Obra</label>
                                <input type="text" class="form-control" id="work_number" name="work_number" value="{{ $checklist->work_number }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="reserve_doc_pres" class="form-label">Reserva, Doc Pres</label>
                                <input type="text" class="form-control" id="reserve_doc_pres" name="reserve_doc_pres" value="{{ $checklist->reserve_doc_pres }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="fixed_asset_number" class="form-label">No. De Activo Fijo</label>
                                <input type="text" class="form-control" id="fixed_asset_number" name="fixed_asset_number" value="{{ $checklist->fixed_asset_number }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="contract_number" class="form-label">Contrato No</label>
                                <input type="text" class="form-control" id="contract_number" name="contract_number" value="{{ $checklist->contract_number }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="contractor" class="form-label">Contratista</label>
                                <input type="text" class="form-control" id="contractor" name="contractor" value="{{ $contractor->name }}" readonly>
                                <input type="hidden" class="form-control" id="contractor_id" name="contractor_id" value="{{ $contractor->id }}" readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="taxpayer_registration" class="form-label">Registro Federal De Contribuyente</label>
                                <input type="text" class="form-control" id="taxpayer_registration" name="taxpayer_registration" value="{{ $checklist->taxpayer_registration }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="award_method" class="form-label">Modalidad De Adjudicación</label>
                                <input type="text" class="form-control" id="award_method" name="award_method" value="{{ $checklist->award_method }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="with_resources" class="form-label">Con Recursos</label>
                                <input type="checkbox" class="form-check-input" id="with_resources" name="with_resources" {{ $checklist->with_resources ? 'checked' : '' }}>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="agreement" class="form-label">Convenio</label>
                                <input type="text" class="form-control" id="agreement" name="agreement" value="{{ $checklist->agreement }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="execution_annex" class="form-label">Anexo De Ejecución</label>
                                <input type="text" class="form-control" id="execution_annex" name="execution_annex" value="{{ $checklist->execution_annex }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="work" class="form-label">Obra</label>
                                <input type="text" class="form-control" id="work" name="work" value="{{ $checklist->work }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="contract_amount" class="form-label">Importe Del Contrato</label>
                                <input type="number" step="0.01" class="form-control" id="contract_amount" name="contract_amount" value="{{ $checklist->contract_amount }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="advance_amount" class="form-label">Monto Del Anticipo</label>
                                <input type="number" step="0.01" class="form-control" id="advance_amount" name="advance_amount" value="{{ $checklist->advance_amount }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="contract_signing_date" class="form-label">Fecha De Firma Del Contrato</label>
                                <input type="date" class="form-control" id="contract_signing_date" name="contract_signing_date" value="{{ $checklist->contract_signing_date }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="contract_validity_start" class="form-label">Vigencia Contrato - Inicia</label>
                                <input type="date" class="form-control" id="contract_validity_start" name="contract_validity_start" value="{{ $checklist->contract_validity_start }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="contract_validity_end" class="form-label">Vigencia Contrato - Termina</label>
                                <input type="date" class="form-control" id="contract_validity_end" name="contract_validity_end" value="{{ $checklist->contract_validity_end }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validity_modification_start" class="form-label">Modificación De La Vigencia - Inicia</label>
                                <input type="date" class="form-control" id="validity_modification_start" name="validity_modification_start" value="{{ $checklist->validity_modification_start }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validity_modification_end" class="form-label">Modificación De La Vigencia - Termina</label>
                                <input type="date" class="form-control" id="validity_modification_end" name="validity_modification_end" value="{{ $checklist->validity_modification_end }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="modification_agreement_amount" class="form-label">Convenio Modificatorio En Monto</label>
                                <input type="number" step="0.01" class="form-control" id="modification_agreement_amount" name="modification_agreement_amount" value="{{ $checklist->modification_agreement_amount }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="amount" class="form-label">Importe</label>
                                <input type="number" step="0.01" class="form-control" id="amount" name="amount" value="{{ $checklist->amount }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="modification_agreement_time_start" class="form-label">Convenio Modificatorio En Tiempo - Inicia</label>
                                <input type="date" class="form-control" id="modification_agreement_time_start" name="modification_agreement_time_start" value="{{ $checklist->modification_agreement_time_start }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="modification_agreement_time_end" class="form-label">Convenio Modificatorio En Tiempo - Termina</label>
                                <input type="date" class="form-control" id="modification_agreement_time_end" name="modification_agreement_time_end" value="{{ $checklist->modification_agreement_time_end }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="estimated" class="form-label">Estimado</label>
                                <input type="number" step="0.01" class="form-control" id="estimated" name="estimated" value="{{ $checklist->estimated }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="iva" class="form-label">IVA</label>
                                <input type="number" step="0.01" class="form-control" id="iva" name="iva" value="{{ $checklist->iva }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="sum" class="form-label">Suma</label>
                                <input type="number" step="0.01" class="form-control" id="sum" name="sum" value="{{ $checklist->sum }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="advance_amortization" class="form-label">Amortización Del Anticipo</label>
                                <input type="number" step="0.01" class="form-control" id="advance_amortization" name="advance_amortization" value="{{ $checklist->advance_amortization }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="subtotal" class="form-label">Subtotal</label>
                                <input type="number" step="0.01" class="form-control" id="subtotal" name="subtotal" value="{{ $checklist->subtotal }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="penalty" class="form-label">Sanción</label>
                                <input type="number" step="0.01" class="form-control" id="penalty" name="penalty" value="{{ $checklist->penalty }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="net_scope" class="form-label">Alcance Neto</label>
                                <input type="number" step="0.01" class="form-control" id="net_scope" name="net_scope" value="{{ $checklist->net_scope }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="subtotal_2" class="form-label">Subtotal 2</label>
                                <input type="number" step="0.01" class="form-control" id="subtotal_2" name="subtotal_2" value="{{ $checklist->subtotal_2 }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="iva_2" class="form-label">IVA 2</label>
                                <input type="number" step="0.01" class="form-control" id="iva_2" name="iva_2" value="{{ $checklist->iva_2 }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="total" class="form-label">Total</label>
                                <input type="number" step="0.01" class="form-control" id="total" name="total" value="{{ $checklist->total }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="faism_2024_pays" class="form-label">FAISM 2024 Paga</label>
                                <input type="number" step="0.01" class="form-control" id="faism_2024_pays" name="faism_2024_pays" value="{{ $checklist->faism_2024_pays }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="state_pays" class="form-label">Estado Paga</label>
                                <input type="number" step="0.01" class="form-control" id="state_pays" name="state_pays" value="{{ $checklist->state_pays }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="prepared_by" class="form-label">Elaborado Por</label>
                                <input type="text" class="form-control" id="prepared_by" name="prepared_by" value="{{ $checklist->prepared_by }}">
                            </div>

                            <!-- Selección de checklist -->
                            <div class="col-md-12 mb-3">
                                <label for="checklist_id" class="form-label">Seleccionar checklist</label>
                                <select class="form-control" id="checklist_id" name="checklist_id">
                                    <option value="">Seleccione un checklist</option>
                                    @foreach($checklists_base as $checklistOption)
                                        <option value="{{ $checklistOption->id }}" {{ $checklistOption->id == $checklist->checklist_id ? 'selected' : '' }}>{{ $checklistOption->name }}</option>
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
document.addEventListener('DOMContentLoaded', function() {
    var checklistId = document.getElementById('checklist_id').value;
    var checklistElementsContainer = document.getElementById('checklist-elements');

    if (checklistId) {
        fetch(`/api/checklists/${checklistId}/elements`)
            .then(response => response.json())
            .then(data => {
                data.forEach(element => {
                    var div = document.createElement('div');
                    div.className = 'col-md-3 mb-3';
                    div.innerHTML = `
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="checklist_element_${element.id}" name="checklist_elements[]" value="${element.id}" ${element.checked ? 'checked' : ''}>
                            <label class="form-check-label" for="checklist_element_${element.id}">
                                ${element.name}
                            </label>
                        </div>
                    `;
                    checklistElementsContainer.appendChild(div);
                });
            });
    }

    document.getElementById('checklist_id').addEventListener('change', function() {
        checklistId = this.value;
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
});
</script>
@endsection