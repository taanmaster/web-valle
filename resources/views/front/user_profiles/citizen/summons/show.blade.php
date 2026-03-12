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
                        <!-- Lista de solicitudes -->
                        <div class="row">
                            <livewire:summons.crud :mode="$mode" :summon="$summon" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <style>
        .avatar {
            width: 3rem;
            height: 3rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .avatar-lg {
            width: 4rem;
            height: 4rem;
        }

        .avatar-initial {
            font-weight: bold;
            font-size: 1.2rem;
        }

        .timeline-item {
            display: block;
            margin-bottom: 0.5rem;
        }

        .dropzone {
            min-height: 10rem;
            border: 3px dotted #d9d9d9;
            position: relative;
            border-radius: 15px;
            margin-bottom: 20px;
        }
    </style>
@endsection
