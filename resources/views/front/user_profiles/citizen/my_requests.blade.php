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

                        @switch($type)

                            {{-- ===== ECONOMÍA ===== --}}
                            @case('economia')
                                <h5 class="mb-4">
                                    <ion-icon name="storefront-outline"></ion-icon> Economía — Mis Solicitudes
                                </h5>
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <div class="card h-100 border">
                                            <div class="card-body d-flex flex-column">
                                                <div class="mb-3">
                                                    <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 mb-2">
                                                        <ion-icon name="document-text-outline" class="me-1"></ion-icon> S.A.R.E
                                                    </span>
                                                </div>
                                                <h5 class="card-title fw-semibold">S.A.R.E</h5>
                                                <p class="card-text text-muted flex-grow-1">
                                                    Gestiona y da seguimiento a tus solicitudes ciudadanas de S.A.R.E.
                                                </p>
                                                <a href="{{ route('citizen.profile.requests') }}" class="btn btn-primary">
                                                    <ion-icon name="eye-outline"></ion-icon> Ver Solicitudes
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @break

                            {{-- ===== TURISMO ===== --}}
                            @case('tramites')
                                <h5 class="mb-4">
                                    <ion-icon name="earth-outline"></ion-icon> Turismo — Mis Solicitudes
                                </h5>
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <div class="card h-100 border">
                                            <div class="card-body d-flex flex-column">
                                                <div class="mb-3">
                                                    <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 mb-2">
                                                        <ion-icon name="earth-outline" class="me-1"></ion-icon> Turismo
                                                    </span>
                                                </div>
                                                <h5 class="card-title fw-semibold">Apoyos a Terceros</h5>
                                                <p class="card-text text-muted flex-grow-1">
                                                    Gestiona y da seguimiento a tus solicitudes ciudadanas de apoyo a terceros de Turismo.
                                                </p>
                                                <a href="{{ route('citizen.third_party.index') }}" class="btn btn-success">
                                                    <ion-icon name="eye-outline"></ion-icon> Ver Solicitudes
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @break

                            {{-- ===== SECRETARÍA DE AYUNTAMIENTO ===== --}}
                            @case('secretaria-de-ayuntamiento')
                                <h5 class="mb-4">
                                    <ion-icon name="business-outline"></ion-icon> Secretaría de Ayuntamiento — Mis Solicitudes
                                </h5>

                                {{-- Tabs navegación --}}
                                <ul class="nav nav-tabs mb-4" id="secretariaTabs" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="tab-mis-solicitudes"
                                            data-bs-toggle="tab" data-bs-target="#pane-mis-solicitudes"
                                            type="button" role="tab" aria-controls="pane-mis-solicitudes" aria-selected="true">
                                            <ion-icon name="apps-outline" class="me-1"></ion-icon> Mis Solicitudes
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="tab-mis-constancias"
                                            data-bs-toggle="tab" data-bs-target="#pane-mis-constancias"
                                            type="button" role="tab" aria-controls="pane-mis-constancias" aria-selected="false">
                                            <ion-icon name="documents-outline" class="me-1"></ion-icon> Mis Constancias
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="tab-nueva-solicitud"
                                            data-bs-toggle="tab" data-bs-target="#pane-nueva-solicitud"
                                            type="button" role="tab" aria-controls="pane-nueva-solicitud" aria-selected="false">
                                            <ion-icon name="add-circle-outline" class="me-1"></ion-icon> Nueva Solicitud
                                        </button>
                                    </li>
                                </ul>

                                <div class="tab-content" id="secretariaTabsContent">

                                    {{-- Tab: Mis Solicitudes — 3 tarjetas con botón Ver Solicitudes --}}
                                    <div class="tab-pane fade show active" id="pane-mis-solicitudes"
                                        role="tabpanel" aria-labelledby="tab-mis-solicitudes">
                                        <div class="row">

                                            {{-- Constancia de Origen --}}
                                            <div class="col-md-4 mb-4">
                                                <div class="card h-100 border">
                                                    <div class="card-body d-flex flex-column">
                                                        <div class="mb-3">
                                                            <span class="badge bg-secondary bg-opacity-10 text-secondary px-3 py-2 mb-2">
                                                                <ion-icon name="document-outline" class="me-1"></ion-icon> Sec. Ayuntamiento
                                                            </span>
                                                        </div>
                                                        <h5 class="card-title fw-semibold">Constancia de Origen</h5>
                                                        <p class="card-text text-muted flex-grow-1">
                                                            Gestiona y da seguimiento a tus solicitudes de constancia de origen.
                                                        </p>
                                                        <button type="button" class="btn btn-secondary"
                                                            onclick="switchToConstanciasTab('Constancia de Origen')">
                                                            <ion-icon name="eye-outline"></ion-icon> Ver Solicitudes
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- Constancia de Identidad --}}
                                            <div class="col-md-4 mb-4">
                                                <div class="card h-100 border">
                                                    <div class="card-body d-flex flex-column">
                                                        <div class="mb-3">
                                                            <span class="badge bg-secondary bg-opacity-10 text-secondary px-3 py-2 mb-2">
                                                                <ion-icon name="person-outline" class="me-1"></ion-icon> Sec. Ayuntamiento
                                                            </span>
                                                        </div>
                                                        <h5 class="card-title fw-semibold">Constancia de Identidad</h5>
                                                        <p class="card-text text-muted flex-grow-1">
                                                            Gestiona y da seguimiento a tus solicitudes de constancia de identidad.
                                                        </p>
                                                        <button type="button" class="btn btn-secondary"
                                                            onclick="switchToConstanciasTab('Constancia de Identidad')">
                                                            <ion-icon name="eye-outline"></ion-icon> Ver Solicitudes
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- Certificación de Documentos --}}
                                            <div class="col-md-4 mb-4">
                                                <div class="card h-100 border">
                                                    <div class="card-body d-flex flex-column">
                                                        <div class="mb-3">
                                                            <span class="badge bg-secondary bg-opacity-10 text-secondary px-3 py-2 mb-2">
                                                                <ion-icon name="ribbon-outline" class="me-1"></ion-icon> Sec. Ayuntamiento
                                                            </span>
                                                        </div>
                                                        <h5 class="card-title fw-semibold">Certificación de Documentos</h5>
                                                        <p class="card-text text-muted flex-grow-1">
                                                            Gestiona y da seguimiento a tus solicitudes ciudadanas de certificación de documentos que expide la secretaría de ayuntamiento.
                                                        </p>
                                                        <a href="{{ route('citizen.profile.document_certificates') }}" class="btn btn-secondary">
                                                            <ion-icon name="eye-outline"></ion-icon> Ver Solicitudes
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    {{-- Tab: Mis Constancias --}}
                                    <div class="tab-pane fade" id="pane-mis-constancias"
                                        role="tabpanel" aria-labelledby="tab-mis-constancias">
                                        <livewire:identification-certificates.table :mode="1" :userId="Auth::user()->id" />
                                    </div>

                                    {{-- Tab: Nueva Solicitud --}}
                                    <div class="tab-pane fade" id="pane-nueva-solicitud"
                                        role="tabpanel" aria-labelledby="tab-nueva-solicitud">
                                        <livewire:front.identification-certificates.crud />
                                    </div>

                                </div>
                            @break

                            {{-- ===== HUB (sin tipo — compatibilidad hacia atrás) ===== --}}
                            @default
                                <h5 class="mb-4">
                                    <ion-icon name="file-tray-full-outline"></ion-icon> Mis Solicitudes
                                </h5>
                                <div class="row">
                                    {{-- Card S.A.R.E --}}
                                    <div class="col-md-6 mb-4">
                                        <div class="card h-100 border">
                                            <div class="card-body d-flex flex-column">
                                                <div class="mb-3">
                                                    <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 mb-2">
                                                        <ion-icon name="document-text-outline" class="me-1"></ion-icon> S.A.R.E
                                                    </span>
                                                </div>
                                                <h5 class="card-title fw-semibold">S.A.R.E</h5>
                                                <p class="card-text text-muted flex-grow-1">
                                                    Gestiona y da seguimiento a tus solicitudes ciudadanas de S.A.R.E.
                                                </p>
                                                <a href="{{ route('citizen.profile.requests') }}" class="btn btn-primary">
                                                    <ion-icon name="eye-outline"></ion-icon> Ver Solicitudes
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Card Apoyos a Terceros --}}
                                    <div class="col-md-6 mb-4">
                                        <div class="card h-100 border">
                                            <div class="card-body d-flex flex-column">
                                                <div class="mb-3">
                                                    <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 mb-2">
                                                        <ion-icon name="earth-outline" class="me-1"></ion-icon> Turismo
                                                    </span>
                                                </div>
                                                <h5 class="card-title fw-semibold">Apoyos a Terceros</h5>
                                                <p class="card-text text-muted flex-grow-1">
                                                    Gestiona y da seguimiento a tus solicitudes ciudadanas de apoyo a terceros de Turismo.
                                                </p>
                                                <a href="{{ route('citizen.third_party.index') }}" class="btn btn-success">
                                                    <ion-icon name="eye-outline"></ion-icon> Ver Solicitudes
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        @endswitch

                        {{-- Ayuda --}}
                        <div class="border rounded text-center p-3 mt-2">
                            <p class="text-muted mb-0 small">
                                ¿Necesitas ayuda? Contacta a soporte ciudadano:
                                <a href="mailto:comunicacion.social@valledesantiago.gob.mx">comunicacion.social@valledesantiago.gob.mx</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    function switchToConstanciasTab(type) {
        const tabEl = document.querySelector('#tab-mis-constancias');
        if (tabEl) {
            bootstrap.Tab.getOrCreateInstance(tabEl).show();
        }
        Livewire.dispatch('filterByType', { type: type });
    }
</script>
@endpush
