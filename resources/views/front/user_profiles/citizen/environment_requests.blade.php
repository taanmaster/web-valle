@extends('front.layouts.app')

@section('title', 'Mis Solicitudes - Medio Ambiente')

@section('content')
    @php
        $requestLabel = \App\Models\EnvironmentRequest::REQUEST_TYPES[$requestType] ?? $requestType;
    @endphp

    <div class="container py-4">
        @include('front.user_profiles.partials._profile_card')

        <div class="row g-3 mt-0">
            <div class="col-md-3">
                @include('front.user_profiles.partials._profile_nav')
            </div>
            <div class="col-md-9">
                <div class="card wow fadeInUp">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="card-title mb-0">
                            <ion-icon name="leaf-outline"></ion-icon>
                            {{ $requestLabel }} — Mis Solicitudes
                        </h5>
                        <a href="{{ route('citizen.environment.create', $requestType) }}" class="btn btn-primary btn-sm">
                            <ion-icon name="add-outline"></ion-icon> Nueva Solicitud
                        </a>
                    </div>
                    <div class="card-body">
                        @if ($environmentRequests->isEmpty())
                            <div class="text-center py-5">
                                <ion-icon name="document-text-outline" class="text-muted" style="font-size: 3rem"></ion-icon>
                                <p class="text-muted mb-0 mt-3">Aún no tienes solicitudes de {{ strtolower($requestLabel) }}.</p>
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="fw-semibold">Folio</th>
                                            <th class="fw-semibold">Fecha</th>
                                            <th class="fw-semibold">Estatus</th>
                                            <th class="fw-semibold"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($environmentRequests as $environmentRequest)
                                            <tr>
                                                <td>{{ $environmentRequest->folio }}</td>
                                                <td>{{ $environmentRequest->fecha_solicitud?->format('d/m/Y') }}</td>
                                                <td><span class="badge bg-primary">{{ $environmentRequest->status_label }}</span></td>
                                                <td class="text-end">
                                                    <a href="{{ route('citizen.environment.show', $environmentRequest) }}"
                                                        class="btn btn-sm btn-outline-primary" title="Ver solicitud" aria-label="Ver solicitud">
                                                        <ion-icon name="eye-outline"></ion-icon>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="d-flex justify-content-center">
                                {{ $environmentRequests->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
