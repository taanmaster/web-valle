@extends('front.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-normal wow fadeInUp">
                <div class="w-100">
                    @switch($gazette->type)
                        @case('ordinary')
                            <p class="small-uppercase mb-0">Sesiones Ordinarias H. Ayuntamiento 2024-2027</p>
                            @break

                        @case('extraordinary')
                            <p class="small-uppercase mb-0">Sesiones Extraordinarias H. Ayuntamiento 2024-2027</p>
                            @break

                        @case('solemn')
                            <p class="small-uppercase mb-0">Sesiones Solemnes H. Ayuntamiento 2024-2027</p>
                            @break
                        @default
                    @endswitch
                    
                    <h2>{{ $gazette->name }}</h2>
                    <p>{{ $gazette->description }}</p>

                    <div class="d-flex gap-3">
                        <p class="d-flex align-items-center gap-2"><ion-icon name="document-text-outline"></ion-icon> Acta {{ $gazette->document_number }}</p>
                        <p class="d-flex align-items-center gap-2"><ion-icon name="calendar-outline"></ion-icon> Fecha de Reunión: {{ Carbon\Carbon::parse($gazette->meeting_date)->translatedFormat('d F Y') }}</p>
                    </div>
                </div>
                
                <div class="w-100">
                    <h5 class="mb-3">Listado de Archivos</h5>
                    <hr>
                    <div class="row">
                        @foreach($gazette->files as $file)
                        <div class="col-md-3">
                            <div class="card p-4 mb-0">
                                @if($file->s3_asset_url != null)
                                <a target="_blank" href="{{ $file->s3_asset_url }}">Descargar Archivo: {{ $file->name }}</a>
                                @else
                                <a target="_blank" href="{{ asset('files/gazettes/' . $file->filename) }}">Descargar Archivo: {{ $file->name }}</a>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection