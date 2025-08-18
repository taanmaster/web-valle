@extends('front.layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center mb-4">
            <div class="col-md-12">
                <div class="card card-image card-image-banner wow fadeInUp">
                    <img class="card-img-top" src="{{ asset('front/img/placeholder-5.jpg') }}" alt="">
                    <div class="overlay"></div>
                    <div class="card-content">
                        <p class="mb-0">Bienvenido</p>
                        <h2>Desarrollo Urbano</h2>
                        <p>del H. Ayuntamiento de Valle de Santiago, Guanajuato.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            @php
                $tramites = [
                    ['name' => 'Licencia de Uso de suelo', 'class' => 'info', 'law' => 'Lo anterior de conformidad con lo establecido en los Artículos 256, 257, 258, 259, 261, 262 y 264 del código territorial para el estado y los municipios de guanajuato y artículo 24 fracc Vll inc. B y C de la Ley de Ingresos para el municipio de Valle de Santiago, Gto. 2024', 'route' => route('urban_dev.show', ['tramite' => 'uso-de-suelo'])],
                    ['name' => 'Constancia de factibilidad', 'class' => 'warning', 'law' => 'Lo anterior de conformidad con lo establecido en los Artículos 253, 254y 255 del código territorial para el estado y los municipios de guanajuato y artículo 28 fracc lll de la Ley de Ingresos para el municipio de Valle de Santiago, Gto. 2024', 'route' => route('urban_dev.show', ['tramite' => 'constancia-de-factibilidad'])],
                    ['name' => 'Permiso de anuncios y toldos', 'class' => 'primary', 'law' => 'Lo anterior de conformidad con lo establecido en los Articulos 168, 169, 170, 171, 172, 173, 174, 175, 176, 177, 178, 179, 180, 181, 182 y 183 del Reglamento de construcción de Valle de Santiago, Gto y artículo 27 fracc VII inc, B y C de la Ley de Ingresos para el municipio de Valle de Santiago, Gto, 2024', 'route' => route('urban_dev.show', ['tramite' => 'permiso-de-anuncios'])],
                    ['name' => 'Certificación de No. oficial constancia de alineamiento', 'class' => 'dark', 'law' => 'Lo anterior de conformidad con lo establecido en los art. 68 y 72 Reglamento de Construcción y Fisionomía para el Municipio de Valle de Sgto; Gto. Cost art. 24 fracc. X y fracc. XIII de la Ley de ingresos para el municipio de Valle de Santiago, Gto. 2024', 'route' => route('urban_dev.show', ['tramite' => 'certificacion-numero-oficial'])],
                    ['name' => 'Permiso de división', 'class' => 'success', 'law' => 'Lo anterior con fundamento en los Art. 2, Fracc. XVIII, Art. 35, Fracc III, Art. 395, Art 397 Y Art. 398 Del Código Territorial para el Estado y sus Municipios de Guanajuato. Art 24, Fracc. VI de la Ley de Ingresos para el Municipio de Valle de Santiago, Gto. 2024 ', 'route' => route('urban_dev.show', ['tramite' => 'permiso-de-division'])],
                    ['name' => 'Uso de Vía Pública', 'class' => 'info', 'law' => 'Lo anterior con fundamento en los art. 53, 54, 55 y 56 del Reglamento de Construcción de Valle de Santiago Gto. Costo art 24 fracc IX de la Ley de Ingresos para el municipio de Valle de Santiago, Gto. 2024', 'route' => route('urban_dev.show', ['tramite' => 'uso-de-via-publica'])],
                    ['name' => 'Licencia de construcción', 'class' => 'danger', 'law' => 'Lo anterior con fundamento en los art. 24 fracc I inc a2a, fracc. I a2b del Reglmento de Construcción de Valle de Santiago, Gto. Costo: Art. 24 fracc IX de la Ley de Ingresos para el Municipio de Valle de Santiago, Gto; 2024.', 'route' => route('urban_dev.show', ['tramite' => 'licencia-de-construccion'])],
                    ['name' => 'Permiso de construcción en panteones', 'class' => 'primary', 'law' => 'Lo anterior con fundamento en los Art. 13, fracciones II, III, inciso a) Art 46, 50, Art. 56, Fracción V y Art. 57, Fracción 1, del Reglamento de Panteones y Cementerios para el Municipio de Valle de Santiago, Gto. y Art 128 Disposiciones Administrativas de Recaudación del Municipio de Valle de Santiago, Gto.', 'route' => route('urban_dev.show', ['tramite' => 'permiso-construccion-panteones'])],
                ];
            @endphp

            @foreach($tramites as $tramite)
                <div class="col-md-6 mb-3">
                    <a href="{{ $tramite['route'] }}" class="card link-card card-normal card-alignment-bottom wow fadeInUp" style="height: 430px;">
                        <div class="card-icon bg-white text-dark d-flex align-items-center justify-content-center">
                            <ion-icon name="arrow-forward-outline" class="md hydrated"></ion-icon>
                        </div>

                        <div class="card-content">
                            <div class="d-flex flex-column mb-2 gap-3">
                                <div class="card-icon card-icon-static bg-{{ $tramite['class'] }} text-white d-flex align-items-center justify-content-center">
                                    <ion-icon name="document-text-outline"></ion-icon>
                                </div>
                                <h4 class="mb-0">{{ $tramite['name'] }}</h4>
                            </div>
                            <p class="mb-0">{{ $tramite['law'] }}</p>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
@endsection
