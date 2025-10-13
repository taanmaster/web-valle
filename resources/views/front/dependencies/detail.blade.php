@extends('front.layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12" style="margin-bottom: 30px;">
                @if ($dependency->image_cover != null)
                    <div class="card card-image card-image-banner wow fadeInUp">
                        <img src="{{ asset('images/dependencies/' . $dependency->image_cover) }}" class="card-img-top"
                            alt="Portada de {{ $dependency->name }}">
                        <div class="overlay"></div>

                        <div class="card-content">
                            <img src="{{ asset('images/dependencies/' . $dependency->logo) }}" class="card-logo mb-3"
                                alt="Logotipo de {{ $dependency->name }}" style="height: 80px;">
                            <h4>{{ $dependency->name }}</h4>
                            <p class="mb-0">{{ $dependency->description }}</p>
                        </div>
                    </div>
                @else
                    <div class="card card-normal card-image-banner wow fadeInUp" style="min-height: 250px;">
                        <div class="card-content">
                            <img src="{{ asset('images/dependencies/' . $dependency->logo) }}" class="card-logo mb-3"
                                alt="Logotipo de {{ $dependency->name }}" style="height: 80px;">
                            <h4>{{ $dependency->name }}</h4>
                            <p class="mb-0">{{ $dependency->description }}</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        @if ($dependency->obligations->count() == 0)
            <div class="row w-100">
                <div class="col-md-12">
                    <p class="text-muted">No hay obligaciones disponibles.</p>
                </div>
            </div>
        @else
            <livewire:front.transparency-obligations.table :dependency="$dependency->id" :mode="2" />
        @endif

    </div>
@endsection
