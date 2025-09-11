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
                        <h1 class="display-1 mb-0">Nuestros Servicios</h1>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="card card-normal card-alignment-bottom wow fadeInUp">
                    <div class="card-content">
                        <div class="d-flex flex-column  gap-3">
                            <div class="card-icon card-icon-static bg-info text-white d-flex align-items-center justify-content-center">
                                <ion-icon name="file-tray-full-outline"></ion-icon>
                            </div>
                            <h4 class="mb-0">Lorem Ipsum Dolor Sit</h4>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card card-normal card-alignment-bottom wow fadeInUp">
                    <div class="card-content">
                        <div class="d-flex flex-column  gap-3">
                            <div class="card-icon card-icon-static bg-info text-white d-flex align-items-center justify-content-center">
                                <ion-icon name="file-tray-full-outline"></ion-icon>
                            </div>
                            <h4 class="mb-0">Lorem Ipsum Dolor Sit</h4>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card card-normal card-alignment-bottom wow fadeInUp">
                    <div class="card-content">
                        <div class="d-flex flex-column  gap-3">
                            <div class="card-icon card-icon-static bg-info text-white d-flex align-items-center justify-content-center">
                                <ion-icon name="file-tray-full-outline"></ion-icon>
                            </div>
                            <h4 class="mb-0">Lorem Ipsum Dolor Sit</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-6">
                <a href="#" class="card link-card card-image card-alignment-bottom wow fadeInUp h-100">
                    <img src="{{ asset('front/img/placeholder.jpg') }}" class="card-img-top" alt="Portada de Desarrollo Urbano">
                    <div class="overlay"></div>

                    <div class="card-icon bg-white text-dark d-flex align-items-center justify-content-center">
                        <ion-icon name="arrow-forward-outline" class="md hydrated"></ion-icon>
                    </div>

                    <div class="card-content">
                        <h2>Lorem Ipsum Dolor Sit Amet</h2>
                        <p class="mb-0">Lorem ipsum dolor sit amet consectetur adipiscing elit class egestas, pretium augue ullamcorper suscipit sapien duis lacus ultrices.</p>
                    </div>
                </a>
            </div>

            <div class="col-md-6">
                <a href="#" class="card link-card card-image card-alignment-bottom wow fadeInUp h-100">
                    <img src="{{ asset('front/img/placeholder.jpg') }}" class="card-img-top" alt="Portada de Desarrollo Urbano">
                    <div class="overlay"></div>

                    <div class="card-icon bg-white text-dark d-flex align-items-center justify-content-center">
                        <ion-icon name="arrow-forward-outline" class="md hydrated"></ion-icon>
                    </div>

                    <div class="card-content">
                        <h2>Lorem Ipsum Dolor Sit Amet</h2>
                        <p class="mb-0">Lorem ipsum dolor sit amet consectetur adipiscing elit class egestas, pretium augue ullamcorper suscipit sapien duis lacus ultrices.</p>
                    </div>
                </a>
            </div>
        </div>

        <!-- Lista de Servicios -->
        <div class="mb-3">
            <div class="d-flex align-items-center mb-4 mt-5 wow fadeInUp" style="gap: 12px">
                <div class="icon bg-primary">
                    <ion-icon name="business-outline"></ion-icon>
                </div>
                <h3 class="mb-0">Lorem ipsum dolor sit amet</h3>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card card-image card-alignment-center wow fadeInUp h-100">
                    <img class="card-img-top" src="{{ asset('front/img/placeholder-4.jpg') }}" alt="">
                    <div class="overlay"></div>

                    <div class="card-content w-100">
                        <div class="d-flex align-items-center mb-0 gap-3">
                            <div class="card-icon card-icon-static bg-white text-primary d-flex align-items-center justify-content-center">
                                <ion-icon name="home-outline"></ion-icon>
                            </div>
                            <h2 class="mb-0">Servicio 01</h2>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card card-normal card-alignment-center wow fadeInUp h-100">
                    <div class="card-content mb-0">
                        <h4 class="mb-0">Este es el contenido de la tarjeta para el servicio</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-4">
            <div class="card card-image card-alignment-center wow fadeInUp h-100">
                <img class="card-img-top" src="{{ asset('front/img/placeholder-4.jpg') }}" alt="">
                <div class="overlay"></div>

                <div class="card-content w-100">
                <div class="d-flex align-items-center mb-0 gap-3">
                    <div class="card-icon card-icon-static bg-white text-primary d-flex align-items-center justify-content-center">
                    <ion-icon name="business-outline"></ion-icon>
                    </div>
                    <h2 class="mb-0">Planificación Urbana</h2>
                </div>
                </div>
            </div>
            </div>

            <div class="col-md-8">
            <div class="card card-normal card-alignment-center wow fadeInUp h-100">
                <div class="card-content mb-0">
                <h4 class="mb-0">Diseño y ordenamiento general de espacios urbanos para mejorar conectividad y uso del suelo.</h4>
                </div>
            </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-4">
            <div class="card card-image card-alignment-center wow fadeInUp h-100">
                <img class="card-img-top" src="{{ asset('front/img/placeholder-4.jpg') }}" alt="">
                <div class="overlay"></div>

                <div class="card-content w-100">
                <div class="d-flex align-items-center mb-0 gap-3">
                    <div class="card-icon card-icon-static bg-white text-primary d-flex align-items-center justify-content-center">
                    <ion-icon name="construct-outline"></ion-icon>
                    </div>
                    <h2 class="mb-0">Asesoría Técnica</h2>
                </div>
                </div>
            </div>
            </div>

            <div class="col-md-8">
            <div class="card card-normal card-alignment-center wow fadeInUp h-100">
                <div class="card-content mb-0">
                <h4 class="mb-0">Soporte profesional para trámites, normas y procesos relacionados con proyectos urbanos.</h4>
                </div>
            </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-4">
            <div class="card card-image card-alignment-center wow fadeInUp h-100">
                <img class="card-img-top" src="{{ asset('front/img/placeholder-4.jpg') }}" alt="">
                <div class="overlay"></div>

                <div class="card-content w-100">
                <div class="d-flex align-items-center mb-0 gap-3">
                    <div class="card-icon card-icon-static bg-white text-primary d-flex align-items-center justify-content-center">
                    <ion-icon name="documents-outline"></ion-icon>
                    </div>
                    <h2 class="mb-0">Estudios y Diagnósticos</h2>
                </div>
                </div>
            </div>
            </div>

            <div class="col-md-8">
            <div class="card card-normal card-alignment-center wow fadeInUp h-100">
                <div class="card-content mb-0">
                <h4 class="mb-0">Análisis técnico y evaluaciones para detectar necesidades y oportunidades en el territorio.</h4>
                </div>
            </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-4">
            <div class="card card-image card-alignment-center wow fadeInUp h-100">
                <img class="card-img-top" src="{{ asset('front/img/placeholder-4.jpg') }}" alt="">
                <div class="overlay"></div>

                <div class="card-content w-100">
                <div class="d-flex align-items-center mb-0 gap-3">
                    <div class="card-icon card-icon-static bg-white text-primary d-flex align-items-center justify-content-center">
                    <ion-icon name="people-outline"></ion-icon>
                    </div>
                    <h2 class="mb-0">Gestión de Proyectos</h2>
                </div>
                </div>
            </div>
            </div>

            <div class="col-md-8">
            <div class="card card-normal card-alignment-center wow fadeInUp h-100">
                <div class="card-content mb-0">
                <h4 class="mb-0">Coordinación y seguimiento de iniciativas desde la idea hasta la implementación operativa.</h4>
                </div>
            </div>
            </div>
        </div>

        <!-- Bloque de Información de Desarrollo Urbano -->
        <div class="row mt-5">
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
@endsection

