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
            Dependencia
        @endslot
        @slot('title')
            Regulaciones propuestas
        @endslot
    @endcomponent

    <livewire:regulatory-agenda.crud-regulations :regulation="$regulation" :dependency="$dependency" />
@endsection
