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
            Normativa Municipal
        @endslot
    @endcomponent

    <div class="content">
        <p class="mb-4">La administración municipal presenta las regulaciones que integran el marco normativo que rige al
            municipio como
            códigos, reglamentos, manuales, etc.</p>



        <div class="row">
            <livewire:municipal-regulations.table :mode="$mode" />
        </div>
    </div>
@endsection
