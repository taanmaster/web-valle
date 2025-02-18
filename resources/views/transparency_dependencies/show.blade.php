@extends('layouts.master')
@section('title')Intranet @endsection
@section('content')
<!-- this is breadcrumbs -->
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') Transparencia @endslot
@slot('title') Dependencias @endslot
@endcomponent

@push('stylesheets')
<link href="https://unpkg.com/dropzone@6.0.0-beta.1/dist/dropzone.css" rel="stylesheet" type="text/css" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet" type="text/css" />

<style>
    .dropzone{
        min-height: 10rem;
        border: 3px dotted #d9d9d9;
        position: relative;
        border-radius: 15px;
        margin-bottom: 20px;
    }
</style>
@endpush

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

                <div class="card card-body">
                    <h4>Usuarios de esta Dependencia</h4>
                    <hr>

                    @foreach($transparency_dependency->users as $user)
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h6>{{ $user->name }}</h6>
                            <p>{{ $user->email }}</p>
                        </div>
                    @endforeach

                    <hr>

                    <a href="" class="btn btn-sm btn-primary">Asociar un usuario</a>
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

                    <hr>

                    @include('transparency_obligations.utilities._table', ['transparency_obligations' => $transparency_dependency->obligations])
                </div>

                <div class="card card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <h4>Repositorio de Archivos</h4>
                    </div>

                    @if($transparency_dependency->files->count() == 0)
                    <div class="alert alert-warning mb-0">Actualmente no has configurado documentos para esta dependencia.</div>
                    @endif
                    <div id="uploaded_image">

                    </div>
                    <hr>

                    <div class="col-md-12">
                        <div id="dropzoneForm" class="dropzone">
                            <div class="dz-message" data-dz-message>
                                <span>
                                    <img src="{{ asset('assets/images/illustrations/upload.svg') }}" class="me-auto ms-auto d-block" width="40%" alt="">
                                    <br>
                                    Arrastra y suelta aquí tus archivos o da click para buscar
                                </span>
                            </div>
                        </div>

                        <p class="text-bold"><small>Peso máximo por archivo: 1.5MB</small></p>

                        <div align="center">
                            <button type="button" class="btn btn-info" id="submit-all">Subir Documentos</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('transparency_obligations.utilities._modal')

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://unpkg.com/dropzone@6.0.0-beta.1/dist/dropzone-min.js"></script>

<script>
    var myDropzone = new Dropzone("#dropzoneForm", {
        url: "{{ route('dropzone.upload', $transparency_dependency->id) }}",
        headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        autoProcessQueue : false,
        parallelUploads: 20,
        acceptedFiles : ".png,.jpg,.gif,.bmp,.jpeg,.pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.txt,.zip,.rar",
        autoDiscover:false,
        maxFilesize: 2,
        addRemoveLinks: true,
        init:function(){
            var submitButton = document.querySelector("#submit-all");
            myDropzone = this;

            submitButton.addEventListener('click', function(){
                myDropzone.processQueue();
            });

            this.on("complete", function(){
                if(this.getQueuedFiles().length == 0 && this.getUploadingFiles().length == 0)
                {
                var _this = this;
                _this.removeAllFiles();
                }
                load_images();
            });

        },
    });

    load_images();

    function load_images()
    {
        $.ajax({
            url:"{{ route('dropzone.fetch', $transparency_dependency->id) }}",
            success:function(data)
            {
                $('#uploaded_image').html(data);
            }
        })
    }

    $(document).on('click', '.remove_file', function(){
        var name = $(this).attr('id');
        $.ajax({
            url:"{{ route('dropzone.delete', $transparency_dependency->id) }}",
            data:{
                name : name
            },
            success:function(data){
                load_images();
            }
        })
    });

    function copyToClipboard(elementId) {
        var copyText = document.getElementById(elementId);
        copyText.select();
        copyText.setSelectionRange(0, 99999); // For mobile devices
        document.execCommand("copy");
        alert("Ruta copiada: " + copyText.value);
    }
</script>
@endpush

@endsection