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
            Dashboard
        @endslot
    @endcomponent

    <div class="container-fluid py-4">
        <livewire:tsr_accounts_due.dashboard />
    </div>
@endsection
