@extends('layouts.master')
@section('title')Intranet @endsection
@section('content')
<!-- this is breadcrumbs -->
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') Transparencia @endslot
@slot('title') Obligaciones @endslot
@endcomponent

<div class="row layout-spacing">
    <div class="main-content">
        <div class="row">
            <h3>Vista vacía</h3>
            <p>Las obligaciones se pueden crear por medio de la ventana modal.</p>
        </div>
    </div>
</div>
@endsection
