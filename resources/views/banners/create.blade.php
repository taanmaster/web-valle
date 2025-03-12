@php
    $html_tag_data = [];
    $title = 'Crear Banner';
    $description= 'Creación de Empresas'
@endphp
@extends('layout',['html_tag_data'=>$html_tag_data, 'title'=>$title, 'description'=>$description])

@section('css')
@endsection

@section('js_vendor')
@endsection

@section('js_page')
<script>
    $('#typeBack').on('change', function(e){
        event.preventDefault();

        var value = $('#typeBack option:selected').attr('value');

        $('#videoType').hide();
        $('#imageType').hide();

        $('#videoType .form-control').attr('required', false);
        $('#imageType .form-control').attr('required', false);

        if(value == 'Imagen'){
            $('#imageType').show();
            $('#imageType .form-control').attr('required', true);
        }

        if(value == 'Video'){
            $('#videoType').show();
            $('#videoType .video-input').attr('required', true);
        }
    });
</script>
@endsection

@section('content')
    <div class="col">
        <!-- Title and Top Buttons Start -->
        <div class="page-title-container mb-3">
            <div class="row">
                <!-- Title Start -->
                <div class="col mb-2">
                    <h1 class="mb-2 pb-0 display-4" id="title">{{ $title }}</h1>
                    <div class="text-muted font-heading text-small">Let us manage the database engines for your applications so you can focus on building.</div>
                </div>
                <!-- Title End -->
            </div>
        </div>
        
        <form method="POST" action="{{ route('banners.store') }}" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="row">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-body">
                                <h5>Información General</h5>
                                <hr>
                                
                                <div class="row">
                                    <div class="mb-3 col-md-8">
                                        <label for="link">Mostrar en: 
                                            <span data-toggle="tooltip" data-placement="top" title="Este será el sitio web donde aparecerá este contenido."><i class="fas fa-info-circle"></i></span>
                                        </label>
                                        <select class="form-control" name="company_id" required>
                                            @foreach($companies as $company)
                                                <option value="{{ $company->id }}">{{ $company->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                    {{-- 
                                    <div class="mb-3 col-md-8">
                                        <label for="link">Tipo de banner <span class="text-danger">*</span></label>
                                        <select class="form-control" name="promotional" required>
                                            <option value="0" selected>Principal</option>
                                        </select>
                                    </div>
                                     --}}

                                    <div class="mb-3 col-md-4">
                                        <label for="link">Prioridad 
                                            <span data-toggle="tooltip" data-placement="top" title="Se refiere al posicionamiento que tendrá este elemento en la página web. Prioridad 1 se muestra siempre primero y prioridad 7 siempre al último. Si existen dos elementos con prioridades iguales tomará prevalencia el elemento creado más recientemente."><i class="fas fa-info-circle"></i></span>
                                        </label>
                                        <select class="form-control" name="priority" required>
                                            <option value="1" selected>1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                            <option value="6">6</option>
                                            <option value="7">7</option>
                                        </select>
                                    </div>

                                    <div class="mb-3 col-md-8">
                                        <label for="title">Título <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" required="" />
                                    </div>

                                    <div class="mb-3 col-md-4">
                                        <label for="link">Color Título <span class="text-info">(Opcional)</span></label>
                                        <input type="color" class="form-control" name="hex_text_title" />
                                    </div>

                                    <div class="mb-3 col-md-8">
                                        <label for="subtitle">Subtítulo <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="subtitle" name="subtitle" value="{{ old('subtitle') }}" required="" />
                                    </div>

                                    <div class="mb-3 col-md-4">
                                        <label for="link">Color Subtítulo <span class="text-info">(Opcional)</span></label>
                                        <input type="color" class="form-control" name="hex_text_subtitle" />
                                    </div>

                                    <div class="mb-3 col-md-12">
                                        <label for="link">Alineación del Texto <span class="text-danger">*</span></label>
                                        <select class="form-control" name="position" required>
                                            <option value="Left" selected>Izquierda</option>
                                            <option value="Center">Centro</option>
                                            <option value="Right">Derecha</option>
                                        </select>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label for="text_button">Texto en el botón <span class="text-info">(Opcional)</span></label>
                                        <input type="text" class="form-control" id="text_button" name="text_button" value="{{ old('text_button') }}"/>
                                    </div> 

                                    <div class="mb-3 col-md-6">
                                        <label for="link">URL del botón <span class="text-info">(Opcional)</span></label>
                                        <input type="url" class="form-control" id="link" name="link" value="{{ old('link') }}" />
                                    </div>

                                    <div class="mb-3 col-md-6">
                                        <label for="link">Color texto del botón <span class="text-info">(Opcional)</span></label>
                                        <input type="color" class="form-control" name="hex_text_button" />
                                    </div>

                                    <div class="mb-3 col-md-6">
                                        <label for="text_button">Color del botón <span class="text-info">(Opcional)</span></label>
                                        <input type="color" class="form-control" name="hex_button" />
                                    </div>                        
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Preview -->
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h5>Fondo</h5>
                                <hr>

                                {{--  
                                <div class="row">
                                    <div class="mb-3 col-md-12">
                                        <label for="link">Tipo de Fondo <span class="text-danger">*</span></label>
                                        <select id="typeBack" class="form-control" name="type_back" required>
                                            <option value="Imagen" selected>Imagen</option>
                                            <option value="Video">Video</option>
                                        </select>
                                    </div>
                                </div>
                                --}}


                                <div id="imageType" class="row">
                                    <div class="mb-3 col-md-12">
                                        <label for="image">Imagen de banner escritorio <span class="text-danger">*</span></label>
                                        <input type="file" id="image" class="form-control" name="image" onchange="loadFile(event)" required="" />

                                        <small class="d-block mt-2">Escritorio = Computadoras y Monitores grandes</small>
                                    </div>
                                    <div class="mb-3 col-md-12">
                                        <label for="image">Imagen de banner responsivo <span class="text-danger">*</span></label>
                                        <input type="file" id="image_responsive" class="form-control"  name="image_responsive" onchange="loadFile(event)" required="" />

                                        <small class="d-block mt-2">Responsivo = Dispositivos móviles</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-right mt-4 mb-5">
                            <button type="submit" class="btn btn-primary btn-lg d-block w-100">Guardar Nuevo Banner</button>
                            <hr>
                            <a href="{{ route('banners.index') }}" class="btn btn-secondary d-block">Cancelar</a>
                        </div>
                    </div>
                
            </div>
        </form>
    </div>
@endsection
