@extends('front.layouts.app')

@section('content')
    <div class="container py-4">
        <div class="row">
            <div class="col-md-12">
                @include('front.user_profiles.partials._profile_card')

                <!-- Menú de navegación -->
                <div class="card wow fadeInUp">
                    <div class="card-header">
                        @include('front.user_profiles.partials._profile_nav')
                    </div>

                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="mb-0">
                                <ion-icon name="document-text-outline"></ion-icon> Mis Altas de Proveedor
                            </h5>
                        </div>

                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <ion-icon name="checkmark-circle-outline"></ion-icon> {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <!-- Botones para iniciar proceso -->
                        @if($suppliers->isEmpty() && !request()->has('status') && !request()->has('person_type') && !request()->has('search'))
                            <div class="row mb-4">
                                <div class="col-md-6 mb-3">
                                    <div class="card h-100 border-primary">
                                        <div class="card-body text-center">
                                            <ion-icon name="person-outline" style="font-size: 48px; color: #0d6efd;"></ion-icon>
                                            <h5 class="mt-3">Persona Física</h5>
                                            <p class="text-muted">Inicia el proceso de alta como persona física</p>
                                            <form action="{{ route('supplier.alta.initiate') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="person_type" value="fisica">
                                                <button type="submit" class="btn btn-primary">
                                                    <ion-icon name="add-circle-outline"></ion-icon> Iniciar Proceso
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="card h-100 border-success">
                                        <div class="card-body text-center">
                                            <ion-icon name="business-outline" style="font-size: 48px; color: #198754;"></ion-icon>
                                            <h5 class="mt-3">Persona Moral</h5>
                                            <p class="text-muted">Inicia el proceso de alta como persona moral</p>
                                            <form action="{{ route('supplier.alta.initiate') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="person_type" value="moral">
                                                <button type="submit" class="btn btn-success">
                                                    <ion-icon name="add-circle-outline"></ion-icon> Iniciar Proceso
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <!-- Filtros -->
                            <div class="card mb-4">
                                <div class="card-body">
                                    <form method="GET" action="{{ route('supplier.alta.index') }}" class="row g-3">
                                        <div class="col-md-3">
                                            <label for="status" class="form-label">Estado</label>
                                            <select name="status" id="status" class="form-select">
                                                <option value="">Todos</option>
                                                <option value="solicitud" {{ request('status') == 'solicitud' ? 'selected' : '' }}>Solicitud</option>
                                                <option value="validacion" {{ request('status') == 'validacion' ? 'selected' : '' }}>Validación</option>
                                                <option value="aprobacion" {{ request('status') == 'aprobacion' ? 'selected' : '' }}>Aprobación</option>
                                                <option value="pago_pendiente" {{ request('status') == 'pago_pendiente' ? 'selected' : '' }}>Pago Pendiente</option>
                                                <option value="padron_activo" {{ request('status') == 'padron_activo' ? 'selected' : '' }}>Padrón Activo</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="person_type" class="form-label">Tipo</label>
                                            <select name="person_type" id="person_type" class="form-select">
                                                <option value="">Todos</option>
                                                <option value="fisica" {{ request('person_type') == 'fisica' ? 'selected' : '' }}>Persona Física</option>
                                                <option value="moral" {{ request('person_type') == 'moral' ? 'selected' : '' }}>Persona Moral</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="search" class="form-label">Buscar</label>
                                            <input type="text" name="search" id="search" class="form-control" 
                                                   placeholder="Nombre de empresa o folio" 
                                                   value="{{ request('search') }}">
                                        </div>
                                        <div class="col-md-2 d-flex align-items-end">
                                            <button type="submit" class="btn btn-primary me-2">
                                                <ion-icon name="search-outline"></ion-icon> Filtrar
                                            </button>
                                            <a href="{{ route('supplier.alta.index') }}" class="btn btn-outline-secondary">
                                                <ion-icon name="close-outline"></ion-icon>
                                            </a>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <!-- Botones para nueva alta -->
                            <div class="mb-3 d-flex gap-2">
                                <form action="{{ route('supplier.alta.initiate') }}" method="POST" class="d-inline">
                                    @csrf
                                    <input type="hidden" name="person_type" value="fisica">
                                    <button type="submit" class="btn btn-primary">
                                        <ion-icon name="add-circle-outline"></ion-icon> Nueva Alta Persona Física
                                    </button>
                                </form>
                                <form action="{{ route('supplier.alta.initiate') }}" method="POST" class="d-inline">
                                    @csrf
                                    <input type="hidden" name="person_type" value="moral">
                                    <button type="submit" class="btn btn-success">
                                        <ion-icon name="add-circle-outline"></ion-icon> Nueva Alta Persona Moral
                                    </button>
                                </form>
                            </div>

                            <!-- Tabla de altas -->
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Folio</th>
                                            <th>Tipo</th>
                                            <th>Nombre/Razón Social</th>
                                            <th>Estado</th>
                                            <th>Progreso</th>
                                            <th>Fecha</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($suppliers as $supplier)
                                            <tr>
                                                <td>
                                                    <strong>{{ $supplier->registration_number }}</strong>
                                                </td>
                                                <td>
                                                    @if($supplier->person_type === 'fisica')
                                                        <span class="badge bg-primary">
                                                            <ion-icon name="person-outline"></ion-icon> Física
                                                        </span>
                                                    @else
                                                        <span class="badge bg-success">
                                                            <ion-icon name="business-outline"></ion-icon> Moral
                                                        </span>
                                                    @endif
                                                </td>
                                                <td>
                                                    {{ $supplier->display_name }}
                                                </td>
                                                <td>
                                                    {!! $supplier->status_badge !!}
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="progress flex-grow-1" style="height: 20px; min-width: 100px;">
                                                            <div class="progress-bar {{ $supplier->progress_percentage == 100 ? 'bg-success' : 'bg-primary' }}" 
                                                                 role="progressbar" 
                                                                 style="width: {{ $supplier->progress_percentage }}%"
                                                                 aria-valuenow="{{ $supplier->progress_percentage }}" 
                                                                 aria-valuemin="0" 
                                                                 aria-valuemax="100">
                                                                {{ $supplier->progress_percentage }}%
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <small>{{ $supplier->created_at->format('d/m/Y') }}</small>
                                                </td>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        <a href="{{ route('supplier.alta.form', $supplier->id) }}" 
                                                           class="btn btn-sm btn-outline-primary" 
                                                           title="Editar">
                                                            <ion-icon name="create-outline"></ion-icon> Editar
                                                        </a>
                                                        {{--  
                                                        <a href="{{ route('supplier.alta.show', $supplier->id) }}" 
                                                           class="btn btn-sm btn-outline-info" 
                                                           title="Ver">
                                                            <ion-icon name="eye-outline"></ion-icon>
                                                        </a>
                                                        --}}
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center py-4">
                                                    <p class="text-muted mb-0">No se encontraron altas con los filtros aplicados</p>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <!-- Paginación -->
                            @if($suppliers->hasPages())
                                <div class="d-flex justify-content-center mt-4">
                                    {{ $suppliers->links() }}
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
