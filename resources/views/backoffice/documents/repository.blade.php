@extends('layouts.master')
@section('title')Intranet @endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') Backoffice @endslot
@slot('title') Repositorio de Oficios @endslot
@endcomponent

<div class="container-fluid py-4">
    <!-- Header Section -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <div class="d-flex align-items-center">
                        <div class="bg-dark bg-opacity-10 rounded-circle p-3 me-3">
                            <i class="fas fa-archive fa-2x text-dark"></i>
                        </div>
                        <div>
                            <h3 class="mb-1 fw-bold">
                                <i class="fas fa-archive text-dark me-2"></i> Repositorio de Oficios
                            </h3>
                            <p class="text-muted mb-0">
                                <i class="fas fa-eye me-1"></i>
                                Vista general de todos los oficios del sistema
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <!-- Filtros -->
                    <form method="GET" action="{{ route('backoffice.documents.repository') }}" class="mb-4">
                        <div class="row g-3 align-items-end">
                            <div class="col-lg-6">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-search me-1"></i> Buscar:
                                </label>
                                <input type="text"
                                       name="search"
                                       class="form-control"
                                       placeholder="Folio, asunto, solicitante..."
                                       value="{{ request('search') }}">
                            </div>
                            <div class="col-lg-3">
                                <label class="form-label fw-semibold">Tipo:</label>
                                <select name="type" class="form-select">
                                    <option value="">Todos</option>
                                    <option value="solicitud" {{ request('type') == 'solicitud' ? 'selected' : '' }}>Solicitud</option>
                                    <option value="respuesta" {{ request('type') == 'respuesta' ? 'selected' : '' }}>Respuesta</option>
                                </select>
                            </div>
                            <div class="col-lg-2">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-filter me-2"></i> Filtrar
                                </button>
                            </div>
                            <div class="col-lg-1">
                                @if(request()->hasAny(['search', 'type']))
                                    <a href="{{ route('backoffice.documents.repository') }}" class="btn btn-outline-secondary w-100">
                                        <i class="fas fa-times"></i>
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

                    @if($documents->count() == 0)
                        <div class="text-center py-5">
                            <div class="mb-4">
                                <i class="fas fa-archive fa-4x text-muted"></i>
                            </div>
                            <h5 class="text-muted">No hay oficios en el repositorio</h5>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th class="fw-semibold">Folio</th>
                                        <th class="fw-semibold">Asunto</th>
                                        <th class="fw-semibold">Solicitante</th>
                                        <th class="fw-semibold text-center">Tipo</th>
                                        <th class="fw-semibold">Creación</th>
                                        <th class="fw-semibold text-center">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($documents as $document)
                                        <tr>
                                            <td>
                                                <strong class="text-primary">{{ $document->folio }}</strong>
                                            </td>
                                            <td>
                                                <span title="{{ $document->subject }}">
                                                    {{ Str::limit($document->subject, 50) }}
                                                </span>
                                            </td>
                                            <td>{{ $document->requester }}</td>
                                            <td class="text-center">{!! $document->type_badge !!}</td>
                                            <td>{{ $document->created_at->format('d/m/Y H:i') }}</td>
                                            <td class="text-center">
                                                <div class="btn-group btn-group-sm">
                                                    <button type="button" 
                                                            class="btn btn-outline-secondary copy-path-btn" 
                                                            data-path="{{ route('backoffice.documents.show', $document->id) }}"
                                                            title="Copiar Ruta">
                                                        <i class="fas fa-copy"></i>
                                                    </button>
                                                    <a href="{{ route('backoffice.documents.show', $document->id) }}" 
                                                       class="btn btn-outline-primary" 
                                                       title="Ver">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <form action="{{ route('backoffice.documents.destroy', $document->id) }}" 
                                                          method="POST" 
                                                          class="d-inline" 
                                                          onsubmit="return confirm('¿Está seguro de eliminar este oficio?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-outline-danger" title="Eliminar">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-center mt-4">
                            {{ $documents->appends(request()->query())->links('pagination::bootstrap-5') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Copiar ruta al portapapeles
    document.querySelectorAll('.copy-path-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            const path = this.getAttribute('data-path');
            navigator.clipboard.writeText(path).then(function() {
                // Cambiar icono temporalmente
                const icon = btn.querySelector('i');
                icon.classList.remove('fa-copy');
                icon.classList.add('fa-check');
                setTimeout(function() {
                    icon.classList.remove('fa-check');
                    icon.classList.add('fa-copy');
                }, 2000);
            });
        });
    });
});
</script>
@endpush
@endsection
