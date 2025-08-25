@extends('layouts.master')
@section('title')Intranet @endsection
@section('content')
<!-- this is breadcrumbs -->
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') DIF @endslot
@slot('title') Editar Locación @endslot
@endcomponent

<div class="row layout-spacing">
    <div class="main-content">
        <div class="row">
            <div class="col-8">
                <div class="card card-body">
                    <form method="POST" action="{{ route('dif.locations.update', $location->id) }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="name" class="form-label">Nombre <span class="text-danger tx-12">*</span></label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ $location->name }}" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="street_name" class="form-label">Calle <span class="text-danger tx-12">*</span></label>
                                <input type="text" class="form-control" id="street_name" name="street_name" value="{{ $location->street_name }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="street_num" class="form-label">Número <span class="text-danger tx-12">*</span></label>
                                <input type="text" class="form-control" id="street_num" name="street_num" value="{{ $location->street_num }}" required>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="zip_code" class="form-label">Código Postal <span class="text-danger tx-12">*</span></label>
                                <input type="text" class="form-control" id="zip_code" name="zip_code" value="{{ $location->zip_code }}" required>
                            </div>
                            <div class="col-md-8 mb-3">
                                <label for="colony" class="form-label">Colonia <span class="text-info tx-12">(Opcional)</span></label>
                                <input type="text" class="form-control" id="colony" name="colony" value="{{ $location->colony }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">Teléfono <span class="text-info tx-12">(Opcional)</span></label>
                                <input type="text" class="form-control" id="phone" name="phone" value="{{ $location->phone }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Correo electrónico <span class="text-info tx-12">(Opcional)</span></label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ $location->email }}">
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="type" class="form-label">Tipo <span class="text-danger tx-12">*</span></label>
                                <select name="type" id="type" class="form-control">
                                    <option value="Consultorio" {{ $location->type == 'Consultorio' ? 'selected' : '' }}>Consultorio</option>
                                    <option value="Módulo Móvil" {{ $location->type == 'Módulo Móvil' ? 'selected' : '' }}>Módulo Móvil</option>
                                    <option value="Clínica" {{ $location->type == 'Clínica' ? 'selected' : '' }}>Clínica</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-dark btn-sm">Actualizar Locación</button>
                                <a href="{{ route('dif.locations.show', $location->id) }}" class="btn btn-secondary btn-sm">Cancelar</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
