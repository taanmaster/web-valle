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
            Documentos
        @endslot
        @slot('title')
            Gaceta Municipal
        @endslot
    @endcomponent

    <div class="row layout-spacing">
        <div class="main-content">
            <div class="row">
                <div class="col-8">
                    <div class="card card-body">
                        <form method="POST" action="{{ route('gazettes.update', $gazette->id) }}"
                            enctype="multipart/form-data">
                            {{ csrf_field() }}
                            {{ method_field('PUT') }}

                            <div class="modal-body pd-25">
                                <div class="row">
                                    <div class="col-md-8 mb-3">
                                        <label for="name">Título del Documento <span
                                                class="text-danger tx-12">*</span></label>
                                        <input type="text" name="name" class="form-control" required=""
                                            autocomplete="off" value="{{ $gazette->name }}">
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label for="document_number">Folio <span class="text-danger tx-12">*</span></label>
                                        <input type="text" name="document_number" class="form-control" required=""
                                            autocomplete="off" value="{{ $gazette->document_number }}">
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <label for="meeting_date">Fecha de Publicación <span
                                                class="text-danger tx-12">*</span></label>
                                        <input type="date" name="meeting_date" class="form-control" required=""
                                            autocomplete="off" value="{{ $gazette->meeting_date }}">
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <label for="type">Tipo de sesión y/o Documentos publicados <span
                                                class="text-danger tx-12">*</span></label>
                                        <select class="form-control" name="type" required>
                                            <option value="solemn">Sesiones Solemnes</option>
                                            <option value="ordinary">Sesiones Ordinarias</option>
                                            <option value="extraordinary">Sesiones Extraordinarias</option>
                                            <option value="document">Documentos publicados H. Ayuntamiento</option>
                                        </select>
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <label for="description">Descripción Breve <span
                                                class="text-info tx-12">(Opcional)</span></label>
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
                                            <p class="mb-0">El documento debe ser en formato PDF, puedes agregar archivos
                                                adicionales más adelante.</p>
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
                            Documentos <a data-bs-toggle="modal" data-bs-target="#modalNuevoArchivo" href="#"
                                class="btn btn-link mb-0"><i class="fas fa-plus"></i> Nuevo</a>

                            <!-- Modal Crear Nuevo -->
                            <div class="modal fade" id="modalNuevoArchivo" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Subir Nuevo Archivo</h5>
                                            <button type="button" class="close" data-bs-dismiss="modal"
                                                aria-label="Close">
                                            </button>
                                        </div>

                                        <form id="gazetteFileForm" method="POST" action="{{ route('gazette_files.store') }}"
                                            enctype="multipart/form-data">
                                            {{ csrf_field() }}
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="form-group col-md-12">
                                                        <label>Nombre</label>
                                                        <input class="form-control" type="text" name="name"
                                                            required="">
                                                    </div>

                                                    <div class="form-group col-md-12">
                                                        <label>Descripción (Opcional)</label>
                                                        <textarea class="form-control" name="description" rows="3"></textarea>
                                                    </div>

                                                    <div class="form-group col-md-12">
                                                        <label class="form-label">Archivo</label>
                                                        <input id="gazette_file_document" type="file" class="form-control" name="document"
                                                            required="">
                                                    </div>

                                                    <div id="gazette_file_upload_progress" class="col-md-12 mt-2" style="display: none;">
                                                        <div class="progress">
                                                            <div id="gazette_file_upload_progress_bar" class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%"></div>
                                                        </div>
                                                        <small id="gazette_file_upload_status" class="text-muted">Preparando subida...</small>
                                                    </div>

                                                    <input type="hidden" name="gazette_id" value="{{ $gazette->id }}"
                                                        required="">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Cerrar</button>
                                                <button id="gazette_file_submit" type="submit" class="btn btn-primary">Guardar Cambios</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>
                        @if ($gazette->files->count() == null || $gazette->files->count() == 0)
                            <h4 class="text-center">No hay documentos para esta Gaceta</h4>
                        @else
                            @foreach ($gazette->files as $file)
                                <div class="card file-card">
                                    <div class="dropdown">
                                        <a href="javascript:void(0)" data-bs-toggle="dropdown"
                                            class="btn btn-sm btn-outline-secondary" aria-expanded="false">Opciones</a>

                                        <div class="dropdown-menu dropdown-menu-right" x-placement="top-end"
                                            style="position: absolute; transform: translate3d(-181px, -158px, 0px); top: 0px; left: 0px; will-change: transform;">
                                            @if ($file->s3_asset_url != null)
                                                <a target="_blank" href="{{ $file->s3_asset_url }}"
                                                    class="dropdown-item">Descargar </a>
                                            @else
                                                <a target="_blank"
                                                    href="{{ asset('files/gazettes/' . $file->filename) }}"
                                                    class="dropdown-item">Descargar </a>
                                            @endif

                                            <a href="#" data-bs-toggle="modal"
                                                data-bs-target="#modalSubirArchivo_{{ $file->id }}"
                                                class="dropdown-item">Actualizar </a>
                                            <div class="dropdown-divider"></div>

                                            <form method="POST"
                                                action="{{ route('gazette_files.destroy', $file->id) }}">
                                                <button type="submit"class="dropdown-item text-danger">
                                                    Eliminar
                                                </button>
                                                {{ csrf_field() }}
                                                {{ method_field('DELETE') }}
                                            </form>
                                        </div>
                                    </div>

                                    <div class="card-body">
                                        @if ($file->file_extension == 'pdf')
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
                                    <p class="filename"><a target="_blank"
                                            href="{{ asset('files/gazettes/' . $file->filename) }}">{{ $file->filename }}</a>
                                    </p>
                                    <hr>
                                    <p class="upload-time">Subido: {{ $file->created_at }}</p>
                                </div>
                    </div>
                    @endforeach
                    @endif

                    @foreach ($gazette->files as $file)
                        <!-- Modal Subir Archivo-->
                        <div class="modal fade" id="modalSubirArchivo_{{ $file->id }}" tabindex="-1"
                            role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Actualizar {{ $file->name }}
                                        </h5>
                                        <button type="button" class="close" data-bs-dismiss="modal"
                                            aria-label="Close">

                                        </button>
                                    </div>

                                    <form method="POST" action="{{ route('gazette_files.update', $file->id) }}"
                                        enctype="multipart/form-data">
                                        {{ csrf_field() }}
                                        {{ method_field('PUT') }}
                                        <div class="modal-body">
                                            <div class="row">
                                                <input type="hidden" name="name" value="{{ $file->name }}">

                                                <div class="form-group col-md-12">
                                                    <label class="form-label">Archivo</label>
                                                    <input type="file" class="form-control" name="file"
                                                        required="">
                                                </div>

                                                <div class="form-group col-md-12">
                                                    <label>Descripción (Opcional)</label>
                                                    <textarea class="form-control" name="description" rows="3"></textarea>
                                                </div>

                                                <input type="hidden" name="account_id" value="{{ $gazette->id }}"
                                                    required="">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Cerrar</button>
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('gazetteFileForm');
            const fileInput = document.getElementById('gazette_file_document');
            const submitButton = document.getElementById('gazette_file_submit');
            const progressContainer = document.getElementById('gazette_file_upload_progress');
            const progressBar = document.getElementById('gazette_file_upload_progress_bar');
            const status = document.getElementById('gazette_file_upload_status');
            const chunkSize = 2 * 1024 * 1024;
            const largeFileThreshold = 8 * 1024 * 1024;

            form.addEventListener('submit', async function(event) {
                const file = fileInput.files[0];
                if (!file || file.size <= largeFileThreshold) {
                    return;
                }

                event.preventDefault();
                submitButton.disabled = true;
                progressContainer.style.display = 'block';

                try {
                    setProgress(0, 'Inicializando subida...');
                    const initResult = await postForm('{{ route('gazette_files.init-chunk-upload') }}', {
                        gazette_id: form.querySelector('[name="gazette_id"]').value,
                        name: form.querySelector('[name="name"]').value,
                        description: form.querySelector('[name="description"]').value,
                        filename: file.name,
                        filesize: file.size,
                        chunk_size: chunkSize,
                    });

                    for (let chunkNumber = 0; chunkNumber < initResult.total_chunks; chunkNumber++) {
                        const start = chunkNumber * chunkSize;
                        const chunk = file.slice(start, Math.min(start + chunkSize, file.size));
                        const data = new FormData();
                        data.append('_token', form.querySelector('[name="_token"]').value);
                        data.append('upload_id', initResult.upload_id);
                        data.append('chunk_number', chunkNumber);
                        data.append('chunk', chunk, 'chunk_' + chunkNumber);
                        await sendRequest('{{ route('gazette_files.upload-chunk') }}', data);
                        setProgress(Math.round((chunkNumber + 1) / initResult.total_chunks * 90),
                            'Subiendo fragmento ' + (chunkNumber + 1) + ' de ' + initResult.total_chunks + '...');
                    }

                    setProgress(95, 'Guardando archivo...');
                    await postForm('{{ route('gazette_files.finalize-chunk-upload') }}', {
                        upload_id: initResult.upload_id,
                    });
                    setProgress(100, 'Archivo subido correctamente.');
                    window.location.reload();
                } catch (error) {
                    setProgress(0, error.message || 'No se pudo subir el archivo.');
                    submitButton.disabled = false;
                }
            });

            async function postForm(url, values) {
                const data = new FormData();
                data.append('_token', form.querySelector('[name="_token"]').value);
                Object.keys(values).forEach(function(key) {
                    data.append(key, values[key]);
                });

                return sendRequest(url, data);
            }

            async function sendRequest(url, data) {
                const response = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    body: data,
                });
                const result = await response.json().catch(function() { return {}; });

                if (!response.ok || !result.success) {
                    throw new Error(result.error || result.message || 'No se pudo completar la subida.');
                }

                return result;
            }

            function setProgress(percent, message) {
                progressBar.style.width = percent + '%';
                progressBar.setAttribute('aria-valuenow', percent);
                status.textContent = message;
            }
        });
    </script>
@endsection
