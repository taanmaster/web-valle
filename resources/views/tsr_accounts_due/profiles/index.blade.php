@extends('layouts.master')
@section('title')Intranet @endsection
@section('content')
<!-- this is breadcrumbs -->
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') Cuentas por cobrar @endslot
@slot('title') Perfiles cuentas por cobrar @endslot
@endcomponent

<div class="row layout-spacing">
    <div class="main-content">
        <div class="row align-items-center mb-4">
            <div class="col text-start">
                <a href="javascript:void(0)" class="btn btn-primary new-income">Nuevo Ingreso</a>
            </div>
        </div>

        <livewire:tsr-accounts-due.profiles.table/>

    </div>
</div>
@endsection
