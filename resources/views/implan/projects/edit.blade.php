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
            IMPLAN
        @endslot
        @slot('title')
            Proyectos
        @endslot
    @endcomponent

    <div class="row layout-spacing">
        <div class="main-content">

            <livewire:implan.projects.crud :mode="$mode" :project="$project" />

        </div>
    </div>
@endsection
