@extends('front.layouts.app')

@push('styles')
@endpush

@section('content')
    <div class="container py-4">
        <div class="row">
            <div class="col-md-12">

                @include('front.user_profiles.partials._profile_card')

                <!-- Menú de navegación -->
                <div class="card wow fadeInUp">
                    <div class="card-header">
                        @include('front.user_profiles.partials._profile_nav')
                    </div>

                    <div class="card-body">
                        <!-- Contenido de la pestaña Inicio de Licitaciones-->
                        <livewire:bidding.table :mode="1" />
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
