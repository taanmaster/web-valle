@extends('layouts.master')
@section('title') Costos de Trámites @endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1') Desarrollo Urbano @endslot
        @slot('li_2') Trámites y Servicios @endslot
        @slot('title') Actualización de Costos @endslot
    @endcomponent

    <div class="row layout-spacing">
        <div class="main-content">

            <div class="d-flex align-items-center gap-3 mb-4">
                <div class="bg-success bg-opacity-10 rounded-circle p-3">
                    <i class="fas fa-money-bill fa-lg text-success"></i>
                </div>
                <div>
                    <h4 class="fw-bold mb-0">Actualización de Costos</h4>
                    <p class="text-muted mb-0">Edita únicamente los montos de cada trámite y servicio de Desarrollo Urbano. El contenido y los pasos no se modifican aquí.</p>
                </div>
            </div>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-check-circle me-2"></i>
                        <div>{{ session('success') }}</div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="row g-4">
                @foreach ($tramites as $slug => $costs)
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm h-100" style="border-radius: 12px;">
                            <div class="card-header bg-success text-white d-flex justify-content-between align-items-center"
                                style="border-radius: 12px 12px 0 0;">
                                <h6 class="mb-0 fw-bold">{{ $costs->first()->tramite_title }}</h6>
                                <a href="{{ route('urban_dev.costs.edit', $slug) }}"
                                    class="btn btn-sm btn-light fw-semibold">
                                    <i class="fas fa-edit"></i> Editar costos
                                </a>
                            </div>
                            <div class="card-body">
                                @foreach ($costs as $cost)
                                    <div class="d-flex justify-content-between align-items-center py-2 {{ !$loop->last ? 'border-bottom' : '' }}">
                                        <span class="text-muted small">{{ $cost->description }}</span>
                                        <span class="badge bg-success bg-opacity-10 text-success fw-bold px-3 py-2">
                                            {{ $cost->formatted_price }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </div>
@endsection
