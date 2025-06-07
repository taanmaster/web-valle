@extends('layouts.master')
@section('title')
    Intranet
@endsection
@section('content')
    <!-- Breadcrumbs -->
    @component('components.breadcrumb')
        @slot('li_1')
            Intranet
        @endslot
        @slot('li_2')
            Control de cajas
        @endslot
        @slot('title')
            Ingreso de caja
        @endslot
    @endcomponent

    <div class="row layout-spacing">
        <div class="main-content">
            <livewire:tsr_accounts_due.incomes.crud :mode="$mode" :income="$income" />
        </div>
    </div>
@endsection
