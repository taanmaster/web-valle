@extends('front.layouts.app')

@section('content')
    <div class="container">
        @include('front.urban_dev.utilities._nav')

        <div class="row justify-content-center mb-4">
            <div class="col-md-12">
                <div class="card card-image card-image-banner justify-content-center wow fadeInUp">
                    <img class="card-img-top" src="{{ asset('front/img/placeholder-5.jpg') }}" alt="">
                    <div class="overlay" style="opacity: .4"></div>
                    <div class="card-content text-center w-100">
                        <p class="small-uppercase mb-0">Desarrollo Urbano</p>
                        <h1 class="display-1 mb-0">Catálogo de Trámites</h1>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3">
                <a href="#" class="card link-card card-normal card-alignment-bottom wow fadeInUp">
                    <div class="card-icon bg-white text-dark d-flex align-items-center justify-content-center">
                        <ion-icon name="arrow-forward-outline" class="md hydrated"></ion-icon>
                    </div>

                    <div class="card-content">
                        <div class="d-flex flex-column  gap-3">
                            <div class="card-icon card-icon-static bg-info text-white d-flex align-items-center justify-content-center">
                                <ion-icon name="file-tray-full-outline"></ion-icon>
                            </div>
                            <h4 class="mb-0">Trámites Destacados</h4>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-3">
                <a href="#" class="card link-card card-normal card-alignment-bottom wow fadeInUp">
                    <div class="card-icon bg-white text-dark d-flex align-items-center justify-content-center">
                        <ion-icon name="arrow-forward-outline" class="md hydrated"></ion-icon>
                    </div>

                    <div class="card-content">
                        <div class="d-flex flex-column  gap-3">
                            <div class="card-icon card-icon-static bg-info text-white d-flex align-items-center justify-content-center">
                                <ion-icon name="file-tray-full-outline"></ion-icon>
                            </div>
                            <h4 class="mb-0">Lorem Ipsum Dolor Sit</h4>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-3">
                <a href="#" class="card link-card card-normal card-alignment-bottom wow fadeInUp">
                    <div class="card-icon bg-white text-dark d-flex align-items-center justify-content-center">
                        <ion-icon name="arrow-forward-outline" class="md hydrated"></ion-icon>
                    </div>

                    <div class="card-content">
                        <div class="d-flex flex-column  gap-3">
                            <div class="card-icon card-icon-static bg-info text-white d-flex align-items-center justify-content-center">
                                <ion-icon name="file-tray-full-outline"></ion-icon>
                            </div>
                            <h4 class="mb-0">Lorem Ipsum Dolor Sit</h4>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-3">
                <a href="#" class="card link-card card-normal card-alignment-bottom wow fadeInUp">
                    <div class="card-icon bg-white text-dark d-flex align-items-center justify-content-center">
                        <ion-icon name="arrow-forward-outline" class="md hydrated"></ion-icon>
                    </div>

                    <div class="card-content">
                        <div class="d-flex flex-column  gap-3">
                            <div class="card-icon card-icon-static bg-info text-white d-flex align-items-center justify-content-center">
                                <ion-icon name="file-tray-full-outline"></ion-icon>
                            </div>
                            <h4 class="mb-0">Lorem Ipsum Dolor Sit</h4>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <div class="row mb-4 mt-5">
            <div class="col">
                <div class="d-flex align-items-center wow fadeInUp" style="gap: 12px">
                    <div class="icon bg-primary">
                        <ion-icon name="business-outline"></ion-icon>
                    </div>
                    <h3 class="mb-0">Catálogo de Trámites</h3>
                </div>
            </div>

            <div class="col-4">
                <!-- Buscador -->
                <div class="d-flex justify-content-end wow fadeInUp">
                    <div class="input-group">
                        <input id="searchProcedures" type="search" class="form-control ps-3" 
                            placeholder="Buscar Contactos o Trámites..." aria-label="Buscar">
                        <button id="searchProceduresBtn" class="btn btn-primary d-flex align-items-center" type="button">
                            <ion-icon name="search-outline"></ion-icon>
                        </button>
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
                <div class="col-md-12">
                    <a href="{{ $tramite['route'] }}" class="card link-card card-normal card-alignment-bottom wow fadeInUp procedure-card">
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

            <!-- Tarjeta cuando no hay resultados -->
            <div id="noProcedures" class="col-12 d-none">
                <div class="card border-0 bg-light text-center py-4">
                    <div class="card-body">
                        <div class="mb-2"><ion-icon name="search-outline" class="fs-2 text-muted"></ion-icon></div>
                        <h5 class="mb-1">No se encontraron trámites</h5>
                        <p class="small text-muted mb-0">Intenta con otro término de búsqueda</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bloque de Información de Desarrollo Urbano -->
        <div class="row">
            <div class="col-md-12">
                <div class="card card-normal wow fadeInUp mb-4">
                    <h2 class="mb-0">Quiénes Somos</h2>
                    <p class="mb-0">Lorem ipsum dolor sit amet consectetur adipiscing elit dictum praesent, semper nulla arcu tempus mi id non varius enim pharetra, habitant viverra rutrum habitasse vel dignissim fermentum congue. Sed nisi hac at quisque posuere netus ante orci rutrum eu eleifend primis vitae, nullam consequat luctus nulla donec egestas cursus pulvinar nascetur gravida quam convallis, fermentum blandit sagittis porta suspendisse erat torquent lacus pharetra inceptos tristique mollis. Ultricies platea odio maecenas phasellus morbi feugiat, netus dis praesent metus varius class, viverra gravida nibh eleifend enim. Facilisis ut fames sapien dui potenti fringilla porttitor sagittis, ad faucibus eget imperdiet rutrum hac aenean, taciti lacus vitae malesuada nostra sollicitudin nisl.</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card card-normal wow fadeInUp h-100 mb-4">
                    <ion-icon style="font-size: 3em;" name="book-outline"></ion-icon>
                    <h2 class="mb-0">Misión</h2>
                    <p class="mb-0">Lorem ipsum dolor sit amet consectetur adipiscing elit dictum praesent, semper nulla arcu tempus mi id non varius enim pharetra, habitant viverra rutrum habitasse vel dignissim fermentum congue.</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card card-normal wow fadeInUp h-100 mb-4">
                    <ion-icon style="font-size: 3em;" name="eye-outline"></ion-icon>
                    <h2 class="mb-0">Visión</h2>
                    <p class="mb-0">Lorem ipsum dolor sit amet consectetur adipiscing elit dictum praesent, semper nulla arcu tempus mi id non varius enim pharetra, habitant viverra rutrum habitasse vel dignissim fermentum congue.</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card card-normal wow fadeInUp h-100 mb-4">
                    <ion-icon style="font-size: 3em;" name="bar-chart-outline"></ion-icon>
                    <h2 class="mb-0">Valores</h2>
                    <p class="mb-0">Lorem ipsum dolor sit amet consectetur adipiscing elit dictum praesent, semper nulla arcu tempus mi id non varius enim pharetra, habitant viverra rutrum habitasse vel dignissim fermentum congue.</p>
                </div>
            </div>

            <div class="col-md-12 mt-4">
                <a href="{{ route('urban_dev.services') }}" class="card link-card card-normal card-alignment-bottom wow fadeInUp">
                    <div class="card-icon bg-white text-dark d-flex align-items-center justify-content-center">
                        <ion-icon name="arrow-forward-outline" class="md hydrated"></ion-icon>
                    </div>

                    <div class="card-content">
                        <div class="d-flex flex-column gap-3">
                            <div class="card-icon card-icon-static bg-primary text-white d-flex align-items-center justify-content-center">
                                <ion-icon name="people-outline"></ion-icon>
                            </div>
                            <h4 class="mb-0">Ir a Directorio</h4>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        @include('front.urban_dev.utilities._footer')
    </div>
    
        <!-- Script de búsqueda para tarjetas de trámites -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const searchInput = document.getElementById('searchProcedures');
                const searchBtn = document.getElementById('searchProceduresBtn');
                const cards = document.querySelectorAll('.procedure-card');

                function filterCards() {
                    const q = (searchInput.value || '').toLowerCase().trim();
                    let visible = 0;

                    if (!q) {
                        cards.forEach(c => { c.classList.remove('d-none'); visible++; });
                    } else {
                        cards.forEach(card => {
                            const text = (card.textContent || '').toLowerCase();
                            const match = text.includes(q);
                            card.classList.toggle('d-none', !match);
                            if (match) visible++;
                        });
                    }

                    const noProcedures = document.getElementById('noProcedures');
                    if (noProcedures) noProcedures.classList.toggle('d-none', visible !== 0);
                }

                searchInput.addEventListener('input', filterCards);
                searchBtn.addEventListener('click', function() { searchInput.focus(); filterCards(); });

                // evitar submit si el input está dentro de un form
                searchInput.addEventListener('keypress', function(e) { if (e.key === 'Enter') e.preventDefault(); });
            });
        </script>
@endsection
