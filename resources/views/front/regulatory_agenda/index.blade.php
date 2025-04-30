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

                        <p class="card-title-description mb-2">Son las propuestas de regulaciones que los sujetos obligados pretenden expedir.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row w-100">
            @foreach ($dependencies as $dependency)
                <div class="col-md-6 mb-4">
                    <a href="{{ route('regulatory-agenda-dependency.show', $dependency->id) }}"
                        class="card link-card card-normal card-alignment-bottom wow fadeInUp h-100">
                        <div class="card-icon bg-white text-dark d-flex align-items-center justify-content-center">
                            <ion-icon name="arrow-forward-outline" class="md hydrated"></ion-icon>
                        </div>

                        <div class="card-content">
                            <h4>{{ $dependency->name }}</h4>
                            <p class="mb-0">{{ $dependency->description }}</p>
                            <p>Enlace de Mejora: {{ $dependency->fullname_connection }} -
                                {{ $dependency->title_connection }}</p>
                            <p>Títular de la dependencia: {{ $dependency->fullname_lider }} - {{ $dependency->title_lider }}
                            </p>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
@endsection
