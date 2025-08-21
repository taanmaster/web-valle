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
            Banners
        @endslot
        @slot('title')
            Editar Banner
        @endslot
    @endcomponent

    <div class="row layout-spacing">
        <div class="main-content">
            <form method="POST" action="{{ route('dif.banners.update', $banner->id) }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                <div class="row">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-body">
                                <h5>Información General</h5>
                                <hr>
                                <div class="row">
                                    <div class="mb-3 col-md-4">
                                        <label for="link">Prioridad
                                            <span data-toggle="tooltip" data-placement="top"
                                                title="Se refiere al posicionamiento que tendrá este elemento en la página web. Prioridad 1 se muestra siempre primero y prioridad 7 siempre al último. Si existen dos elementos con prioridades iguales tomará prevalencia el elemento creado más recientemente."><i
                                                    class="fas fa-info-circle"></i></span>
                                        </label>
                                        <select class="form-control" name="priority" required>
                                            <option value="1" {{ $banner->priority == '1' ? 'selected' : '' }}>1
                                            </option>
                                            <option value="2" {{ $banner->priority == '2' ? 'selected' : '' }}>2
                                            </option>
                                            <option value="3" {{ $banner->priority == '3' ? 'selected' : '' }}>3
                                            </option>
                                            <option value="4" {{ $banner->priority == '4' ? 'selected' : '' }}>4
                                            </option>
                                            <option value="5" {{ $banner->priority == '5' ? 'selected' : '' }}>5
                                            </option>
                                            <option value="6" {{ $banner->priority == '6' ? 'selected' : '' }}>6
                                            </option>
                                            <option value="7" {{ $banner->priority == '7' ? 'selected' : '' }}>7
                                            </option>
                                        </select>
                                    </div>

                                    <div class="mb-3 col-md-8">
                                        <label for="title">Título <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="title" name="title"
                                            value="{{ $banner->title }}" required="" />
                                    </div>

                                    <div class="mb-3 col-md-4">
                                        <label for="link">Color Título <span class="text-info">(Opcional)</span></label>
                                        <input type="color" class="form-control" name="hex_text_title"
                                            value="{{ $banner->hex_text_title }}" />
                                    </div>

                                    <div class="mb-3 col-md-8">
                                        <label for="subtitle">Subtítulo <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="subtitle" name="subtitle"
                                            value="{{ $banner->subtitle }}" required="" />
                                    </div>

                                    <div class="mb-3 col-md-4">
                                        <label for="link">Color Subtítulo <span
                                                class="text-info">(Opcional)</span></label>
                                        <input type="color" class="form-control" name="hex_text_subtitle"
                                            value="{{ $banner->hex_text_subtitle }}" />
                                    </div>

                                    <div class="mb-3 col-md-12">
                                        <label for="link">Alineación del Texto <span
                                                class="text-danger">*</span></label>
                                        <select class="form-control" name="position" required>
                                            <option value="Left" {{ $banner->position == 'Left' ? 'selected' : '' }}>
                                                Izquierda</option>
                                            <option value="Center" {{ $banner->position == 'Center' ? 'selected' : '' }}>
                                                Centro</option>
                                            <option value="Right" {{ $banner->position == 'Right' ? 'selected' : '' }}>
                                                Derecha</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label for="text_button">Texto en el botón <span
                                                class="text-info">(Opcional)</span></label>
                                        <input type="text" class="form-control" id="text_button" name="text_button"
                                            value="{{ $banner->text_button }}" />
                                    </div>

                                    <div class="mb-3 col-md-6">
                                        <label for="link">URL del botón <span
                                                class="text-info">(Opcional)</span></label>
                                        <input type="url" class="form-control" id="link" name="link"
                                            value="{{ $banner->link }}" />
                                    </div>

                                    <div class="mb-3 col-md-6">
                                        <label for="link">Color texto del botón <span
                                                class="text-info">(Opcional)</span></label>
                                        <input type="color" class="form-control" name="hex_text_button"
                                            value="{{ $banner->hex_text_button }}" />
                                    </div>

                                    <div class="mb-3 col-md-6">
                                        <label for="text_button">Color del botón <span
                                                class="text-info">(Opcional)</span></label>
                                        <input type="color" class="form-control" name="hex_button"
                                            value="{{ $banner->hex_button }}" />
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
                                <div id="imageType" class="row">
                                    <div class="mb-3 col-md-12">
                                        <label for="image">Imagen de banner escritorio</label>
                                        <input type="file" id="image" class="form-control" name="image"
                                            onchange="loadFile(event)" />

                                            <small class="d-block mt-2">Escritorio = Computadoras y Monitores grandes.</small>
                                            <small class="d-block mt-2">Tamaño recomendado = 1920 pixeles de ancho por 1080 pixeles de alto.</small>
                                            @if ($banner->image)
                                                <img class="img-fluid mt-2"
                                                    src="{{ asset('front/img/banners/' . $banner->image) }}"
                                                    alt="{{ $banner->title }}">
                                            @endif
                                    </div>
                                    <div class="mb-3 col-md-12">
                                        <label for="image">Imagen de banner responsivo</label>
                                        <input type="file" id="image_responsive" class="form-control"
                                            name="image_responsive" onchange="loadFile(event)" />
                                            
                                            <small class="d-block mt-2">Responsivo = Dispositivos móviles.</small>
                                            <small class="d-block mt-2">Tamaño recomendado = 720 pixeles de ancho por 1280 pixeles de alto.</small>
                                            @if ($banner->image_responsive)
                                                <img class="img-fluid mt-2"
                                                    src="{{ asset('front/img/banners/' . $banner->image_responsive) }}"
                                                    alt="{{ $banner->title }}">
                                            @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-right mt-4 mb-5">
                            <button type="submit" class="btn btn-primary btn-lg d-block w-100">Guardar Cambios</button>
                            <hr>
                            <a href="{{ route('dif.banners.index') }}" class="btn btn-secondary d-block">Cancelar</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
