@extends('layouts.master')
@section('title')Intranet @endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') Backoffice @endslot
@slot('title') Dependencias @endslot
@endcomponent

<div class="container-fluid py-4">
    <!-- Header Section -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary bg-opacity-10 rounded-circle p-3 me-3">
                            <i class="fas fa-building fa-2x text-primary"></i>
                        </div>
                        <div>
                            <h3 class="mb-1 fw-bold">
                                <i class="fas fa-sitemap text-primary me-2"></i> Dependencias
                            </h3>
                            <p class="text-muted mb-0">
                                <i class="fas fa-clipboard-list me-1"></i>
                                Gestión de dependencias para oficios
                            </p>
                        </div>
                    </div>
                </div>

                @hasanyrole(['all', 'webmaster'])
                <div class="col-lg-4 text-end">
                    <a href="{{ route('backoffice.dependencies.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i> Nueva Dependencia
                    </a>
                </div>
                @endhasanyrole
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <!-- Filtros -->
                    <form method="GET" action="{{ route('backoffice.dependencies.index') }}" class="mb-4">
                        <div class="row g-3 align-items-end">
                            <div class="col-lg-8">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-search me-1"></i> Buscar:
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="fas fa-search text-muted"></i>
                                    </span>
                                    <input type="text"
                                           name="search"
                                           class="form-control border-start-0"
                                           placeholder="Buscar por código, nombre o responsable..."
                                           value="{{ request('search') }}">
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-filter me-2"></i> Filtrar
                                </button>
                            </div>
                            <div class="col-lg-2">
                                @if(request()->has('search'))
                                    <a href="{{ route('backoffice.dependencies.index') }}" class="btn btn-outline-secondary w-100">
                                        <i class="fas fa-times me-1"></i> Limpiar
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-check-circle fa-lg me-3"></i>
                                <div>{{ session('success') }}</div>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-exclamation-circle fa-lg me-3"></i>
                                <div>{{ session('error') }}</div>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if($dependencies->count() == 0)
                        <div class="text-center py-5">
                            <div class="mb-4">
                                <i class="fas fa-folder-open fa-4x text-muted"></i>
                            </div>
                            <h5 class="text-muted">No hay dependencias registradas</h5>
                            <p class="text-muted mb-4">Comienza creando una nueva dependencia para gestionar oficios.</p>
                            @hasanyrole(['all', 'webmaster'])
                            <a href="{{ route('backoffice.dependencies.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i> Crear Primera Dependencia
                            </a>
                            @endhasanyrole
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th class="fw-semibold">Código</th>
                                        <th class="fw-semibold">Nombre</th>
                                        <th class="fw-semibold">Tipo</th>
                                        <th class="fw-semibold">Responsable</th>
                                        <th class="fw-semibold text-center">Usuarios</th>
                                        <th class="fw-semibold text-center">Oficios</th>
                                        <th class="fw-semibold text-center">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($dependencies as $dependency)
                                        <tr>
                                            <td>
                                                <span class="badge bg-primary">{{ $dependency->formatted_code }}</span>
                                            </td>
                                            <td>
                                                <strong>{{ $dependency->name }}</strong>
                                            </td>
                                            <td>
                                                @if($dependency->type)
                                                    <span class="text-muted">{{ $dependency->type }}</span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>{{ $dependency->responsible_name }}</td>
                                            <td class="text-center">
                                                <span class="badge bg-secondary">{{ $dependency->users_count ?? 0 }}</span>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-info">{{ $dependency->documents_count ?? 0 }}</span>
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group btn-group-sm">
                                                    <a href="{{ route('backoffice.dependencies.edit', $dependency->id) }}" 
                                                       class="btn btn-outline-primary" 
                                                       title="Editar">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    @if($dependency->documents_count == 0 && $dependency->users_count == 0)
                                                        <form action="{{ route('backoffice.dependencies.destroy', $dependency->id) }}" 
                                                              method="POST" 
                                                              class="d-inline" 
                                                              onsubmit="return confirm('¿Está seguro de eliminar esta dependencia?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-outline-danger" title="Eliminar">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-center mt-4">
                            {{ $dependencies->appends(request()->query())->links('pagination::bootstrap-5') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
