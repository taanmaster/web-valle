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
                                <ion-icon name="file-tray-full-outline"></ion-icon> Mis Solicitudes — Permiso de Publicidad en Vía Pública
                            </h5>
                        </div>

                        <div class="alert alert-info d-flex align-items-start gap-2">
                            <ion-icon name="information-circle-outline" style="font-size:1.3rem;"></ion-icon>
                            <span>
                                Este trámite se captura en Fiscalización, acude con tu material publicitario. Aquí solo podrás consultar el estatus de las solicitudes capturadas a tu nombre.
                            </span>
                        </div>

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
                                                            <ion-icon name="megaphone-outline"></ion-icon> {{ $req->advertising_type }}
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
                                <p class="mb-0 text-muted">Aún no tienes solicitudes de Permiso de Publicidad en Vía Pública.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
