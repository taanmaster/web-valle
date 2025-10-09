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
            Mejora regulatoría
        @endslot
        @slot('title')
            Registro Municipal de Inspecciones, Verificaciones y Visitas Domiciliarias
        @endslot
    @endcomponent

    <div class="content">


        <div class="row">
            <livewire:municipal-inspection.table :mode="$mode" />
        </div>
    </div>
@endsection
