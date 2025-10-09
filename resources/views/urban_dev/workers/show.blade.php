@extends('layouts.master')
@section('title')Intranet @endsection

@section('content')
<!-- this is breadcrumbs -->
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') Desarrollo Urbano @endslot
@slot('title') Perfil de Trabajador @endslot
@endcomponent

<style>
    .profile-header {
        background: linear-gradient(to bottom, #f8f9fa 0%, #ffffff 100%);
        border-radius: 10px;
        padding: 40px 20px 30px;
        margin-bottom: 30px;
        border: 1px solid #dee2e6;
    }

    .profile-photo {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid #fff;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .profile-avatar {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        border: 4px solid #fff;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        font-size: 60px;
        font-weight: 600;
    }

    .info-card {
        border: 1px solid #dee2e6;
        border-radius: 8px;
        padding: 25px;
        margin-bottom: 20px;
        background: #fff;
    }

    .info-card-title {
        font-size: 16px;
        font-weight: 600;
        color: #212529;
        margin-bottom: 20px;
        padding-bottom: 12px;
        border-bottom: 2px solid #e9ecef;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .info-card-title i {
        color: #0d6efd;
        font-size: 20px;
    }

    .info-row {
        margin-bottom: 15px;
    }

    .info-label {
        font-weight: 600;
        color: #6c757d;
        font-size: 14px;
        margin-bottom: 5px;
    }

    .info-value {
        color: #212529;
        font-size: 15px;
    }
</style>

<div class="row">
    <div class="col-lg-10 offset-lg-1">
        <!-- Header con foto y acciones -->
        <div class="profile-header text-center">
            @if($worker->s3_asset_url)
                <img src="{{ $worker->s3_asset_url }}" alt="{{ $worker->full_name }}" class="profile-photo mb-3">
            @else
                <div class="profile-avatar bg-primary text-white d-inline-flex align-items-center justify-content-center mb-3">
                    {{ strtoupper(substr($worker->name, 0, 1)) }}{{ strtoupper(substr($worker->last_name, 0, 1)) }}
                </div>
            @endif
            
            <h3 class="mb-2 mt-3">{{ $worker->full_name }}</h3>
            <p class="text-muted mb-2">{{ $worker->position }}</p>
            <span class="badge bg-secondary px-3 py-2">
                <i class="fas fa-id-badge me-1"></i> {{ $worker->employee_number }}
            </span>
            
            <div class="mt-4 d-flex justify-content-center gap-2">
                <a href="{{ route('urban_dev.workers.edit', $worker->id) }}" class="btn btn-warning">
                    <i class="fas fa-edit me-1"></i> Editar
                </a>
                <button type="button" class="btn btn-danger" onclick="confirmDelete()">
                    <i class="fas fa-trash-alt me-1"></i> Eliminar
                </button>
                <a href="{{ url()->previous() }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Volver
                </a>
            </div>
            
            <form id="delete-form" action="{{ route('urban_dev.workers.destroy', $worker->id) }}" method="POST" style="display: none;">
                @csrf
                @method('DELETE')
            </form>
        </div>

        </div>

        <!-- Información en Grid de 2 columnas -->
        <div class="row">
            <!-- Columna Izquierda -->
            <div class="col-lg-6">
                <!-- Información Personal -->
                <div class="info-card">
                    <div class="info-card-title">
                        <i class="fas fa-user"></i>
                        <span>Información Personal</span>
                    </div>
                    
                    <div class="info-row">
                        <div class="info-label">Nombre(s)</div>
                        <div class="info-value">{{ $worker->name }}</div>
                    </div>
                    
                    <div class="info-row">
                        <div class="info-label">Apellido(s)</div>
                        <div class="info-value">{{ $worker->last_name }}</div>
                    </div>
                    
                    <div class="info-row">
                        <div class="info-label">Puesto/Cargo</div>
                        <div class="info-value">{{ $worker->position }}</div>
                    </div>
                    
                    <div class="info-row">
                        <div class="info-label">No. Empleado</div>
                        <div class="info-value">
                            <span class="badge bg-secondary">{{ $worker->employee_number }}</span>
                        </div>
                    </div>
                </div>

                <!-- Dependencia -->
                <div class="info-card">
                    <div class="info-card-title">
                        <i class="fas fa-building"></i>
                        <span>Dependencia</span>
                    </div>
                    
                    <div class="info-row">
                        <div class="info-label">Categoría</div>
                        <div class="info-value">
                            <span class="badge bg-primary">{{ $worker->dependency_category }}</span>
                        </div>
                    </div>
                    
                    @if($worker->dependency_subcategory)
                    <div class="info-row">
                        <div class="info-label">Tipo</div>
                        <div class="info-value">
                            <span class="badge bg-info">{{ $worker->dependency_subcategory }}</span>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Columna Derecha -->
            <div class="col-lg-6">
                <!-- Información de Credencial -->
                <div class="info-card">
                    <div class="info-card-title">
                        <i class="fas fa-id-card"></i>
                        <span>Credencial</span>
                    </div>
                    
                    <div class="info-row">
                        <div class="info-label">
                            <i class="fas fa-calendar-plus text-muted me-1"></i> Fecha de Expedición
                        </div>
                        <div class="info-value">{{ $worker->issue_date->format('d/m/Y') }}</div>
                    </div>
                    
                    <div class="info-row">
                        <div class="info-label">
                            <i class="fas fa-calendar-check text-muted me-1"></i> Vigencia Inicio
                        </div>
                        <div class="info-value">{{ $worker->validity_date_start->format('d/m/Y') }}</div>
                    </div>
                    
                    <div class="info-row">
                        <div class="info-label">
                            <i class="fas fa-calendar-times text-muted me-1"></i> Vigencia Fin
                        </div>
                        <div class="info-value">
                            @if($worker->validity_date_end)
                                {{ $worker->validity_date_end->format('d/m/Y') }}
                                @php
                                    $now = \Carbon\Carbon::now();
                                    $isExpired = $worker->validity_date_end < $now;
                                @endphp
                                @if($isExpired)
                                    <span class="badge bg-danger ms-2">
                                        <i class="fas fa-exclamation-triangle me-1"></i> Vencida
                                    </span>
                                @else
                                    <span class="badge bg-success ms-2">
                                        <i class="fas fa-check-circle me-1"></i> Vigente
                                    </span>
                                @endif
                            @else
                                <span class="badge bg-success">
                                    <i class="fas fa-infinity me-1"></i> Sin fecha límite
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Información del Registro -->
                <div class="info-card">
                    <div class="info-card-title">
                        <i class="fas fa-clock"></i>
                        <span>Registro del Sistema</span>
                    </div>
                    
                    <div class="info-row">
                        <div class="info-label">
                            <i class="fas fa-plus-circle text-muted me-1"></i> Fecha de Creación
                        </div>
                        <div class="info-value">{{ $worker->created_at->format('d/m/Y H:i') }}</div>
                    </div>
                    
                    <div class="info-row">
                        <div class="info-label">
                            <i class="fas fa-sync-alt text-muted me-1"></i> Última Actualización
                        </div>
                        <div class="info-value">{{ $worker->updated_at->format('d/m/Y H:i') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function confirmDelete() {
        if (confirm('¿Estás seguro de que deseas eliminar este trabajador? Esta acción no se puede deshacer.')) {
            document.getElementById('delete-form').submit();
        }
    }
</script>

@endsection
