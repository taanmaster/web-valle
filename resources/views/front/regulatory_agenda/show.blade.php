@extends('front.layouts.app')

@section('content')
    <div class="container py-4">
        <!-- Header de Dependencia -->
        <div class="row justify-content-center mb-4">
            <div class="col-md-12">
                <div class="card card-normal card-image-banner wow fadeInUp" style="min-height: 250px;">
                    <div class="card-content">
                        <h4>{{ $dependency->name }}</h4>
                        <p class="mb-0">{{ $dependency->description }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Navegación de Agendas -->
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <nav>
                    <ul class="nav nav-pills nav-fill mb-4 shadow-sm border rounded" id="agendaTabsFront" role="tablist" 
                        style="background-color: #f8f9fa;">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active rounded-start py-3 fw-semibold" 
                                id="regulatory-tab-front" 
                                data-bs-toggle="tab" 
                                data-bs-target="#regulatory-front" 
                                type="button" 
                                role="tab" 
                                aria-controls="regulatory-front" 
                                aria-selected="true">
                                <i class="bx bx-file-blank me-2"></i>
                                <span class="d-none d-sm-inline">Agenda</span> Regulatoria
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link rounded-end py-3 fw-semibold" 
                                id="simplification-tab-front" 
                                data-bs-toggle="tab" 
                                data-bs-target="#simplification-front" 
                                type="button" 
                                role="tab" 
                                aria-controls="simplification-front" 
                                aria-selected="false">
                                <i class="bx bx-layer me-2"></i>
                                <span class="d-none d-sm-inline">Agenda de</span> Simplificación
                            </button>
                        </li>
                    </ul>
                </nav>

                <!-- Contenido de las Agendas -->
                <div class="tab-content" id="agendaTabsFrontContent">
                    <div class="tab-pane fade show active" id="regulatory-front" role="tabpanel" aria-labelledby="regulatory-tab-front">
                        <livewire:regulatory-agenda.regulations-table :dependency="$dependency" is_admin="false" />
                    </div>
                    <div class="tab-pane fade" id="simplification-front" role="tabpanel" aria-labelledby="simplification-tab-front">
                        <livewire:regulatory-agenda.simplifications-table :dependency="$dependency" is_admin="false" />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Estilos personalizados para nav-pills */
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
