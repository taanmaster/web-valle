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
            Agendas
        @endslot
        @slot('title')
            Simplificación
        @endslot
    @endcomponent

    <livewire:regulatory-agenda.crud-simplifications :simplification="$simplification" :dependency="$dependency" :mode="$mode" />
@endsection
