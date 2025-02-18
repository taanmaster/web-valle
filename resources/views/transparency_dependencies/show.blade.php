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
            <div class="col-4">
                <div class="card">
                    <div class="card-header">
                        <h5>#{{ $transparency_dependency->id }} - {{ $transparency_dependency->name }}</h5>
                    </div>
                    <div class="card-body">
                        <p>{{ $transparency_dependency->description }}</p>
                    </div>
                    <div class="card-footer text-muted">
                        <div class="row">
                            <div class="col-md-12">
                                <small>Creado: {{ $transparency_dependency->created_at }}</small><br>
                                <small>Actualizado: {{ $transparency_dependency->updated_at }}</small>
                            </div>
                            <div class="col-md-12">
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <form method="POST" action="{{ route('transparency_dependencies.destroy', $transparency_dependency->id) }}" style="display: inline-block;">
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class='bx bx-trash-alt'></i> Eliminar
                                        </button>
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-8">
                <div class="card card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <h4>Obligaciones</h4>

                        <div class="text-end">
                            <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#modalCreate" class="btn btn-primary">Nueva Obligación</a>
                        </div>
                    </div>
                </div>

                <div class="card card-body">
                    <h4>Repositorio de Archivos</h4>
                </div>
            </div>
        </div>
    </div>
</div>

@include('transparency_obligations.utilities._modal')

@endsection
