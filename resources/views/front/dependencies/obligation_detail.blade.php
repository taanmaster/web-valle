@extends('front.layouts.app')

@section('content')
<div class="container">
    <div class="row mt-4">
        <div class="col-12">
            <div class="card card-normal wow fadeInUp">
                <div class="card-title">
                    <div class="d-flex gap-3">
                        <div class="card-icon bg-secondary text-white d-flex align-items-center justify-content-center">
                            <ion-icon name="documents-outline"></ion-icon>
                        </div>
                        
                        <h3>{{ $obligation->name }}</h3>
                    </div>
                    <p class="card-title-description mb-0">{{ $obligation->description }}</p>
                </div>

                <div class="row w-100">
                    <div class="col-md-12 mb-4">
                        <h6 class="mb-3">Filtrar por Año</h6>
                        <ul class="nav nav-tabs">
                            <li class="nav-item">
                                <a class="nav-link {{ !request('date') ? 'active' : '' }}" href="{{ route('obligation.detail', [$dependency, $obligation->slug]) }}">Ver Todos</a>
                            </li>
                            @foreach($dates as $date)
                                <li class="nav-item">
                                    <a class="nav-link {{ request('date') == $date ? 'active' : '' }}" href="{{ route('document.filter', [$dependency, $obligation->slug, $date]) }}">{{ $date }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="col-md-12">
                        <div class="row">
                            @foreach($documents as $document)
                            <div class="col-md-3">
                                @if($document->s3_asset_url != null)
                                    <a href="{{ $document->s3_asset_url }}" target="_blank" class="card gazette-card d-block">
                                @else
                                <a href="{{ asset('files/documents/' . $document->filename) }}" target="_blank" class="card gazette-card d-block">
                                @endif
                                    <h4 class="mb-0">{{ $document->name }}</h4>
                                    <small class="text-muted mt-1 mb-3 d-block">ID BD: {{ $document->id }}</small>
                                    <div>
                                        <p class="mb-0">{{ $document->name }}</p>
                                        <p>{{ Carbon\Carbon::createFromFormat('Y', $document->year)->format('Y') }}</p>
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