@extends('layouts.master')

@section('title')
    Ingresos
@endsection

@section('content')
    <!-- this is breadcrumbs -->
    @component('components.breadcrumb')
        @slot('li_1')
            Intranet
        @endslot
        @slot('li_2')
            DIF
        @endslot
        @slot('title')
            Ingresos
        @endslot
    @endcomponent

    <div class="row layout-spacing">
        <div class="main-content">
            <div class="row align-items-center mb-4">
                <div class="col text-start">
                    <a href="{{ route('dif.incomes.create') }}" class="btn btn-primary">Nuevo Ingreso</a>
                </div>
            </div>

            <livewire:d-i-f.incomes.table />
        </div>
    </div>
@endsection
