@extends('front.layouts.app')

@section('content')
    <div class="container">
        @include('front.implan.utilities.nav')

        <div class="row mb-4">
            <div class="col-md-6">
                <h2>Planos temáticos</h2>
                @foreach ($planos as $plano)
                    <a href="{{ $plano->image }}" class="card card-body mb-3" target="_blank">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">{{ $plano->title }}</h5>

                            <ion-icon name="download-outline" style="font-size:32px"></ion-icon>
                        </div>
                    </a>
                @endforeach
            </div>
            <div class="col-md-6">
                <h2>Capas</h2>

                @foreach ($capas as $capa)
                    <a href="{{ $capa->image }}" class="card card-body mb-3" target="_blank">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">{{ $capa->title }}</h5>

                            <ion-icon name="download-outline" style="font-size:32px"></ion-icon>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>

        @include('front.implan.utilities.footer')
    </div>
@endsection
