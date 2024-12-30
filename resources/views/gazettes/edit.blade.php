@extends('layouts.master')
@section('title')Intranet @endsection
@section('content')
<!-- this is breadcrumbs -->
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') Documentos @endslot
@slot('title') Gaceta Municipal @endslot
@endcomponent

<div class="row layout-spacing">
    <div class="main-content">
        <div class="row">
            <div class="col">
                <h2>Edición no permitida para este rol.</h2>
                <a href="{{ URL::previous() }}" class="btn btn-primary">Regresar</a>
            </div>
            
        </div>
    </div>
</div>
@endsection
