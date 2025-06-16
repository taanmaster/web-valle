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
            Cuentas por cobrar
        @endslot
        @slot('title')
            Reporte de caja
        @endslot
    @endcomponent

    <div class="row layout-spacing">

        <livewire:tsr_accounts_due.reports.custome />

    </div>
@endsection
