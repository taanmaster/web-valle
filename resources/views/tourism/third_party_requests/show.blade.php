@extends('layouts.master')
@section('title')
    Turismo
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Turismo
        @endslot
        @slot('li_2')
            Apoyo a Terceros
        @endslot
        @slot('title')
            Detalle de Solicitud
        @endslot
    @endcomponent

    <div class="row layout-spacing">
        <div class="main-content">
            {{-- Header --}}
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-3">
                            <small class="text-muted">Folio</small>
                            <h5 class="mb-0 fw-bold">{{ $request->folio }}</h5>
                        </div>
                        <div class="col-md-4">
                            <small class="text-muted">Evento</small>
                            <h5 class="mb-0">{{ $request->event_name }}</h5>
                        </div>
                        <div class="col-md-3">
                            <small class="text-muted">Solicitante</small>
                            <h6 class="mb-0">{{ $request->full_name }}</h6>
                        </div>
                        <div class="col-md-2 text-end d-flex flex-column align-items-end gap-2">
                            <span class="badge bg-{{ $request->status_color }} fs-6">{{ $request->status }}</span>
                            <a href="{{ route('tourism.third_party_requests.admin.index') }}" class="btn btn-outline-secondary btn-sm">
                                <i class="bx bx-arrow-back"></i> Volver
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Componente compartido --}}
            <livewire:tourism.third-party-request.request-detail
                :request="$request"
                mode="admin" />

        </div>
    </div>

@endsection
