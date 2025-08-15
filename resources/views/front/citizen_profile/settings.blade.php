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
                            <a class="nav-link" href="{{ route('citizen.profile.requests') }}" 
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
                            <a class="nav-link active" href="{{ route('citizen.profile.settings') }}" 
                               id="configuraciones-tab" role="tab">
                                <ion-icon name="cog-outline"></ion-icon> Configuraciones
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="card-body">
                    <h5 class="mb-4">
                        <i class="bx bx-cog"></i> Configuraciones
                    </h5>

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="bx bx-check-circle me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="row">
                        <!-- Notificaciones -->
                        <div class="col-md-6 mb-4">
                            <div class="card h-100">
                                <div class="card-header">
                                    <h6 class="mb-0">
                                        <i class="bx bx-bell"></i> Preferencias de Notificaciones
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('citizen.profile.notifications') }}" method="POST">
                                        @csrf
                                        @method('PUT')

                                        <div class="mb-3">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" id="emailNotifications" 
                                                       name="mail_notifications" 
                                                       {{ $userInfo->mail_notifications ?? true ? 'checked' : '' }}>
                                                <label class="form-check-label" for="emailNotifications">
                                                    <strong>Notificaciones por Email</strong>
                                                    <br><small class="text-muted">Recibir actualizaciones de solicitudes por correo</small>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" id="smsNotifications" 
                                                       name="sms_notifications" 
                                                       {{ $userInfo->sms_notifications ?? true ? 'checked' : '' }}>
                                                <label class="form-check-label" for="smsNotifications">
                                                    <strong>Notificaciones por SMS</strong>
                                                    <br><small class="text-muted">Recibir mensajes de texto importantes</small>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" id="pushNotifications" 
                                                       name="push_notifications" 
                                                       {{ $userInfo->push_notifications ?? true ? 'checked' : '' }}>
                                                <label class="form-check-label" for="pushNotifications">
                                                    <strong>Notificaciones Push</strong>
                                                    <br><small class="text-muted">Notificaciones en tiempo real en el navegador</small>
                                                </label>
                                            </div>
                                        </div>

                                        <button type="submit" class="btn btn-primary btn-sm">
                                            <i class="bx bx-save"></i> Guardar Preferencias
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Privacidad y Seguridad -->
                        <div class="col-md-6 mb-4">
                            <div class="card h-100">
                                <div class="card-header">
                                    <h6 class="mb-0">
                                        <i class="bx bx-shield"></i> Privacidad y Seguridad
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label class="form-label">
                                            <strong>Estado de la cuenta</strong>
                                        </label>
                                        <div>
                                            @if(Auth::user()->email_verified_at)
                                                <span class="badge bg-success">
                                                    <i class="bx bx-check"></i> Cuenta verificada
                                                </span>
                                            @else
                                                <span class="badge bg-warning">
                                                    <i class="bx bx-time"></i> Pendiente de verificación
                                                </span>
                                                <br>
                                                <a href="{{ route('verification.send') }}" class="btn btn-sm btn-outline-primary mt-2">
                                                    Reenviar verificación
                                                </a>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">
                                            <strong>Última actividad</strong>
                                        </label>
                                        <p class="text-muted">{{ Auth::user()->updated_at->format('d/m/Y H:i') }}</p>
                                    </div>

                                    <div class="mb-3">
                                        <a href="{{ route('citizen.profile.edit') }}" class="btn btn-outline-primary btn-sm">
                                            <i class="bx bx-key"></i> Cambiar Contraseña
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Información de la cuenta -->
                        <div class="col-md-6 mb-4">
                            <div class="card h-100">
                                <div class="card-header">
                                    <h6 class="mb-0">
                                        <i class="bx bx-info-circle"></i> Información de la Cuenta
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="mb-2">
                                        <strong>ID de Usuario:</strong> {{ Auth::user()->id }}
                                    </div>
                                    <div class="mb-2">
                                        <strong>Fecha de registro:</strong> {{ Auth::user()->created_at->format('d/m/Y') }}
                                    </div>
                                    <div class="mb-2">
                                        <strong>Tipo de cuenta:</strong> 
                                        <span class="badge bg-info">Ciudadano</span>
                                    </div>
                                    <div class="mb-2">
                                        <strong>Solicitudes realizadas:</strong> 
                                        <span class="badge bg-secondary">0</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Acciones de cuenta -->
                        <div class="col-md-6 mb-4">
                            <div class="card h-100">
                                <div class="card-header">
                                    <h6 class="mb-0">
                                        <i class="bx bx-user-x"></i> Acciones de Cuenta
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="alert alert-warning">
                                        <small>
                                            <i class="bx bx-error-circle"></i>
                                            <strong>Zona peligrosa:</strong> Estas acciones son irreversibles.
                                        </small>
                                    </div>

                                    <div class="mb-3">
                                        <button class="btn btn-outline-warning btn-sm" data-bs-toggle="modal" data-bs-target="#deactivateModal">
                                            <i class="bx bx-user-minus"></i> Desactivar Cuenta
                                        </button>
                                    </div>

                                    <div class="mb-3">
                                        <button class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                            <i class="bx bx-trash"></i> Eliminar Cuenta
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Soporte -->
                    <div class="card mt-4">
                        <div class="card-header">
                            <h6 class="mb-0">
                                <i class="bx bx-help-circle"></i> ¿Necesitas ayuda?
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 text-center">
                                    <i class="bx bx-phone display-4 text-primary"></i>
                                    <h6 class="mt-2">Teléfono</h6>
                                    <p class="text-muted">(555) 123-4567</p>
                                </div>
                                <div class="col-md-4 text-center">
                                    <i class="bx bx-envelope display-4 text-primary"></i>
                                    <h6 class="mt-2">Email</h6>
                                    <p class="text-muted">soporte@municipio.gob.mx</p>
                                </div>
                                <div class="col-md-4 text-center">
                                    <i class="bx bx-time display-4 text-primary"></i>
                                    <h6 class="mt-2">Horario</h6>
                                    <p class="text-muted">Lun-Vie 9:00-17:00</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Desactivar Cuenta -->
<div class="modal fade" id="deactivateModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-warning">
                    <i class="bx bx-error-circle"></i> Desactivar Cuenta
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>¿Estás seguro de que deseas desactivar tu cuenta?</p>
                <p class="text-muted">Tu cuenta será desactivada temporalmente. Podrás reactivarla contactando al soporte.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-warning">Desactivar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Eliminar Cuenta -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-danger">
                    <i class="bx bx-trash"></i> Eliminar Cuenta
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p class="text-danger"><strong>¡ATENCIÓN! Esta acción es irreversible.</strong></p>
                <p>Se eliminarán permanentemente:</p>
                <ul>
                    <li>Tu información personal</li>
                    <li>Todas tus solicitudes</li>
                    <li>Historial de actividades</li>
                </ul>
                <p>Escribe <strong>ELIMINAR</strong> para confirmar:</p>
                <input type="text" class="form-control" id="deleteConfirmation" placeholder="ELIMINAR">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" id="confirmDelete" disabled>Eliminar Cuenta</button>
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
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Validación para eliminar cuenta
    const deleteInput = document.getElementById('deleteConfirmation');
    const confirmButton = document.getElementById('confirmDelete');
    
    deleteInput.addEventListener('input', function() {
        if (this.value === 'ELIMINAR') {
            confirmButton.disabled = false;
        } else {
            confirmButton.disabled = true;
        }
    });
});
</script>
@endsection
