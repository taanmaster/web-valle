@extends('layouts.master')
@section('title')Intranet @endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') Backoffice @endslot
@slot('title') Oficios Recibidos @endslot
@endcomponent

<div class="container-fluid py-4">
    <!-- Header Section -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <div class="d-flex align-items-center">
                        <div class="bg-success bg-opacity-10 rounded-circle p-3 me-3">
                            <i class="fas fa-inbox fa-2x text-success"></i>
                        </div>
                        <div>
                            <h3 class="mb-1 fw-bold">
                                <i class="fas fa-inbox text-success me-2"></i> Oficios Recibidos
                            </h3>
                            <p class="text-muted mb-0">
                                <i class="fas fa-envelope-open-text me-1"></i>
                                Oficios firmados que te han sido enviados
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 text-end">
                    <a href="{{ route('backoffice.documents.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i> Nuevo Oficio
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabs de navegación -->
    <ul class="nav nav-tabs mb-4" id="documentTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link" href="{{ route('backoffice.documents.index') }}">
                <i class="fas fa-file-alt me-2"></i> Mis Oficios
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link active" href="{{ route('backoffice.documents.received') }}">
                <i class="fas fa-inbox me-2"></i> Recibidos
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" href="{{ route('backoffice.documents.notifications') }}">
                <i class="fas fa-bell me-2"></i> Notificaciones
            </a>
        </li>
    </ul>

    <div class="row">
        <div class="col-lg-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <!-- Filtros -->
                    <form method="GET" action="{{ route('backoffice.documents.received') }}" class="mb-4">
                        <div class="row g-3 align-items-end">
                            <div class="col-lg-4">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-search me-1"></i> Buscar:
                                </label>
                                <input type="text"
                                       name="search"
                                       class="form-control"
                                       placeholder="Folio, asunto..."
                                       value="{{ request('search') }}">
                            </div>
                            <div class="col-lg-3">
                                <label class="form-label fw-semibold">Prioridad:</label>
                                <select name="priority" class="form-select">
                                    <option value="">Todas</option>
                                    <option value="urgente" {{ request('priority') == 'urgente' ? 'selected' : '' }}>Urgente</option>
                                    <option value="alta" {{ request('priority') == 'alta' ? 'selected' : '' }}>Alta</option>
                                    <option value="baja" {{ request('priority') == 'baja' ? 'selected' : '' }}>Baja</option>
                                </select>
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

                    @if($documents->count() == 0)
                        <div class="text-center py-5">
                            <div class="mb-4">
                                <i class="fas fa-inbox fa-4x text-muted"></i>
                            </div>
                            <h5 class="text-muted">No tienes oficios recibidos</h5>
                            <p class="text-muted mb-4">Cuando te envíen un oficio firmado, aparecerá aquí.</p>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th class="fw-semibold">Folio</th>
                                        <th class="fw-semibold">Recibido</th>
                                        <th class="fw-semibold">De</th>
                                        <th class="fw-semibold">Dependencia Origen</th>
                                        <th class="fw-semibold">Asunto</th>
                                        <th class="fw-semibold text-center">Prioridad</th>
                                        <th class="fw-semibold text-center">Tipo</th>
                                        <th class="fw-semibold text-center">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($documents as $document)
                                        <tr>
                                            <td>
                                                <strong class="text-primary">{{ $document->folio }}</strong>
                                                <span class="badge bg-success ms-1">Firmado</span>
                                            </td>
                                            <td>
                                                <small class="text-muted">
                                                    {{ $document->sent_at ? $document->sent_at->format('d/m/Y H:i') : '-' }}
                                                </small>
                                            </td>
                                            <td>{{ $document->requester }}</td>
                                            <td>
                                                <small>{{ $document->user->backofficeDependency->name ?? '-' }}</small>
                                            </td>
                                            <td>
                                                <span title="{{ $document->subject }}">
                                                    {{ Str::limit($document->subject, 35) }}
                                                </span>
                                            </td>
                                            <td class="text-center">{!! $document->priority_badge !!}</td>
                                            <td class="text-center">{!! $document->type_badge !!}</td>
                                            <td class="text-center">
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('backoffice.documents.show', $document->id) }}" 
                                                       class="btn btn-sm btn-outline-primary"
                                                       title="Ver detalle">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('backoffice.documents.pdf', $document->id) }}" 
                                                       class="btn btn-sm btn-danger"
                                                       target="_blank"
                                                       title="Descargar PDF">
                                                        <i class="fas fa-file-pdf"></i>
                                                    </a>
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
@endsection
