@extends('front.layouts.app')

@section('content')
<div class="container">
    <div class="row mt-4">
        <div class="col-8">
            <h3>Documentos de la Gaceta</h3>
            <ul class="list-group">
                @foreach($gazettes as $gazette)
                    

                    @foreach($gazette->files as $file)
                        <li class="list-group-item">
                            <a href="{{ route('gazette.detail', $gazette->slug) }}">{{ $gazette->name }}</a>
                            
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
                        <a href="{{ route('gazette.filter', ['date' => $date->format('Y-m')]) }}">{{ $date->translatedFormat('F Y') }}</a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
    
</div>
@endsection