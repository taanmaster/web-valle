@extends('layouts.master')
@section('title')
    Ver Evento
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Medio Ambiente
        @endslot
        @slot('li_2')
            <a href="{{ route('environment_events.admin.index') }}">Calendario</a>
        @endslot
        @slot('title')
            Ver
        @endslot
    @endcomponent

    <livewire:environment-events.crud :mode="$mode" :entry="$entry" />
@endsection
