@extends('layouts.master')
@section('title')Intranet @endsection
@section('content')
<!-- this is breadcrumbs -->
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') Fiscalización @endslot
@slot('title') {{ $breadcrumbTitle }} @endslot
@endcomponent

<div class="row layout-spacing">
    <div class="main-content">
        <div class="row align-items-center mb-4">
            <div class="col text-start">
                <h4 class="mb-0">{{ $heading }}</h4>
                <p class="text-muted">{{ $subtitle }}</p>
            </div>
            @if ($createRoute)
            <div class="col-auto">
                <a href="{{ $createRoute }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> {{ $createLabel ?? 'Nueva Solicitud' }}
                </a>
            </div>
            @endif
        </div>

        <div class="row mb-4">
            <div class="col-12">
                <form method="GET" action="{{ $filterRoute }}" class="row g-2">
                    <div class="col-md-3">
                        <select name="status" class="form-select">
                            <option value="">Todos los estados</option>
                            <option value="nueva_solicitud" {{ request('status') == 'nueva_solicitud' ? 'selected' : '' }}>Nuevo</option>
                            <option value="inspeccion" {{ request('status') == 'inspeccion' ? 'selected' : '' }}>Inspección</option>
                            <option value="aprobada" {{ request('status') == 'aprobada' ? 'selected' : '' }}>Aprobada</option>
                            <option value="denegada" {{ request('status') == 'denegada' ? 'selected' : '' }}>Denegada</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="{{ $searchPlaceholder }}">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-outline-secondary w-100">
                            <i class="fas fa-filter"></i> Filtrar
                        </button>
                    </div>
                </form>
            </div>
        </div>

        @if ($requests->count() == 0)
        <div class="row">
            <div class="col-lg-12">
                <div class="box">
                    <div class="box-body">
                        <div class="text-center" style="padding:80px 0px 100px 0px;">
                            <img src="{{ asset('assets/images/empty.svg') }}" class="ml-auto mr-auto" style="width:30%; margin-bottom: 40px;">
                            <h4>{{ $emptyTitle }}</h4>
                            <p class="mb-4">{{ $emptyText }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="row">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No. Solicitud</th>
                            <th>Tipo de Solicitud</th>
                            <th>{{ $personLabel }}</th>
                            <th>{{ $dateLabel }}</th>
                            <th>Estatus</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($requests as $req)
                        <tr>
                            <td>{{ $req->folio ?: '#'.$req->id }}</td>
                            <td>{{ $tramiteLabel }}</td>
                            <td>{{ $personResolver($req) }}</td>
                            <td>{{ $dateResolver($req) }}</td>
                            <td><span class="badge bg-{{ $req->status_color }}">{{ $req->status_label }}</span></td>
                            <td>
                                <a href="{{ route($showRoute, $req) }}" class="btn btn-sm btn-outline-info" title="Ver">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="align-items-center mt-4">
            {{ $requests->links('pagination::bootstrap-5') }}
        </div>
        @endif
    </div>
</div>
@endsection
