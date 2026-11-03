@extends('layouts.master')
@section('title')Intranet @endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') Alumbrado Público @endslot
@slot('title') Peticiones de Servicio @endslot
@endcomponent

<div class="row layout-spacing">
    <div class="main-content">
        <div class="pl-banner rounded-pill px-4 py-3 mb-4">
            <h5 class="mb-0 text-white">Peticiones Servicio Alumbrado Público</h5>
        </div>

        <div class="row mb-4">
            <div class="col-12">
                <form method="GET" action="{{ route('public_lighting.requests.index') }}" class="row g-2">
                    <div class="col-md-3">
                        <select name="status" class="form-select">
                            <option value="">Todos los estatus</option>
                            @foreach (\App\Models\PublicLightingRequest::STATUSES as $key => [$label])
                                <option value="{{ $key }}" {{ request('status') == $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Buscar por folio, nombre, colonia o calle...">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-outline-secondary w-100">
                            <i class="fas fa-filter"></i> Filtrar
                        </button>
                    </div>
                    <div class="col-md-2">
                        <a href="{{ route('public_lighting.requests.index') }}" class="btn btn-outline-secondary w-100">Limpiar filtros</a>
                    </div>
                </form>
            </div>
        </div>

        @if ($requests->count() == 0)
            <div class="card">
                <div class="card-body text-center py-5">
                    <img src="{{ asset('assets/images/empty.svg') }}" class="w-25 mb-4" alt="">
                    <h4>¡No hay peticiones de alumbrado público!</h4>
                    <p class="mb-0">Las peticiones aparecerán aquí cuando los ciudadanos las envíen desde el portal.</p>
                </div>
            </div>
        @else
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>Folio</th>
                                    <th>Recepción</th>
                                    <th>Nombre</th>
                                    <th>Ubicación de petición</th>
                                    <th>Estatus</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($requests as $req)
                                    <tr>
                                        <td class="fw-semibold">{{ $req->folio ?: '#'.$req->id }}</td>
                                        <td>{{ $req->created_at->format('d/m/Y H:i') }}</td>
                                        <td>{{ $req->full_name }}</td>
                                        <td>{{ $req->full_address }}</td>
                                        <td><span class="badge bg-{{ $req->status_color }}">{{ $req->status_label }}</span></td>
                                        <td class="text-end">
                                            <a href="{{ route('public_lighting.requests.show', $req) }}" class="btn btn-sm btn-outline-secondary" title="Ver">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="mt-4">
                {{ $requests->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>
</div>
@endsection

@push('stylesheets')
    <style>
        .pl-banner { background-color: #561a1d; }
    </style>
@endpush
