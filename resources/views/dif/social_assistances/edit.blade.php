@extends('layouts.master')
@section('title')Intranet @endsection
@section('content')
<!-- this is breadcrumbs -->
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') DIF @endslot
@slot('title') Editar Apoyo Social @endslot
@endcomponent

<div class="row layout-spacing">
    <div class="main-content">
        <div class="row">
            <div class="col-8">
                <div class="card card-body">
                    <form method="POST" action="{{ route('dif.social_assistances.update', $assistance->id) }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="name" class="form-label">Nombre del Apoyo <span class="text-danger tx-12">*</span></label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ $assistance->name }}" required>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="description" class="form-label">Descripción <span class="text-info tx-12">(Opcional)</span></label>
                                <textarea class="form-control" id="description" name="description" rows="4">{{ $assistance->description }}</textarea>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="value" class="form-label">Valor / Monto <span class="text-info tx-12">(Opcional)</span></label>
                                <input type="text" class="form-control" id="value" name="value" value="{{ $assistance->value }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-check mt-3">
                                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" {{ $assistance->is_active ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">
                                        Activo
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-dark btn-sm">Actualizar Servicio</button>
                                <a href="{{ route('dif.services.show', $service->id) }}" class="btn btn-secondary btn-sm">Cancelar</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
