@extends('layouts.master')

@section('title')
    Salidas
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
            Salidas
        @endslot
    @endcomponent

    <div class="row layout-spacing">
        <div class="main-content">
            <div class="row align-items-center mb-4">
                <div class="col text-start">
                    <a href="{{ route('dif.expenses.create') }}" class="btn btn-primary">Nueva Salida</a>
                </div>
            </div>

            <livewire:d-i-f.expenses.table />


        </div>
    </div>
@endsection
