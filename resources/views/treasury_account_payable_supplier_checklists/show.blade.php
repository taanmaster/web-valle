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
                <form method="POST" action="{{ route('supplier_checklists.download', [$supplier->id, $checklist->id]) }}" enctype="multipart/form-data">
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
                        <p><strong>Fecha Devolución:</strong> {{ $checklist->return_date ?? 'N/A' }}</p>
                        <p><strong>Dependencia:</strong> {{ $checklist->dependency_name ?? 'N/A' }}</p>
                        <p><strong>No. Factura:</strong> {{ $checklist->invoice_number ?? 'N/A' }}</p>
                        <p><strong>Estado:</strong> {{ $checklist->status }}</p>
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
                    <div class="card-footer text-muted">
                        <div class="btn-group" role="group">
                            <a href="{{ route('supplier_checklists.edit', [$supplier->id, $checklist->id]) }}" class="btn btn-sm btn-secondary">
                                <i class="bx bx-edit"></i> Editar
                            </a>
                            <form method="POST" action="{{ route('supplier_checklists.destroy', [$supplier->id, $checklist->id]) }}" style="display: inline-block;">
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

            <!-- Autorizaciones -->
            <div class="col-12 mt-5">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5>Autorizaciones</h5>
                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#newAuthorizationModal">
                            <i class="bx bx-plus"></i> Nueva autorización
                        </button>
                    </div>
                    <div class="card-body">
                        @if($checklist->authorizations->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Número</th>
                                        <th>Título</th>
                                        <th>Tipo</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($checklist->authorizations as $authorization)
                                    <tr>
                                        <td>{{ $authorization->folio ?? 'N/A' }}</td>
                                        <td>{{ $authorization->title }}</td>
                                        <td>{{ $authorization->type }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('supplier_checklist_authorizations.edit', $authorization->id) }}" class="btn btn-sm btn-outline-secondary">
                                                    <i class="bx bx-edit"></i> Editar
                                                </a>
                                                <form method="POST" action="{{ route('supplier_checklist_authorizations.destroy', $authorization->id) }}" style="display: inline-block;">
                                                    {{ csrf_field() }}
                                                    {{ method_field('DELETE') }}
                                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                                        <i class="bx bx-trash-alt"></i> Eliminar
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <div class="text-center my-4">
                            <h5>No hay autorizaciones asociadas a este checklist.</h5>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para nueva autorización -->
<div class="modal fade" id="newAuthorizationModal" tabindex="-1" aria-labelledby="newAuthorizationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newAuthorizationModalLabel">Nueva Autorización</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('supplier_checklist_authorizations.store') }}">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="folio" class="form-label">Folio</label>
                            <input type="text" class="form-control" id="folio" name="folio">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="title" class="form-label">Título</label>
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="type" class="form-label">Tipo</label>
                            <input type="text" class="form-control" id="type" name="type" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="amount" class="form-label">Cantidad</label>
                            <input type="number" class="form-control" id="amount" name="amount" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="sender_bank_name" class="form-label">Banco Emisor</label>
                            <input type="text" class="form-control" id="sender_bank_name" name="sender_bank_name">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="sender_account_number" class="form-label">Número de Cuenta Emisor</label>
                            <input type="text" class="form-control" id="sender_account_number" name="sender_account_number">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="financing_fund" class="form-label">Fondo de Financiamiento</label>
                            <input type="text" class="form-control" id="financing_fund" name="financing_fund">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="receiver_bank_name" class="form-label">Banco Receptor</label>
                            <input type="text" class="form-control" id="receiver_bank_name" name="receiver_bank_name">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="receiver_account_number" class="form-label">Número de Cuenta Receptor</label>
                            <input type="text" class="form-control" id="receiver_account_number" name="receiver_account_number">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="recipient_name" class="form-label">Beneficiario</label>
                            <input type="text" class="form-control" id="recipient_name" name="recipient_name">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="transaction_by" class="form-label">Transacción por</label>
                            <input type="text" class="form-control" id="transaction_by" name="transaction_by">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="authorized_by" class="form-label">Autorizado por</label>
                            <input type="text" class="form-control" id="authorized_by" name="authorized_by">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="reviewed_by" class="form-label">Revisado por</label>
                            <input type="text" class="form-control" id="reviewed_by" name="reviewed_by">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="redacted_by" class="form-label">Redactado por</label>
                            <input type="text" class="form-control" id="redacted_by" name="redacted_by">
                        </div>
                    </div>
                    <input type="hidden" name="supplier_id" value="{{ $supplier->id }}">
                    <input type="hidden" name="supplier_checklist_id" value="{{ $checklist->id }}">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection