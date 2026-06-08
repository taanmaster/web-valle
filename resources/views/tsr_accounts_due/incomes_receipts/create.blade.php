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
            Recibo de ingreso
        @endslot
    @endcomponent

    <div class="container-fluid py-4">
        <livewire:tsr_accounts_due.incomes_receipts.crud :mode="$mode" :income="$income" />
    </div>
@endsection
