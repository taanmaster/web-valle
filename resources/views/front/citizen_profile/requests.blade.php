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
                            <a class="nav-link" href="{{ route('citizen.profile.index') }}" 
                               id="inicio-tab" role="tab">
                                <ion-icon name="home-outline"></ion-icon> Inicio
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" href="{{ route('citizen.profile.edit') }}" 
                               id="perfil-tab" role="tab">
                                <ion-icon name="create-outline"></ion-icon> Editar Perfil
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" href="{{ route('citizen.profile.requests') }}" 
                               id="solicitudes-tab" role="tab">
                                <ion-icon name="file-tray-full-outline"></ion-icon> Solicitudes
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" href="{{ route('citizen.profile.settings') }}" 
                               id="configuraciones-tab" role="tab">
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
                            <ion-icon name="add-circle-outline"></ion-icon> Nueva Solicitud
                        </button>
                    </div>

                    <!-- Filtros -->
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <select class="form-select" id="statusFilter">
                                <option value="">Todos los estados</option>
                                <option value="pendiente">Pendiente</option>
                                <option value="en_proceso">En Proceso</option>
                                <option value="completada">Completada</option>
                                <option value="rechazada">Rechazada</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select class="form-select" id="typeFilter">
                                <option value="">Todos los tipos</option>
                                <option value="informacion">Solicitud de Información</option>
                                <option value="servicio">Solicitud de Servicio</option>
                                <option value="queja">Queja o Sugerencia</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Buscar solicitudes..." id="searchInput">
                                <button class="btn btn-outline-secondary" type="button">
                                    <ion-icon name="search-outline"></ion-icon>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Lista de solicitudes -->
                    <div class="row" id="requestsList">
                        <!-- Ejemplo de solicitud -->
                        <div class="col-md-12 mb-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-md-8">
                                            <h6 class="mb-1">Solicitud de Información Pública #001</h6>
                                            <p class="text-muted mb-1">
                                                <i class="bx bx-calendar"></i> Creada: 15/08/2025
                                                <span class="mx-2">|</span>
                                                <i class="bx bx-tag"></i> Información
                                            </p>
                                            <p class="mb-0">Solicitud de información sobre presupuesto municipal 2025</p>
                                        </div>
                                        <div class="col-md-2 text-center">
                                            <span class="badge bg-warning">En Proceso</span>
                                        </div>
                                        <div class="col-md-2 text-end">
                                            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#requestDetailModal">
                                                <i class="bx bx-eye"></i> Ver
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Estado vacío -->
                        <div class="col-md-12" id="emptyState" style="display: none;">
                            <div class="text-center py-5">
                                <i class="bx bx-file display-1 text-muted"></i>
                                <h5 class="mt-3">No tienes solicitudes</h5>
                                <p class="text-muted">Crea tu primera solicitud para empezar</p>
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newRequestModal">
                                    <ion-icon name="add-circle-outline"></ion-icon> Nueva Solicitud
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Paginación -->
                    <nav aria-label="Paginación de solicitudes">
                        <ul class="pagination justify-content-center">
                            <li class="page-item disabled">
                                <span class="page-link">Anterior</span>
                            </li>
                            <li class="page-item active">
                                <span class="page-link">1</span>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="#">2</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="#">Siguiente</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Nueva Solicitud -->
<div class="modal fade" id="newRequestModal" tabindex="-1">
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

<!-- Modal Detalle de Solicitud -->
<div class="modal fade" id="requestDetailModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <ion-icon name="file-tray-full-outline"></ion-icon> Detalle de Solicitud #001
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Tipo:</strong> Solicitud de Información</p>
                        <p><strong>Estado:</strong> <span class="badge bg-warning">En Proceso</span></p>
                        <p><strong>Fecha de creación:</strong> 15/08/2025</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Última actualización:</strong> 16/08/2025</p>
                        <p><strong>Responsable:</strong> Unidad de Transparencia</p>
                    </div>
                </div>
                <hr>
                <h6>Descripción:</h6>
                <p>Solicitud de información sobre presupuesto municipal 2025 y desglose por departamentos.</p>
                
                <h6>Historial:</h6>
                <div class="timeline">
                    <div class="timeline-item">
                        <span class="badge bg-primary">15/08/2025</span>
                        <span class="ms-2">Solicitud creada</span>
                    </div>
                    <div class="timeline-item">
                        <span class="badge bg-info">16/08/2025</span>
                        <span class="ms-2">En revisión por el departamento</span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
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
</style>
@endsection
