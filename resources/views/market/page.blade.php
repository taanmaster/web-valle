{{-- Página genérica del Mercado: encabezado + componente Livewire --}}
@extends('layouts.master')
@section('title')Intranet @endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') Mercado Municipal @endslot
@slot('title') {{ $title }} @endslot
@endcomponent

<div class="row layout-spacing">
    <div class="main-content">
        @if ($heading || $action)
            <div class="d-flex justify-content-between align-items-end mb-4">
                <div>
                    @if ($eyebrow)<p class="mk-eyebrow mb-1">{{ $eyebrow }}</p>@endif
                    @if ($heading)<h4 class="mb-1">{{ $heading }}</h4>@endif
                    @if ($subtitle)<p class="text-muted mb-0">{{ $subtitle }}</p>@endif
                </div>
                @if ($action)
                    <a href="{{ $action[1] }}" @class(['btn', 'mk-btn' => str_starts_with($action[0], '+'), 'btn-outline-secondary' => ! str_starts_with($action[0], '+')])>{{ $action[0] }}</a>
                @endif
            </div>
        @endif

        @livewire($component, $params)
    </div>
</div>
@include('market._styles')
@endsection
