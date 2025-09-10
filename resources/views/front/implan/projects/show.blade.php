@extends('front.layouts.app')

@section('content')
    <div class="container">
        @include('front.implan.utilities.nav')

        <div class="row">
            <h3>Proyecto</h3>

            <h2>{{ $project->title }}</h2>
        </div>

        <div class="row my-4">
            <div class="col-md-8">
                <div class="card card-normal wow fadeInUp h-100">
                    <div class="card-content">
                        <h3>{{ $project->title }}</h3>

                        <p>
                            {{ $project->description }}
                        </p>

                        @if ($project->file)
                            <a href="{{ $project->file }}" class="btn btn-outline-secondary">Descargar</a>
                        @endif
                    </div>
                </div>
            </div>
            @if ($project->image)
                <div class="col-md-4">
                    <div class="card card-image wow fadeInUp h-100">
                        <img class="card-img-top" src="{{ $project->image }}" alt="">
                        <div class="overlay"></div>
                    </div>
                </div>
            @endif
        </div>

        @include('front.implan.utilities.footer')
    </div>
@endsection
