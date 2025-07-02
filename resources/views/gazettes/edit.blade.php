@extends('layouts.master')
@section('title')Intranet @endsection
@section('content')
<!-- this is breadcrumbs -->
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') Documentos @endslot
@slot('title') Gaceta Municipal @endslot
@endcomponent

<div class="row layout-spacing">
    <div class="main-content">
        <div class="row">
            <div class="col-8">
                <div class="card card-body">
                    <form method="POST" action="{{ route('gazettes.update', $gazette->id) }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
    
                        <div class="modal-body pd-25">
                            <div class="row">
                                <div class="col-md-8 mb-3">
                                    <label for="name">Título del Documento  <span class="text-danger tx-12">*</span></label>
                                    <input type="text" name="name" class="form-control" required="" autocomplete="off" value="{{ $gazette->name }}">
                                </div>
        
                                <div class="col-md-4 mb-3">
                                    <label for="document_number">Folio <span class="text-danger tx-12">*</span></label>
                                    <input type="text" name="document_number" class="form-control" required="" autocomplete="off" value="{{ $gazette->document_number }}">
                                </div>
        
                                <div class="col-md-12 mb-3">
                                    <label for="meeting_date">Fecha de Publicación  <span class="text-danger tx-12">*</span></label>
                                    <input type="date" name="meeting_date" class="form-control" required="" autocomplete="off" value="{{ $gazette->meeting_date }}">
                                </div>
        
                                <div class="col-md-12 mb-3">
                                    <label for="type">Tipo de Sesión <span class="text-danger tx-12">*</span></label>
                                    <select class="form-control" name="type" required>
                                        <option value="solemn">Sesiones Solemnes</option>
                                        <option value="ordinary">Sesiones Ordinarias</option>
                                        <option value="extraordinary">Sesiones Extraordinarias</option>
                                    </select>
                                </div>
        
                                <div class="col-md-12 mb-3">
                                    <label for="description">Descripción Breve <span class="text-info tx-12">(Opcional)</span></label>
                                    <textarea name="description" class="form-control" cols="30" rows="5">{{ $gazette->description }}</textarea>
                                </div>
                                
                                {{--  
                                <div class="col-md-12 mb-3">
                                    <label for="document">Documento <span class="text-danger tx-12">*</span></label>
                                    <input type="file" name="document" class="form-control" required="" autocomplete="off" >
                                </div>
                                --}}
    
                                <div class="col-md-12">
                                    <div class="alert alert-info">
                                        <p class="mb-0">El documento debe ser en formato PDF, puedes agregar archivos adicionales más adelante.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <a href="{{ URL::previous() }}" class="btn btn-de-secondary btn-sm">Cancelar</a>
                            <button type="submit" class="btn btn-de-dark btn-sm">Guardar datos</button>
                        </div>
                    </form>
                </div>
                
            </div>

            <div class="col-md-4">
                <div class="card card-body">
                    <div class="card-header">
                        Documentos <a data-bs-toggle="modal" data-bs-target="#modalNuevoArchivo" href="#" class="btn btn-link mb-0"><i class="fas fa-plus"></i> Nuevo</a>
        
                        <!-- Modal Crear Nuevo -->
                        <div class="modal fade" id="modalNuevoArchivo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Subir Nuevo Archivo</h5>
                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                        </button>
                                    </div>
        
                                    <form method="POST" action="{{ route('gazette_files.store') }}" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="form-group col-md-12">
                                                    <label>Nombre</label>
                                                    <input class="form-control" type="text" name="name" required="">
                                                </div>
        
                                                <div class="form-group col-md-12">
                                                    <label>Descripción (Opcional)</label>
                                                    <textarea class="form-control" name="description" rows="3"></textarea>
                                                </div>
        
                                                <div class="form-group col-md-12">
                                                    <label class="form-label">Archivo</label>
                                                    <input type="file" class="form-control" name="document" required="">
                                                </div>
        
                                                <input type="hidden" name="gazette_id" value="{{ $gazette->id }}" required="">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>
                    @if($gazette->files->count() == NULL || $gazette->files->count() == 0)
					    <h4 class="text-center">No hay documentos para esta Gaceta</h4>
				    @else
                        @foreach($gazette->files as $file)
                            <div class="card file-card">
                                <div class="dropdown">
                                    <a href="javascript:void(0)" data-bs-toggle="dropdown" class="btn btn-sm btn-outline-secondary" aria-expanded="false">Opciones</a>

                                    <div class="dropdown-menu dropdown-menu-right" x-placement="top-end" style="position: absolute; transform: translate3d(-181px, -158px, 0px); top: 0px; left: 0px; will-change: transform;">
                                        @if($file->s3_asset_url != null)
                                        <a target="_blank" href="{{ $file->s3_asset_url }}" class="dropdown-item">Descargar </a>
                                        @else
                                        <a target="_blank" href="{{ asset('files/gazettes/' . $file->filename ) }}" class="dropdown-item">Descargar </a>
                                        @endif
                                        
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#modalSubirArchivo_{{ $file->id }}" class="dropdown-item">Actualizar </a>
                                        <div class="dropdown-divider"></div>

                                        <form method="POST" action="{{ route('gazette_files.destroy', $file->id) }}">
                                            <button type="submit"class="dropdown-item text-danger">
                                                Eliminar
                                            </button>
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                        </form>
                                    </div>
                                </div>

                                <div class="card-body">
                                    @if($file->file_extension == 'pdf')
                                    <div class="pdf-color">
                                    @elseif($file->file_extension == 'png' || $file->file_extension == 'jpg' || $file->file_extension == 'jpeg')
                                    <div class="image-color">
                                    @elseif($file->file_extension == 'xls' || $file->file_extension == 'xlsx')
                                    <div class="excel-color">
                                    @elseif($file->file_extension == 'docx' || $file->file_extension == 'doc')
                                    <div class="word-color">
                                    @else
                                    <div class="default-color">
                                    @endif
                                        <div class="file-icon">
                                            <i class="far fa-file"></i>
                                            <span class="filename">{{ $file->file_extension }}</span>
                                        </div>
                                    </div>

                                    <h5>{{ $file->name }}</h5>
                                    <p class="filename"><a target="_blank" href="{{ asset('files/gazettes/' . $file->filename ) }}">{{ $file->filename }}</a></p>
                                    <hr>
                                    <p class="upload-time">Subido: {{ $file->created_at }}</p>
                                </div>
                            </div>
                        @endforeach
				    @endif

                    @foreach($gazette->files as $file)
                    <!-- Modal Subir Archivo-->
                    <div class="modal fade" id="modalSubirArchivo_{{ $file->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Actualizar {{ $file->name }}</h5>
                                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">

                                    </button>
                                </div>

                                <form method="POST" action="{{ route('gazette_files.update', $file->id) }}" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                {{ method_field('PUT') }}
                                    <div class="modal-body">
                                        <div class="row">
                                            <input type="hidden" name="name" value="{{ $file->name }}">

                                            <div class="form-group col-md-12">
                                                <label class="form-label">Archivo</label>
                                                <input type="file" class="form-control" name="file" required="">
                                            </div>

                                            <div class="form-group col-md-12">
                                                <label>Descripción (Opcional)</label>
                                                <textarea class="form-control" name="description" rows="3"></textarea>
                                            </div>
                            
                                            <input type="hidden" name="account_id" value="{{ $gazette->id }}" required="">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                        <button type="submit" class="btn btn-primary">Subir Archivo</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
