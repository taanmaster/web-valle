@extends('layouts.master')
@section('title') Intranet @endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1') Intranet @endslot
        @slot('li_2') Apoyos Económicos @endslot
        @slot('title') Listado por Día @endslot
    @endcomponent

    <div class="container-fluid py-4">

        {{-- ALERTA: ERRORES DE IMPORTACIÓN POR FILA --}}
        @if(session('import_row_errors'))
            <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
                <div class="d-flex align-items-start">
                    <i class="fas fa-exclamation-triangle fa-lg me-3 mt-1"></i>
                    <div class="w-100">
                        <strong>FALTA INFORMACIÓN OBLIGATORIA EN LAS SIGUIENTES FILAS DEL DOCUMENTO:</strong>
                        <div class="table-responsive mt-2">
                            <table class="table table-sm table-bordered mb-0 bg-white">
                                <thead class="table-light">
                                    <tr>
                                        <th class="fw-semibold">Fila</th>
                                        <th class="fw-semibold">Columnas faltantes</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach(session('import_row_errors') as $fila => $columnas)
                                        <tr>
                                            <td class="text-center fw-bold">{{ $fila }}</td>
                                            <td>{{ implode(', ', $columnas) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <p class="mb-0 mt-2 small text-muted">Las filas con información incompleta fueron omitidas. El resto se importó correctamente.</p>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- HEADER DE MÓDULO --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <div class="row align-items-center">
                    <div class="col-lg-8 d-flex align-items-center">
                        <div class="bg-primary bg-opacity-10 rounded-circle p-3 me-3">
                            <i class="fas fa-hand-holding-usd fa-2x text-primary"></i>
                        </div>
                        <div>
                            <h3 class="mb-1 fw-bold">Apoyos Económicos</h3>
                            <p class="text-muted mb-0">Registro y consulta de apoyos entregados a beneficiarios</p>
                        </div>
                    </div>
                    <div class="col-lg-4 text-end d-flex gap-2 justify-content-end">
                        <button type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#importApoyos">
                            <i class="fas fa-file-excel me-2"></i> Importar Excel
                        </button>
                        <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#modalCreate" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i> Nuevo Apoyo
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- FILTROS --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <div class="row g-3 align-items-end">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Buscar por folio</label>
                        <form role="search" action="{{ route('back.financial_supports.query') }}" class="input-group">
                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                            <input class="form-control" type="search" name="query" placeholder="Folio del apoyo...">
                            <button type="submit" class="btn btn-primary">Buscar</button>
                        </form>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Filtrar por fecha</label>
                        <form role="search" action="{{ route('report.query') }}" class="input-group">
                            <input type="date" class="form-control" name="date_start" value="{{ Request::input('date_start') }}">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- NAVEGACIÓN POR DÍA --}}
        <div class="d-flex gap-3 align-items-center justify-content-center mb-4">
            <form role="search" action="{{ route('report.query') }}">
                <input type="hidden" name="date_start" value="{{ Carbon\Carbon::parse(Request::input('date_start'))->subDay()->format('Y-m-d') }}">
                <button type="submit" class="btn btn-outline-secondary" title="Día anterior" aria-label="Día anterior">
                    <i class="fas fa-arrow-left"></i>
                </button>
            </form>
            <h5 class="mb-0 fw-bold">Apoyos del día: {{ Carbon\Carbon::parse(Request::input('date_start'))->translatedFormat('d M Y') }}</h5>
            <form role="search" action="{{ route('report.query') }}">
                <input type="hidden" name="date_start" value="{{ Carbon\Carbon::parse(Request::input('date_start'))->addDay()->format('Y-m-d') }}">
                <button type="submit" class="btn btn-outline-secondary" title="Día siguiente" aria-label="Día siguiente">
                    <i class="fas fa-arrow-right"></i>
                </button>
            </form>
        </div>

        @include('financial_supports.utilities._modal')

        {{-- MODAL IMPORTAR EXCEL --}}
        <div class="modal fade" id="importApoyos" role="dialog" aria-labelledby="importApoyosLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="importApoyosLabel">Importar Apoyos desde Excel</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="POST" action="{{ route('financial_supports.import') }}" enctype="multipart/form-data" id="formImportApoyos">
                        @csrf
                        <div class="modal-body p-4">
                            <p class="text-muted small mb-3">El archivo debe contener las columnas: <strong>Fecha, Tipos de Apoyo, Apellido P, Apellido M, Nombre, CURP, Calle, Numero, Colonia, Seccional, Teléfono, Observaciones</strong>.</p>
                            <label class="form-label fw-semibold">Selecciona tu archivo Excel</label>
                            <input class="form-control" type="file" name="import_file" accept=".xlsx,.xls,.csv" required />
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary" id="btnProcesarImport">
                                <i class="fas fa-upload me-2" id="btnProcesarIcon"></i>
                                <span class="spinner-border spinner-border-sm me-2 d-none" id="btnProcesarSpinner" role="status" aria-hidden="true"></span>
                                <span id="btnProcesarLabel">Procesar</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- TABLA O ESTADO VACÍO --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                @if($financial_supports->count() == 0)
                    <div class="text-center py-5">
                        <div class="mb-4">
                            <i class="fas fa-folder-open fa-4x text-muted"></i>
                        </div>
                        <h5 class="text-muted">No hay apoyos registrados en este día</h5>
                        <p class="text-muted mb-4">Empieza a cargarlos en la sección correspondiente.</p>
                        <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#modalCreate" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i> Nuevo Apoyo
                        </a>
                    </div>
                @else
                    @include('financial_supports.utilities._table')
                @endif
            </div>
        </div>

        {{-- DESCARGA CORTE --}}
        <form method="POST" action="{{ route('financial_supports.downloadCashCut') }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="date_start" value="{{ Request::input('date_start') }}">
            <button type="submit" class="btn btn-success">
                <i class="fas fa-file-excel me-2"></i> Descargar Corte de este día
            </button>
        </form>

    </div>
@endsection

@push('scripts')
<script>
    document.getElementById('formImportApoyos').addEventListener('submit', function () {
        const btn     = document.getElementById('btnProcesarImport');
        const icon    = document.getElementById('btnProcesarIcon');
        const spinner = document.getElementById('btnProcesarSpinner');
        const label   = document.getElementById('btnProcesarLabel');

        btn.disabled = true;
        icon.classList.add('d-none');
        spinner.classList.remove('d-none');
        label.textContent = 'Procesando...';
    });
</script>
@endpush
