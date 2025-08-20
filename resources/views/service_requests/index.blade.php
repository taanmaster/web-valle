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
            Mejora regulatoria
        @endslot
        @slot('title')
            Trámites y servicios
        @endslot
    @endcomponent

    <div class="content">
        <div class="row">
            <livewire:service-requests.table :mode="$mode" />
        </div>
    </div>
@endsection
