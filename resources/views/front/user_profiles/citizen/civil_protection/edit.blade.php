@extends('front.layouts.app')

@section('content')
    <div class="container py-4">
        @include('front.user_profiles.partials._profile_card')

        <div class="row g-3 mt-0">
            <div class="col-md-3">
                @include('front.user_profiles.partials._profile_nav')
            </div>
            <div class="col-md-9">
                <div class="card wow fadeInUp">
                    <div class="card-body">
                        @livewire('citizen.civil-protection.request-form', ['procedure' => $procedure, 'case' => $case])
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

