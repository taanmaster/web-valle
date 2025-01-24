@extends('front.layouts.app')

@section('content')
<div class="container">
    <div class="row mt-4">
        <div class="col-12">
            <div class="card card-normal wow fadeInUp">
                <div class="card-title">
                    <div class="d-flex gap-3">
                        @switch($type)
                            @case('all')
                                <div class="card-icon bg-secondary text-white d-flex align-items-center justify-content-center">
                                    <ion-icon name="documents-outline"></ion-icon>
                                </div>
                                
                                <h3>Archivo de Gaceta Municipal</h3>
                                @break
                            @case('ordinary')
                                <div class="card-icon bg-success text-white d-flex align-items-center justify-content-center">
                                    <ion-icon name="documents-outline"></ion-icon>
                                </div>
                                
                                <h3>Sesiones Ordinarias H. Ayuntamiento 2024-2027</h3>
                                @break

                            @case('extraordinary')
                                <div class="card-icon bg-primary text-white d-flex align-items-center justify-content-center">
                                    <ion-icon name="documents-outline"></ion-icon>
                                </div>
                                
                                <h3>Sesiones Extraordinarias H. Ayuntamiento 2024-2027</h3>
                                @break

                            @case('solemn')
                                <div class="card-icon bg-warning text-white d-flex align-items-center justify-content-center">
                                    <ion-icon name="documents-outline"></ion-icon>
                                </div>
                                
                                <h3>Sesiones Solemnes H. Ayuntamiento 2024-2027</h3>
                                @break
                            @default
                        @endswitch
                    </div>
                    <p class="card-title-description mb-0">Entérate aquí de las decisiones tomadas por las y los integrantes del H. Ayuntamiento</p>
                </div>

                <div class="row w-100">
                    <div class="col-md-12 mb-4">
                        <h6 class="mb-3">Filtrar por Fecha</h6>
                        <ul class="nav nav-pills">
                            @foreach($dates as $date)
                                <li class="nav-item">
                                    <a class="nav-link {{ $loop->first ? 'active' : '' }}" href="{{ route('gazette.filter', [$type, 'date' => $date->format('Y-m')]) }}">{{ $date->translatedFormat('F Y') }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="col-md-12">
                        <div class="row">
                            @foreach($gazettes as $gazette)
                            <div class="col-md-3">
                                <a href="{{ route('gazette.detail', [$gazette->type, $gazette->slug]) }}" class="card gazette-card d-block">
                                    <h4>{{ $gazette->name }}</h4>
                                    <div>
                                        <p class="mb-0">Acta {{ $gazette->document_number }}</p>
                                        <p>{{ Carbon\Carbon::parse($gazette->meeting_date)->translatedFormat('d F Y') }}</p>
                                    </div>
                                    <div class="btn btn-primary w-100 d-flex align-items-center justify-content-between gap-2">Descargar el Archivo <ion-icon name="download-outline"></ion-icon></div>
                                </a>
                            </div>
                            @endforeach                           
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection