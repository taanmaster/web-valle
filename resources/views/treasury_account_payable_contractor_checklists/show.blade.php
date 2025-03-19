@extends('layouts.master')
@section('title')Intranet @endsection
@section('content')
<!-- this is breadcrumbs -->
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') Tesorería @endslot
@slot('title') Detalle del Checklist @endslot
@endcomponent

<div class="row layout-spacing">
    <div class="main-content">
        <div class="row">
            <!-- Información del checklist -->
            <div class="col-md-12 text-end mb-5">
                <form method="POST" action="{{ route('contractor_checklists.download', [$checklist->contractor_id, $checklist->id]) }}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <button type="submit" class="btn btn-primary"><i class="bx bx-download"></i> Descargar Checklist</button>
                </form>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5>Detalle del Checklist</h5>
                    </div>
                    <div class="card-body">
                        <p><strong>Folio:</strong> {{ $checklist->folio ?? 'N/A' }}</p>
                        <p><strong>Fecha Recibido:</strong> {{ $checklist->received_at ?? 'N/A' }}</p>
                        <p><strong>Programa:</strong> {{ $checklist->program_name ?? 'N/A' }}</p>
                        <p><strong>Fuente del Financiamiento:</strong> {{ $checklist->funding_source ?? 'N/A' }}</p>
                        <p><strong>Partida:</strong> {{ $checklist->budget_item ?? 'N/A' }}</p>
                        <p><strong>No. de Obra:</strong> {{ $checklist->work_number ?? 'N/A' }}</p>
                        <p><strong>Reserva, Doc Pres:</strong> {{ $checklist->reserve_doc_pres ?? 'N/A' }}</p>
                        <p><strong>No. de Activo Fijo:</strong> {{ $checklist->fixed_asset_number ?? 'N/A' }}</p>
                        <p><strong>Contrato No:</strong> {{ $checklist->contract_number ?? 'N/A' }}</p>
                        <p><strong>Contratista:</strong> {{ $checklist->contractor ?? 'N/A' }}</p>
                        <p><strong>Registro Federal de Contribuyente:</strong> {{ $checklist->taxpayer_registration ?? 'N/A' }}</p>
                        <p><strong>Modalidad de Adjudicación:</strong> {{ $checklist->award_method ?? 'N/A' }}</p>
                        <p><strong>Con Recursos:</strong> {{ $checklist->with_resources ? 'Sí' : 'No' }}</p>
                        <p><strong>Convenio:</strong> {{ $checklist->agreement ?? 'N/A' }}</p>
                        <p><strong>Anexo de Ejecución:</strong> {{ $checklist->execution_annex ?? 'N/A' }}</p>
                        <p><strong>Obra:</strong> {{ $checklist->work ?? 'N/A' }}</p>
                        <p><strong>Importe del Contrato:</strong> {{ $checklist->contract_amount ?? 'N/A' }}</p>
                        <p><strong>Monto del Anticipo:</strong> {{ $checklist->advance_amount ?? 'N/A' }}</p>
                        <p><strong>Fecha de Firma del Contrato:</strong> {{ $checklist->contract_signing_date ?? 'N/A' }}</p>
                        <p><strong>Vigencia del Contrato:</strong> {{ $checklist->contract_validity_start ?? 'N/A' }} - {{ $checklist->contract_validity_end ?? 'N/A' }}</p>
                        <p><strong>Modificación de la Vigencia:</strong> {{ $checklist->validity_modification_start ?? 'N/A' }} - {{ $checklist->validity_modification_end ?? 'N/A' }}</p>
                        <p><strong>Convenio Modificatorio en Monto:</strong> {{ $checklist->modification_agreement_amount ?? 'N/A' }}</p>
                        <p><strong>Importe:</strong> {{ $checklist->amount ?? 'N/A' }}</p>
                        <p><strong>Convenio Modificatorio en Tiempo:</strong> {{ $checklist->modification_agreement_time_start ?? 'N/A' }} - {{ $checklist->modification_agreement_time_end ?? 'N/A' }}</p>
                        <p><strong>Estimado:</strong> {{ $checklist->estimated ?? 'N/A' }}</p>
                        <p><strong>IVA:</strong> {{ $checklist->iva ?? 'N/A' }}</p>
                        <p><strong>Suma:</strong> {{ $checklist->sum ?? 'N/A' }}</p>
                        <p><strong>Amortización del Anticipo:</strong> {{ $checklist->advance_amortization ?? 'N/A' }}</p>
                        <p><strong>Subtotal:</strong> {{ $checklist->subtotal ?? 'N/A' }}</p>
                        <p><strong>Sanción:</strong> {{ $checklist->penalty ?? 'N/A' }}</p>
                        <p><strong>Alcance Neto:</strong> {{ $checklist->net_scope ?? 'N/A' }}</p>
                        <p><strong>Subtotal 2:</strong> {{ $checklist->subtotal_2 ?? 'N/A' }}</p>
                        <p><strong>IVA 2:</strong> {{ $checklist->iva_2 ?? 'N/A' }}</p>
                        <p><strong>Total:</strong> {{ $checklist->total ?? 'N/A' }}</p>
                        <p><strong>FAISM 2024 Paga:</strong> {{ $checklist->faism_2024_pays ?? 'N/A' }}</p>
                        <p><strong>Estado Paga:</strong> {{ $checklist->state_pays ?? 'N/A' }}</p>
                        <p><strong>Elaborado Por:</strong> {{ $checklist->prepared_by ?? 'N/A' }}</p>
                    </div>
                    <div class="card-footer text-muted">
                        <div class="btn-group" role="group">
                            <a href="{{ route('contractor_checklists.edit', [$checklist->contractor_id, $checklist->id]) }}" class="btn btn-sm btn-secondary">
                                <i class="bx bx-edit"></i> Editar
                            </a>
                            <form method="POST" action="{{ route('contractor_checklists.destroy', [$checklist->contractor_id, $checklist->id]) }}" style="display: inline-block;">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="bx bx-trash-alt"></i> Eliminar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection