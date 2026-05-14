@extends('layouts.master')
@section('title') Ver Entrada @endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1') Bienestar Laboral @endslot
        @slot('li_2') Blog @endslot
        @slot('title') Ver @endslot
    @endcomponent
    <livewire:welfare-blog.crud :mode="$mode" :entry="$entry" />
@endsection
