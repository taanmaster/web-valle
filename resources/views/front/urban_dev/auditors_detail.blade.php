@extends('front.layouts.app')

@section('content')
    <div class="container">
        @include('front.urban_dev.utilities._auditor_nav')

        <style>
            /* Avatar circular */
            .uv-avatar {
                width: 44px;
                height: 44px;
                min-width: 44px;
                min-height: 44px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                border-radius: 50%;
                font-weight: 600;
            }

            /* Worker item cursor pointer */
            .worker-item {
                cursor: pointer;
            }
        </style>

        <div class="row justify-content-center mb-4">
            <div class="col-md-12">
                <div class="card card-image card-image-banner justify-content-center wow fadeInUp">
                    <img class="card-img-top" src="{{ asset('front/img/placeholder-8.jpg') }}" alt="">
                    <div class="overlay" style="opacity: .4"></div>
                    <div class="card-content text-center w-100">
                        <p class="small-uppercase mb-0">Directorio y Contactos</p>
                        <h1 class="display-1 mb-0">{{ $title }}</h1>
                    </div>
                </div>
            </div>
        </div>

        <div class="card card-normal wow fadeInUp mb-4">
            <div class="w-100">
                <!-- Búsqueda -->
                <div class="row mb-3">
                    <div class="col-12 col-md-6">
                        <div class="input-group">
                            <input id="searchContact" type="text" class="form-control" placeholder="Buscar contacto por nombre">
                            <button class="btn btn-outline-secondary" type="button" aria-label="Buscar">
                                <ion-icon name="search-outline"></ion-icon>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Cabecera -->
                <div class="row text-muted small fw-bold mb-2 mt-5">
                    <div class="col-12 col-md-6">Nombre / Puesto</div>
                    <div class="d-none d-md-block col-md-2 text-center">No. Empleado</div>
                    <div class="col-12 col-md-4">Vigencia</div>
                </div>

                <!-- Contactos -->
                <div class="list-group list-group-flush" id="contactList">
                    @forelse($workers as $worker)
                        @php
                            $bgColors = ['bg-primary','bg-secondary','bg-success','bg-danger','bg-warning','bg-info','bg-dark'];
                            $bg = $bgColors[array_rand($bgColors)];
                            $initials = strtoupper(substr($worker->name, 0, 1) . substr($worker->last_name, 0, 1));
                        @endphp
                        <div class="list-group-item py-3 worker-item" data-bs-toggle="modal" data-bs-target="#workerModal{{ $worker->id }}">
                            <div class="row align-items-center">
                                <div class="col-12 col-md-6 d-flex align-items-center flex-nowrap">
                                    @if($worker->s3_asset_url)
                                        <img src="{{ $worker->s3_asset_url }}" alt="{{ $worker->full_name }}" class="uv-avatar me-3 flex-shrink-0" style="object-fit: cover;">
                                    @else
                                        <div class="uv-avatar text-white me-3 flex-shrink-0 {{ $bg }} fs-6 fw-bold" role="img" aria-label="avatar">{{ $initials }}</div>
                                    @endif
                                    <div>
                                        <div class="fw-semibold">{{ $worker->full_name }}</div>
                                        <div class="small text-muted">{{ $worker->position }}</div>
                                    </div>
                                </div>
                                <div class="d-none d-md-flex col-md-2 justify-content-center">
                                    <div class="fw-bold">{{ $worker->employee_number }}</div>
                                </div>
                                <div class="col-12 col-md-4">
                                    <div class="small">
                                        @if($worker->validity_date_end && $worker->validity_date_end->isFuture())
                                            <span class="badge bg-success">Vigente</span>
                                            hasta {{ $worker->validity_date_end->format('d/m/Y') }}
                                        @elseif($worker->validity_date_end && $worker->validity_date_end->isPast())
                                            <span class="badge bg-danger">Vencida</span>
                                            desde {{ $worker->validity_date_end->format('d/m/Y') }}
                                        @else
                                            <span class="badge bg-info">Sin fecha de vencimiento</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5">
                            <ion-icon name="people-outline" style="font-size: 4rem; opacity: 0.3;"></ion-icon>
                            <p class="text-muted mt-3">No hay trabajadores registrados en esta categoría.</p>
                        </div>
                    @endforelse
                </div>

                <div id="noResults" class="text-center py-4 small text-muted d-none">
                    <div class="mb-2"><ion-icon name="search-outline" class="fs-2"></ion-icon></div>
                    No se encontraron contactos
                </div>
            </div>
        </div>

        <!-- Modales de Identificación  -->
        @foreach($workers as $worker)
            @php
                $bgColors = ['bg-primary','bg-secondary','bg-success','bg-danger','bg-warning','bg-info','bg-dark'];
                $bg = $bgColors[array_rand($bgColors)];
                $initials = strtoupper(substr($worker->name, 0, 1) . substr($worker->last_name, 0, 1));
            @endphp
            <!-- Modal de Identificación -->
            <div class="modal fade" id="workerModal{{ $worker->id }}" tabindex="-1" aria-labelledby="workerModalLabel{{ $worker->id }}" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-header border-0">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body p-0">
                            <!-- Tarjeta de Identificación -->
                            <div class="card border-0 mb-0">
                                <div class="card-body p-0">
                                    <!-- Encabezado con foto -->
                                    <div class="bg-primary text-white p-4 text-center position-relative">
                                        <div class="position-absolute top-0 end-0 p-3">
                                            <ion-icon name="shield-checkmark" style="font-size: 2rem; opacity: 0.3;"></ion-icon>
                                        </div>
                                        <div class="d-flex justify-content-center mb-3">
                                            @if($worker->s3_asset_url)
                                                <img src="{{ $worker->s3_asset_url }}" alt="{{ $worker->full_name }}" class="rounded-circle border border-4 border-white shadow" style="width: 120px; height: 120px; object-fit: cover;">
                                            @else
                                                <div class="rounded-circle border border-4 border-white shadow bg-white text-primary d-flex align-items-center justify-content-center" style="width: 120px; height: 120px; font-size: 2.5rem; font-weight: bold;">
                                                    {{ $initials }}
                                                </div>
                                            @endif
                                        </div>
                                        <h3 class="mb-1 fw-bold text-white">{{ $worker->full_name }}</h3>
                                        <p class="mb-0 opacity-75 text-white">{{ $worker->position }}</p>
                                    </div>

                                    <!-- Información detallada -->
                                    <div class="p-4">
                                        <div class="row g-4">
                                            <!-- Número de Empleado -->
                                            <div class="col-md-6">
                                                <div class="d-flex align-items-start">
                                                    <div class="flex-shrink-0">
                                                        <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                            <ion-icon name="card-outline" style="font-size: 1.2rem;"></ion-icon>
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1 ms-3">
                                                        <p class="small text-muted mb-1">No. de Empleado</p>
                                                        <p class="mb-0 fw-semibold">{{ $worker->employee_number }}</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Categoría -->
                                            <div class="col-md-6">
                                                <div class="d-flex align-items-start">
                                                    <div class="flex-shrink-0">
                                                        <div class="bg-info bg-opacity-10 text-info rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                            <ion-icon name="business-outline" style="font-size: 1.2rem;"></ion-icon>
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1 ms-3">
                                                        <p class="small text-muted mb-1">Categoría</p>
                                                        <p class="mb-0 fw-semibold">{{ $worker->dependency_category }}</p>
                                                        @if($worker->dependency_subcategory)
                                                            <p class="small text-muted mb-0">{{ $worker->dependency_subcategory }}</p>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Fecha de Emisión -->
                                            <div class="col-md-6">
                                                <div class="d-flex align-items-start">
                                                    <div class="flex-shrink-0">
                                                        <div class="bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                            <ion-icon name="calendar-outline" style="font-size: 1.2rem;"></ion-icon>
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1 ms-3">
                                                        <p class="small text-muted mb-1">Fecha de Emisión</p>
                                                        <p class="mb-0 fw-semibold">{{ $worker->issue_date->format('d/m/Y') }}</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Vigencia -->
                                            <div class="col-md-6">
                                                <div class="d-flex align-items-start">
                                                    <div class="flex-shrink-0">
                                                        <div class="bg-warning bg-opacity-10 text-warning rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                            <ion-icon name="time-outline" style="font-size: 1.2rem;"></ion-icon>
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1 ms-3">
                                                        <p class="small text-muted mb-1">Período de Vigencia</p>
                                                        <p class="mb-0 fw-semibold">
                                                            {{ $worker->validity_date_start->format('d/m/Y') }}
                                                            @if($worker->validity_date_end)
                                                                - {{ $worker->validity_date_end->format('d/m/Y') }}
                                                            @else
                                                                - Indefinida
                                                            @endif
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Estado de Vigencia -->
                                            <div class="col-12">
                                                <div class="alert mb-0 
                                                    @if($worker->validity_date_end && $worker->validity_date_end->isFuture())
                                                        alert-success
                                                    @elseif($worker->validity_date_end && $worker->validity_date_end->isPast())
                                                        alert-danger
                                                    @else
                                                        alert-info
                                                    @endif
                                                " role="alert">
                                                    <div class="d-flex align-items-center">
                                                        <ion-icon name="
                                                            @if($worker->validity_date_end && $worker->validity_date_end->isFuture())
                                                                checkmark-circle
                                                            @elseif($worker->validity_date_end && $worker->validity_date_end->isPast())
                                                                close-circle
                                                            @else
                                                                information-circle
                                                            @endif
                                                        " class="me-2" style="font-size: 1.5rem;"></ion-icon>
                                                        <div>
                                                            @if($worker->validity_date_end && $worker->validity_date_end->isFuture())
                                                                <strong>Credencial Vigente</strong><br>
                                                                <small>Válida hasta el {{ $worker->validity_date_end->format('d/m/Y') }}</small>
                                                            @elseif($worker->validity_date_end && $worker->validity_date_end->isPast())
                                                                <strong>Credencial Vencida</strong><br>
                                                                <small>Venció el {{ $worker->validity_date_end->format('d/m/Y') }}</small>
                                                            @else
                                                                <strong>Vigencia Indefinida</strong><br>
                                                                <small>Esta credencial no tiene fecha de vencimiento establecida</small>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Footer con logo o sello -->
                                    <div class="border-top p-3 text-center bg-light">
                                        <small class="text-muted">
                                            <ion-icon name="shield-checkmark-outline"></ion-icon>
                                            Gobierno Municipal de Valle de Santiago
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        @include('front.urban_dev.utilities._footer')
    </div>

    <!-- Script para funcionalidad de búsqueda -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchContact');
            const contactItems = document.querySelectorAll('#contactList .worker-item');
            const noResults = document.getElementById('noResults');

            function updateFilter() {
                const searchTerm = searchInput.value.toLowerCase().trim();
                let visibleCount = 0;

                contactItems.forEach(function(item) {
                    const contactNameEl = item.querySelector('.fw-semibold');
                    const contactName = contactNameEl ? contactNameEl.textContent.toLowerCase() : '';
                    const matches = contactName.includes(searchTerm);
                    item.classList.toggle('d-none', !matches);
                    if (matches) visibleCount++;
                });

                noResults.classList.toggle('d-none', !(visibleCount === 0 && searchTerm !== ''));
            }

            if (searchInput) {
                searchInput.addEventListener('input', updateFilter);

                // Botón de búsqueda: enfocar input
                const searchBtn = searchInput.closest('.input-group')?.querySelector('button');
                if (searchBtn) searchBtn.addEventListener('click', function() { searchInput.focus(); });

                // Evitar submit con Enter
                searchInput.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') e.preventDefault();
                });
            }
        });
    </script>
@endsection

