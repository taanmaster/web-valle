@extends('front.layouts.app')

@section('content')
<div class="container">
    <div class="row mt-4">
        <div class="col-12">
            <div class="card card-normal">
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
                    <div class="col-md-8">
                        <ul class="list-group">
                            @foreach($gazettes as $gazette)
                            
                                @foreach($gazette->files as $file)
                                    <li class="list-group-item">
                                        <a href="{{ route('gazette.detail', [$gazette->type, $gazette->slug]) }}">{{ $gazette->name }}</a>
                                        
                                    </li>
                                @endforeach
            
                                <hr>
                            @endforeach
                        </ul>
                    </div>

                    <div class="col-4">
                        <h3>Filtrar por Fecha</h3>
                        <ul class="list-group">
                            @foreach($dates as $date)
                                <li class="list-group-item">
                                    <a href="{{ route('gazette.filter', [$type, 'date' => $date->format('Y-m')]) }}">{{ $date->translatedFormat('F Y') }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection