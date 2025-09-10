@extends('layouts.master')
@section('title')Intranet @endsection
@section('content')
<!-- this is breadcrumbs -->
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') Banners @endslot
@slot('title') Detalle de Banner @endslot
@endcomponent

<div class="row layout-spacing">
    <div class="main-content">
        <div class="row align-items-center mb-4">
            <div class="col text-start">
                <h5 class="box-title fs-5">Detalle de Banner</h5>
            </div>
            <div class="col text-end">
                <a href="{{ route('banners.edit', $banner->id ) }}" class="btn btn-primary mr-2"><i class="simple-icon-pencil"></i> Editar</a>
                <form method="POST" action="{{ route('banners.destroy', $banner->id) }}" style="display: inline-block;">
                    <button type="submit" class="btn btn-outline-danger" data-toggle="tooltip" data-original-title="Borrar">
                        <i class="simple-icon-trash"></i> Eliminar
                    </button>
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                </form>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <h4 class="mb-0">
                            Información del Banner
                            @if($banner->is_active == true)
                                <span class="badge badge-success">Activo</span>
                            @else
                                <span class="badge badge-danger">Desactivado</span>
                            @endif
                        </h4>
                        <hr>
                        <div class="row mt-5">
                            <div class="col">
                                <h5>Título</h5>
                                <p>{{ $banner->title }}</p>

                                <h5>Subtítulo</h5>
                                <p>{{ $banner->subtitle}}</p>

                                <h5>Prioridad</h5>
                                <p>{{$banner->priority}}</p>

                                <h5>Texto de botón</h5>
                                <p>{{ $banner->text_button}}</p>

                                <h5>Color</h5>
                                <p>{{ $banner->hex}}</p>
                            </div>
                            <div class="col">
                                <h5>Imagen</h5>
                                <div class="box">
                                    <p class="badge badge-primary">Identificador de base de datos: {{ $banner->id }}</p>
                                    <div class="box-body">
                                        <img class="img-fluid mb-4" src="{{ asset('front/img/banners/' . $banner->image ) }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection