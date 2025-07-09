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
            Editar de Autorización
        @endslot
    @endcomponent

    <div class="row layout-spacing">
        <div class="main-content">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <form method="POST"
                            action="{{ route('supplier_checklist_authorizations.update', $authorization->id) }}"
                            enctype="multipart/form-data">
                            {{ csrf_field() }}
                            {{ method_field('PUT') }}
                            <div class="card-body">
                                <div class="row">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="folio" class="form-label">Folio</label>
                                            <input type="text" class="form-control" value="{{ $authorization->folio }}"
                                                id="folio" name="folio">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="title" class="form-label">Título</label>
                                            <input type="text" class="form-control" value="{{ $authorization->title }}"
                                                id="title" name="title" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="type" class="form-label">Tipo</label>
                                            <input type="text" class="form-control" value="{{ $authorization->type }}"
                                                id="type" name="type" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="amount" class="form-label">Cantidad</label>
                                            <input type="number" class="form-control" value="{{ $authorization->amount }}"
                                                id="amount" name="amount" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="sender_bank_name" class="form-label">Banco Emisor</label>
                                            <input type="text" class="form-control"
                                                value="{{ $authorization->sender_bank_name }}" id="sender_bank_name"
                                                name="sender_bank_name">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="sender_account_number" class="form-label">Número de Cuenta
                                                Emisor</label>
                                            <input type="text" class="form-control"
                                                value="{{ $authorization->sender_account_number }}"
                                                id="sender_account_number" name="sender_account_number">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="financing_fund" class="form-label">Fondo de Financiamiento</label>
                                            <input type="text" class="form-control"
                                                value="{{ $authorization->financing_fund }}" id="financing_fund"
                                                name="financing_fund">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="receiver_bank_name" class="form-label">Banco Receptor</label>
                                            <input type="text" class="form-control"
                                                value="{{ $authorization->receiver_bank_name }}" id="receiver_bank_name"
                                                name="receiver_bank_name">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="receiver_account_number" class="form-label">Número de Cuenta
                                                Receptor</label>
                                            <input type="text" class="form-control"
                                                value="{{ $authorization->receiver_account_number }}"
                                                id="receiver_account_number" name="receiver_account_number">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="recipient_name" class="form-label">Beneficiario</label>
                                            <input type="text" class="form-control"
                                                value="{{ $authorization->recipient_name }}" id="recipient_name"
                                                name="recipient_name">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="transaction_by" class="form-label">Transacción por</label>
                                            <input type="text" class="form-control"
                                                value="{{ $authorization->transaction_by }}" id="transaction_by"
                                                name="transaction_by">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="authorized_by" class="form-label">Autorizado por</label>
                                            <input type="text" class="form-control"
                                                value="{{ $authorization->authorized_by }}" id="authorized_by"
                                                name="authorized_by">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="reviewed_by" class="form-label">Revisado por</label>
                                            <input type="text" class="form-control"
                                                value="{{ $authorization->reviewed_by }}" id="reviewed_by"
                                                name="reviewed_by">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="redacted_by" class="form-label">Redactado por</label>
                                            <input type="text" class="form-control"
                                                value="{{ $authorization->redacted_by }}" id="redacted_by"
                                                name="redacted_by">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="payment_status" class="form-label">Estatus de pago</label>
                                            <select name="payment_status" id="payment_status" class="form-select">
                                                <option value="programado"
                                                    @if ($authorization->status == 'programado') selected @endif>
                                                    Programado
                                                </option>
                                                <option value="pagado" @if ($authorization->status == 'pagado') selected @endif>
                                                    Pagado
                                                </option>
                                                <option value="vencido" @if ($authorization->status == 'vencido') selected @endif>
                                                    Vencido
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-muted">
                                <button type="button" class="btn btn-secondary btn-sm"
                                    data-bs-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-dark btn-sm">Actualizar datos</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
