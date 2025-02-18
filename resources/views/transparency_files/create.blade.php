@extends('layouts.master')
@section('title')Intranet @endsection
@section('content')
<!-- this is breadcrumbs -->
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') Transparencia @endslot
@slot('title') Repositorio @endslot
@endcomponent

<div class="row layout-spacing">
    <div class="main-content">
        <div class="row">
            <h3>Vista Vacía</h3>
            <p>Los archivos del repositorio se dan de alta desde la vista de detalle de la dependencia a la que quieres que pertenezcan.</p>
        </div>
    </div>
</div>
@endsection
