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
            Adquisiciones
        @endslot
        @slot('title')
            Productos y servicio
        @endslot
    @endcomponent

    <div class="row layout-spacing">
        <div class="main-content">

            <div class="row justify-content-end mb-4">
                <div class="col-md-2 text-end">
                    <a href="{{ route('acquisitions.materials.create') }}" class="btn btn-primary">Ingresar producto o
                        servicio</a>
                </div>
            </div>

            <livewire:acquisitions.materials.table />
        </div>
    </div>
@endsection
