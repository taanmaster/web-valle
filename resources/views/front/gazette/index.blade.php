@extends('front.layouts.app')

@section('content')
    <div class="container">

        @if ($type == 'all' && !isset($is_filtered))
            <div class="row justify-content-center mb-4">
                <div class="col-md-12">
                    <div class="card card-image card-image-banner justify-content-center wow fadeInUp">
                        <img class="card-img-top" src="{{ asset('front/img/placeholder.jpg') }}" alt="">
                        <div class="overlay" style="opacity: .4"></div>
                        <div class="card-content text-center w-100">
                            <p class="small-uppercase mb-0">Bienvenidos a la página oficial de</p>
                            <h1 class="display-1 mb-3">Gaceta Municipal</h1>
                            <p class="p mb-0 ms-auto me-auto" style="width: 70%;">Entérate aquí de las decisiones tomadas
                                por las y los integrantes del H. Ayuntamiento.</p>
                        </div>
                    </div>

                    <div class="card card-normal wow fadeInUp mt-4 mb-4">
                        @include('front.gazette.utilities._folder_cards')
                    </div>
                </div>
            </div>
        @endif

        <div class="row">
            <div class="col-12">
                <div class="card card-normal wow fadeInUp">
                    <div class="card-title">
                        <div class="d-flex gap-3">
                            @switch($type)
                                @case('all')
                                    <div class="card-icon bg-secondary text-white d-flex align-items-center justify-content-center">
                                        <ion-icon name="documents-outline"></ion-icon>
                                    </div>

                                    <h3>Archivo de Gaceta Municipal</h3>
                                @break

                                @case('ordinary')
                                    <div class="card-icon bg-success text-white d-flex align-items-center justify-content-center">
                                        <ion-icon name="documents-outline"></ion-icon>
                                    </div>

                                    <h3>Sesiones Ordinarias H. Ayuntamiento 2024-2027</h3>
                                @break
                            @endswitch
                        </div>
                    </div>
                    <div class="row justify-content-center mb-4 w-100">
                        <div class="col-md-12">
                            <div class="card card-image card-image-banner justify-content-center wow fadeInUp">
                                <img class="card-img-top" src="{{ asset('front/img/placeholder-5.jpg') }}" alt="">
                                <div class="overlay" style="opacity: .4"></div>
                                <div class="card-content text-center w-100">
                                    <h1 class="display-1 mb-0">Gaceta Municipal</h1>
                                    <p>Entérate aquí de las decisiones tomadas por las y los integrantes del H.
                                        Ayuntamiento</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row w-100">
                        <div class="col-md-12 mb-4">
                            <h6 class="mb-3">Filtrar por Fecha</h6>
                            <ul class="nav nav-pills">
                                @foreach ($dates as $date)
                                    <li class="nav-item">
                                        <a class="nav-link {{ (isset($selected_date) && $date->format('Y-m') == $selected_date) || (!isset($selected_date) && $loop->first) ? 'active' : '' }}"
                                            href="{{ route('gazette.filter', [$type, 'date' => $date->format('Y-m')]) }}">
                                            {{ $date->translatedFormat('F Y') }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <div class="col-md-12">
                            <div class="">
                                <table id="gazettesTable" class="table table-hover align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Acta</th>
                                            <th>Fecha</th>
                                            <th class="text-center">Archivo</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($gazettes as $gazette)
                                            <tr>
                                                <td>
                                                    <a href="{{ route('gazette.detail', [$gazette->type, $gazette->slug]) }}"
                                                        class="text-decoration-none fw-semibold">
                                                        {{ $gazette->name }}
                                                    </a>
                                                </td>
                                                <td>Acta {{ $gazette->document_number }}</td>
                                                <td data-order="{{ $gazette->meeting_date }}">
                                                    {{ Carbon\Carbon::parse($gazette->meeting_date)->translatedFormat('d F Y') }}
                                                </td>
                                                <td class="text-center">
                                                    <a href="{{ route('gazette.detail', [$gazette->type, $gazette->slug]) }}"
                                                        class="btn btn-primary btn-sm d-inline-flex align-items-center gap-2">
                                                        <ion-icon name="download-outline"></ion-icon>
                                                        Descargar Documentos
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if ($type == 'all' && !isset($is_filtered))
            <div class="row">
                <div class="col-md-12">
                    <a href="{{ route('proposals.list') }}"
                        class="card link-card card-normal card-alignment-bottom wow fadeInUp">
                        <div class="card-icon bg-white text-dark d-flex align-items-center justify-content-center">
                            <ion-icon name="arrow-forward-outline" class="md hydrated"></ion-icon>
                        </div>

                        <div class="card-content">
                            <div class="d-flex flex-column  gap-3">
                                <div
                                    class="card-icon card-icon-static bg-warning text-white d-flex align-items-center justify-content-center">
                                    <ion-icon name="file-tray-full-outline"></ion-icon>
                                </div>
                                <h4 class="mb-0">Convocatorias</h4>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        @endif
    </div>

    @push('styles')
        <!-- DataTables CSS -->
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
    @endpush

    @push('scripts')
        <!-- DataTables JS -->
        <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
        <script>
            $(document).ready(function() {
                $('#gazettesTable').DataTable({
                    responsive: true,
                    language: {
                        "decimal": "",
                        "emptyTable": "No hay información disponible",
                        "info": "Mostrando _START_ a _END_ de _TOTAL_ registros",
                        "infoEmpty": "Mostrando 0 a 0 de 0 registros",
                        "infoFiltered": "(filtrado de _MAX_ registros totales)",
                        "infoPostFix": "",
                        "thousands": ",",
                        "lengthMenu": "Mostrar _MENU_ registros",
                        "loadingRecords": "Cargando...",
                        "processing": "Procesando...",
                        "search": "Buscar:",
                        "zeroRecords": "No se encontraron resultados",
                        "paginate": {
                            "first": "Primero",
                            "last": "Último",
                            "next": "Siguiente",
                            "previous": "Anterior"
                        },
                        "aria": {
                            "sortAscending": ": activar para ordenar la columna de manera ascendente",
                            "sortDescending": ": activar para ordenar la columna de manera descendente"
                        }
                    },
                    order: [
                        [2, 'desc']
                    ], // Ordenar por fecha descendente por defecto
                    pageLength: 25,
                    lengthMenu: [
                        [10, 25, 50, 100, -1],
                        [10, 25, 50, 100, "Todos"]
                    ],
                    columnDefs: [{
                        targets: 3, // Columna de Archivo
                        orderable: false,
                        searchable: false
                    }],
                    dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>rtip',
                });
            });
        </script>
    @endpush
@endsection
