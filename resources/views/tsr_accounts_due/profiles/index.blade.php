@extends('layouts.master')
@section('title')Intranet @endsection
@section('content')
<!-- this is breadcrumbs -->
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') Cuentas por cobrar @endslot
@slot('title') Perfiles cuentas por cobrar @endslot
@endcomponent

<div class="container-fluid py-4">
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary bg-opacity-10 rounded-circle p-3 me-3">
                            <i class="fas fa-address-card fa-2x text-primary"></i>
                        </div>
                        <div>
                            <h3 class="mb-1 fw-bold">
                                <i class="fas fa-users text-primary me-2"></i> Perfiles de Cuentas por Cobrar
                            </h3>
                            <p class="text-muted mb-0">
                                <i class="fas fa-clipboard-list me-1"></i>
                                Consulta, filtra y administra los contribuyentes registrados para cobro.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 text-end">
                    <a href="{{ route('account_due_profiles.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i> Nuevo Perfil
                    </a>
                </div>
            </div>
        </div>
    </div>

    <livewire:tsr-accounts-due.profiles.table/>
</div>
@endsection
