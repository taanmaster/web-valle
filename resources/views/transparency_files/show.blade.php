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
        <h3>Vista vacía</h3>
    </div>
</div>
@endsection
