@extends('front.layouts.app')

@section('content')
<div class="container">
    <div class="row w-100 mt-4">
        <div class="col-md-12">
            @php
                $transparency_dependency = App\Models\TransparencyDependency::where('slug', 'unidad-de-transparencia-y-acceso-a-la-informacion')->first();
            @endphp
            
            @if ($transparency_dependency->image_cover != null)
                <div class="card card-image card-image-banner wow fadeInUp mb-4">
                    <img src="{{ asset('images/dependencies/' . $transparency_dependency->image_cover) }}" class="card-img-top"
                        alt="Portada de {{ $transparency_dependency->name }}">
                    <div class="overlay"></div>

                    <div class="card-content">
                        <img src="{{ asset('images/dependencies/' . $transparency_dependency->logo) }}" class="card-logo mb-3" alt="Logotipo de {{ $transparency_dependency->name }}" style="height: 80px;">
                        <h4>Unidad de Transparencia y acceso a la información</h4>
                        <p class="mb-0">La Unidad de Transparencia se congratula en servir de enlace entre la ciudadanía y nuestro gobierno para lograr incrementar la Cultura de la Transparencia, lo esperamos con agrado en nuestras oficinas ubicada es Palacio Municipal S/N, Zona Centro o al teléfono 01 (456) 643 08 60</p>
                    </div>
                </div>
            @else
                <div class="card card-normal card-image-banner wow fadeInUp" style="min-height: 250px;">
                    <div class="card-content">
                        <img src="{{ asset('images/dependencies/' . $transparency_dependency->logo) }}" class="card-logo mb-3"
                            alt="Logotipo de {{ $transparency_dependency->name }}" style="height: 80px;">
                        <h4>Unidad de Transparencia y acceso a la información</h4>
                        <p class="mb-0">La Unidad de Transparencia se congratula en servir de enlace entre la ciudadanía y nuestro gobierno para lograr incrementar la Cultura de la Transparencia, lo esperamos con agrado en nuestras oficinas ubicada es Palacio Municipal S/N, Zona Centro o al teléfono 01 (456) 643 08 60</p>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <div class="row w-100">
        <div class="col-md-6 mb-4">
            <a href="{{ route('transparency.obligations', 'Común') }}" class="card link-card card-normal card-alignment-bottom wow fadeInUp h-100">
                <div class="card-icon bg-white text-dark d-flex align-items-center justify-content-center">
                    <ion-icon name="arrow-forward-outline" class="md hydrated"></ion-icon>
                </div>

                <div class="card-content">
                    <div class="d-flex align-items-center gap-3">
                        <div class="card-icon card-icon-static bg-primary text-white d-flex align-items-center justify-content-center">
                            <ion-icon name="documents-outline"></ion-icon>
                        </div>
                        <h4 class="mb-0">Obligaciones Comúnes</h4>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-6 mb-4">
            <a href="{{ route('transparency.obligations', 'Especifica') }}" class="card link-card card-normal card-alignment-bottom wow fadeInUp h-100">
                <div class="card-icon bg-white text-dark d-flex align-items-center justify-content-center">
                    <ion-icon name="arrow-forward-outline" class="md hydrated"></ion-icon>
                </div>

                <div class="card-content">
                    <div class="d-flex align-items-center gap-3">
                        <div class="card-icon card-icon-static bg-secondary text-white d-flex align-items-center justify-content-center">
                            <ion-icon name="documents-outline"></ion-icon>
                        </div>
                        <h4 class="mb-0">Obligaciones Especificas</h4>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-6 mb-4">
            <a href="{{ route('transparency.obligations', 'Aplicabilidad') }}" class="card link-card card-normal card-alignment-bottom wow fadeInUp h-100">
                <div class="card-icon bg-white text-dark d-flex align-items-center justify-content-center">
                    <ion-icon name="arrow-forward-outline" class="md hydrated"></ion-icon>
                </div>

                <div class="card-content">
                    <div class="d-flex align-items-center gap-3">
                        <div class="card-icon card-icon-static bg-success text-white d-flex align-items-center justify-content-center">
                            <ion-icon name="documents-outline"></ion-icon>
                        </div>
                        <h4 class="mb-0">Tabla de Aplicabilidad</h4>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-6 mb-4">
            <a href="{{ route('transparency.obligations', 'Clasificados') }}" class="card link-card card-normal card-alignment-bottom wow fadeInUp h-100">
                <div class="card-icon bg-white text-dark d-flex align-items-center justify-content-center">
                    <ion-icon name="arrow-forward-outline" class="md hydrated"></ion-icon>
                </div>

                <div class="card-content">
                    <div class="d-flex align-items-center gap-3">
                        <div class="card-icon card-icon-static bg-warning text-white d-flex align-items-center justify-content-center">
                            <ion-icon name="documents-outline"></ion-icon>
                        </div>
                        <h4 class="mb-0">Índice de Expendientes Clasificados</h4>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-12 mb-4">
            <div class="card card-normal card-alignment-bottom wow fadeInUp h-100">
                <div class="card-content">
                    <h4>Protección de Datos</h4>

                    <div class="d-flex gap-2 mt-4">
                        <a href="{{ asset('transparencia/static_files/ley_proteccion_datos.pdf') }}" class="btn btn-outline-primary"><ion-icon name="download-outline"></ion-icon> Ley de Protección de Datos</a>
                        <a href="{{ asset('transparencia/static_files/guia_proteccion_datos_personales.pdf') }}" class="btn btn-outline-secondary"><ion-icon name="download-outline"></ion-icon> Protección de Datos Personales</a>
                        <a href="{{ asset('transparencia/static_files/derechos_arco.pdf') }}" class="btn btn-outline-info"><ion-icon name="download-outline"></ion-icon> Derechos ARCO</a>
                    </div>
                </div>
            </div>
        </div>
        

        <div class="col-md-12 mb-4">
            <a href="{{ route('transparency.obligations', 'Graficas') }}" class="card link-card card-normal card-alignment-bottom wow fadeInUp h-100">
                <div class="card-icon bg-white text-dark d-flex align-items-center justify-content-center">
                    <ion-icon name="arrow-forward-outline" class="md hydrated"></ion-icon>
                </div>

                <div class="card-content">
                    <div class="d-flex align-items-center gap-3">
                        <div class="card-icon card-icon-static bg-primary text-white d-flex align-items-center justify-content-center">
                            <ion-icon name="documents-outline"></ion-icon>
                        </div>
                        <h4 class="mb-0">Gráficas Informativas</h4>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-6 mb-4">
            <a href="https://www.plataformadetransparencia.org.mx/Inicio" target="_blank" class="card link-card card-image card-image-banner wow fadeInUp h-100">
                <div class="card-icon bg-white text-dark d-flex align-items-center justify-content-center">
                    <ion-icon name="arrow-forward-outline" class="md hydrated"></ion-icon>
                </div>

                <img src="{{ asset('images/dependencies/' . $transparency_dependency->image_cover) }}" class="card-img-top"
                    alt="Portada de {{ $transparency_dependency->name }}">
                <div class="overlay"></div>

                <div class="card-content">
                    <img src="{{ asset('transparencia/static_files/logo_pnt.svg') }}" class="card-logo mb-3" alt="Logotipo PNT" style="height: 80px;">
                    <h4>Plataforma Nacional de Transparencia</h4>
                </div>
            </a>
        </div>

        <div class="col-md-6 mb-4">
            <a href="https://consultapublicamx.plataformadetransparencia.org.mx/vut-web/faces/view/consultaPublica.xhtml#inicio" target="_blank" class="card link-card card-normal card-alignment-bottom wow fadeInUp h-100">
                <div class="card-icon bg-white text-dark d-flex align-items-center justify-content-center">
                    <ion-icon name="arrow-forward-outline" class="md hydrated"></ion-icon>
                </div>

                <div class="card-content">
                    <h4>Consulta Pública</h4>
                    <p>Consulta nuestra oblicaciones transparencia (LGT ARTÍCULO 64)</p>
                </div>
            </a>
        </div>

        <div class="col-md-6 mb-4">
            <a href="{{ route('transparency.obligations', 'Proactiva') }}" class="card link-card card-normal card-alignment-bottom wow fadeInUp h-100">
                <div class="card-icon bg-white text-dark d-flex align-items-center justify-content-center">
                    <ion-icon name="arrow-forward-outline" class="md hydrated"></ion-icon>
                </div>

                <div class="card-content">
                    <div class="d-flex align-items-center gap-3">
                        <div class="card-icon card-icon-static bg-primary text-white d-flex align-items-center justify-content-center">
                            <ion-icon name="documents-outline"></ion-icon>
                        </div>
                        <h4 class="mb-0">Transparencia Proactiva</h4>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-6 mb-4">
            <a href="{{ asset('transparencia/static_files/guia_solicitudes_informacion.pdf') }}" target="_blank" class="card link-card card-normal card-alignment-bottom wow fadeInUp h-100">
                <div class="card-icon bg-white text-dark d-flex align-items-center justify-content-center">
                    <ion-icon name="arrow-forward-outline" class="md hydrated"></ion-icon>
                </div>

                <div class="card-content">
                    <h4>Guía para elaboración de respuestas a solicitudes de información pública y de datos personales.</h4>
                </div>
            </a>
        </div>
    </div>
</div>

<div class="container mt-4 mb-4 wow fadeInUp">
    <div class="text-center">
        <p class="mb-1">Dirección</p>
        <h5>Portal Hidalgo S/N CP:38400 - Tel: 464 162 3070 - Valle de Santiago, Guanajuato</h5>
    </div>
</div>
@endsection