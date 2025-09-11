<div class="dropdown me-2">
    <button type="button" class="btn btn-outline-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="fas fa-search"></i> Búsqueda Avanzada <i class="mdi mdi-chevron-down"></i>
    </button>
    <div class="dropdown-menu p-4" style="min-width: 500px;">
        <form class="form-horizontal" role="search" action="{{ route('urban_dev.requests.query') }}" method="GET">
            <div class="row">
                <div class="col-12 mb-3">
                    <h6 class="mb-3 text-primary">
                        <i class="fas fa-filter"></i> Filtros de Búsqueda
                    </h6>
                </div>
                
                <!-- Rango de Fechas -->
                <div class="col-md-6 mb-3">
                    <label for="fecha_inicio" class="form-label">Fecha Inicio</label>
                    <input class="form-control" type="date" name="fecha_inicio" id="fecha_inicio" 
                           value="{{ request('fecha_inicio') }}" placeholder="Fecha de inicio">
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="fecha_fin" class="form-label">Fecha Fin</label>
                    <input class="form-control" type="date" name="fecha_fin" id="fecha_fin" 
                           value="{{ request('fecha_fin') }}" placeholder="Fecha de fin">
                </div>

                <!-- Folio -->
                <div class="col-md-6 mb-3">
                    <label for="folio" class="form-label">Folio</label>
                    <input class="form-control" type="text" name="folio" id="folio" 
                           value="{{ request('folio') }}" placeholder="Número de folio">
                </div>

                <!-- Solicitante -->
                <div class="col-md-6 mb-3">
                    <label for="solicitante" class="form-label">Nombre del Solicitante</label>
                    <input class="form-control" type="text" name="solicitante" id="solicitante" 
                           value="{{ request('solicitante') }}" placeholder="Nombre o razón social">
                </div>

                <!-- Estatus -->
                <div class="col-md-6 mb-3">
                    <label for="estatus" class="form-label">Estatus</label>
                    <select class="form-select" name="estatus" id="estatus">
                        <option value="">Todos los estatus</option>
                        <option value="new" {{ request('estatus') == 'new' ? 'selected' : '' }}>Nuevo</option>
                        <option value="entry" {{ request('estatus') == 'entry' ? 'selected' : '' }}>Ingreso</option>
                        <option value="validation" {{ request('estatus') == 'validation' ? 'selected' : '' }}>Validación</option>
                        <option value="requires_correction" {{ request('estatus') == 'requires_correction' ? 'selected' : '' }}>Requiere Corrección</option>
                        <option value="inspection" {{ request('estatus') == 'inspection' ? 'selected' : '' }}>Inspección</option>
                        <option value="resolved" {{ request('estatus') == 'resolved' ? 'selected' : '' }}>Resolución</option>
                    </select>
                </div>

                <!-- Tipo de Trámite -->
                <div class="col-md-6 mb-3">
                    <label for="tipo_tramite" class="form-label">Tipo de Trámite</label>
                    <select class="form-select" name="tipo_tramite" id="tipo_tramite">
                        <option value="">Todos los trámites</option>
                        <option value="uso-de-suelo" {{ request('tipo_tramite') == 'uso-de-suelo' ? 'selected' : '' }}>Licencia de Uso de Suelo</option>
                        <option value="constancia-de-factibilidad" {{ request('tipo_tramite') == 'constancia-de-factibilidad' ? 'selected' : '' }}>Constancia de Factibilidad</option>
                        <option value="permiso-de-anuncios" {{ request('tipo_tramite') == 'permiso-de-anuncios' ? 'selected' : '' }}>Permiso de Anuncios y Toldos</option>
                        <option value="certificacion-numero-oficial" {{ request('tipo_tramite') == 'certificacion-numero-oficial' ? 'selected' : '' }}>Certificación de Número Oficial</option>
                        <option value="permiso-de-division" {{ request('tipo_tramite') == 'permiso-de-division' ? 'selected' : '' }}>Permiso de División</option>
                        <option value="uso-de-via-publica" {{ request('tipo_tramite') == 'uso-de-via-publica' ? 'selected' : '' }}>Uso de Vía Pública</option>
                        <option value="licencia-de-construccion" {{ request('tipo_tramite') == 'licencia-de-construccion' ? 'selected' : '' }}>Licencia de Construcción</option>
                        <option value="permiso-construccion-panteones" {{ request('tipo_tramite') == 'permiso-construccion-panteones' ? 'selected' : '' }}>Permiso de Construcción en Panteones</option>
                    </select>
                </div>

                <!-- Inspector -->
                <div class="col-md-6 mb-3">
                    <label for="inspector" class="form-label">Inspector</label>
                    <select class="form-select" name="inspector" id="inspector">
                        <option value="">Todos los inspectores</option>
                        @php
                            try {
                                $inspectors = \App\Models\User::whereHas('roles', function($q) {
                                    $q->where('name', 'inspector');
                                })->get();
                            } catch (\Exception $e) {
                                $inspectors = collect();
                            }
                        @endphp
                        @foreach($inspectors as $inspector)
                            <option value="{{ $inspector->id }}" {{ request('inspector') == $inspector->id ? 'selected' : '' }}>
                                {{ $inspector->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Botones -->
                <div class="col-12 text-end mt-3">
                    <button type="button" class="btn btn-outline-secondary me-2" onclick="clearFilters()">
                        <i class="fas fa-eraser"></i> Limpiar
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i> Buscar
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
function clearFilters() {
    // Limpiar todos los campos del formulario
    document.getElementById('fecha_inicio').value = '';
    document.getElementById('fecha_fin').value = '';
    document.getElementById('folio').value = '';
    document.getElementById('solicitante').value = '';
    document.getElementById('estatus').value = '';
    document.getElementById('tipo_tramite').value = '';
    document.getElementById('inspector').value = '';
}
</script>
