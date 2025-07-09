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
            Detalle de Autorización
        @endslot
    @endcomponent

    <div class="row layout-spacing">
        <div class="main-content">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <p><strong>Folio:</strong> {{ $authorization->folio ?? 'N/A' }}</p>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <p><strong>Tipo:</strong> {{ $authorization->type ?? 'N/A' }}</p>
                                    <p><strong>Banco emisor:</strong> {{ $authorization->sender_bank_name ?? 'N/A' }}</p>
                                    <p><strong>Fondo de Financiamiento:</strong>
                                        {{ $authorization->financing_fund ?? 'N/A' }}</p>
                                    <p><strong>Número de Cuenta Receptor:</strong>
                                        {{ $authorization->receiver_account_number ?? 'N/A' }}</p>
                                    <p><strong>Transacción por:</strong> {{ $authorization->transaction_by }}</p>
                                    <p><strong>Revisado por:</strong>{{ $authorization->reviewed_by }}</p>
                                </div>

                                <div class="col-md-4">
                                    <p><strong>Concepto de pago:</strong> {{ $authorization->title ?? 'N/A' }}</p>
                                    <p><strong>Cantidad:</strong> {{ $authorization->amount ?? 'N/A' }}</p>
                                    <p><strong>Número de Cuenta Emisor:</strong>
                                        {{ $authorization->sender_account_number ?? 'N/A' }}</p>
                                    <p><strong>Banco Receptor:</strong>
                                        {{ $authorization->recipient_name ?? 'N/A' }}</p>
                                    <p><strong>Autorizado por:</strong> {{ $authorization->authorized_by }}</p>
                                    <p><strong>Redactado por:</strong> {{ $authorization->redacted_by }}</p>
                                    <p><strong>Estatus de pago:</strong> @switch($authorization->status)
                                            @case('programado')
                                                <span class="badge bg-warning">Programado</span>
                                            @break

                                            @case('vencido')
                                                <span class="badge bg-danger">Vencido</span>
                                            @break

                                            @case('active' || 'pagado')
                                                <span class="badge bg-success">Pagado</span>
                                            @break
                                        @endswitch
                                    </p>
                                </div>
                            </div>

                        </div>

                        <div class="card-footer text-muted">
                            <div class="btn-group" role="group">
                                <a href="{{ route('supplier_checklist_authorizations.edit', $authorization->id) }}"
                                    class="btn btn-sm btn-secondary">
                                    <i class="bx bx-edit"></i> Editar
                                </a>
                                <form method="POST"
                                    action="{{ route('supplier_checklist_authorizations.destroy', $authorization->id) }}"
                                    style="display: inline-block;">
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

                <div class="col-12 mt-5">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5>Notas</h5>
                            <button class="btn btn-sm btn-primary" style="max-width: 140px" data-bs-toggle="modal"
                                data-bs-target="#newNoteModal">
                                <i class="bx bx-plus"></i> Nueva nota
                            </button>
                        </div>
                        <div class="card-body">
                            @if ($authorization->notes->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>Fecha</th>
                                                <th>Descripción</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($authorization->notes as $note)
                                                <tr>
                                                    <td>{{ $note->created_at->format('Y-m-d') }}</td>
                                                    <td>{{ $note->description }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para nueva nota -->
    <div class="modal fade" id="newNoteModal" tabindex="-1" aria-labelledby="newNoteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="newNoteModalLabel">Nueva Nota</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('supplier_checklist_authorizations_notes.store') }}">
                    {{ csrf_field() }}

                    <div class="modal-body">
                        <input type="hidden" name="authorization_id" value="{{ $authorization->id }}">

                        <div class="mb-3">
                            <label for="description" class="form-label">Descripción</label>
                            <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                        </div>
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
