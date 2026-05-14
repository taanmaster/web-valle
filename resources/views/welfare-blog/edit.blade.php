@extends('layouts.master')
@section('title') Editar Entrada @endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1') Bienestar Laboral @endslot
        @slot('li_2') Blog @endslot
        @slot('title') Editar @endslot
    @endcomponent
    <livewire:general-blog.crud :mode="$mode" :entry="$entry" :type="'welfare'" />
@endsection
