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
            Cuentas por pagar
        @endslot
        @slot('title')
            Dashboard
        @endslot
    @endcomponent

    <div class="row layout-spacing">
        <livewire:tap_accounts_payable.dashboard />
    </div>
@endsection
