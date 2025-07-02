@extends('layouts.master')
@section('title')Intranet @endsection
@section('content')
<!-- this is breadcrumbs -->
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') General @endslot
@slot('title') Vista General @endslot
@endcomponent

<!-- Welcome Section -->
<div class="row mb-5">
    <div class="col-12">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="display-4 fw-bold mb-2">
                    ¡Bienvenido, {{ Auth::user()->name }}! 👋
                </h1>
                <p class="fs-5 mb-0 opacity-90">
                    Es un placer tenerte de vuelta en la Intranet de Valle de Santiago.<br> Desde aquí podrás acceder a todas las herramientas y recursos necesarios para tu día a día.
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Quick Stats Cards -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card shadow-sm">
            <div class="card-body text-center">
                <div class="text-primary mb-3">
                    <i class="fas fa-clock fs-1"></i>
                </div>
                <h5 class="card-title">Hora Actual</h5>
                <p class="card-text fw-bold">{{ date('H:i') }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card shadow-sm">
            <div class="card-body text-center">
                <div class="text-success mb-3">
                    <i class="fas fa-calendar-day fs-1"></i>
                </div>
                <h5 class="card-title">Fecha</h5>
                <p class="card-text fw-bold">{{ date('d/m/Y') }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card shadow-sm">
            <div class="card-body text-center">
                <div class="text-warning mb-3">
                    <i class="fas fa-user-shield fs-1"></i>
                </div>
                <h5 class="card-title">Tu Rol</h5>
                <p class="card-text fw-bold">{{ Auth::user()->roles->first()->name ?? 'Usuario' }}</p>
            </div>
        </div>
    </div>

    {{--  
    Trabajando funcionalidad de último acceso.
    <div class="col-md-3 mb-3">
        <div class="card  shadow-sm h-100">
            <div class="card-body text-center">
                <div class="text-info mb-3">
                    <i class="fas fa-sign-in-alt fs-1"></i>
                </div>
                <h5 class="card-title">Último Acceso</h5>
                <p class="card-text fw-bold">{{ Auth::user()->last_login_at ? Auth::user()->last_login_at->format('d/m H:i') : 'Primer acceso' }}</p>
            </div>
        </div>
    </div>
    --}}
</div>

<!-- Information and Updates Section -->
<div class="row">
    <div class="col-lg-9 mb-4">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-white border-bottom-0">
                <h5 class="card-title mb-0 mt-3">
                    <i class="fas fa-info-circle text-primary me-2"></i>
                    Información del Sistema
                </h5>
            </div>
            <div class="card-body">
                <div class="alert alert-info " role="alert">
                    <h6 class="alert-heading">
                        <i class="fas fa-rocket me-2"></i>
                        Sistema en Constante Evolución
                    </h6>
                    <p class="mb-0">
                        Esta plataforma se va actualizando conforme más funcionalidades se crean. 
                        Si tienes un comentario o sugerencia, compártelo con el equipo para tenerlo contemplado 
                        en futuras actualizaciones.
                    </p>
                </div>
                
                <!-- Server Health Status Cards -->
                <div class="row mt-4">
                    <div class="col-lg-4 col-sm-6 mb-3">
                        <div class="card border-0 bg-light">
                            <div class="card-body p-3">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <h6 class="card-title mb-1">Estado del Servidor</h6>
                                        <small class="text-muted">Sistema Principal</small>
                                    </div>
                                    <div class="text-end">
                                        <span class="badge bg-success">
                                            <i class="fas fa-circle me-1" style="font-size: 8px;"></i>
                                            OPERATIVO
                                        </span>
                                        <div class="mt-1">
                                            <small class="text-success fw-bold">99.9% Uptime</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-4 col-sm-6 mb-3">
                        <div class="card border-0 bg-light">
                            <div class="card-body p-3">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <h6 class="card-title mb-1">Base de Datos</h6>
                                        <small class="text-muted">MySQL Server</small>
                                    </div>
                                    <div class="text-end">
                                        <span class="badge bg-success">
                                            <i class="fas fa-circle me-1" style="font-size: 8px;"></i>
                                            ACTIVA
                                        </span>
                                        <div class="mt-1">
                                            <small class="text-success fw-bold">< 50ms</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-4 col-sm-6 mb-3">
                        <div class="card border-0 bg-light">
                            <div class="card-body p-3">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <h6 class="card-title mb-1">Certificado SSL</h6>
                                        <small class="text-muted">Seguridad HTTPS</small>
                                    </div>
                                    <div class="text-end">
                                        <span class="badge bg-success">
                                            <i class="fas fa-circle me-1" style="font-size: 8px;"></i>
                                            VÁLIDO
                                        </span>
                                        <div class="mt-1">
                                            <small class="text-success fw-bold">256-bit</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-6 col-sm-6 mb-3">
                        <div class="card border-0 bg-light">
                            <div class="card-body p-3">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <h6 class="card-title mb-1">Estatus del Sistema</h6>
                                        <small class="text-muted">Plataforma funcionando correctamente</small>
                                    </div>
                                    <div class="text-end">
                                        <span class="badge bg-success">
                                            <i class="fas fa-circle me-1" style="font-size: 8px;"></i>
                                            ESTABLE
                                        </span>
                                        {{--  
                                        <div class="mt-1">
                                            <small class="text-success fw-bold">Sin errores</small>
                                        </div>
                                        --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-6 col-sm-6 mb-3">
                        <div class="card border-0 bg-light">
                            <div class="card-body p-3">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <h6 class="card-title mb-1">Actualizaciones</h6>
                                        <small class="text-muted">Mejoras continuas disponibles</small>
                                    </div>
                                    <div class="text-end">
                                        <span class="badge bg-primary">
                                            <i class="fas fa-circle me-1" style="font-size: 8px;"></i>
                                            ACTIVO
                                        </span>
                                        <div class="mt-1">
                                            <small class="text-primary fw-bold">Regulares</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <hr class="my-4">
                
                <div class="text-center">
                    <small class="text-muted">
                        <i class="fas fa-shield-alt me-1"></i>
                        Plataforma Segura protegida por certificado SSL de 256 bits.
                    </small>
                </div>
            </div>
        </div>
    </div>
    
    {{--  
    <div class="col-lg-4 mb-4">
        <div class="card  shadow-sm h-100">
            <div class="card-header bg-white border-bottom-0">
                <h5 class="card-title mb-0">
                    <i class="fas fa-bullhorn text-warning me-2"></i>
                    Acciones Rápidas
                </h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="#" class="btn btn-outline-primary">
                        <i class="fas fa-user-edit me-2"></i>
                        Editar Perfil
                    </a>
                    <a href="#" class="btn btn-outline-success">
                        <i class="fas fa-envelope me-2"></i>
                        Enviar Comentario
                    </a>
                    <a href="#" class="btn btn-outline-info">
                        <i class="fas fa-question-circle me-2"></i>
                        Centro de Ayuda
                    </a>
                </div>
                
                <hr class="my-4">
                
                <div class="text-center">
                    <small class="text-muted">
                        <i class="fas fa-shield-alt me-1"></i>
                        Sesión segura activa
                    </small>
                </div>
            </div>
        </div>
    </div>
    --}}
</div>
@endsection

@section('script')

@endsection
