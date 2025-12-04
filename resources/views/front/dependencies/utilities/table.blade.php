{{-- 
    Tabla de Documentos de Transparencia con DataTables
    
    CARACTERÍSTICAS:
    - Ordenamiento por defecto: Año DESC, Período DESC (backend)
    - Ordenamiento interactivo en tiempo real (DataTables)
    - Búsqueda global en todas las columnas
    - Filtros dinámicos por Año y Período (basados en datos disponibles)
    - Paginación de 25 registros por página
    - Responsive design para dispositivos móviles
    - Traducción al español (México)
    - Iconos personalizados con ion-icons
    
    COLUMNAS ORDENABLES:
    - Año: Ordenamiento numérico
    - Obligación: Ordenamiento alfabético
    - Nombre: Ordenamiento alfabético
    - Período: Ordenamiento numérico mediante data-order
    - Rubro: Ordenamiento alfabético
    - Documento: No ordenable (columna de acciones)
    
    FILTROS DINÁMICOS:
    - Año: Se puebla automáticamente con los años disponibles en $documents
    - Período: Se puebla automáticamente con los períodos disponibles en $documents
    - Los filtros se aplican en tiempo real sin recargar la página
    - Botón "Limpiar filtros" para resetear todos los filtros de DataTable
    
    ICONOS DE ORDENAMIENTO (ion-icons):
    - swap-vertical-outline: Columna ordenable, no ordenada actualmente
    - arrow-up-outline: Ordenado ascendente (A-Z, 0-9)
    - arrow-down-outline: Ordenado descendente (Z-A, 9-0)
    
    INTEGRACIÓN CON LIVEWIRE:
    - La tabla se reinicializa automáticamente después de cada actualización de Livewire
    - Compatible con filtros dinámicos (año, período, obligación)
    - Los iconos se actualizan dinámicamente al cambiar el ordenamiento
    - Los filtros de DataTable se repoblan al actualizar los datos
--}}
<div>
    <div class="row mb-4 align-items-center">

        @if ($mode != 1)
            <div class="col-md-3">
                <label for="selectedObligation" class="col-form-label">Obligación</label>
                <select name="selectedObligation" id="selectedObligation" wire:model.live="selectedObligation"
                    class="form-control">
                    <option value="" disabled selected>Seleccione una obligación</option>
                    @foreach ($obligations as $obligation)
                        <option value="{{ $obligation->id }}">{{ $obligation->name }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="col-md-3">
                <label for="year" class="col-form-label">Año</label>
                <select name="year" id="year" wire:model.live="year" class="form-control">
                    <option value="" disabled selected>Seleccione un año</option>
                    @foreach ($years as $y)
                        <option value="{{ $y }}">{{ $y }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3">
                <label for="period" class="col-form-label">Periodo</label>
                <select name="period" id="period" wire:model.live="period" class="form-control">
                    <option value="" disabled selected>Seleccione un periodo</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                </select>
            </div>
            <div class="col-md-3 text-end">
                <button wire:click="resetFilters" class="btn btn-outline-secondary btn-sm">Restablecer Filtros</button>
            </div>
        @endif
    </div>

    @if ($period != null || $selectedObligation != null || $year != null)
        @if ($documents->count() == 0)
            <div class="row">
                <div class="col-md-12">
                    <p class="text-muted">No hay documentos disponibles.</p>
                    <p class="text-muted">Por favor, ajusta los filtros de búsqueda.</p>
                </div>
            </div>
        @else
            <p>Se encontraron <strong>{{ $documents->count() }}</strong> resultados en documentos.</p>

            <!-- Filtros de DataTable -->
            <div id="datatableFilters" class="row mb-3">
                <div class="col-md-3">
                    <label for="datatableYearFilter" class="form-label">Filtrar por Año</label>
                    <select id="datatableYearFilter" class="form-select form-select-sm">
                        <option value="">Todos los años</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="datatablePeriodFilter" class="form-label">Filtrar por Período</label>
                    <select id="datatablePeriodFilter" class="form-select form-select-sm">
                        <option value="">Todos los períodos</option>
                    </select>
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button id="resetDatatableFilters" class="btn btn-outline-secondary btn-sm">Limpiar filtros</button>
                </div>
            </div>

            <div class="table-responsive">
                <table id="transparencyDocumentsTable" class="table table-striped">
                    <thead>
                        <tr>
                            <th>Año</th>
                            <th>Obligación</th>
                            <th>Nombre</th>
                            <th>Período</th>
                            <th>Rubro</th>
                            <th>Documento</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($documents as $document)
                            <tr>
                                <td data-order="{{ $document->year }}">{{ $document->year }}</td>
                                <td>{{ $document->obligation->name }}</td>
                                <td>{{ $document->name }}</td>
                                <td data-order="{{ $document->period }}">{{ $document->obligation->update_period }} {{ $document->period }}</td>
                                <td>{{ $document->obligation->type }}</td>
                                <td>
                                    @if ($document->s3_asset_url != null)
                                        <a href="{{ $document->s3_asset_url }}" target="_blank"
                                            class="btn btn-primary d-flex align-items-center justify-content-between gap-2"
                                            style="width: fit-content">
                                        @else
                                            <a href="{{ asset('files/documents/' . $document->filename) }}"
                                                target="_blank"
                                                class="btn btn-primary d-flex align-items-center justify-content-between gap-2"
                                                style="width: fit-content">
                                    @endif
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#fff"
                                        viewBox="0 0 256 256">
                                        <path
                                            d="M213.66,82.34l-56-56A8,8,0,0,0,152,24H56A16,16,0,0,0,40,40V216a16,16,0,0,0,16,16H200a16,16,0,0,0,16-16V88A8,8,0,0,0,213.66,82.34ZM160,51.31,188.69,80H160ZM200,216H56V40h88V88a8,8,0,0,0,8,8h48V216Z">
                                        </path>
                                    </svg>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    @else
        @if ($obligations->count() == 0)
            <div class="row">
                <div class="col-md-12">
                    <p class="text-muted">No hay obligaciones disponibles.</p>
                    <p class="text-muted">Por favor, ajusta los filtros de búsqueda.</p>
                </div>
            </div>
        @else
            <div class="row">
                @foreach ($obligations as $obligation)
                    <div class="col-md-3">
                        <a href="{{ route('obligation.detail', [$dependency, $obligation->slug]) }}"
                            class="card px-3 py-1 wow fadeInUp d-flex flex-column justify-content-center"
                            style="min-height: 160px">
                            <div class="d-flex align-items-center" style="gap: 30px">
                                @if ($obligation->icon != null)
                                    <img src="{{ asset('front/img/icons/' . $obligation->icon) }}" alt=""
                                        style="height: 30px; width:auto">
                                @endif
                                <p class="mb-0">{{ $obligation->name }}</p>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        @endif
    @endif
</div>

@push('styles')
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">

<!-- Estilos personalizados para DataTables con ion-icons -->
<style>
    /* Ocultar los iconos de ordenamiento predeterminados de DataTables */
    table.dataTable thead > tr > th.sorting:before,
    table.dataTable thead > tr > th.sorting_asc:before,
    table.dataTable thead > tr > th.sorting_desc:before,
    table.dataTable thead > tr > th.sorting:after,
    table.dataTable thead > tr > th.sorting_asc:after,
    table.dataTable thead > tr > th.sorting_desc:after {
        display: none;
    }
    
    /* Estilos para los encabezados ordenables */
    table.dataTable thead > tr > th.sorting,
    table.dataTable thead > tr > th.sorting_asc,
    table.dataTable thead > tr > th.sorting_desc {
        position: relative;
        padding-right: 35px !important;
        cursor: pointer;
    }
    
    /* Contenedor para los ion-icons */
    table.dataTable thead > tr > th.sorting ion-icon,
    table.dataTable thead > tr > th.sorting_asc ion-icon,
    table.dataTable thead > tr > th.sorting_desc ion-icon {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 18px;
        opacity: 0.5;
    }
    
    table.dataTable thead > tr > th.sorting_asc ion-icon,
    table.dataTable thead > tr > th.sorting_desc ion-icon {
        opacity: 1;
    }
    
    /* Ocultar la barra de búsqueda y el selector de entradas */
    .dataTables_wrapper .dataTables_filter,
    .dataTables_wrapper .dataTables_length {
        display: none !important;
    }
    
    /* Estilos para la búsqueda y controles de DataTables */
    .dataTables_wrapper .dataTables_filter input {
        border: 1px solid #ddd;
        border-radius: 4px;
        padding: 5px 10px;
        margin-left: 10px;
    }
    
    .dataTables_wrapper .dataTables_length select {
        border: 1px solid #ddd;
        border-radius: 4px;
        padding: 5px 10px;
        margin: 0 10px;
    }
    
    /* Estilos para los filtros de DataTable */
    #datatableFilters .form-select {
        border: 1px solid #ddd;
        border-radius: 4px;
        padding: 5px 10px;
    }
</style>
@endpush

@push('scripts')
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

<script>
    document.addEventListener('livewire:initialized', () => {
        initializeDataTable();

        // Reinicializar DataTable después de actualizaciones de Livewire
        Livewire.hook('morph.updated', ({el, component}) => {
            if ($.fn.DataTable.isDataTable('#transparencyDocumentsTable')) {
                $('#transparencyDocumentsTable').DataTable().destroy();
            }
            initializeDataTable();
        });
    });

    function initializeDataTable() {
        if ($('#transparencyDocumentsTable').length) {
            var table = $('#transparencyDocumentsTable').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-MX.json',
                },
                responsive: true,
                order: [[0, 'desc'], [3, 'desc']], // Ordenar por Año (desc) y Período (desc)
                pageLength: 25,
                columnDefs: [
                    { 
                        targets: 5, // Columna Documento
                        orderable: false // Deshabilitar ordenamiento en la columna de acciones
                    }
                ],
                drawCallback: function() {
                    // Asegurar que los tooltips funcionen después de redibujar
                    $('[data-bs-toggle="tooltip"]').tooltip();
                    
                    // Actualizar iconos después de redibujar
                    updateSortIcons();
                },
                initComplete: function() {
                    // Agregar ion-icons a los encabezados después de inicializar
                    updateSortIcons();
                    
                    // Poblar los filtros dinámicamente desde los datos de la tabla
                    populateFilters(this.api());
                }
            });
            
            // Actualizar iconos cuando se hace click en un encabezado
            $('#transparencyDocumentsTable thead').on('click', 'th', function() {
                setTimeout(updateSortIcons, 50);
            });
            
            // Manejar cambios en el filtro de Año
            $('#datatableYearFilter').on('change', function() {
                var year = $(this).val();
                table.column(0).search(year ? '^' + year + '$' : '', true, false).draw();
            });
            
            // Manejar cambios en el filtro de Período
            $('#datatablePeriodFilter').on('change', function() {
                var period = $(this).val();
                // Buscar en la columna de período (índice 3)
                // Usamos regex para buscar solo el número del período
                table.column(3).search(period ? period + '$' : '', true, false).draw();
            });
            
            // Botón para resetear filtros
            $('#resetDatatableFilters').on('click', function() {
                $('#datatableYearFilter').val('').trigger('change');
                $('#datatablePeriodFilter').val('').trigger('change');
                table.search('').columns().search('').draw();
            });
        }
    }
    
    /**
     * Actualiza los ion-icons en los encabezados de la tabla según el estado de ordenamiento
     */
    function updateSortIcons() {
        // Remover todos los ion-icons existentes
        $('#transparencyDocumentsTable thead th ion-icon').remove();
        
        // Agregar ion-icons según el estado de ordenamiento
        $('#transparencyDocumentsTable thead th').each(function() {
            var $th = $(this);
            
            if ($th.hasClass('sorting')) {
                // No ordenado - mostrar icono swap-vertical
                $th.append('<ion-icon name="swap-vertical-outline"></ion-icon>');
            } else if ($th.hasClass('sorting_asc')) {
                // Ordenado ascendente - mostrar flecha hacia arriba
                $th.append('<ion-icon name="arrow-up-outline"></ion-icon>');
            } else if ($th.hasClass('sorting_desc')) {
                // Ordenado descendente - mostrar flecha hacia abajo
                $th.append('<ion-icon name="arrow-down-outline"></ion-icon>');
            }
        });
    }
    
    /**
     * Puebla los selectores de filtro con valores únicos de la tabla
     * @param {DataTable.Api} api - Instancia de la API de DataTables
     */
    function populateFilters(api) {
        // Obtener años únicos de la columna 0 (Año)
        var years = [];
        api.column(0, {search: 'applied'}).data().each(function(value) {
            if (value && years.indexOf(value) === -1) {
                years.push(value);
            }
        });
        
        // Ordenar años de mayor a menor
        years.sort(function(a, b) { return b - a; });
        
        // Poblar el selector de años
        var $yearSelect = $('#datatableYearFilter');
        $yearSelect.find('option:not(:first)').remove();
        $.each(years, function(index, year) {
            $yearSelect.append($('<option></option>').val(year).text(year));
        });
        
        // Obtener períodos únicos de la columna 3 (Período)
        var periods = [];
        var periodLabels = {}; // Almacenar el label completo para cada período
        
        api.column(3, {search: 'applied'}).data().each(function(value) {
            if (value) {
                // Extraer el tipo de período (ej: "Trimestre", "Semestre") y el número
                var match = value.match(/^(.+?)\s+(\d+)$/);
                if (match) {
                    var periodType = match[1].trim();
                    var periodNumber = match[2];
                    
                    if (periods.indexOf(periodNumber) === -1) {
                        periods.push(periodNumber);
                        // Guardar el label completo para este período
                        periodLabels[periodNumber] = periodType + ' ' + periodNumber;
                    }
                }
            }
        });
        
        // Ordenar períodos numéricamente
        periods.sort(function(a, b) { return a - b; });
        
        // Poblar el selector de períodos
        var $periodSelect = $('#datatablePeriodFilter');
        $periodSelect.find('option:not(:first)').remove();
        $.each(periods, function(index, period) {
            var label = periodLabels[period] || 'Período ' + period;
            $periodSelect.append($('<option></option>').val(period).text(label));
        });
    }
</script>
@endpush
