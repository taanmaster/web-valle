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
                <a href="{{ route('account_due_profiles.create') }}" class="btn btn-primary new-income">Nuevo Perfil</a>
            </div>
        </div>

        <livewire:tsr-accounts-due.profiles.table/>

    </div>
</div>
@endsection
