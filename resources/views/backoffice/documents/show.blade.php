@extends('layouts.master')
@section('title')Intranet @endsection

@section('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
<link href="{{ asset('libs/signature-pad-main/assets/jquery.signaturepad.css') }}" rel="stylesheet" />
<style>
    .signature-pad-wrapper {
        border: 2px dashed #dee2e6;
        border-radius: 8px;
        background: #f8f9fa;
    }
    .sigPad canvas {
        width: 100%;
        height: 200px;
    }
    .validation-progress {
        height: 20px;
        border-radius: 10px;
    }
</style>
@endsection

@section('content')
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') Backoffice @endslot
@slot('li_3') <a href="{{ route('backoffice.documents.index') }}">Oficios</a> @endslot
@slot('title') Detalle del Oficio @endslot
@endcomponent

@php
    $lastCorrectionRequest = $document->versions()
        ->where('activity_type', 'correccion_solicitada')
        ->orderBy('created_at', 'desc')
        ->first();

    $isCreatorViewing  = $document->user_id    == Auth::id();
    $isAssignedViewing = $document->assigned_to == Auth::id();
@endphp

<div class="container-fluid py-4">

    @include('backoffice.documents.partials.alerts')

    @include('backoffice.documents.partials.workflow-banner')

    <div class="row">
        <!-- Columna principal -->
        <div class="col-lg-8">

            @include('backoffice.documents.partials.document-body')

            @include('backoffice.documents.partials.actions-reviewer')

            @include('backoffice.documents.partials.actions-send-recipient')

            @include('backoffice.documents.partials.actions-send-review')

        </div>

        <!-- Panel Lateral -->
        @include('backoffice.documents.partials.sidebar')

    </div>
</div>

{{-- Modales --}}
@include('backoffice.documents.partials.modal-confirm-receipt')
@include('backoffice.documents.partials.modal-send-review')
@include('backoffice.documents.partials.modal-correction')
@include('backoffice.documents.partials.modal-validate')
@include('backoffice.documents.partials.modal-sign')
@include('backoffice.documents.partials.modal-send-recipient')

@endsection

@section('script')
@include('backoffice.documents.partials.scripts')
@endsection
{{-- ============================================================
     Fin de show.blade.php — lógica distribuida en partials/:
       alerts, workflow-banner, document-body,
       actions-reviewer, actions-send-recipient, actions-send-review,
       sidebar, modal-confirm-receipt, modal-send-review,
       modal-correction, modal-validate, modal-sign,
       modal-send-recipient, scripts
     ============================================================ --}}
