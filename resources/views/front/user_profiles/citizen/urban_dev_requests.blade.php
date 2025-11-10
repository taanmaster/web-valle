@extends('front.layouts.app')

@section('content')
    <div class="container py-4">
        <div class="row">
            <div class="col-md-12">
                @include('front.user_profiles.partials._profile_card')

                <!-- Menú de navegación -->
                <div class="card wow fadeInUp">
                    <div class="card-header">
                        <ul class="nav nav-tabs card-header-tabs" id="citizenProfileTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" href="{{ route('citizen.profile.index') }}" id="inicio-tab"
                                    role="tab">
                                    <ion-icon name="home-outline"></ion-icon> Inicio
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" href="{{ route('citizen.profile.edit') }}" id="perfil-tab"
                                    role="tab">
                                    <ion-icon name="create-outline"></ion-icon> Editar Perfil
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" href="{{ route('citizen.profile.requests') }}" id="solicitudes-tab"
                                    role="tab">
                                    <ion-icon name="file-tray-full-outline"></ion-icon> Solicitudes S.A.R.E
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" href="{{ route('citizen.profile.urban_dev_requests') }}"
                                    id="solicitudes-tab" role="tab">
                                    <ion-icon name="file-tray-full-outline"></ion-icon> Trámites Desarrollo Urbano
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" href="{{ route('citizen.summons.index') }}" id="citatorios-tab"
                                    role="tab">
                                    <ion-icon name="document-text-outline"></ion-icon>Citatorios
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" href="{{ route('citizen.profile.settings') }}" id="configuraciones-tab"
                                    role="tab">
                                    <ion-icon name="cog-outline"></ion-icon> Configuraciones
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="mb-0">
                                <ion-icon name="file-tray-full-outline"></ion-icon> Mis Trámites de Desarrollo Urbano
                            </h5>
                            <a href="{{ route('citizen.urban_dev.create') }}" class="btn btn-primary">
                                <ion-icon name="add-circle-outline"></ion-icon> Nueva Solicitud
                            </a>
                        </div>

                        <!-- Filtros -->
                        <div class="row mb-4">
                            <div class="col-md-3">
                                <select class="form-select" id="statusFilter">
                                    <option value="">Todos los estados</option>
                                    <option value="new">Nuevo</option>
                                    <option value="initial_review">Revisión Inicial</option>
                                    <option value="requirement_validation">Validación de Requisitos</option>
                                    <option value="requires_correction">Requiere Corrección</option>
                                    <option value="payment_pending">Pago Pendiente</option>
                                    <option value="authorization_process">Proceso de Autorización</option>
                                    <option value="authorized">Autorizada</option>
                                    <option value="rejected">Rechazada</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select class="form-select" id="typeFilter">
                                    <option value="">Todos los tipos</option>
                                    <option value="uso-de-suelo">Uso de Suelo</option>
                                    <option value="constancia-de-factibilidad">Constancia de Factibilidad</option>
                                    <option value="permiso-de-anuncios">Permiso de Anuncios</option>
                                    <option value="certificacion-numero-oficial">Certificación Número Oficial</option>
                                    <option value="permiso-de-division">Permiso de División</option>
                                    <option value="uso-de-via-publica">Uso de Vía Pública</option>
                                    <option value="licencia-de-construccion">Licencia de Construcción</option>
                                    <option value="permiso-construccion-panteones">Construcción en Panteones</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <input type="text" class="form-control"
                                        placeholder="Buscar por tipo de trámite o descripción..." id="searchInput">
                                    <button class="btn btn-outline-secondary" type="button" id="searchBtn">
                                        <ion-icon name="search-outline"></ion-icon>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Lista de solicitudes -->
                        <div class="row" id="requestsList">
                            @if ($urbanDevRequests->count() > 0)
                                @foreach ($urbanDevRequests as $request)
                                    @php
                                        // Configuración de documentos por tipo de trámite
                                        $documentsConfig = [
                                            'uso-de-suelo' => [
                                                'Solicitud por escrito dirigida al Director',
                                                'Copia de identificación oficial vigente',
                                                'Escritura pública o documento de propiedad',
                                                'Último recibo de pago del impuesto predial',
                                                'Plano de localización del predio (escala 1:1000)',
                                                'Croquis de ubicación con referencias y medidas',
                                            ],
                                            'constancia-de-factibilidad' => [
                                                'Solicitud detallada del proyecto',
                                                'Proyecto arquitectónico o memoria descriptiva',
                                                'Escritura pública de propiedad',
                                                'Plano topográfico actualizado',
                                                'Estudio de factibilidad de servicios públicos',
                                                'Dictamen de uso de suelo vigente',
                                            ],
                                            'permiso-de-anuncios' => [
                                                'Solicitud especificando tipo y características',
                                                'Diseño gráfico y especificaciones técnicas',
                                                'Documento de propiedad o autorización',
                                                'Memoria de cálculo estructural (si aplica)',
                                                'Plano de localización y ubicación exacta',
                                                'Fotografías del lugar de instalación',
                                            ],
                                            'certificacion-numero-oficial' => [
                                                'Solicitud dirigida al Director',
                                                'Escritura pública o documento de propiedad',
                                                'Constancia de alineamiento vigente',
                                                'Plano de localización con medidas exactas',
                                                'Identificación oficial del propietario',
                                                'Último recibo de impuesto predial',
                                            ],
                                            'permiso-de-division' => [
                                                'Solicitud con proyecto de división',
                                                'Escritura pública de propiedad',
                                                'Levantamiento topográfico certificado',
                                                'Proyecto de lotificación completo',
                                                'Dictamen de factibilidad de servicios',
                                                'Estudio de impacto urbano y vial',
                                            ],
                                            'uso-de-via-publica' => [
                                                'Solicitud especificando uso y tiempo',
                                                'Croquis del área a ocupar',
                                                'Programa de actividades y horarios',
                                                'Medidas de seguridad propuestas',
                                                'Póliza de seguro de responsabilidad civil',
                                                'Autorización de vecinos (si aplica)',
                                            ],
                                            'licencia-de-construccion' => [
                                                'Solicitud con proyecto arquitectónico',
                                                'Planos estructurales firmados por DRO',
                                                'Memoria de cálculo y especificaciones',
                                                'Dictamen de uso de suelo compatible',
                                                'Factibilidades de servicios públicos',
                                                'Estudio de mecánica de suelos (si aplica)',
                                            ],
                                            'permiso-construccion-panteones' => [
                                                'Solicitud dirigida a Administración del Panteón',
                                                'Proyecto de construcción funeraria',
                                                'Documento de propiedad o concesión del lote',
                                                'Especificaciones de materiales y acabados',
                                                'Plano de ubicación dentro del cementerio',
                                                'Autorización de familiares o herederos',
                                            ],
                                        ];

                                        $totalDocuments = count($documentsConfig[$request->request_type] ?? []);
                                        $uploadedDocuments = $request->files->count();
                                        $progressPercentage =
                                            $totalDocuments > 0
                                                ? round(($uploadedDocuments / $totalDocuments) * 100)
                                                : 0;

                                        // Determinar color de la barra de progreso
                                        $progressColor = 'danger';
                                        if ($progressPercentage >= 80) {
                                            $progressColor = 'success';
                                        } elseif ($progressPercentage >= 50) {
                                            $progressColor = 'warning';
                                        } elseif ($progressPercentage >= 25) {
                                            $progressColor = 'info';
                                        }
                                    @endphp

                                    <div class="col-lg-6 col-xl-4 request-item mb-4" data-status="{{ $request->status }}"
                                        data-type="{{ $request->request_type }}"
                                        data-search="{{ strtolower($request->getRequestTypeLabelAttribute() . ' ' . ($request->description ?? '')) }}">
                                        <div class="card h-100 shadow-sm">
                                            <div
                                                class="card-header bg-{{ $request->getStatusColorAttribute() }} text-white">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <h6 class="mb-0">
                                                        <ion-icon name="document-text-outline"></ion-icon>
                                                        Solicitud #{{ $request->id }}
                                                    </h6>
                                                    <span
                                                        class="badge bg-white text-{{ $request->getStatusColorAttribute() }} small">
                                                        {{ $request->getStatusLabelAttribute() }}
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="card-body">
                                                <h6 class="card-title text-primary mb-2">
                                                    {{ $request->getRequestTypeLabelAttribute() }}
                                                </h6>

                                                <div class="mb-3">
                                                    <small class="text-muted">
                                                        <ion-icon name="calendar-outline"></ion-icon> Creada:
                                                        {{ $request->created_at->format('d/m/Y') }}
                                                        <span class="mx-2">|</span>
                                                        <ion-icon name="time-outline"></ion-icon>
                                                        {{ $request->created_at->diffForHumans() }}
                                                    </small>
                                                </div>

                                                @if ($request->description)
                                                    <p class="card-text text-muted small mb-3">
                                                        {{ Str::limit($request->description, 80) }}
                                                    </p>
                                                @endif

                                                <!-- Información de documentos -->
                                                <div class="bg-light rounded p-3 mb-3">
                                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                                        <span class="small fw-bold">Progreso de Documentos</span>
                                                        <span
                                                            class="small">{{ $uploadedDocuments }}/{{ $totalDocuments }}</span>
                                                    </div>

                                                    <!-- Barra de progreso -->
                                                    <div class="progress mb-2" style="height: 8px;">
                                                        <div class="progress-bar bg-{{ $progressColor }}"
                                                            role="progressbar" style="width: {{ $progressPercentage }}%"
                                                            aria-valuenow="{{ $progressPercentage }}" aria-valuemin="0"
                                                            aria-valuemax="100">
                                                        </div>
                                                    </div>

                                                    <div class="d-flex justify-content-between">
                                                        <small class="text-{{ $progressColor }}">
                                                            <ion-icon name="document-outline"></ion-icon>
                                                            {{ $uploadedDocuments }} subidos
                                                        </small>
                                                        @if ($totalDocuments - $uploadedDocuments > 0)
                                                            <small class="text-muted">
                                                                <ion-icon name="document-outline"></ion-icon>
                                                                {{ $totalDocuments - $uploadedDocuments }} pendientes
                                                            </small>
                                                        @endif
                                                    </div>
                                                </div>

                                                <!-- Estado visual -->
                                                <div class="mb-3">
                                                    <div class="row text-center">
                                                        <div class="col-4">
                                                            <div class="p-2">
                                                                <div class="mb-1 {{ $progressPercentage > 0 ? 'text-success' : 'text-muted' }}"
                                                                    style="font-size: 1.2rem;">
                                                                    <ion-icon name="alert-circle-outline"></ion-icon>
                                                                </div>
                                                                <small class="d-block">Iniciado</small>
                                                            </div>
                                                        </div>
                                                        <div class="col-4">
                                                            <div class="p-2">
                                                                <div class="mb-1 {{ $progressPercentage >= 50 ? 'text-warning' : 'text-muted' }}"
                                                                    style="font-size: 1.2rem;">
                                                                    <ion-icon name="list-circle-outline"></ion-icon>
                                                                </div>
                                                                <small class="d-block">En Proceso</small>
                                                            </div>
                                                        </div>
                                                        <div class="col-4">
                                                            <div class="p-2">
                                                                <div class="mb-1 {{ $progressPercentage == 100 ? 'text-success' : 'text-muted' }}"
                                                                    style="font-size: 1.2rem;">
                                                                    <ion-icon name="checkmark-circle-outline"></ion-icon>
                                                                </div>
                                                                <small class="d-block">Completo</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="card-footer bg-light">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    @if ($request->created_at->diffInDays() <= 7)
                                                        <small class="text-success">
                                                            <ion-icon name="sparkles-outline"></ion-icon> Reciente
                                                        </small>
                                                    @else
                                                        <span></span>
                                                    @endif

                                                    <div class="btn-group btn-group-sm">
                                                        <a href="{{ route('citizen.urban_dev.show', $request->id) }}"
                                                            class="btn btn-outline-primary btn-sm">
                                                            <ion-icon name="eye-outline"></ion-icon> Ver
                                                        </a>

                                                        {{--
                                                    @if ($request->status === 'new')
                                                        <a href="{{ route('citizen.urban_dev.edit', $request->id) }}"
                                                           class="btn btn-outline-warning btn-sm">
                                                            <ion-icon name="create-outline"></ion-icon> Editar
                                                        </a>
                                                    @endif
                                                    --}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <!-- Estado vacío -->
                                <div class="col-md-12" id="emptyState">
                                    <div class="text-center py-5">
                                        <div class="text-muted mb-4">
                                            <ion-icon name="business-outline" class="display-1"></ion-icon>
                                        </div>
                                        <h5 class="mt-3">No tienes trámites de Desarrollo Urbano</h5>
                                        <p class="text-muted">Crea tu primera solicitud de desarrollo urbano para empezar
                                            el trámite</p>
                                        <a href="{{ route('citizen.urban_dev.create') }}" class="btn btn-primary">
                                            <ion-icon name="add-circle-outline"></ion-icon> Nueva Solicitud
                                        </a>
                                    </div>
                                </div>
                            @endif

                            <!-- Estado de búsqueda vacía (oculto por defecto) -->
                            <div class="col-md-12" id="noResultsState" style="display: none;">
                                <div class="text-center py-5">
                                    <ion-icon name="search-outline" class="display-1 text-muted"></ion-icon>
                                    <h5 class="mt-3 text-muted">No se encontraron trámites</h5>
                                    <p class="text-muted">
                                        Los filtros aplicados no coinciden con ninguno de tus trámites.<br>
                                        Intenta cambiar los criterios de búsqueda o limpiar los filtros.
                                    </p>
                                    <div class="mt-3">
                                        <button class="btn btn-outline-secondary btn-sm me-2" onclick="clearFilters()">
                                            <ion-icon name="refresh-outline"></ion-icon> Limpiar Filtros
                                        </button>
                                        <a href="{{ route('citizen.urban_dev.create') }}" class="btn btn-primary btn-sm">
                                            <ion-icon name="add-circle-outline"></ion-icon> Nueva Solicitud
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Paginación -->
                        @if ($urbanDevRequests->hasPages())
                            <nav aria-label="Paginación de trámites de desarrollo urbano">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <p class="text-muted mb-0">
                                            Mostrando {{ $urbanDevRequests->firstItem() }} a
                                            {{ $urbanDevRequests->lastItem() }}
                                            de {{ $urbanDevRequests->total() }} trámites
                                        </p>
                                    </div>
                                    <div>
                                        {{ $urbanDevRequests->links() }}
                                    </div>
                                </div>
                            </nav>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <script>
            // Funciones de filtrado y búsqueda
            function initializeFilters() {
                const statusFilter = document.getElementById('statusFilter');
                const typeFilter = document.getElementById('typeFilter');
                const searchInput = document.getElementById('searchInput');
                const searchBtn = document.getElementById('searchBtn');

                // Event listeners para filtros
                statusFilter.addEventListener('change', filterRequests);
                typeFilter.addEventListener('change', filterRequests);
                searchInput.addEventListener('input', filterRequests);
                searchBtn.addEventListener('click', filterRequests);

                // Filtro en tiempo real
                searchInput.addEventListener('keyup', function(e) {
                    if (e.key === 'Enter') {
                        filterRequests();
                    }
                });
            }

            function filterRequests() {
                const statusFilter = document.getElementById('statusFilter').value.toLowerCase();
                const typeFilter = document.getElementById('typeFilter').value.toLowerCase();
                const searchTerm = document.getElementById('searchInput').value.toLowerCase();

                const requestItems = document.querySelectorAll('.request-item');
                const emptyState = document.getElementById('emptyState');
                const noResultsState = document.getElementById('noResultsState');

                let visibleCount = 0;

                requestItems.forEach(item => {
                    const status = item.dataset.status.toLowerCase();
                    const type = item.dataset.type.toLowerCase();
                    const searchData = item.dataset.search.toLowerCase();

                    let statusMatch = !statusFilter || status === statusFilter;
                    let typeMatch = !typeFilter || type === typeFilter;
                    let searchMatch = !searchTerm || searchData.includes(searchTerm);

                    if (statusMatch && typeMatch && searchMatch) {
                        item.style.display = 'block';
                        visibleCount++;
                    } else {
                        item.style.display = 'none';
                    }
                });

                // Mostrar/ocultar estados
                if (visibleCount === 0) {
                    if (requestItems.length === 0) {
                        if (emptyState) emptyState.style.display = 'block';
                        if (noResultsState) noResultsState.style.display = 'none';
                    } else {
                        if (emptyState) emptyState.style.display = 'none';
                        if (noResultsState) noResultsState.style.display = 'block';
                    }
                } else {
                    if (emptyState) emptyState.style.display = 'none';
                    if (noResultsState) noResultsState.style.display = 'none';
                }
            }

            function clearFilters() {
                document.getElementById('statusFilter').value = '';
                document.getElementById('typeFilter').value = '';
                document.getElementById('searchInput').value = '';
                filterRequests();
            }

            // Inicializar cuando la página esté lista
            document.addEventListener('DOMContentLoaded', function() {
                initializeFilters();
            });
        </script>
    @endpush

@endsection
