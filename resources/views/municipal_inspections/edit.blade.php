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
            Normativa municipal
        @endslot
        @slot('title')
            Regulación
        @endslot
    @endcomponent

    <div class="row layout-spacing">
        <div class="main-content">
            <h4>Editar Regulación</h4>

            <livewire:municipal-inspection.crud :mode="$mode" :inspection="$inspection" />
        </div>
    </div>
@endsection
