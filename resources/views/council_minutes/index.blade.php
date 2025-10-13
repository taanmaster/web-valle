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
            Actas de Consejo
        @endslot
    @endcomponent

    <div class="content">


        <div class="row">
            <livewire:council-minute.table :mode="$mode" />
        </div>
    </div>
@endsection
