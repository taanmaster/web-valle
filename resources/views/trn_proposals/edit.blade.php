@extends('layouts.master')
@section('title')Intranet @endsection
@section('content')
<!-- this is breadcrumbs -->
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') Documentos @endslot
@slot('title') Convocatorias @endslot
@endcomponent

<div class="row layout-spacing">
    <div class="main-content">
        <div class="row">
            <div class="col-12">
                <div class="card card-body">
                    <form method="POST" action="{{ route('trn_proposals.update', $proposal->id) }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
    
                        <div class="modal-body pd-25">
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="title">Título de la Convocatoria <span class="text-danger tx-12">*</span></label>
                                    <input type="text" name="title" class="form-control" required="" autocomplete="off" value="{{ $proposal->title }}">
                                </div>
        
                                <div class="col-md-12 mb-3">
                                    <label for="description">Descripción <span class="text-danger tx-12">*</span></label>
                                    <textarea name="description" class="form-control" cols="30" rows="5" required="">{{ $proposal->description }}</textarea>
                                </div>
                                
                                <div class="col-md-12 mb-3">
                                    <label for="document">Documento <span class="text-info tx-12">(Dejar vacío si no desea cambiar el archivo)</span></label>
                                    <input type="file" name="document" class="form-control" autocomplete="off">
                                    @if($proposal->filepath)
                                        <small class="text-muted">Archivo actual: {{ $proposal->filename }}</small>
                                    @endif
                                </div>

                                <div class="col-md-12 mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="in_index" id="in_index" {{ $proposal->in_index ? 'checked' : '' }}>
                                        <label class="form-check-label" for="in_index">
                                            Visible en el Front Público
                                        </label>
                                    </div>
                                </div>
    
                                <div class="col-md-12">
                                    <div class="alert alert-info">
                                        <p class="mb-0">El documento debe ser en formato PDF, DOC, DOCX o ZIP. Tamaño máximo: 50MB.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <a href="{{ route('trn_proposals.index') }}" class="btn btn-de-secondary btn-sm">Cancelar</a>
                            <button type="submit" class="btn btn-de-dark btn-sm">Actualizar Convocatoria</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
