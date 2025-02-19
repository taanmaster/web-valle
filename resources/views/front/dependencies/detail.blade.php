@extends('front.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if($dependency->image_cover != NULL)
            <div class="card card-image card-image-banner wow fadeInUp">
                <img src="{{ asset('images/dependencies/' . $dependency->image_cover) }}" class="card-img-top" alt="Portada de {{ $dependency->name }}">
                <div class="overlay"></div>

                <div class="card-content">
                    <img src="{{ asset('images/dependencies/' . $dependency->logo) }}" class="card-logo mb-3" alt="Logotipo de {{ $dependency->name }}" style="height: 80px;">
                    <h4>{{ $dependency->name }}</h4>
                    <p class="mb-0">{{ $dependency->description }}</p>
                </div>
            </div>
            @else
            <div class="card card-normal card-image-banner wow fadeInUp" style="min-height: 250px;">
                <div class="card-content">
                    <img src="{{ asset('images/dependencies/' . $dependency->logo) }}" class="card-logo mb-3" alt="Logotipo de {{ $dependency->name }}" style="height: 80px;">
                    <h4>{{ $dependency->name }}</h4>
                    <p class="mb-0">{{ $dependency->description }}</p>
                </div>
            </div>
            @endif
        </div>
    </div>

    <div class="row w-100">
        <div class="col-md-12">
            <div class="row">
                @foreach($dependency->obligations as $obligation)
                <div class="col-md-3">
                    <a href="{{ route('obligation.detail', $obligation->slug) }}" class="card link-card card-normal card-alignment-bottom wow fadeInUp h-100">
                        <div class="card-icon bg-white text-dark d-flex align-items-center justify-content-center">
                            <ion-icon name="arrow-forward-outline" class="md hydrated"></ion-icon>
                        </div>
        
                        <div class="card-content">
                            <span class="badge bg-primary mb-3">{{ $obligation->update_period }}</span>
                            <h4 class="mb-1">{{ $obligation->name }}</h4>
                            <p>{{ $obligation->description }}</p>
                            <div class="btn btn-outline-secondary w-100 d-flex align-items-center justify-content-between gap-2">Ver Documentación <ion-icon name="arrow-forward-outline"></ion-icon></div>
                        </div>
                    </a>
                </div>
                @endforeach                           
            </div>
        </div>
    </div>
</div>
@endsection