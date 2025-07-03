<!-- Opciones de Búsqueda -->
<div class="row mb-3">
    <div class="col-md-6">
        <form method="GET" action="{{ route('dif.consult_types.index') }}" class="d-flex">
            <div class="input-group">
                <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Buscar por nombre o descripción..." aria-label="Buscar tipos de consulta">
                <button class="btn btn-outline-secondary" type="submit">
                    <i class="fas fa-search"></i> Buscar
                </button>
                @if(request('search'))
                    <a href="{{ route('dif.consult_types.index') }}" class="btn btn-outline-danger">
                        <i class="fas fa-times"></i> Limpiar
                    </a>
                @endif
            </div>
        </form>
    </div>
    <div class="col-md-6">
        <div class="d-flex justify-content-end">
            <span class="badge bg-primary">
                Total: {{ $consultTypes->total() }} tipo(s) de consulta
            </span>
        </div>
    </div>
</div>
