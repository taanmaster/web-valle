@extends('layouts.master')
@section('title')
    Intranet
@endsection
@section('content')
    <!-- Breadcrumbs -->
    @component('components.breadcrumb')
        @slot('li_1')
            Tesorería
        @endslot
        @slot('li_2')
            Agendas
        @endslot
        @slot('title')
            Detalle de la dependencia
        @endslot
    @endcomponent

    <div class="row layout-spacing">
        <div class="main-content">
            <!-- Información General de la Dependencia -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <h4 class="card-title text-primary mb-4">
                        <i class="bx bx-building me-2"></i>Información General
                    </h4>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="d-flex align-items-start">
                                <i class="bx bx-label text-muted me-2 mt-1"></i>
                                <div>
                                    <small class="text-muted d-block mb-1">Nombre</small>
                                    <strong>{{ $dependency->name }}</strong>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-start">
                                <i class="bx bx-info-circle text-muted me-2 mt-1"></i>
                                <div>
                                    <small class="text-muted d-block mb-1">Descripción</small>
                                    <strong>{{ $dependency->description ?? 'N/A' }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Navegación de Agendas -->
            <nav>
                <ul class="nav nav-pills nav-fill mb-4 shadow-sm border rounded" id="agendaTabs" role="tablist" 
                    style="background-color: #f8f9fa;">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active rounded-start py-3 fw-semibold" 
                            id="regulatory-tab" 
                            data-bs-toggle="tab" 
                            data-bs-target="#regulatory" 
                            type="button" 
                            role="tab" 
                            aria-controls="regulatory" 
                            aria-selected="true">
                            <i class="bx bx-file-blank me-2"></i>
                            Agenda Regulatoria
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link rounded-end py-3 fw-semibold" 
                            id="simplification-tab" 
                            data-bs-toggle="tab" 
                            data-bs-target="#simplification" 
                            type="button" 
                            role="tab" 
                            aria-controls="simplification" 
                            aria-selected="false">
                            <i class="bx bx-layer me-2"></i>
                            Agenda de Simplificación
                        </button>
                    </li>
                </ul>
            </nav>

            <!-- Contenido de las Agendas -->
            <div class="tab-content" id="agendaTabsContent">
                <div class="tab-pane fade show active" id="regulatory" role="tabpanel" aria-labelledby="regulatory-tab">
                    <livewire:regulatory-agenda.regulations-table :dependency="$dependency" is_admin="true" />
                </div>
                <div class="tab-pane fade" id="simplification" role="tabpanel" aria-labelledby="simplification-tab">
                    <livewire:regulatory-agenda.simplifications-table :dependency="$dependency" is_admin="true" />
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Estilos personalizados para nav-pills en admin */
        .nav-pills .nav-link {
            color: #495057;
            background-color: transparent;
            border: none;
            transition: all 0.3s ease;
        }
        
        .nav-pills .nav-link:hover {
            color: #0d6efd;
            background-color: rgba(13, 110, 253, 0.1);
        }
        
        .nav-pills .nav-link.active {
            background-color: #0d6efd;
            color: white;
        }
        
        .nav-pills .nav-link i {
            font-size: 1.2rem;
            vertical-align: middle;
        }
    </style>
@endsection
