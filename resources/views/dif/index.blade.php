@extends('layouts.master')

@section('title')Intranet @endsection

@section('content')
    <!-- this is breadcrumbs -->
    @component('components.breadcrumb')
        @slot('li_1') Intranet @endslot
        @slot('li_2') DIF @endslot
        @slot('title') Pantalla Inicial @endslot
    @endcomponent

    <div class="row">
        <div class="col-md-6">
            <h1>Hola, {{ Auth::user()->name }}</h1>
            <p>Esta es la pantalla del DIF</p>
        </div>
    </div>
@endsection

@section('script')

@endsection
