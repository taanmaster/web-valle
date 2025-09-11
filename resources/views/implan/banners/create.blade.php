@extends('layouts.master')
@section('title')
    Implan
@endsection
@section('content')
    <!-- this is breadcrumbs -->
    @component('components.breadcrumb')
        @slot('li_1')
            Implan
        @endslot
        @slot('li_2')
            Banners
        @endslot
        @slot('title')
            Crear Banner
        @endslot
    @endcomponent

    <div class="row layout-spacing">
        <div class="main-content">
            <form method="POST" action="{{ route('implan.banners.store') }}" enctype="multipart/form-data">
                {{ csrf_field() }}
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
                                        <input type="text" class="form-control" id="title" name="title"
                                            value="{{ old('title') }}" required="" />
                                    </div>

                                    <div class="mb-3 col-md-4">
                                        <label for="link">Color Título <span class="text-info">(Opcional)</span></label>
                                        <input type="color" class="form-control" name="hex_text_title" />
                                    </div>

                                    <div class="mb-3 col-md-8">
                                        <label for="subtitle">Subtítulo <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="subtitle" name="subtitle"
                                            value="{{ old('subtitle') }}" required="" />
                                    </div>

                                    <div class="mb-3 col-md-4">
                                        <label for="link">Color Subtítulo <span
                                                class="text-info">(Opcional)</span></label>
                                        <input type="color" class="form-control" name="hex_text_subtitle" />
                                    </div>

                                    <div class="mb-3 col-md-12">
                                        <label for="link">Alineación del Texto <span
                                                class="text-danger">*</span></label>
                                        <select class="form-control" name="position" required>
                                            <option value="Left" selected>Izquierda</option>
                                            <option value="Center">Centro</option>
                                            <option value="Right">Derecha</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label for="text_button">Texto en el botón <span
                                                class="text-info">(Opcional)</span></label>
                                        <input type="text" class="form-control" id="text_button" name="text_button"
                                            value="{{ old('text_button') }}" />
                                    </div>

                                    <div class="mb-3 col-md-6">
                                        <label for="link">URL del botón <span
                                                class="text-info">(Opcional)</span></label>
                                        <input type="url" class="form-control" id="link" name="link"
                                            value="{{ old('link') }}" />
                                    </div>

                                    <div class="mb-3 col-md-6">
                                        <label for="link">Color texto del botón <span
                                                class="text-info">(Opcional)</span></label>
                                        <input type="color" class="form-control" name="hex_text_button" />
                                    </div>

                                    <div class="mb-3 col-md-6">
                                        <label for="text_button">Color del botón <span
                                                class="text-info">(Opcional)</span></label>
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
                                <div id="imageType" class="row">
                                    <div class="mb-3 col-md-12">
                                        <label for="image">Imagen de banner escritorio <span
                                                class="text-danger">*</span></label>
                                        <input type="file" id="image" class="form-control" name="image"
                                            onchange="loadFile(event)" required="" />
                                        <small class="d-block mt-2">Escritorio = Computadoras y Monitores grandes</small>
                                    </div>
                                    <div class="mb-3 col-md-12">
                                        <label for="image">Imagen de banner responsivo <span
                                                class="text-danger">*</span></label>
                                        <input type="file" id="image_responsive" class="form-control"
                                            name="image_responsive" onchange="loadFile(event)" required="" />
                                        <small class="d-block mt-2">Responsivo = Dispositivos móviles</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-right mt-4 mb-5">
                            <button type="submit" class="btn btn-primary btn-lg d-block w-100">Guardar Nuevo
                                Banner</button>
                            <hr>
                            <a href="{{ route('banners.index') }}" class="btn btn-secondary d-block">Cancelar</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
