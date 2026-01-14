@extends('layouts.master')
@section('title')
    Intranet
@endsection
@section('content')
    <!-- Breadcrumbs -->
    @component('components.breadcrumb')
        @slot('li_1')
            Intranet
        @endslot
        @slot('li_2')
            Contraloría
        @endslot
        @slot('title')
            Denuncia #{{ $complain->id }}
        @endslot
    @endcomponent

    <div class="row layout-spacing">
        <div class="main-content">
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header bg-dark text-white">
                            <h5 class="card-title mb-0 text-white">Información del Denunciante</h5>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">{{ $complain->name }}</h5>

                            <div class="mb-3">
                                <span class="badge bg-{{ $complain->status == 'Pendiente' ? 'warning' : ($complain->status == 'En proceso' ? 'info' : 'success') }}">
                                    {{ $complain->status }}
                                </span>
                            </div>

                            <p class="card-text"><strong>Teléfono:</strong> {{ $complain->phone }}</p>
                            <p class="card-text"><strong>Correo:</strong> {{ $complain->email ?? 'N/A' }}</p>
                            <p class="card-text"><strong>Dirección:</strong> {{ $complain->address }}</p>

                            <hr>

                            <div class="d-flex gap-2 flex-wrap" role="group">
                                <a href="{{ route('citizen_complain.index') }}" class="btn btn-sm btn-secondary">
                                    <i class="bx bx-arrow-back"></i> Volver
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header bg-dark text-white">
                            <h5 class="card-title mb-0 text-white">Detalle de la Denuncia</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <h6 class="text-muted">Folio</h6>
                                    <p class="fs-5"><strong>#{{ $complain->id }}</strong></p>
                                </div>

                                <div class="col-12 mb-3">
                                    <h6 class="text-muted">Asunto</h6>
                                    <p>{{ $complain->subject }}</p>
                                </div>

                                <div class="col-12 mb-3">
                                    <h6 class="text-muted">Descripción</h6>
                                    <p>{{ $complain->message }}</p>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <h6 class="text-muted">Fecha de Creación</h6>
                                    <p>{{ $complain->created_at->format('d/m/Y H:i') }}</p>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <h6 class="text-muted">Última Actualización</h6>
                                    <p>{{ $complain->updated_at->format('d/m/Y H:i') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($complain->files && $complain->files->count() > 0)
                        <div class="card mt-3">
                            <div class="card-header bg-dark text-white">
                                <h5 class="card-title mb-0 text-white">Pruebas Adjuntas</h5>
                            </div>
                            <div class="card-body">
                                <ul class="list-group list-group-flush">
                                    @foreach($complain->files as $file)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span>{{ $file->name }}</span>
                                            <a href="{{ asset($file->filename) }}" class="btn btn-sm btn-outline-primary" target="_blank">
                                                <i class="bx bx-download"></i> Ver archivo
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
