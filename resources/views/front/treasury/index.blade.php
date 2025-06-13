@extends('front.layouts.app')

@section('content')
    <div class="container">

        <div class="title-container wow fadeInUp mb-4">
            <div class="d-flex align-items-center mb-2" style="gap: 12px">
                <div class="icon bg-secondary">
                    <ion-icon name="documents-outline"></ion-icon>
                </div>
                <h3 class="mb-0">Tesorería</h3>
            </div>
            <p class="title-description mb-0">Información relevante sobre tesorería.</p>
        </div>
        
        <div class="row w-100">
            @foreach ($dependencies as $dependency)
                <div class="col-md-6 mb-4">
                    @if ($dependency->image_cover != null)
                        <a href="{{ route('dependency.detail', $dependency->slug) }}"
                            class="card link-card card-image card-alignment-bottom wow fadeInUp h-100">
                            <img src="{{ asset('images/dependencies/' . $dependency->image_cover) }}" class="card-img-top"
                                alt="Portada de {{ $dependency->name }}">
                            <div class="overlay"></div>

                            <div class="card-icon bg-white text-dark d-flex align-items-center justify-content-center">
                                <ion-icon name="arrow-forward-outline" class="md hydrated"></ion-icon>
                            </div>

                            <div class="card-content">
                                <img src="{{ asset('images/dependencies/' . $dependency->logo) }}" class="card-logo mb-3"
                                    alt="Logotipo de {{ $dependency->name }}" style="height: 80px;">
                                <h4>{{ $dependency->name }}</h4>
                                <p class="mb-0">{{ $dependency->description }}</p>
                            </div>
                        </a>
                    @else
                        <a href="{{ route('dependency.detail', $dependency->slug) }}"
                            class="card link-card card-normal card-alignment-bottom wow fadeInUp h-100">
                            <div class="card-icon bg-white text-dark d-flex align-items-center justify-content-center">
                                <ion-icon name="arrow-forward-outline" class="md hydrated"></ion-icon>
                            </div>

                            <div class="card-content">
                                <img src="{{ asset('images/dependencies/' . $dependency->logo) }}" class="card-logo mb-3"
                                    alt="Logotipo de {{ $dependency->name }}" style="height: 80px;">

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
