<div class="row g-3">
    <!-- Información de la Empresa -->
    <div class="col-12">
        <h5 class="border-bottom pb-2 mb-3">
            <i class="fas fa-building text-primary"></i> Información de la Empresa
        </h5>
    </div>
    
    <div class="col-md-6">
        <label class="form-label fw-semibold">
            <i class="fas fa-certificate text-primary me-1"></i> Razón Social
        </label>
        <input type="text" class="form-control disabled" value="{{ $supplier->legal_name }}" readonly disabled>
    </div>
    
    <div class="col-md-6">
        <label class="form-label fw-semibold">
            <i class="fas fa-id-card text-primary me-1"></i> RFC
        </label>
        <input type="text" class="form-control disabled" value="{{ $supplier->rfc }}" readonly disabled>
    </div>
    
    <div class="col-md-6">
        <label class="form-label fw-semibold">
            <i class="fas fa-calendar-check text-primary me-1"></i> Fecha de Constitución
        </label>
        <input type="text" class="form-control disabled" value="{{ $supplier->incorporation_date ? $supplier->incorporation_date->format('d/m/Y') : '-' }}" readonly disabled>
    </div>
    
    <div class="col-md-6">
        <label class="form-label fw-semibold">
            <i class="fas fa-hand-holding-usd text-primary me-1"></i> Capital Social
        </label>
        <input type="text" class="form-control disabled" value="{{ $supplier->share_capital ? '$' . number_format($supplier->share_capital, 2) : '-' }}" readonly disabled>
    </div>
    
    <div class="col-md-6">
        <label class="form-label fw-semibold">
            <i class="fas fa-chart-line text-primary me-1"></i> Actividad Preponderante
        </label>
        <input type="text" class="form-control disabled" value="{{ $supplier->predominant_activity ?? '-' }}" readonly disabled>
    </div>
    
    <!-- Información Legal -->
    <div class="col-12 mt-4">
        <h5 class="border-bottom pb-2 mb-3">
            <i class="fas fa-gavel text-warning"></i> Información Legal
        </h5>
    </div>
    
    <div class="col-md-6">
        <label class="form-label fw-semibold">
            <i class="fas fa-file-signature text-primary me-1"></i> Número de Escritura
        </label>
        <input type="text" class="form-control disabled" value="{{ $supplier->deed_number ?? '-' }}" readonly disabled>
    </div>
    
    <div class="col-md-6">
        <label class="form-label fw-semibold">
            <i class="fas fa-user-tie text-primary me-1"></i> Nombre del Notario
        </label>
        <input type="text" class="form-control disabled" value="{{ $supplier->notary_name ?? '-' }}" readonly disabled>
    </div>
    
    <div class="col-md-6">
        <label class="form-label fw-semibold">
            <i class="fas fa-user-shield text-primary me-1"></i> Apoderado Legal / Representante
        </label>
        <input type="text" class="form-control disabled" value="{{ $supplier->legal_representative ?? '-' }}" readonly disabled>
    </div>
    
    <div class="col-md-6">
        <label class="form-label fw-semibold">
            <i class="fas fa-address-card text-primary me-1"></i> CURP del Representante Legal
        </label>
        <input type="text" class="form-control disabled" value="{{ $supplier->legal_representative_curp ?? '-' }}" readonly disabled>
    </div>
    
    <!-- Socios y Accionistas -->
    <div class="col-12 mt-4">
        <h5 class="border-bottom pb-2 mb-3">
            <i class="fas fa-users text-info"></i> Socios y Accionistas
        </h5>
    </div>
    
    <div class="col-12">
        <label class="form-label fw-semibold">
            <i class="fas fa-user-friends text-primary me-1"></i> Nombre de los Socios
        </label>
        <textarea class="form-control disabled" rows="3" readonly disabled>{{ $supplier->partners_names ?? '-' }}</textarea>
    </div>
    
    <div class="col-12">
        <label class="form-label fw-semibold">
            <i class="fas fa-id-badge text-primary me-1"></i> CURP de los Accionistas
        </label>
        <textarea class="form-control disabled" rows="3" readonly disabled>{{ $supplier->shareholders_curp ?? '-' }}</textarea>
    </div>
    
    <!-- Información de Contacto -->
    <div class="col-12 mt-4">
        <h5 class="border-bottom pb-2 mb-3">
            <i class="fas fa-phone-alt text-success"></i> Información de Contacto
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
