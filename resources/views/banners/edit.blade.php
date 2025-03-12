@php
    $html_tag_data = [];
    $title = 'Editar Banner';
    $description= 'Creación de Empresas'
@endphp
@extends('layout',['html_tag_data'=>$html_tag_data, 'title'=>$title, 'description'=>$description])

@section('css')
@endsection

@section('js_vendor')
@endsection

@section('js_page')
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
        <!-- Title and Top Buttons End -->

        <form method="POST" action="{{ route('banners.update', $banner->id) }}" enctype="multipart/form-data">
            {{ csrf_field() }}
            {{ method_field('PUT') }}
            <div class="row">
                <div class="col-md-8">
                    <div class="box">
                        <div class="box-body">
                            <h4>Información General</h4>
                            <hr>
                            
                            <div class="row">
                                <div class="mb-3 col-md-12">
                                    <label for="link">Mostrar en: 
                                        <span data-toggle="tooltip" data-placement="top" title="Este será el sitio web donde aparecerá este contenido."><i class="fas fa-info-circle"></i></span>
                                    </label>
                                    <select class="form-control" name="company_id" required>
                                        @foreach($companies as $company)
                                            <option {{ ($banner->company_id == $company->id) ? 'selected' : '' }} value="{{ $company->id }}">{{ $company->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3 col-md-8">
                                    <label for="link">Tipo de banner <span class="text-danger">*</span></label>
                                    <select class="form-control" name="promotional" required>
                                          <option value="0" {{ ($banner->is_promotional == '0') ? 'selected' : '' }}>Principal</option>
                                          <option value="1" {{ ($banner->is_promotional == '1') ? 'selected' : '' }}>Promocional</option>
                                    </select>
                                </div>
        
                                <div class="mb-3 col-md-4">
                                    <label for="link">Prioridad 
                                        <span data-toggle="tooltip" data-placement="top" title="Se refiere al posicionamiento que tendrá este elemento en la página web. Prioridad 1 se muestra siempre primero y prioridad 7 siempre al último. Si existen dos elementos con prioridades iguales tomará prevalencia el elemento creado más recientemente."><i class="fas fa-info-circle"></i></span>
                                    </label>
                                    <select class="form-control" name="priority" required>
                                          <option value="1" {{ ($banner->priority == '1') ? 'selected' : '' }}>1</option>
                                          <option value="2" {{ ($banner->priority == '2') ? 'selected' : '' }}>2</option>
                                          <option value="3" {{ ($banner->priority == '3') ? 'selected' : '' }}>3</option>
                                          <option value="4" {{ ($banner->priority == '4') ? 'selected' : '' }}>4</option>
                                          <option value="5" {{ ($banner->priority == '5') ? 'selected' : '' }}>5</option>
                                          <option value="6" {{ ($banner->priority == '6') ? 'selected' : '' }}>6</option>
                                          <option value="7" {{ ($banner->priority == '7') ? 'selected' : '' }}>7</option>
                                    </select>
                                </div>
        
                                <div class="mb-3 col-md-8">
                                    <label for="title">Título <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="title" name="title" value="{{ $banner->title }}" required="" />
                                </div>
        
                                <div class="mb-3 col-md-4">
                                    <label for="link">Color Título <span class="text-info">(Opcional)</span></label>
                                    <input type="color" class="form-control" name="hex_text_title" value="{{ $banner->hex_text_title }}" />
                                </div>
        
                                <div class="mb-3 col-md-8">
                                    <label for="subtitle">Subtítulo <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="subtitle" name="subtitle" value="{{ $banner->subtitle }}" required="" />
                                </div>
                                
                                <div class="mb-3 col-md-4">
                                    <label for="link">Color Subtítulo <span class="text-info">(Opcional)</span></label>
                                    <input type="color" class="form-control" name="hex_text_subtitle"  value="{{ $banner->hex_text_subtitle }}" />
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
                                    <input type="text" class="form-control" id="text_button" name="text_button"  value="{{ $banner->text_button }}"/>
                                </div> 
        
                                <div class="mb-3 col-md-6">
                                    <label for="link">URL del botón <span class="text-info">(Opcional)</span></label>
                                    <input type="url" class="form-control" id="link" name="link"  value="{{ $banner->link }}" />
                                </div>
        
                                <div class="mb-3 col-md-6">
                                    <label for="link">Color texto del botón <span class="text-info">(Opcional)</span></label>
                                    <input type="color" class="form-control" name="hex_text_button"  value="{{ $banner->hex_text_button }}" />
                                </div>
        
                                <div class="mb-3 col-md-6">
                                    <label for="text_button">Color del botón <span class="text-info">(Opcional)</span></label>
                                    <input type="color" class="form-control" name="hex_button"  value="{{ $banner->hex_button }}" />
                                </div>                        
                            </div>
                        </div>
                    </div>
                </div>
        
                <!-- Preview -->
                <div class="col-md-4">
                    <div class="box">
                        <div class="box-body">
                            <h4>Fondo</h4>
                            <hr>
        
                            <div class="row">
                                <div class="col-md-12 mb-2">
                                    <h6>Contenido Actual</h6>
        
                                    @if($banner->image != NULL)
                                         <img style="width: 100%;" src="{{ asset('img/banners/' . $banner->image ) }}" alt="{{ $banner->title }}">
                                    @endif
        
                                    @if($banner->video_background != NULL)
                                    <iframe width="100%" height="300" src="https://www.youtube.com/embed/{{ $banner->video_background }}?controls=0&autoplay=1&mute=1&modestbranding=1&showinfo=0" title="{{ $banner->title }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope"></iframe>
                                    @endif
                                </div>
                            </div>
                            <hr>
        
                            <div class="row">
                                <div class="col-md-12">
                                    <h6>Sobreescribir</h6>
                                </div>
        
                                <div class="mb-3 col-md-12">
                                    <label for="link">Tipo de Fondo </label>
                                    <select id="typeBack" class="form-control" name="type_back">
                                          <option value="Imagen" selected>Imagen</option>
                                          <option value="Video">Video</option>
                                    </select>
                                </div>
                            </div>
        
                            <div id="videoType" class="row" style="display:none;">
                                <div class="mb-3 col-md-12">
                                    <label for="link">Identificador del Video <span class="text-info">(Opcional)</span></label>
                                    <input type="text" class="form-control video-input" name="video_background" />
        
                                    <p class="mb-0 mt-2">Ejemplo:</p>
                                    <p class="example-url">https://www.youtube.com/watch?v=<span class="video-identifier">SMKP21GW083c</span></p>
                                </div>
        
                                <style type="text/css">
                                    .video-identifier{
                                        display: inline-block;
                                        padding: 3px 3px;
                                        border: 2px solid red;
                                    }
        
                                    .example-url{
                                        font-size: .8em;
                                    }
                                </style>
                                
                                <div class="mb-3 col-md-4">
                                    <label for="link">Autoplay</label>
                                    <input type="checkbox" class="form-control" name="video_autoplay" value="1" />
                                </div>
                                <div class="mb-3 col-md-4">
                                    <label for="link">Loop</label>
                                    <input type="checkbox" class="form-control" name="video_loop" value="1"/>
                                </div>
                                <div class="mb-3 col-md-4">
                                    <label for="link">Controles</label>
                                    <input type="checkbox" class="form-control" name="video_controls" value="1" />
                                </div>
                            </div>
        
                            <div id="imageType" class="row">
                                <div class="mb-3 col-md-12">
                                    <label for="image">Imagen de banner escritorio</label>
                                    <input type="file" id="image" class="form-control" name="image" onchange="loadFile(event)" />
        
                                    <small class="d-block mt-2">Escritorio = Computadoras y Monitores grandes</small>
                                </div>
                                <div class="mb-3 col-md-12">
                                    <label for="image">Imagen de banner responsivo</label>
                                    <input type="file" id="image_responsive" class="form-control"  name="image_responsive" onchange="loadFile(event)" />
        
                                    <small class="d-block mt-2">Responsivo = Dispositivos móviles</small>
                                </div>
                            </div>
                        </div>
                    </div>
        
                    <div class="text-right mt-4 mb-5">
                        <a href="{{ route('banners.index') }}" class="btn btn-default btn-lg">Cancelar</a>
                        <button type="submit" class="btn btn-primary btn-lg">Guardar Nuevo Banner</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
