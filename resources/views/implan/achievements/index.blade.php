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
            Implan
        @endslot
        @slot('title')
            Logros
        @endslot
    @endcomponent

    <div class="row layout-spacing">
        <div class="main-content">

            <div class="row justify-content-end">
                <div class="col-md-3 text-end">
                    <a href="{{ route('implan.achievements.create') }}" class="btn btn-primary btn-sm">Nuevo Logro</a>
                </div>
            </div>
            <livewire:implan.achievements.table />
        </div>
    </div>
@endsection
