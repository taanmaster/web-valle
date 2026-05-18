@extends('layouts.master')
@section('title') Intranet @endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1') Intranet @endslot
        @slot('li_2') Apoyos Económicos @endslot
        @slot('title') Detalle del Particular @endslot
    @endcomponent

    <div class="container-fluid py-4">
        <div class="row">

            {{-- PANEL LATERAL: DATOS DEL PARTICULAR --}}
            <div class="col-md-4 col-lg-3">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <div class="text-center mb-3">
                            <div class="bg-primary bg-opacity-10 rounded-circle p-3 d-inline-flex mb-2">
                                <i class="fas fa-user fa-2x text-primary"></i>
                            </div>
                            <h5 class="fw-bold mb-0">{{ $citizen->name }} {{ $citizen->first_name }} {{ $citizen->last_name }}</h5>
                        </div>
                        <hr>
                        <ul class="list-unstyled mb-0">
                            <li class="mb-2"><i class="fas fa-phone text-muted me-2"></i>{{ $citizen->phone ?? 'Sin registro' }}</li>
                            <li class="mb-2"><i class="fas fa-envelope text-muted me-2"></i>{{ $citizen->email ?? 'Sin registro' }}</li>
                            <li class="mb-2"><i class="fas fa-id-card text-muted me-2"></i><small>{{ $citizen->curp }}</small></li>
                        </ul>
                        <hr>
                        <div class="d-flex gap-2">
                            <a href="{{ route('citizens.edit', $citizen->id) }}" class="btn btn-outline-secondary btn-sm w-100">
                                <i class="fas fa-edit me-1"></i> Editar
                            </a>
                            <form method="POST" action="{{ route('citizens.destroy', $citizen->id) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm"
                                    title="Eliminar" aria-label="Eliminar"
                                    onclick="return confirm('¿Estás seguro de eliminar este particular?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            {{-- PANEL PRINCIPAL: DOCUMENTACIÓN --}}
            <div class="col-md-8 col-lg-9">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h6 class="fw-bold mb-0">Documentación del Particular</h6>
                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalCreate">
                                <i class="fas fa-upload me-2"></i> Cargar documento
                            </button>
                        </div>

                        @if($files->count())
                            <ul class="list-group list-group-flush">
                                @foreach($files as $file)
                                    <li class="list-group-item d-flex align-items-center justify-content-between">
                                        <span><i class="fas fa-file-alt text-muted me-2"></i>{{ $file->name }}</span>
                                        <a href="{{ asset('files/citizens/' . $file->filename) }}" target="_blank"
                                            class="btn btn-outline-primary btn-sm" title="Ver documento" aria-label="Ver documento">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                                <p class="text-muted mb-0">No hay documentos cargados aún.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL NUEVO DOCUMENTO --}}
    <div class="modal fade" id="modalCreate" tabindex="-1" role="dialog" aria-labelledby="modalCreateLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h6 class="modal-title m-0" id="modalCreateLabel">Nuevo Documento</h6>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('citizen_files.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body p-4">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="doc_name" class="form-label fw-semibold">Nombre del Documento <span class="text-danger">*</span></label>
                                <select class="form-select" id="doc_name" name="name" required>
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
                                <label for="description" class="form-label fw-semibold">Descripción <span class="text-muted fw-normal">(Opcional)</span></label>
                                <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="document" class="form-label fw-semibold">Archivo <span class="text-danger">*</span></label>
                                <input type="file" class="form-control" id="document" name="document" required>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="expiration_date" class="form-label fw-semibold">Vigencia <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="expiration_date" name="expiration_date" required>
                            </div>
                            <input type="hidden" name="citizen_id" value="{{ $citizen->id }}">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i> Guardar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection