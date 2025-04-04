@extends('layouts.master')

@section('title')
    Intranet
@endsection

@section('content')
    <!-- this is breadcrumbs -->
    @component('components.breadcrumb')
        @slot('li_1')
            Intranet
        @endslot
        @slot('li_2')
            Usuarios
        @endslot
        @slot('title')
            Perfil
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-md-6">
            <h1>Hola, {{ Auth::user()->name }}</h1>
        </div>
    </div>
@endsection

@section('script')
@endsection
