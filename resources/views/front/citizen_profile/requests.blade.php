@extends('front.layouts.app')

@section('content')
    <div class="container py-4">
        <div class="row">
            <div class="col-md-12">
                @include('front.citizen_profile.partials._profile_card')

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
                                <a class="nav-link active" href="{{ route('citizen.profile.requests') }}"
                                    id="solicitudes-tab" role="tab">
                                    <ion-icon name="file-tray-full-outline"></ion-icon> Solicitudes S.A.R.E
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" href="{{ route('citizen.profile.urban_dev_requests') }}"
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
                                <ion-icon name="file-tray-full-outline"></ion-icon> Mis Solicitudes
                            </h5>
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newRequestModal">
                                <ion-icon name="add-circle-outline"></ion-icon> Nueva Solicitud SARE
                            </button>
                        </div>

                        <!-- Filtros -->
                        <!-- Filtros -->
                        <div class="row mb-4">
                            <div class="col-md-3">
                                <select class="form-select" id="statusFilter">
                                    <option value="">Todos los estados</option>
                                    <option value="new">Nuevo</option>
                                    <option value="in_progress">En Progreso</option>
                                    <option value="cancelled">Cancelado</option>
                                    <option value="payment_pending">Pago Pendiente</option>
                                    <option value="authorized">Autorizado</option>
                                    <option value="rejected">Rechazado</option>
                                    <option value="validation">Validación</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select class="form-select" id="typeFilter">
                                    <option value="">Todos los tipos</option>
                                    <option value="general">General</option>
                                    <option value="nuevo">Permiso Nuevo</option>
                                    <option value="renovacion">Renovación</option>
                                    <option value="anuncio">Anuncio</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <input type="text" class="form-control"
                                        placeholder="Buscar por número, RFC o nombre comercial..." id="searchInput">
                                    <button class="btn btn-outline-secondary" type="button" id="searchBtn">
                                        <ion-icon name="search-outline"></ion-icon>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Lista de solicitudes -->
                        <div class="row" id="requestsList">
                            @if ($sareRequests->count() > 0)
                                @foreach ($sareRequests as $request)
                                    <div class="col-md-12 request-item" data-status="{{ $request->status }}"
                                        data-type="{{ $request->request_type }}"
                                        data-search="{{ strtolower($request->request_num . ' ' . $request->rfc_name . ' ' . $request->commercial_name) }}">
                                        <div class="card mb-3">
                                            <div class="card-body">
                                                <div class="row align-items-center">
                                                    <div class="col-md-8">
                                                        <h6 class="mb-1">Solicitud SARE #{{ $request->request_num }}</h6>
                                                        <p class="text-muted mb-1">
                                                            <i class="bx bx-calendar"></i> Creada:
                                                            {{ $request->created_at->format('d/m/Y') }}
                                                            <span class="mx-2">|</span>
                                                            <i class="bx bx-tag"></i>
                                                            {{ ucfirst($request->request_type) }}
                                                            <span class="mx-2">|</span>
                                                            <i class="bx bx-building"></i> {{ $request->commercial_name }}
                                                        </p>
                                                        <p class="mb-0">
                                                            <strong>RFC:</strong> {{ $request->rfc_name }}
                                                            <span class="mx-2">|</span>
                                                            <strong>Propietario:</strong> {{ $request->property_owner }}
                                                        </p>
                                                        @if ($request->description)
                                                            <small
                                                                class="text-muted">{{ Str::limit($request->description, 100) }}</small>
                                                        @endif
                                                    </div>
                                                    <div class="col-md-2 text-center">
                                                        <span
                                                            class="badge bg-{{ $request->status_color }}">{{ $request->status_label }}</span>
                                                        @if ($request->created_at->diffInDays() <= 7)
                                                            <br><small class="text-success"><i class="bx bx-time"></i>
                                                                Reciente</small>
                                                        @endif
                                                    </div>
                                                    <div class="col-md-2 text-end">
                                                        <a href="{{ route('citizen.sare.show', $request->id) }}"
                                                            class="btn btn-outline-primary btn-sm">
                                                            <i class="bx bx-eye"></i> Ver Detalle
                                                        </a>
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
                                        <i class="bx bx-file display-1 text-muted"></i>
                                        <h5 class="mt-3">No tienes solicitudes SARE</h5>
                                        <p class="text-muted">Crea tu primera solicitud SARE para empezar el trámite</p>
                                        <button class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#newRequestModal">
                                            <ion-icon name="add-circle-outline"></ion-icon> Nueva Solicitud SARE
                                        </button>
                                    </div>
                                </div>
                            @endif

                            <!-- Estado de búsqueda vacía (oculto por defecto) -->
                            <div class="col-md-12" id="noResultsState" style="display: none;">
                                <div class="text-center py-5">
                                    <i class="bx bx-search-alt-2 display-1 text-muted"></i>
                                    <h5 class="mt-3 text-muted">No se encontraron solicitudes</h5>
                                    <p class="text-muted">
                                        Los filtros aplicados no coinciden con ninguna de tus solicitudes.<br>
                                        Intenta cambiar los criterios de búsqueda o limpiar los filtros.
                                    </p>
                                    <div class="mt-3">
                                        <button class="btn btn-outline-secondary btn-sm me-2" onclick="clearFilters()">
                                            <i class="bx bx-refresh"></i> Limpiar Filtros
                                        </button>
                                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#newRequestModal">
                                            <i class="bx bx-plus"></i> Nueva Solicitud
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Paginación -->
                        @if ($sareRequests->hasPages())
                            <nav aria-label="Paginación de solicitudes SARE">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <p class="text-muted mb-0">
                                            Mostrando {{ $sareRequests->firstItem() }} a {{ $sareRequests->lastItem() }}
                                            de {{ $sareRequests->total() }} solicitudes
                                        </p>
                                    </div>
                                    <div>
                                        {{ $sareRequests->links() }}
                                    </div>
                                </div>
                            </nav>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Detalle Solicitud -->
    <div class="modal fade" id="requestDetailModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <ion-icon name="add-circle-outline"></ion-icon> Nueva Solicitud
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="requestType" class="form-label">Tipo de Solicitud *</label>
                            <select class="form-select" id="requestType" required>
                                <option value="">Selecciona un tipo</option>
                                <option value="informacion">Solicitud de Información</option>
                                <option value="servicio">Solicitud de Servicio</option>
                                <option value="queja">Queja o Sugerencia</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="requestSubject" class="form-label">Asunto *</label>
                            <input type="text" class="form-control" id="requestSubject" required>
                        </div>

                        <div class="mb-3">
                            <label for="requestDescription" class="form-label">Descripción *</label>
                            <textarea class="form-control" id="requestDescription" rows="4" required></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="requestFiles" class="form-label">Archivos Adjuntos</label>
                            <input type="file" class="form-control" id="requestFiles" multiple>
                            <small class="form-text text-muted">Máximo 5 archivos de 10MB cada uno</small>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary">
                        <i class="bx bx-send"></i> Enviar Solicitud
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Nueva Solicitud -->
    <div class="modal fade" id="newRequestModal" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <ion-icon name="file-tray-full-outline"></ion-icon> Solicitud SARE
                    </h5>
                    <div class="d-flex gap-2">
                        <button type="button" id="fillTestDataBtn" class="btn btn-warning btn-sm">
                            <i class="bx bx-test-tube"></i> Llenar Datos de Prueba
                        </button>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                </div>
                <form id="sareRequestForm" method="POST" action="{{ route('citizen.sare.store') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <!-- Información General -->
                            <div class="col-md-12">
                                <h6 class="text-primary mb-3">
                                    <ion-icon name="information-circle-outline"></ion-icon> Información General
                                </h6>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="request_num" class="form-label">Número de Solicitud *</label>
                                    <input type="text" class="form-control" id="request_num" name="request_num"
                                        required>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="request_date" class="form-label">Fecha de Solicitud *</label>
                                    <input type="date" class="form-control" id="request_date" name="request_date"
                                        required>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="catastral_num" class="form-label">Número Catastral *</label>
                                    <input type="text" class="form-control" id="catastral_num" name="catastral_num"
                                        required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="request_type" class="form-label">Tipo de Solicitud *</label>
                                    <select class="form-select" id="request_type" name="request_type" required>
                                        <option value="">Seleccione un tipo</option>
                                        <option value="general">General</option>
                                        <option value="nuevo">Permiso Nuevo</option>
                                        <option value="renovacion">Renovación</option>
                                        <option value="anuncio">Anuncio</option>
                                    </select>
                                </div>
                            </div>


                            {{--
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status" class="form-label">Estado</label>
                                    <select class="form-select" id="status" name="status">
                                        <option value="new">Nuevo</option>
                                        <option value="in_progress">En Progreso</option>
                                        <option value="cancelled">Cancelado</option>
                                        <option value="payment_pending">Pago Pendiente</option>
                                        <option value="authorized">Autorizado</option>
                                        <option value="rejected">Rechazado</option>
                                        <option value="validation">Validación</option>
                                    </select>
                                </div>
                            </div>
                             --}}

                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="description" class="form-label">Descripción</label>
                                    <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                                </div>
                            </div>

                            <!-- Datos del Solicitante -->
                            <div class="col-md-12">
                                <hr>
                                <h6 class="text-primary mb-3">
                                    <ion-icon name="person-outline"></ion-icon> Datos del Solicitante
                                </h6>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="rfc_name" class="form-label">Nombre/Razón Social RFC *</label>
                                    <input type="text" class="form-control" id="rfc_name" name="rfc_name" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="rfc_num" class="form-label">RFC *</label>
                                    <input type="text" class="form-control" id="rfc_num" name="rfc_num" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="property_owner" class="form-label">Propietario del Inmueble *</label>
                                    <input type="text" class="form-control" id="property_owner" name="property_owner"
                                        required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email *</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="office_phone" class="form-label">Teléfono de Oficina *</label>
                                    <input type="tel" class="form-control" id="office_phone" name="office_phone"
                                        required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="mobile_phone" class="form-label">Teléfono Móvil *</label>
                                    <input type="tel" class="form-control" id="mobile_phone" name="mobile_phone"
                                        required>
                                </div>
                            </div>

                            <!-- Representante Legal -->
                            <div class="col-md-12">
                                <hr>
                                <h6 class="text-primary mb-3">
                                    <ion-icon name="people-outline"></ion-icon> Representante Legal
                                </h6>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="legal_representative_name" class="form-label">Nombre *</label>
                                    <input type="text" class="form-control" id="legal_representative_name"
                                        name="legal_representative_name" required>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="legal_representative_father_last_name" class="form-label">Apellido Paterno
                                        *</label>
                                    <input type="text" class="form-control" id="legal_representative_father_last_name"
                                        name="legal_representative_father_last_name" required>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="legal_representative_mother_last_name" class="form-label">Apellido Materno
                                        *</label>
                                    <input type="text" class="form-control" id="legal_representative_mother_last_name"
                                        name="legal_representative_mother_last_name" required>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="legal_representative_office_phone" class="form-label">Teléfono Oficina
                                        *</label>
                                    <input type="tel" class="form-control" id="legal_representative_office_phone"
                                        name="legal_representative_office_phone" required>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="legal_representative_mobile_phone" class="form-label">Teléfono Móvil
                                        *</label>
                                    <input type="tel" class="form-control" id="legal_representative_mobile_phone"
                                        name="legal_representative_mobile_phone" required>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="legal_representative_personal_phone" class="form-label">Teléfono Personal
                                        *</label>
                                    <input type="tel" class="form-control" id="legal_representative_personal_phone"
                                        name="legal_representative_personal_phone" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="legal_representative_email" class="form-label">Email Representante
                                        *</label>
                                    <input type="email" class="form-control" id="legal_representative_email"
                                        name="legal_representative_email" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="legal_representative_ownership_document" class="form-label">Documento de
                                        Propiedad *</label>
                                    <select class="form-select" id="legal_representative_ownership_document"
                                        name="legal_representative_ownership_document" required>
                                        <option value="">Seleccione un documento</option>
                                        <option value="Apoderado Especial">Apoderado Especial</option>
                                        <option value="Apoderado General">Apoderado General</option>
                                        <option value="Gestor de Trámite">Gestor de Trámite</option>
                                        <option value="Poder Notariado">Poder Notariado</option>
                                        <option value="Escritura Pública">Escritura Pública</option>
                                        <option value="Poder Simple">Poder Simple</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Responsable del Establecimiento -->
                            <div class="col-md-12">
                                <hr>
                                <h6 class="text-primary mb-3">
                                    <ion-icon name="business-outline"></ion-icon> Responsable del Establecimiento
                                </h6>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="establishment_legal_cause" class="form-label">Causa Legal *</label>
                                    <select class="form-select" id="establishment_legal_cause"
                                        name="establishment_legal_cause" required>
                                        <option value="">Seleccione una opción</option>
                                        <option value="Proprietario">Propietario</option>
                                        <option value="Arrendatario">Arrendatario</option>
                                        <option value="Otro">Otro</option>
                                        <option value="Copropietario">Copropietario</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="establishment_legal_cause_addon" class="form-label">Especificar
                                        Otro</label>
                                    <input type="text" class="form-control" id="establishment_legal_cause_addon"
                                        name="establishment_legal_cause_addon">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="establishment_good_faith_clause" class="form-label">Cláusula de Buena Fe
                                        *</label>
                                    <select class="form-select" id="establishment_good_faith_clause"
                                        name="establishment_good_faith_clause" required>
                                        <option value="">Seleccione una opción</option>
                                        <option value="Si">Sí</option>
                                        <option value="No">No</option>
                                        <option value="N/A">N/A</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Domicilio del Establecimiento -->
                            <div class="col-md-12">
                                <hr>
                                <h6 class="text-primary mb-3">
                                    <ion-icon name="location-outline"></ion-icon> Domicilio del Establecimiento
                                </h6>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="establishment_address_street" class="form-label">Calle *</label>
                                    <input type="text" class="form-control" id="establishment_address_street"
                                        name="establishment_address_street" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="establishment_address_number" class="form-label">Número *</label>
                                    <input type="text" class="form-control" id="establishment_address_number"
                                        name="establishment_address_number" required>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="establishment_address_neighborhood" class="form-label">Colonia *</label>
                                    <input type="text" class="form-control" id="establishment_address_neighborhood"
                                        name="establishment_address_neighborhood" required>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="establishment_address_municipality" class="form-label">Municipio *</label>
                                    <input type="text" class="form-control" id="establishment_address_municipality"
                                        name="establishment_address_municipality" required>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="establishment_address_state" class="form-label">Estado *</label>
                                    <input type="text" class="form-control" id="establishment_address_state"
                                        name="establishment_address_state" required>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="establishment_address_postal_code" class="form-label">Código Postal
                                        *</label>
                                    <input type="text" class="form-control" id="establishment_address_postal_code"
                                        name="establishment_address_postal_code" required>
                                </div>
                            </div>

                            <!-- Datos del uso de la edificación -->
                            <div class="col-md-12">
                                <hr>
                                <h6 class="text-primary mb-3">
                                    <ion-icon name="construct-outline"></ion-icon> Datos del Uso de la Edificación
                                </h6>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="establishment_use" class="form-label">Uso del Establecimiento</label>
                                    <input type="text" class="form-control" id="establishment_use"
                                        name="establishment_use">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="commercial_name" class="form-label">Nombre Comercial *</label>
                                    <input type="text" class="form-control" id="commercial_name"
                                        name="commercial_name" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="aprox_investment" class="form-label">Inversión Aproximada *</label>
                                    <input type="text" class="form-control" id="aprox_investment"
                                        name="aprox_investment" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="jobs_to_generate" class="form-label">Empleos a Generar *</label>
                                    <input type="number" class="form-control" id="jobs_to_generate"
                                        name="jobs_to_generate" required>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="operation_start_date" class="form-label">Fecha Inicio Operaciones</label>
                                    <input type="date" class="form-control" id="operation_start_date"
                                        name="operation_start_date">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="business_hours" class="form-label">Horario de Negocio</label>
                                    <input type="text" class="form-control" id="business_hours" name="business_hours"
                                        placeholder="Ej: 8:00 - 18:00">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <div class="form-check mt-4">
                                        <input class="form-check-input" type="checkbox" id="is_location_in_operation"
                                            name="is_location_in_operation" value="1">
                                        <label class="form-check-label" for="is_location_in_operation">
                                            Local en operación
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- Zonificación -->
                            <div class="col-md-12">
                                <hr>
                                <h6 class="text-primary mb-3">
                                    <ion-icon name="map-outline"></ion-icon> Zonificación
                                </h6>
                                <small class="text-muted">Indique las actividades de los locales colindantes a su
                                    negocio</small>
                            </div>

                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="zoning_front" class="form-label">Frente</label>
                                    <input type="text" class="form-control" id="zoning_front" name="zoning_front">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="zoning_rear" class="form-label">Fondo</label>
                                    <input type="text" class="form-control" id="zoning_rear" name="zoning_rear">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="zoning_left" class="form-label">Izquierda</label>
                                    <input type="text" class="form-control" id="zoning_left" name="zoning_left">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="zoning_right" class="form-label">Derecha</label>
                                    <input type="text" class="form-control" id="zoning_right" name="zoning_right">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bx bx-save"></i> Guardar Solicitud
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        .avatar {
            width: 3rem;
            height: 3rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .avatar-lg {
            width: 4rem;
            height: 4rem;
        }

        .avatar-initial {
            font-weight: bold;
            font-size: 1.2rem;
        }

        .timeline-item {
            display: block;
            margin-bottom: 0.5rem;
        }

        .dropzone {
            min-height: 10rem;
            border: 3px dotted #d9d9d9;
            position: relative;
            border-radius: 15px;
            margin-bottom: 20px;
        }
    </style>

    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <script>
            // Función para llenar todos los campos con datos de prueba
            function fillTestData() {
                // Información General
                document.getElementById('request_num').value = 'SARE-' + Math.floor(Math.random() * 10000);
                document.getElementById('request_date').value = new Date().toISOString().split('T')[0];
                document.getElementById('catastral_num').value = 'CAT-' + Math.floor(Math.random() * 100000);
                document.getElementById('request_type').value = 'general';
                document.getElementById('status').value = 'new';
                document.getElementById('description').value =
                    'Solicitud de permiso para establecimiento comercial de prueba. Esta es una descripción de ejemplo para fines de testing del sistema SARE.';

                // Datos del Solicitante
                document.getElementById('rfc_name').value = 'COMERCIAL VALLE DEL BRAVO SA DE CV';
                document.getElementById('rfc_num').value = 'CVB123456789';
                document.getElementById('property_owner').value = 'Juan Carlos Pérez García';
                document.getElementById('email').value = 'jperez@ejemplo.com';
                document.getElementById('office_phone').value = '(726) 262-1234';
                document.getElementById('mobile_phone').value = '(726) 123-4567';

                // Representante Legal
                document.getElementById('legal_representative_name').value = 'María Elena';
                document.getElementById('legal_representative_father_last_name').value = 'González';
                document.getElementById('legal_representative_mother_last_name').value = 'Rodríguez';
                document.getElementById('legal_representative_office_phone').value = '(726) 262-5678';
                document.getElementById('legal_representative_mobile_phone').value = '(726) 987-6543';
                document.getElementById('legal_representative_personal_phone').value = '(726) 555-0123';
                document.getElementById('legal_representative_email').value = 'mgonzalez@ejemplo.com';
                document.getElementById('legal_representative_ownership_document').value = 'Poder Notariado';

                // Responsable del Establecimiento
                document.getElementById('establishment_legal_cause').value = 'Proprietario';
                document.getElementById('establishment_legal_cause_addon').value = '';
                document.getElementById('establishment_good_faith_clause').value = 'Si';

                // Domicilio del Establecimiento
                document.getElementById('establishment_address_street').value = 'Avenida Independencia';
                document.getElementById('establishment_address_number').value = '123';
                document.getElementById('establishment_address_neighborhood').value = 'Centro';
                document.getElementById('establishment_address_municipality').value = 'Valle de Bravo';
                document.getElementById('establishment_address_state').value = 'Estado de México';
                document.getElementById('establishment_address_postal_code').value = '51200';

                // Datos del uso de la edificación
                document.getElementById('establishment_use').value = 'Comercial - Restaurante';
                document.getElementById('commercial_name').value = 'Restaurante El Mirador';
                document.getElementById('aprox_investment').value = '$500,000.00';
                document.getElementById('jobs_to_generate').value = '15';
                document.getElementById('operation_start_date').value = '2025-09-01';
                document.getElementById('business_hours').value = '09:00 - 22:00';
                document.getElementById('is_location_in_operation').checked = true;

                // Zonificación
                document.getElementById('zoning_front').value = 'Comercial';
                document.getElementById('zoning_rear').value = 'Habitacional';
                document.getElementById('zoning_left').value = 'Comercial';
                document.getElementById('zoning_right').value = 'Comercial';

                // Mostrar alerta de confirmación
                alert('✅ Datos de prueba cargados correctamente en todos los campos del formulario.');
            }

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
                        emptyState.style.display = 'block';
                        noResultsState.style.display = 'none';
                    } else {
                        emptyState.style.display = 'none';
                        noResultsState.style.display = 'block';
                    }
                } else {
                    emptyState.style.display = 'none';
                    noResultsState.style.display = 'none';
                }
            }

            function clearFilters() {
                document.getElementById('statusFilter').value = '';
                document.getElementById('typeFilter').value = '';
                document.getElementById('searchInput').value = '';
                filterRequests();
            }

            // Inicializar filtros cuando la página esté lista
            document.addEventListener('DOMContentLoaded', function() {
                initializeFilters();

                // Conectar el botón de datos de prueba
                const fillTestDataBtn = document.getElementById('fillTestDataBtn');
                if (fillTestDataBtn) {
                    fillTestDataBtn.addEventListener('click', fillTestData);
                }
            });
        </script>
    @endpush

@endsection
