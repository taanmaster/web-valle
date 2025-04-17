@extends('layouts.master')
@section('title')
    Intranet
@endsection
@section('content')
    <!-- Breadcrumbs -->
    @component('components.breadcrumb')
        @slot('li_1')
            Tesorería
        @endslot
        @slot('li_2')
            Agenda regulatoria
        @endslot
        @slot('title')
            Detalle de la dependencia
        @endslot
    @endcomponent

    <div class="row layout-spacing">
        <div class="main-content">
            <h4>Información General</h4>

            <div class="row mb-4">
                <div class="col-md-6">
                    <p>
                        <strong>Nombre:</strong> {{ $dependency->name }}
                    </p>
                </div>
                <div class="col-md-6">
                    <p>
                        <strong>Descripción:</strong> {{ $dependency->description ?? 'N/A' }}
                    </p>
                </div>
            </div>

            <livewire:regulatory-agenda.regulations-table :dependency="$dependency" is_admin="true" />
        </div>
    </div>
@endsection
