@extends('layouts.master')
@section('title') Intranet @endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1') Intranet @endslot
        @slot('li_2') Apoyos Económicos @endslot
        @slot('title') Particulares @endslot
    @endcomponent

    <div class="container-fluid py-4">

        {{-- HEADER DE MÓDULO --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <div class="row align-items-center">
                    <div class="col-lg-8 d-flex align-items-center">
                        <div class="bg-primary bg-opacity-10 rounded-circle p-3 me-3">
                            <i class="fas fa-users fa-2x text-primary"></i>
                        </div>
                        <div>
                            <h3 class="mb-1 fw-bold">Particulares</h3>
                            <p class="text-muted mb-0">Registro y gestión de beneficiarios de apoyos económicos</p>
                        </div>
                    </div>
                    <div class="col-lg-4 text-end d-flex gap-2 justify-content-end">
                        @if(Auth::user()->email == 'webmaster@valle.com')
                            <button type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#import">
                                <i class="fas fa-file-excel me-2"></i> Importar Excel
                            </button>
                        @endif
                        <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#modalCreate" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i> Nuevo Particular
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- FILTROS --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <form role="search" action="{{ route('back.citizens.query') }}" class="row g-3 align-items-end">
                    <div class="col-md-10">
                        <label class="form-label fw-semibold">Buscar particular</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                            <input class="form-control" type="search" name="query" placeholder="Nombre o CURP del particular...">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">Buscar</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- MODAL IMPORTAR EXCEL --}}
        @if(Auth::user()->email == 'webmaster@valle.com')
        <div class="modal fade" id="import" role="dialog" aria-labelledby="importLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="importLabel">Importar Excel de Particulares</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="POST" action="{{ route('citizens.import') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body p-4">
                            <label class="form-label fw-semibold">Selecciona tu archivo</label>
                            <input class="form-control" type="file" name="import_file" />
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-upload me-2"></i> Procesar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endif

        @include('citizens.utilities._modal')

        {{-- TABLA O ESTADO VACÍO --}}
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                @if($citizens->count() == 0)
                    <div class="text-center py-5">
                        <div class="mb-4">
                            <i class="fas fa-folder-open fa-4x text-muted"></i>
                        </div>
                        <h5 class="text-muted">No hay particulares registrados</h5>
                        <p class="text-muted mb-4">Empieza a cargarlos en la sección correspondiente.</p>
                        <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#modalCreate" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i> Nuevo Particular
                        </a>
                    </div>
                @else
                    @include('citizens.utilities._table')
                    <div class="d-flex justify-content-center mt-4">
                        {{ $citizens->links('pagination::bootstrap-5') }}
                    </div>
                @endif
            </div>
        </div>

    </div>
@endsection
