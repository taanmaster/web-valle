@extends('layouts.master')
@section('title')
    Intranet
@endsection
@section('content')
    <!-- Breadcrumbs -->
    @component('components.breadcrumb')
        @slot('li_1')
            Mejora regulatoria
        @endslot
        @slot('li_2')
            Trámites
        @endslot
        @slot('title')
            Citatorios
        @endslot
    @endcomponent

    <div class="row layout-spacing">
        <div class="main-content">
            <h4>Editar Acta</h4>

            <livewire:summons.crud :mode="$mode" :summon="$summon" />
        </div>
    </div>
@endsection
