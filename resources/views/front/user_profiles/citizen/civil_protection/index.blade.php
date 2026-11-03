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
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="mb-0">Protección Civil - Mis trámites</h5>
                            <a href="{{ route('citizen.civil_protection.hub') }}" class="btn" style="background-color:#6d1b2b; color:#fff;">
                                <ion-icon name="add-circle-outline"></ion-icon> Nuevo trámite
                            </a>
                        </div>

                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        @if ($cases->isEmpty())
                            <div class="text-center py-5">
                                <ion-icon name="file-tray-outline" style="font-size: 3rem;" class="text-muted"></ion-icon>
                                <p class="mb-0 text-muted">Aún no tienes trámites de Protección Civil.</p>
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Folio</th>
                                            <th>Trámite</th>
                                            <th>Estatus</th>
                                            <th>Última actualización</th>
                                            <th>Vigencia</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($cases as $case)
                                            @php $url = $case->status === 'borrador' ? route('citizen.civil_protection.edit', $case) : route('citizen.civil_protection.show', $case); @endphp
                                            <tr>
                                                <td><a href="{{ $url }}" class="fw-semibold">{{ $case->folio ?? 'Borrador' }}</a></td>
                                                <td>{{ $case->procedure->name }}</td>
                                                <td>
                                                    <span class="badge rounded-pill bg-{{ $case->status_color }}-subtle text-{{ $case->status_color }}">{{ \App\Models\CivilProtectionCase::STATUSES[$case->status][1] }}</span>
                                                    @if ($case->requires_citizen_action)
                                                        <small class="d-block text-danger fw-semibold">● Requiere tu acción</small>
                                                    @endif
                                                </td>
                                                <td>{{ $case->updated_at->format('d/m/Y H:i') }}</td>
                                                <td>
                                                    @if ($validity = $case->validity)
                                                        <small class="fw-semibold text-{{ $validity[1] }}">● {{ explode(' · ', $validity[0])[0] }}</small>
                                                        <small class="d-block text-muted">Vence {{ $case->expires_at->format('d/m/Y') }}</small>
                                                    @else
                                                        <span class="text-muted">—</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

