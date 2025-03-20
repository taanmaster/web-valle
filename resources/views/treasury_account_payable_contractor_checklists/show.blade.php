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
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <strong>Folio:</strong>
                                <p>{{ $checklist->folio ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>Fecha Recibido:</strong>
                                <p>{{ $checklist->received_at ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>Programa:</strong>
                                <p>{{ $checklist->program_name ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>Fuente del Financiamiento:</strong>
                                <p>{{ $checklist->funding_source ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>Partida:</strong>
                                <p>{{ $checklist->budget_item ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>No. de Obra:</strong>
                                <p>{{ $checklist->work_number ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>Reserva, Doc Pres:</strong>
                                <p>{{ $checklist->reserve_doc_pres ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>No. de Activo Fijo:</strong>
                                <p>{{ $checklist->fixed_asset_number ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>Contrato No:</strong>
                                <p>{{ $checklist->contract_number ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>Contratista:</strong>
                                <p>{{ $checklist->contractor->name ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>Registro Federal de Contribuyente:</strong>
                                <p>{{ $checklist->taxpayer_registration ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>Modalidad de Adjudicación:</strong>
                                <p>{{ $checklist->award_method ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>Con Recursos:</strong>
                                <p>{{ $checklist->with_resources ? 'Sí' : 'No' }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>Convenio:</strong>
                                <p>{{ $checklist->agreement ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>Anexo de Ejecución:</strong>
                                <p>{{ $checklist->execution_annex ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>Obra:</strong>
                                <p>{{ $checklist->work ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>Importe del Contrato:</strong>
                                <p>{{ $checklist->contract_amount ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>Monto del Anticipo:</strong>
                                <p>{{ $checklist->advance_amount ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>Fecha de Firma del Contrato:</strong>
                                <p>{{ $checklist->contract_signing_date ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>Vigencia del Contrato:</strong>
                                <p>{{ $checklist->contract_validity_start ?? 'N/A' }} - {{ $checklist->contract_validity_end ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>Modificación de la Vigencia:</strong>
                                <p>{{ $checklist->validity_modification_start ?? 'N/A' }} - {{ $checklist->validity_modification_end ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>Convenio Modificatorio en Monto:</strong>
                                <p>{{ $checklist->modification_agreement_amount ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>Importe:</strong>
                                <p>{{ $checklist->amount ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>Convenio Modificatorio en Tiempo:</strong>
                                <p>{{ $checklist->modification_agreement_time_start ?? 'N/A' }} - {{ $checklist->modification_agreement_time_end ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>Estimado:</strong>
                                <p>{{ $checklist->estimated ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>IVA:</strong>
                                <p>{{ $checklist->iva ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>Suma:</strong>
                                <p>{{ $checklist->sum ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>Amortización del Anticipo:</strong>
                                <p>{{ $checklist->advance_amortization ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>Subtotal:</strong>
                                <p>{{ $checklist->subtotal ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>Sanción:</strong>
                                <p>{{ $checklist->penalty ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>Alcance Neto:</strong>
                                <p>{{ $checklist->net_scope ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>Subtotal 2:</strong>
                                <p>{{ $checklist->subtotal_2 ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>IVA 2:</strong>
                                <p>{{ $checklist->iva_2 ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>Total:</strong>
                                <p>{{ $checklist->total ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>FAISM 2024 Paga:</strong>
                                <p>{{ $checklist->faism_2024_pays ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>Estado Paga:</strong>
                                <p>{{ $checklist->state_pays ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>Elaborado Por:</strong>
                                <p>{{ $checklist->prepared_by ?? 'N/A' }}</p>
                            </div>

                            <div class="col-md-12">
                                <p><strong>Elementos del Checklist:</strong></p>

                                @php
                                    $checklist_elements = App\Models\TreasuryAccountPayableChecklistElement::where('checklist_id', $checklist->checklist_id)->get();
                                @endphp
                                <ul>
                                    @foreach($checklist_elements as $element)
                                        <li>{{ $element->name }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
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