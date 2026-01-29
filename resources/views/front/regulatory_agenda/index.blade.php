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

                        <p class="card-title-description mb-2">Son las propuestas de regulaciones y simplificación que los sujetos obligados pretenden expedir.</p>
                    </div>
                </div>
            </div>
        </div>

        @if($dependencies->count() > 0)
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
        @else
            <div class="row">
                <div class="col-12">
                    <div class="card card-normal card-alignment-center wow fadeInUp">
                        <div class="card-content w-100 text-center py-5">
                            <div class="card-icon bg-light text-muted d-flex align-items-center justify-content-center mx-auto mb-4" style="width: 80px; height: 80px;">
                                <ion-icon name="folder-open-outline" style="font-size: 2rem;"></ion-icon>
                            </div>
                            <h4 class="text-muted mb-3">No hay dependencias disponibles</h4>
                            <p class="text-muted text-center mb-0">
                                En este momento no se han registrado dependencias en la Agenda Regulatoria. 
                                Vuelve a consultar más tarde para ver las propuestas de regulaciones disponibles.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
