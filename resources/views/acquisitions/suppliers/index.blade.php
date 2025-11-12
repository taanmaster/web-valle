@extends('layouts.master')
@section('title')Intranet @endsection
@section('content')
<!-- this is breadcrumbs -->
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') Adquisiciones @endslot
@slot('title') Solicitudes de Alta de Proveedores @endslot
@endcomponent

<div class="container-fluid py-4">
    <!-- Header Section -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <div class="d-flex align-items-center mb-2">
                        <div class="bg-primary bg-opacity-10 rounded-circle p-3 me-3">
                            <i class="fas fa-users-cog fa-2x text-primary"></i>
                        </div>
                        <div>
                            <h3 class="mb-1 fw-bold">Solicitudes de Alta de Proveedores</h3>
                            <p class="text-muted mb-0">
                                <i class="fas fa-clipboard-list me-1"></i>
                                Gestión y seguimiento de solicitudes de proveedores
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                    @include('acquisitions.suppliers.utilities._search_options')
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
            <div class="d-flex align-items-center">
                <i class="fas fa-check-circle fa-lg me-3"></i>
                <div>{{ session('success') }}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($suppliers->count() == 0)
    <div class="row"> 
        <div class="col-lg-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body"> 
                    <div class="text-center py-5">
                        <div class="mb-4">
                            <i class="fas fa-inbox fa-5x text-muted opacity-50"></i>
                        </div>
                        <h4 class="fw-bold mb-3">¡No hay solicitudes de Alta de Proveedores!</h4>
                        <p class="text-muted mb-4">
                            Las solicitudes aparecerán aquí cuando los proveedores las envíen desde el portal.
                        </p>
                        <div class="d-flex justify-content-center gap-2">
                            <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2">
                                <i class="fas fa-info-circle me-1"></i> Sistema listo para recibir solicitudes
                            </span>
                        </div>
                    </div>       
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="row"> 
        @include('acquisitions.suppliers.utilities._table')
    </div>

    @if($suppliers->hasPages())
    <div class="card border-0 shadow-sm mt-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-muted">
                    <i class="fas fa-info-circle me-1"></i>
                    Mostrando <strong>{{ $suppliers->firstItem() }}</strong> a <strong>{{ $suppliers->lastItem() }}</strong> de <strong>{{ $suppliers->total() }}</strong> registros
                </div>
                <div>
                    {{ $suppliers->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
    @endif
    @endif    
</div>

@section('scripts')
<style>
    /* Estilos personalizados para tablas */
    .table {
        font-size: 0.9rem;
    }
    
    .table-dark th {
        background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
        color: white;
        font-weight: 600;
        text-align: center;
        vertical-align: middle;
        border: none;
        padding: 1rem 0.75rem;
    }

    .table tbody tr {
        transition: all 0.3s ease;
    }

    .table tbody tr:hover {
        background-color: rgba(13, 110, 253, 0.05);
        transform: scale(1.01);
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .table td {
        vertical-align: middle;
        padding: 1rem 0.75rem;
    }

    /* Badges mejorados */
    .badge {
        padding: 0.5rem 0.75rem;
        border-radius: 6px;
        font-weight: 500;
        font-size: 0.8rem;
    }

    /* Progress bar mejorado */
    .progress {
        border-radius: 8px;
        background-color: #e9ecef;
        box-shadow: inset 0 1px 2px rgba(0,0,0,0.1);
    }
    
    .progress-bar {
        border-radius: 8px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    /* Botones */
    .btn-group .btn {
        transition: all 0.3s ease;
    }
    
    .btn-group .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    }

    /* Dropdown menus */
    .dropdown-menu {
        border: none;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        border-radius: 8px;
    }
    
    .dropdown-item {
        padding: 0.75rem 1.25rem;
        transition: all 0.2s ease;
    }
    
    .dropdown-item:hover {
        background-color: rgba(13, 110, 253, 0.1);
        padding-left: 1.5rem;
    }

    /* Tooltips */
    .tooltip {
        font-size: 0.875rem;
    }

    /* Cards */
    .card {
        border-radius: 12px;
        transition: all 0.3s ease;
    }

    .card:hover {
        box-shadow: 0 8px 25px rgba(0,0,0,0.1) !important;
    }

    /* Empty state */
    .text-center i.fa-inbox {
        animation: float 3s ease-in-out infinite;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .table {
            font-size: 0.8rem;
        }
        
        .table td, .table th {
            padding: 0.5rem 0.25rem;
        }
        
        .badge {
            font-size: 0.7rem;
            padding: 0.35rem 0.5rem;
        }
    }
</style>

<script>
    // Inicializar tooltips de Bootstrap
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>
@endsection
@endsection
