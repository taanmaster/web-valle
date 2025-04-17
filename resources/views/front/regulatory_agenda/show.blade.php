@extends('front.layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center mb-4">
            <div class="col-md-12">
                <div class="card card-normal card-image-banner wow fadeInUp" style="min-height: 250px;">
                    <div class="card-content">
                        <h4>{{ $dependency->name }}</h4>
                        <p class="mb-0">{{ $dependency->description }}</p>
                    </div>
                </div>
            </div>
        </div>

        <livewire:regulatory-agenda.regulations-table :dependency="$dependency" is_admin="false" />
    </div>
@endsection
