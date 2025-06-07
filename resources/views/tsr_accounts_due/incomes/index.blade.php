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

    <div class="row layout-spacing">
        <div class="main-content">
            <div class="row align-items-center mb-4">
                <div class="col text-start">
                    <a href="{{ route('account_due_incomes.create') }}" class="btn btn-primary">Nueva Ingreso</a>
                </div>
            </div>

            <livewire:tsr_accounts_due.incomes.table />

        </div>
    </div>
@endsection
