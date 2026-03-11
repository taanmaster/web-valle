@extends('front.layouts.app')

@push('styles')
@endpush

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
                        <!-- Contenido de la pestaña Inicio de Licitaciones-->
                        <livewire:bidding.crud :mode="$mode" :bidding="$bidding" />
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
