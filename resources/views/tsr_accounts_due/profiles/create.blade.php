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
            Tesorería
        @endslot
        @slot('title')
            Cuentas por cobrar
        @endslot
    @endcomponent

    <div class="container-fluid py-4">
        <livewire:tsr_accounts_due.profiles.crud :mode="$mode"/>
    </div>
@endsection
