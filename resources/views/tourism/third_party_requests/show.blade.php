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
            {{-- Header siempre visible --}}
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
                        <div class="col-md-2 text-end">
                            <span class="badge bg-{{ $request->status_color }} fs-6">{{ $request->status }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tabs --}}
            <ul class="nav nav-tabs mb-4" id="requestTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="detail-tab" data-bs-toggle="tab" data-bs-target="#detail"
                        type="button" role="tab" aria-controls="detail" aria-selected="true">Detalle</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="observations-tab" data-bs-toggle="tab" data-bs-target="#observations"
                        type="button" role="tab" aria-controls="observations" aria-selected="false">
                        Observaciones
                        <span class="badge bg-primary ms-1">{{ $request->observations->count() }}</span>
                    </button>
                </li>
            </ul>

            <div class="tab-content" id="requestTabsContent">
                {{-- Tab Detalle --}}
                <div class="tab-pane fade show active" id="detail" role="tabpanel" aria-labelledby="detail-tab">
                    <livewire:tourism.third-party-request.detail-view :request="$request" />
                </div>

                {{-- Tab Observaciones --}}
                <div class="tab-pane fade" id="observations" role="tabpanel" aria-labelledby="observations-tab">
                    <livewire:tourism.third-party-request.observations-tab :request="$request" />
                </div>
            </div>
        </div>
    </div>
@endsection
