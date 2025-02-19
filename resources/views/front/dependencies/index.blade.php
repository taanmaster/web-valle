@extends('front.layouts.app')

@section('content')
<div class="container">
    <div class="row mt-4">
        <div class="col-12">
            <div class="card card-normal card-alignment-bottom wow fadeInUp">
                <div class="card-title">
                    <div class="d-flex gap-3 mb-3">
                        <div class="card-icon bg-secondary text-white d-flex align-items-center justify-content-center">
                            <ion-icon name="documents-outline"></ion-icon>
                        </div>
                        
                        <h3>Listado de Dependencias</h3>
                    </div>

                    <p class="card-title-description mb-2">La Unidad de Transparencia de Valle de Santiago, Gto. Te da la Bienvenida al Portal de Obligaciones Comunes del Articulo 26 y Obligaciones Especificas del Articulo 28 LTAIPEG Garantizando el derecho a acceder a la información pública y fortaleciendo la  confianza de nuestra institución de manera oportuna, completa, continua y permanente. La Unidad de Transparencia se congratula en servir de enlace entre la ciudadanía y nuestro gobierno  para lograr incrementar la Cultura de la Transparencia, lo esperamos con agrado en nuestras oficinas ubicada es Palacio Municipal S/N, Zona  Centro  o al teléfono 01 (456) 643 08 60</p>
                    <p class="card-title-description mb-0">Atentamente: Unidad de Transparencia y Acceso a la Información Pública.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row w-100">
        @foreach($dependencies as $dependency)
        <div class="col-md-6 mb-4">
            @if($dependency->image_cover != NULL)
            <a href="{{ route('dependency.detail', $dependency->slug) }}" class="card link-card card-image card-alignment-bottom wow fadeInUp h-100">
                <img src="{{ asset('images/dependencies/' . $dependency->image_cover) }}" class="card-img-top" alt="Portada de {{ $dependency->name }}">
                <div class="overlay"></div>
                
                <div class="card-icon bg-white text-dark d-flex align-items-center justify-content-center">
                    <ion-icon name="arrow-forward-outline" class="md hydrated"></ion-icon>
                </div>

                <div class="card-content">
                    <img src="{{ asset('images/dependencies/' . $dependency->logo) }}" class="card-logo mb-3" alt="Logotipo de {{ $dependency->name }}" style="height: 80px;">
                    <h4>{{ $dependency->name }}</h4>
                    <p class="mb-0">{{ $dependency->description }}</p>
                </div>
            </a>
            @else
            <a href="{{ route('dependency.detail', $dependency->slug) }}" class="card link-card card-normal card-alignment-bottom wow fadeInUp h-100">
                <div class="card-icon bg-white text-dark d-flex align-items-center justify-content-center">
                    <ion-icon name="arrow-forward-outline" class="md hydrated"></ion-icon>
                </div>

                <div class="card-content">
                    <img src="{{ asset('images/dependencies/' . $dependency->logo) }}" class="card-logo mb-3" alt="Logotipo de {{ $dependency->name }}" style="height: 80px;">
                    
                    <h4>{{ $dependency->name }}</h4>
                    <p class="mb-0">{{ $dependency->description }}</p>
                </div>
            </a>
            @endif
        </div>
        @endforeach
    </div>
</div>
@endsection