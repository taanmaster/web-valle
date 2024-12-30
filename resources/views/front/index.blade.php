@extends('front.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-body">
                <h2>Sitio Web Valle</h2>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-8">
            <h3>Documentos de la Gaceta</h3>
            <ul class="list-group">
                @foreach($gazettes as $gazette)
                    @foreach($gazette->files as $file)
                        <li class="list-group-item">
                            <a href="{{ asset('files/gazettes/' . $file->filename) }}">{{ $file->name }}</a>
                        </li>
                    @endforeach
                @endforeach
            </ul>
        </div>
        <div class="col-4">
            <h3>Filtrar por Fecha</h3>
            <ul class="list-group">
                @foreach($dates as $date)
                    <li class="list-group-item">
                        <a href="{{ route('gazette.filter', ['date' => $date->format('Y-m')]) }}">{{ $date->translatedFormat('F Y') }}</a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endsection