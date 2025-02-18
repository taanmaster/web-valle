@extends('layouts.master')
@section('title')Intranet @endsection
@section('content')
<!-- this is breadcrumbs -->
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') Transparencia @endslot
@slot('title') Documentos @endslot
@endcomponent

<div class="row layout-spacing">
    <div class="main-content">
        <div class="row">
            <h3>Vista Vacía</h3>
            <p>Los documentos se dan de alta desde la vista de detalle de la obligación a la que quieres que pertenezca el documento.</p>
        </div>
    </div>
</div>
@endsection
