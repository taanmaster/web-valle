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
                    <div class="col-md-4">
                        <h3>{{ $item->title }}</h3>
                        <p>{{ $item->description }}</p>
                    </div>
                @endforeach
            @endif
        </div>

        @include('front.implan.utilities.footer')
    </div>
@endsection
