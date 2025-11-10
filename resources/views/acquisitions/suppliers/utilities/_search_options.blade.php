<form method="GET" action="{{ route('acquisitions.suppliers.index') }}" class="d-flex gap-2">
    <select name="status" class="form-select form-select-sm" style="width: auto;">
        <option value="">Todos los estatus</option>
        <option value="solicitud" {{ request('status') == 'solicitud' ? 'selected' : '' }}>Solicitud</option>
        <option value="validacion" {{ request('status') == 'validacion' ? 'selected' : '' }}>Validación</option>
        <option value="aprobacion" {{ request('status') == 'aprobacion' ? 'selected' : '' }}>Aprobación</option>
        <option value="pago_pendiente" {{ request('status') == 'pago_pendiente' ? 'selected' : '' }}>Pago Pendiente</option>
        <option value="padron_activo" {{ request('status') == 'padron_activo' ? 'selected' : '' }}>Padrón Activo</option>
        <option value="rechazado" {{ request('status') == 'rechazado' ? 'selected' : '' }}>Rechazado</option>
    </select>
    
    <select name="person_type" class="form-select form-select-sm" style="width: auto;">
        <option value="">Todos los tipos</option>
        <option value="fisica" {{ request('person_type') == 'fisica' ? 'selected' : '' }}>Persona Física</option>
        <option value="moral" {{ request('person_type') == 'moral' ? 'selected' : '' }}>Persona Moral</option>
    </select>
    
    <input type="text" name="search" class="form-control form-control-sm" placeholder="Buscar por nombre o RFC..." value="{{ request('search') }}" style="width: 250px;">
    
    <button type="submit" class="btn btn-sm btn-primary">
        <ion-icon name="search-outline"></ion-icon> Filtrar
    </button>
    
    @if(request()->hasAny(['status', 'person_type', 'search']))
    <a href="{{ route('acquisitions.suppliers.index') }}" class="btn btn-sm btn-secondary">
        <ion-icon name="close-outline"></ion-icon> Limpiar
    </a>
    @endif
</form>
