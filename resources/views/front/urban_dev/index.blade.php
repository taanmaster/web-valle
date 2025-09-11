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
                        <p class="small-uppercase mb-0">Bienvenidos a la página oficial de</p>
                        <h1 class="display-1 mb-0">Desarrollo Urbano</h1>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <a href="{{ route('urban_dev.procedures') }}" class="card link-card card-normal card-alignment-bottom wow fadeInUp">
                    <div class="card-icon bg-white text-dark d-flex align-items-center justify-content-center">
                        <ion-icon name="arrow-forward-outline" class="md hydrated"></ion-icon>
                    </div>

                    <div class="card-content">
                        <div class="d-flex flex-column gap-3">
                            <div class="card-icon card-icon-static bg-info text-white d-flex align-items-center justify-content-center">
                                <ion-icon name="document-text-outline"></ion-icon>
                            </div>
                            <h4 class="mb-0">Ir a Trámites</h4>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-6">
                <a href="{{ route('urban_dev.services') }}" class="card link-card card-normal card-alignment-bottom wow fadeInUp">
                    <div class="card-icon bg-white text-dark d-flex align-items-center justify-content-center">
                        <ion-icon name="arrow-forward-outline" class="md hydrated"></ion-icon>
                    </div>

                    <div class="card-content">
                        <div class="d-flex flex-column gap-3">
                            <div class="card-icon card-icon-static bg-warning text-white d-flex align-items-center justify-content-center">
                                <ion-icon name="grid-outline"></ion-icon>
                            </div>
                            <h4 class="mb-0">Ir a Servicios</h4>
                        </div>
                    </div>
                </a>
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
@endsection

