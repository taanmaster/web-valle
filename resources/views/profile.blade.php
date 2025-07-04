@extends('layouts.master')

@section('title')
    Intranet
@endsection

@section('content')
    <!-- this is breadcrumbs -->
    @component('components.breadcrumb')
        @slot('li_1')
            Intranet
        @endslot
        @slot('li_2')
            Usuarios
        @endslot
        @slot('title')
            Perfil
        @endslot
    @endcomponent

    <!-- Cabecera -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-md-3 text-center mb-3 mb-md-0">
                            <!-- Foto de Perfil -->
                            <div class="bg-primary bg-gradient rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 120px; height: 120px;">
                                <i class="fas fa-user fs-1 text-white"></i>
                            </div>
                            <div>
                                <span class="badge bg-success">
                                    <i class="fas fa-circle me-1" style="font-size: 8px;"></i>
                                    Usuario Activo
                                </span>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <h2 class="mb-2">{{ Auth::user()->name }}</h2>
                            <p class="text-muted mb-3">
                                <i class="fas fa-envelope me-2"></i>
                                {{ Auth::user()->email }}
                            </p>
                            <div class="row">
                                <div class="col-sm-6">
                                    <small class="text-muted">Miembro desde:</small>
                                    <div class="fw-bold">{{ Auth::user()->created_at->format('d/m/Y') }}</div>
                                </div>
                                <div class="col-sm-6">
                                    <small class="text-muted">Estado del email:</small>
                                    <div>
                                        @if(Auth::user()->email_verified_at)
                                            <span class="badge bg-success">
                                                <i class="fas fa-check me-1"></i>
                                                Verificado
                                            </span>
                                        @else
                                            <span class="badge bg-warning">
                                                <i class="fas fa-exclamation-triangle me-1"></i>
                                                Pendiente
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tarjetas Informativas -->
    <div class="row">
        <div class="col-lg-8 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-bottom-0">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-user-circle text-primary me-2"></i>
                        Información Personal
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="bg-light rounded p-3">
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-3">
                                        <i class="fas fa-user text-primary"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted">Nombre Completo</small>
                                        <div class="fw-bold">{{ Auth::user()->name }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="bg-light rounded p-3">
                                <div class="d-flex align-items-center">
                                    <div class="bg-success bg-opacity-10 rounded-circle p-2 me-3">
                                        <i class="fas fa-envelope text-success"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted">Correo Electrónico</small>
                                        <div class="fw-bold">{{ Auth::user()->email }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="bg-light rounded p-3">
                                <div class="d-flex align-items-center">
                                    <div class="bg-info bg-opacity-10 rounded-circle p-2 me-3">
                                        <i class="fas fa-calendar-plus text-info"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted">Fecha de Registro</small>
                                        <div class="fw-bold">{{ Auth::user()->created_at->format('d/m/Y H:i') }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="bg-light rounded p-3">
                                <div class="d-flex align-items-center">
                                    <div class="bg-warning bg-opacity-10 rounded-circle p-2 me-3">
                                        <i class="fas fa-user-shield text-warning"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted">Rol Asignado</small>
                                        <div class="fw-bold">{{ Auth::user()->roles->first()->name ?? 'Usuario Estándar' }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <!-- Estadisticas -->
                    <h6 class="mb-3">
                        <i class="fas fa-chart-bar me-2"></i>
                        Estadísticas de la Cuenta
                    </h6>
                    <div class="row">
                        <div class="col-sm-4 text-center mb-3">
                            <div class="border rounded p-3">
                                <div class="text-primary fs-4 fw-bold">{{ Auth::user()->created_at->diffInDays(now()) }}</div>
                                <small class="text-muted">Días activo</small>
                            </div>
                        </div>
                        <div class="col-sm-4 text-center mb-3">
                            <div class="border rounded p-3">
                                <div class="text-success fs-4 fw-bold">{{ Auth::user()->updated_at->format('d/m') }}</div>
                                <small class="text-muted">Última actualización</small>
                            </div>
                        </div>
                        <div class="col-sm-4 text-center mb-3">
                            <div class="border rounded p-3">
                                <div class="text-info fs-4 fw-bold">ID {{ Auth::user()->id }}</div>
                                <small class="text-muted">Identificador único</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-bottom-0">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-cogs text-success me-2"></i>
                        Acciones de Cuenta
                    </h5>
                </div>
                <div class="card-body">
                    {{--  
                    <div class="d-grid gap-2">
                        <a href="#" class="btn btn-outline-primary">
                            <i class="fas fa-edit me-2"></i>
                            Editar Información
                        </a>
                        <a href="#" class="btn btn-outline-warning">
                            <i class="fas fa-key me-2"></i>
                            Cambiar Contraseña
                        </a>
                         
                        @if(!Auth::user()->email_verified_at)
                        <a href="#" class="btn btn-outline-success">
                            <i class="fas fa-envelope-open me-2"></i>
                            Verificar Email
                        </a>
                        @endif
                        
                        <a href="#" class="btn btn-outline-info">
                            <i class="fas fa-shield-alt me-2"></i>
                            Configuración de Seguridad
                        </a>
                    </div>
                    
                    <hr class="my-4">  
                    --}}

                    <!-- Estado de Seguridad -->
                    <h6 class="mb-3">
                        <i class="fas fa-shield-alt me-2"></i>
                        Estado de Seguridad
                    </h6>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <small>Verificación de Email</small>
                            @if(Auth::user()->email_verified_at)
                                <span class="badge bg-success">Completado</span>
                            @else
                                <span class="badge bg-warning">Pendiente</span>
                            @endif
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <small>Contraseña Segura</small>
                            <span class="badge bg-success">Activa</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <small>Token de Sesión</small>
                            <span class="badge bg-primary">Válido</span>
                        </div>
                    </div>

                    <div class="text-center mt-4">
                        <small class="text-muted">
                            <i class="fas fa-info-circle me-1"></i>
                            Cuenta protegida y segura. <br>Mantenlo asi no compartiendo tus credenciales con nadie.
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')

@endsection
