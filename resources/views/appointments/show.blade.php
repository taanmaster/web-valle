@extends('layouts.master')
@section('title') Intranet @endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1') Intranet @endslot
        @slot('li_2') Citas @endslot
        @slot('title') Detalle del Trámite @endslot
    @endcomponent

    <div class="container-fluid py-4">
        <livewire:appointments.crud :appointment="$appointment" :mode="1" />

        <div class="mt-4">
            <livewire:appointments.holidays-manager :appointment="$appointment" :hideBackButton="true" />
        </div>

        <div class="col-lg-8 mx-auto mt-3">
            <div class="d-flex justify-content-end">
                <a href="{{ route('appointments.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i> Regresar
                </a>
            </div>
        </div>
    </div>
@endsection
