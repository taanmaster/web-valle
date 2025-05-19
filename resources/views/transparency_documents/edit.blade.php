@extends('layouts.master')
@section('title')
    Intranet
@endsection
@section('content')
    <!-- this is breadcrumbs -->
    @component('components.breadcrumb')
        @slot('li_1')
            Intranet
        @endslot
        @slot('li_2')
            Transparencia
        @endslot
        @slot('title')
            Documentos
        @endslot
    @endcomponent

    <div class="row layout-spacing">
        <div class="main-content">
            <div class="row">
                <div class="col-12">
                    <div class="card card-body">
                        <form method="POST" action="{{ route('transparency_documents.update', $transparency_document->id) }}"
                            enctype="multipart/form-data">
                            {{ csrf_field() }}
                            {{ method_field('PUT') }}

                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="name" class="form-label">Nombre <span
                                            class="text-danger tx-12">*</span></label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        value="{{ $transparency_document->name }}" required>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label for="description" class="form-label">Descripción <span
                                            class="text-info tx-12">(Opcional)</span></label>
                                    <textarea class="form-control" id="description" name="description" rows="3">
                                        {{ $transparency_document->description }}
                                    </textarea>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="year" class="form-label">Año <span
                                            class="text-danger tx-12">*</span></label>
                                    <input type="text" class="form-control" id="year" name="year"
                                        value="{{ $transparency_document->year }}" required>
                                </div>

                                <div class="col-md-12 mb-3">
                                    @php
                                        $periodOptions = [];
                                        $periodLabel = '';

                                        switch ($transparency_obligation->update_period) {
                                            case 'Trimestral':
                                                $periodOptions = ['1', '2', '3', '4'];
                                                $periodLabel = 'Periodo Trimestral al que pertenece:';
                                                break;
                                            case 'Anual':
                                                $periodOptions = ['1'];
                                                $periodLabel = 'Periodo Anual al que pertenece:';
                                                break;
                                            case 'Semestral':
                                                $periodOptions = ['1', '2'];
                                                $periodLabel = 'Periodo Semestral al que pertenece:';
                                                break;
                                            default:
                                                $periodOptions = ['1'];
                                                $periodLabel = 'Periodo al que pertenece:';
                                                break;
                                        }
                                    @endphp
                                    <label for="period" class="form-label">{{ $periodLabel }} <span
                                            class="text-danger tx-12">*</span></label>
                                    <select class="form-control" id="period" name="period" required>
                                        @foreach ($periodOptions as $option)
                                            <option value="{{ $option }}">{{ $option }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                @if ($transparency_document->filename == 'empty')
                                    <div class="col-md-12 mb-3">
                                        <label for="filename" class="form-label">Archivo <span
                                                class="text-danger tx-12">*</span></label>
                                        <input type="file" class="form-control" id="filename" name="filename" required>
                                    </div>
                                @endif

                                <input type="hidden" name="obligation_id" value="{{ $transparency_obligation->id }}">

                                <div class="row justify-content-end align-items-center" style="gap: 12px">
                                    @if ($transparency_document->filename != 'empty')
                                        <a href="{{ route('transparency_obligations.show', $transparency_document->obligation_id) }}"
                                            class="btn btn-secondary btn-sm" style="width: 120px">Cancelar</a>
                                    @endif
                                    <button type="submit" class="btn btn-dark btn-sm" style="width: 150px">
                                        Guardar Documento
                                    </button>
                                </div>
                            </div>
                        </form>

                        @if ($transparency_document->filename != 'empty')
                            <form action="{{ route('transparency_documents.deleteFile', $transparency_document->id) }}"
                                method="POST">
                                {{ csrf_field() }}
                                {{ method_field('PUT') }}
                                <div class="col-md-12 mb-3">
                                    <label for="current_file" class="form-label">Archivo Actual:</label>
                                    <a class="btn btn-link"
                                        href="{{ asset('files/documents/' . $transparency_document->filename) }}"
                                        target="_blank">{{ $transparency_document->filename }}</a>
                                </div>

                                <button type="submit" class="btn btn-danger btn-sm" style="width: 150px">
                                    Borrar archivo actual
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
