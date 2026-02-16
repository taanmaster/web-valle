@extends('front.layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center mb-4">
            <div class="col-md-8">
                <a href="{{ route('rrhh.vacancy.detail', $vacancy->id) }}" class="btn btn-link mb-3 p-0">
                    <ion-icon name="arrow-back"></ion-icon> Volver al detalle
                </a>

                <div class="card">
                    <div class="card-body">
                        <h2 class="mb-1">Aplicar a vacante</h2>
                        <h5 class="text-muted mb-4">{{ $vacancy->position_name }}</h5>

                        <livewire:front.h-r.apply-form :vacancy="$vacancy" />
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
