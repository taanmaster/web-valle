@extends('layouts.master')
@section('title')Intranet @endsection
@section('content')
<!-- this is breadcrumbs -->
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') Cuentas por cobrar @endslot
@slot('title') Registro de Enteros @endslot
@endcomponent

<div class="row layout-spacing">
    <div class="main-content">
        <livewire:tsr_accounts_due.provisional_integer.table/>
    </div>
</div>
@endsection
