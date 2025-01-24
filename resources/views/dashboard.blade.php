@extends('layouts.master')
@section('title')Intranet @endsection
@section('content')
<!-- this is breadcrumbs -->
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') General @endslot
@slot('title') Vista General @endslot
@endcomponent

<div class="row">
    <div class="col-lg-12">
        <h1>Bienvenido</h1>
        <p>Esta plataforma se va actualizando conforme mas funcionalidades se crean. Si tienes un comentario externalo al equipo para tenerlo contemplado.</p>
    </div>
</div>
<!--end row-->
@endsection
@section('script')

@endsection
