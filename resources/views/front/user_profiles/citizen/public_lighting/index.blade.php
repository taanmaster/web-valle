@extends('front.layouts.app')

@section('content')
    <div class="container py-4">
        @include('front.user_profiles.partials._profile_card')

        <div class="row g-3 mt-0">
            <div class="col-md-3">
                @include('front.user_profiles.partials._profile_nav')
            </div>
            <div class="col-md-9">
                <div class="card wow fadeInUp">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="mb-0">
                                <ion-icon name="file-tray-full-outline"></ion-icon> Mis Solicitudes — Peticiones Servicio Alumbrado Público
                            </h5>
                            <a href="{{ route('citizen.public_lighting.create') }}" class="btn" style="background-color:#6d1b2b; color:#fff;">
                                <ion-icon name="add-circle-outline"></ion-icon> Nueva Petición
                            </a>
                        </div>

                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        {{-- Filtros --}}
                        <form method="GET" action="{{ route('citizen.public_lighting.index') }}" class="row g-2 mb-4">
                            <div class="col-md-3">
                                <label class="form-label">Estatus</label>
                                <select name="status" class="form-select">
                                    <option value="">Todos los estatus</option>
                                    @foreach (\App\Models\PublicLightingRequest::STATUSES as $key => [$label])
                                        <option value="{{ $key }}" {{ request('status') == $key ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Desde</label>
                                <input type="date" name="from" value="{{ request('from') }}" class="form-control">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Hasta</label>
                                <input type="date" name="to" value="{{ request('to') }}" class="form-control">
                            </div>
                            <div class="col-md-3 d-flex align-items-end gap-2">
                                <button type="submit" class="btn btn-outline-secondary flex-grow-1">
                                    <ion-icon name="filter-outline"></ion-icon> Filtrar
                                </button>
                                <a href="{{ route('citizen.public_lighting.index') }}" class="btn btn-outline-secondary flex-grow-1">Limpiar filtros</a>
                            </div>
                        </form>

                        @if ($requests->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Folio</th>
                                            <th>Fecha de petición</th>
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
                                                <td>{{ $req->full_address }}</td>
                                                <td><span class="badge bg-{{ $req->status_color }}">{{ $req->status_label }}</span></td>
                                                <td class="text-end">
                                                    <a href="{{ route('citizen.public_lighting.show', $req) }}" class="btn btn-sm btn-outline-secondary">
                                                        <ion-icon name="eye-outline"></ion-icon> Ver
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-3">
                                {{ $requests->links('pagination::bootstrap-5') }}
                            </div>
                        @else
                            <div class="text-center py-5">
                                <ion-icon name="file-tray-outline" style="font-size: 3rem;" class="text-muted"></ion-icon>
                                <p class="mb-0 text-muted">Aún no tienes peticiones de alumbrado público.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
