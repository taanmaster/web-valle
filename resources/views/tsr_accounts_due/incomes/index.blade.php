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
            Registros de cobro
        @endslot
    @endcomponent

    <div class="container-fluid py-4">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <div class="row align-items-center">
                    <div class="col-lg-8">
                        <div class="d-flex align-items-center">
                            <div class="bg-primary bg-opacity-10 rounded-circle p-3 me-3">
                                <i class="fas fa-cash-register fa-2x text-primary"></i>
                            </div>
                            <div>
                                <h3 class="mb-1 fw-bold">
                                    <i class="fas fa-receipt text-primary me-2"></i> Registros de Cobro
                                </h3>
                                <p class="text-muted mb-0">
                                    <i class="fas fa-clipboard-list me-1"></i>
                                    Administra ingresos generados a partir de enteros provisionales.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 text-end">
                        <a href="{{ route('account_due_incomes.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i> Nuevo Ingreso
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <livewire:tsr_accounts_due.incomes.table />
    </div>
@endsection
