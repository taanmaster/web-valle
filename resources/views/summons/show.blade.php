@extends('layouts.master')
@section('title')Intranet @endsection
@section('content')
<!-- this is breadcrumbs -->
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') Documentos @endslot
@slot('title') Particulares @endslot
@endcomponent

<div class="row layout-spacing">
    <div class="main-content">
        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $citizen->name }} {{ $citizen->first_name }} {{ $citizen->last_name }}</h5>
                        <p class="card-text"><strong>Teléfono:</strong> {{ $citizen->phone }}</p>
                        <p class="card-text"><strong>Email:</strong> {{ $citizen->email }}</p>
                        <p class="card-text"><strong>CURP:</strong> {{ $citizen->curp }}</p>

                        <hr>

                        <div class="d-flex gap-2" role="group" aria-label="Basic example">
                            <a href="{{ route('citizens.edit', $citizen->id) }}" class="btn btn-sm btn-secondary">Editar</a>
                            <form method="POST" action="{{ route('citizens.destroy', $citizen->id) }}" style="display: inline-block;">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                                <button type="submit" class="btn btn-sm btn-danger">
                                    Eliminar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Documentación del Particular</h5>

                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalCreate">
                            Carga nuevo documento
                        </button>
                    </div>

                    <div class="card-body">
                        <ul class="list-group">
                            @foreach($files as $file)
                                <li class="list-group-item">
                                    <a href="{{ asset('files/citizens/' . $file->filename) }}" target="_blank">{{ $file->name }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalCreate" tabindex="-1" role="dialog" aria-labelledby="modalCreate" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h6 class="modal-title m-0 text-white" id="modalCreate">Nuevo Documento</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div><!--end modal-header-->

            <form method="POST" action="{{ route('citizen_files.store') }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="modal-body pd-25">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="name" class="form-label">Nombre del Documento <span class="text-danger tx-12">*</span></label>
                            <select class="form-control" id="name" name="name" required>
                                <option value="Acta de nacimiento">Acta de nacimiento</option>
                                <option value="INE">INE</option>
                                <option value="Comprobante de domicilio">Comprobante de domicilio</option>
                                <option value="RFC">RFC</option>
                                <option value="Acta de defunción">Acta de defunción</option>
                                <option value="Hoja de paga funeraria">Hoja de paga funeraria</option>
                                <option value="Documentos del panteón">Documentos del panteón</option>
                                <option value="Constancia de estudios">Constancia de estudios</option>
                                <option value="Recetas médicas">Recetas médicas</option>
                                <option value="Constancia médica">Constancia médica</option>
                                <option value="Tarjetón de visita al hospital">Tarjetón de visita al hospital</option>
                            </select>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="description" class="form-label">Descripción <span class="text-info tx-12">(Opcional)</span></label>
                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="document" class="form-label">Archivo <span class="text-danger tx-12">*</span></label>
                            <input type="file" class="form-control" id="document" name="document" required>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="expiration_date" class="form-label">Vigencia <span class="text-danger tx-12">*</span></label>
                            <input type="date" class="form-control" id="expiration_date" name="expiration_date" required>
                        </div>
                        <input type="hidden" name="citizen_id" value="{{ $citizen->id }}">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-dark btn-sm">Guardar datos</button>
                </div>
            </form>
        </div><!--end modal-content-->
    </div><!--end modal-dialog-->
</div><!--end modal-->
@endsection