@extends('front.layouts.app')

@section('content')
    <div class="container py-5">
        <livewire:ayuda.guia-detalle :guia="$guia" context="front" />
    </div>
@endsection
