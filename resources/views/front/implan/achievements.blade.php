@extends('front.layouts.app')

@section('content')
    <div class="container">
        @include('front.implan.utilities.nav')

        <div class="row mb-4">
            <h2 class="text-center">Nuestros Logros</h2>

            @if ($achievements->isEmpty())
                <p class="text-center">No hay logros disponibles en este momento.</p>
            @else
                @foreach ($achievements as $item)
                    <div class="col-md-4 d-flex flex-column align-items-center">

                        <div class="circle-img"
                            @if ($item->hex != null) style="border-color: {{ $item->hex }} !important" @endif>
                            @if ($item->image)
                                <img src="{{ $item->image }}" alt="">
                            @else
                                <img src="{{ asset('front/img/placeholder.jpg') }}" alt="">
                            @endif
                        </div>

                        <h5 class="text-center">{{ $item->title }}</h5>

                        <a href="{{ $item->file }}" target="_blank" class="btn btn-secondary btn-sm">Descargar</a>
                    </div>
                @endforeach
            @endif
        </div>

        @include('front.implan.utilities.footer')
    </div>
@endsection

@push('styles')
    <style>
        .circle-img {
            width: 160px;
            height: 160px;
            border-radius: 100px;
            border: 12px solid #931917;
            position: relative;
            overflow: hidden;
            margin-bottom: 18px;
        }

        .circle-img img {
            height: 100%;
            width: 100%;
            object-fit: cover;
            border-radius: 100px;
        }
    </style>
@endpush
