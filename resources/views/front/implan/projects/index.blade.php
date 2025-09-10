@extends('front.layouts.app')

@section('content')
    <div class="container">
        @include('front.implan.utilities.nav')

        <div class="row mb-4">
            <div class="col-md-12">
                <h2>Proyectos</h2>

                @foreach ($projects as $project)
                    <a href="{{ route('implan.front.project.detail', $project->slug) }}" class="card card-body mb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">{{ $project->title }}</h5>

                            <ion-icon name="chevron-forward-outline" style="font-size:32px"></ion-icon>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>

        @include('front.implan.utilities.footer')
    </div>
@endsection
