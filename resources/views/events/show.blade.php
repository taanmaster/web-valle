@extends('layouts.master')
@section('title')Intranet @endsection
@section('content')
<!-- this is breadcrumbs -->
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') Eventos @endslot
@slot('title') Detalle de Evento @endslot
@endcomponent

<div class="row layout-spacing">
    <div class="main-content">
        <div class="row align-items-center mb-4">
            <div class="col text-start">
                <h5 class="box-title fs-5">Detalle de Evento</h5>
            </div>
            <div class="col text-end">
                <a href="{{ route('events.edit', $event->id ) }}" class="btn btn-primary mr-2"><i class="simple-icon-pencil"></i> Editar</a>
                <form method="POST" action="{{ route('events.destroy', $event->id) }}" style="display: inline-block;">
                    <button type="submit" class="btn btn-outline-danger" data-toggle="tooltip" data-original-title="Borrar">
                        <i class="simple-icon-trash"></i> Eliminar
                    </button>
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                </form>
            </div>
        </div>

        <div class="row">
        </div>
    </div>
</div>
@endsection