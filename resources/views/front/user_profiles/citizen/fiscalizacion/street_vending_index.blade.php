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
                                <ion-icon name="file-tray-full-outline"></ion-icon> Mis Solicitudes — Permiso de Venta en Vía Pública
                            </h5>
                            <a href="{{ route('citizen.fisc.street_vending.create') }}" class="btn" style="background-color:#6d1b2b; color:#fff;">
                                <ion-icon name="add-circle-outline"></ion-icon> Nueva Solicitud
                            </a>
                        </div>

                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        {{-- Filtros --}}
                        <form method="GET" action="{{ route('citizen.fisc.street_vending.index') }}" class="row g-2 mb-4">
                            <div class="col-md-4">
                                <label class="form-label">Estatus</label>
                                <select name="status" class="form-select">
                                    <option value="">Todos los estados</option>
                                    <option value="nueva_solicitud" {{ request('status') == 'nueva_solicitud' ? 'selected' : '' }}>Nuevo</option>
                                    <option value="inspeccion" {{ request('status') == 'inspeccion' ? 'selected' : '' }}>Inspección</option>
                                    <option value="aprobada" {{ request('status') == 'aprobada' ? 'selected' : '' }}>Aprobada</option>
                                    <option value="denegada" {{ request('status') == 'denegada' ? 'selected' : '' }}>Denegada</option>
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
                            <div class="col-md-2 d-flex align-items-end">
                                <button type="submit" class="btn btn-outline-secondary w-100">
                                    <ion-icon name="filter-outline"></ion-icon> Filtrar
                                </button>
                            </div>
                        </form>

                        @if ($requests->count() > 0)
                            <div class="row">
                                @foreach ($requests as $req)
                                    <div class="col-md-12 mb-3">
                                        <div class="card border">
                                            <div class="card-body">
                                                <div class="row align-items-center">
                                                    <div class="col-md-8">
                                                        <h6 class="mb-1">Solicitud {{ $req->folio ?: '#'.$req->id }}</h6>
                                                        <p class="text-muted mb-0">
                                                            <ion-icon name="calendar-outline"></ion-icon> Creada: {{ $req->created_at->format('d/m/Y') }}
                                                            <span class="mx-2">|</span>
                                                            <ion-icon name="location-outline"></ion-icon> {{ $req->option1_street }}
                                                        </p>
                                                    </div>
                                                    <div class="col-md-4 text-md-end mt-2 mt-md-0">
                                                        <span class="badge bg-{{ $req->status_color }} mb-2">{{ $req->status_label }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="mt-3">
                                {{ $requests->links('pagination::bootstrap-5') }}
                            </div>
                        @else
                            <div class="text-center py-5">
                                <ion-icon name="file-tray-outline" style="font-size: 3rem;" class="text-muted"></ion-icon>
                                <p class="mb-0 text-muted">Aún no tienes solicitudes de Permiso de Venta en Vía Pública.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
