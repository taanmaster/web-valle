@extends('layouts.master')
@section('title')Intranet @endsection
@section('content')
<!-- this is breadcrumbs -->
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') Cuentas por cobrar @endslot
@slot('title') Registro de Enteros @endslot
@endcomponent

<div class="container-fluid py-4">
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
            <div class="d-flex align-items-center">
                <div class="bg-primary bg-opacity-10 rounded-circle p-3 me-3">
                    <i class="fas fa-file-invoice-dollar fa-2x text-primary"></i>
                </div>
                <div>
                    <h3 class="mb-1 fw-bold">
                        <i class="fas fa-file-signature text-primary me-2"></i> Registro de Enteros
                    </h3>
                    <p class="text-muted mb-0">
                        <i class="fas fa-clipboard-list me-1"></i>
                        Consulta y descarga enteros provisionales generados desde perfiles.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <livewire:tsr_accounts_due.provisional_integer.table/>
</div>
@endsection
