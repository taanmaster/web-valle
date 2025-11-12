<div class="row g-3">
    <!-- Información Personal -->
    <div class="col-12">
        <h5 class="border-bottom pb-2 mb-3">
            <i class="fas fa-user-circle text-primary"></i> Información Personal
        </h5>
    </div>
    
    <div class="col-md-6">
        <label class="form-label fw-semibold">
            <i class="fas fa-user text-primary me-1"></i> Nombre del Propietario
        </label>
        <input type="text" class="form-control disabled" value="{{ $supplier->owner_name }}" readonly disabled>
    </div>
    
    <div class="col-md-6">
        <label class="form-label fw-semibold">
            <i class="fas fa-store text-primary me-1"></i> Nombre del Negocio
        </label>
        <input type="text" class="form-control disabled" value="{{ $supplier->business_name }}" readonly disabled>
    </div>
    
    <div class="col-md-6">
        <label class="form-label fw-semibold">
            <i class="fas fa-id-card text-primary me-1"></i> RFC
        </label>
        <input type="text" class="form-control disabled" value="{{ $supplier->rfc }}" readonly disabled>
    </div>
    
    <div class="col-md-6">
        <label class="form-label fw-semibold">
            <i class="fas fa-address-card text-primary me-1"></i> CURP
        </label>
        <input type="text" class="form-control disabled" value="{{ $supplier->curp }}" readonly disabled>
    </div>
    
    <!-- Información Fiscal -->
    <div class="col-12 mt-4">
        <h5 class="border-bottom pb-2 mb-3">
            <i class="fas fa-dollar-sign text-success"></i> Información Fiscal y Empresarial
        </h5>
    </div>
    
    <div class="col-md-6">
        <label class="form-label fw-semibold">
            <i class="fas fa-calendar-alt text-primary me-1"></i> Fecha de Inicio de Actividades
        </label>
        <input type="text" class="form-control disabled" value="{{ $supplier->activities_start_date ? $supplier->activities_start_date->format('d/m/Y') : '-' }}" readonly disabled>
    </div>
    
    <div class="col-md-6">
        <label class="form-label fw-semibold">
            <i class="fas fa-coins text-primary me-1"></i> Capital Contable
        </label>
        <input type="text" class="form-control disabled" value="{{ $supplier->equity_capital ? '$' . number_format($supplier->equity_capital, 2) : '-' }}" readonly disabled>
    </div>
    
    <div class="col-md-6">
        <label class="form-label fw-semibold">
            <i class="fas fa-building text-primary me-1"></i> Registro de Cámara
        </label>
        <input type="text" class="form-control disabled" value="{{ $supplier->chamber_registration ?? '-' }}" readonly disabled>
    </div>
    
    <div class="col-md-6">
        <label class="form-label fw-semibold">
            <i class="fas fa-briefcase text-primary me-1"></i> Giro del Negocio
        </label>
        <input type="text" class="form-control disabled" value="{{ $supplier->business_line ?? '-' }}" readonly disabled>
    </div>
    
    <!-- Información de Contacto -->
    <div class="col-12 mt-4">
        <h5 class="border-bottom pb-2 mb-3">
            <i class="fas fa-phone-alt text-info"></i> Información de Contacto
        </h5>
    </div>
    
    <div class="col-md-6">
        <label class="form-label fw-semibold">
            <i class="fas fa-envelope text-primary me-1"></i> Email
        </label>
        <input type="text" class="form-control disabled" value="{{ $supplier->email }}" readonly disabled>
    </div>
    
    <div class="col-md-6">
        <label class="form-label fw-semibold">
            <i class="fas fa-phone text-primary me-1"></i> Teléfono
        </label>
        <input type="text" class="form-control disabled" value="{{ $supplier->phone ?? '-' }}" readonly disabled>
    </div>
    
    <div class="col-md-6">
        <label class="form-label fw-semibold">
            <i class="fas fa-mobile-alt text-primary me-1"></i> Celular
        </label>
        <input type="text" class="form-control disabled" value="{{ $supplier->mobile_phone ?? '-' }}" readonly disabled>
    </div>
    
    <div class="col-md-6">
        <label class="form-label fw-semibold">
            <i class="fas fa-fax text-primary me-1"></i> Fax
        </label>
        <input type="text" class="form-control disabled" value="{{ $supplier->fax ?? '-' }}" readonly disabled>
    </div>
    
    <div class="col-md-6">
        <label class="form-label fw-semibold">
            <i class="fas fa-mobile text-primary me-1"></i> Nextel
        </label>
        <input type="text" class="form-control disabled" value="{{ $supplier->nextel_phone ?? '-' }}" readonly disabled>
    </div>
    
    <!-- Dirección -->
    <div class="col-12 mt-4">
        <h5 class="border-bottom pb-2 mb-3">
            <i class="fas fa-map-marker-alt text-danger"></i> Dirección
        </h5>
    </div>
    
    <div class="col-12">
        <label class="form-label fw-semibold">
            <i class="fas fa-location-arrow text-primary me-1"></i> Dirección Completa
        </label>
        <textarea class="form-control disabled" rows="2" readonly disabled>{{ $supplier->address ?? '-' }}</textarea>
    </div>
    
    <div class="col-md-4">
        <label class="form-label fw-semibold">
            <i class="fas fa-city text-primary me-1"></i> Ciudad
        </label>
        <input type="text" class="form-control disabled" value="{{ $supplier->city ?? '-' }}" readonly disabled>
    </div>
    
    <div class="col-md-4">
        <label class="form-label fw-semibold">
            <i class="fas fa-map text-primary me-1"></i> Estado
        </label>
        <input type="text" class="form-control disabled" value="{{ $supplier->state ?? '-' }}" readonly disabled>
    </div>
    
    <div class="col-md-4">
        <label class="form-label fw-semibold">
            <i class="fas fa-mailbox text-primary me-1"></i> Código Postal
        </label>
        <input type="text" class="form-control disabled" value="{{ $supplier->postal_code ?? '-' }}" readonly disabled>
    </div>
</div>
