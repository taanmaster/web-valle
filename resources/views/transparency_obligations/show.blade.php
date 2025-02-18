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
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5>#{{ $transparency_obligation->id }} - {{ $transparency_obligation->name }}</h5>
                    </div>
                    <div class="card-body">
                        <p>{{ $transparency_obligation->description }}</p>
                        <p class="mb-0"><strong>Dependencia:</strong> {{ $transparency_obligation->dependency->name }}</p>
                        <p class="mb-0"><strong>Tipo:</strong> {{ $transparency_obligation->type }}</p>
                        <p class="mb-0"><strong>Periodo de Actualización:</strong> {{ $transparency_obligation->update_period }}</p>
                    </div>
                    
                    <div class="card-footer text-muted">
                        <div class="row">
                            <div class="col-md-12">
                                <small>Creado: {{ $transparency_obligation->created_at }}</small><br>
                                <small>Actualizado: {{ $transparency_obligation->updated_at }}</small>
                            </div>
                            <div class="col-md-12 text-right">
                                <div class="btn-group mt-4" role="group" aria-label="Basic example">
                                    <a href="{{ route('transparency_obligations.edit', $transparency_obligation->id) }}" class="btn btn-sm btn-primary me-2"><i class='bx bx-edit'></i> Editar</a>

                                    <form method="POST" action="{{ route('transparency_obligations.destroy', $transparency_obligation->id) }}" style="display: inline-block;">
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

            <div class="col-md-8">
                <div class="card card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <h4>Documentos</h4>

                        <div class="text-end">
                            <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#modalCreate" class="btn btn-primary">Nuevo Documento</a>
                        </div>
                    </div>

                    <hr>

                    @php
                        $sortedDocuments = $transparency_obligation->documents->sortBy([
                            ['year', 'desc'],
                            ['period', 'asc']
                        ]);
                    @endphp

                    @include('transparency_documents.utilities._table', ['transparency_documents' => $sortedDocuments])
                </div>
            </div>
        </div>
    </div>
</div>

@include('transparency_documents.utilities._modal', ['transparency_obligation' => $transparency_obligation])

@endsection