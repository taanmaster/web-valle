@extends('layouts.master')
@section('title')Intranet @endsection
@section('content')
<!-- this is breadcrumbs -->
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') Transparencia @endslot
@slot('title') Dependencias @endslot
@endcomponent

<div class="row layout-spacing">
    <div class="main-content">
        <div class="row">
            <div class="col-8">
                <div class="card card-body">
                    <form method="POST" action="{{ route('transparency_dependencies.update', $transparency_dependency->id) }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="name" class="form-label">Nombre <span class="text-danger tx-12">*</span></label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ $transparency_dependency->name }}" required>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="description" class="form-label">Descripción <span class="text-info tx-12">(Opcional)</span></label>
                                <textarea class="form-control" id="description" name="description" rows="3">{{ $transparency_dependency->description }}</textarea>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="logo" class="form-label">Logo <span class="text-info tx-12">(Opcional)</span></label>
                                <input type="file" class="form-control" id="logo" name="logo">
                                @if($transparency_dependency->logo)
                                <img src="{{ asset('images/dependencies/' . $transparency_dependency->logo) }}" alt="Logo actual" class="img-thumbnail mt-2" style="width: 100px;">
                                @endif
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="image_cover" class="form-label">Imagen de Portada <span class="text-info tx-12">(Opcional)</span></label>
                                <input type="file" class="form-control" id="image_cover" name="image_cover">
                                @if($transparency_dependency->image_cover)
                                <img src="{{ asset('images/dependencies/' . $transparency_dependency->image_cover) }}" alt="Imagen de Portada actual" class="img-thumbnail mt-2" style="width: 100px;">
                                @endif
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="in_index" name="in_index" value="1" {{ $transparency_dependency->in_index ? 'checked' : '' }}>
                                    <label class="form-check-label" for="in_index">Mostrar en la página web</label>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-dark btn-sm">Guardar datos</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection