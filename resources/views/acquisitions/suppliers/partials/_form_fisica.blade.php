<div class="row g-3">
    <!-- Información Personal -->
    <div class="col-12">
        <h5 class="border-bottom pb-2 mb-3"><i class="bx bx-user"></i> Información Personal</h5>
    </div>
    
    <div class="col-md-6">
        <label class="form-label">Nombre del Propietario</label>
        <input type="text" class="form-control" value="{{ $supplier->owner_name }}" readonly>
    </div>
    
    <div class="col-md-6">
        <label class="form-label">Nombre del Negocio</label>
        <input type="text" class="form-control" value="{{ $supplier->business_name }}" readonly>
    </div>
    
    <div class="col-md-6">
        <label class="form-label">RFC</label>
        <input type="text" class="form-control" value="{{ $supplier->rfc }}" readonly>
    </div>
    
    <div class="col-md-6">
        <label class="form-label">CURP</label>
        <input type="text" class="form-control" value="{{ $supplier->curp }}" readonly>
    </div>
    
    <!-- Información Fiscal -->
    <div class="col-12 mt-4">
        <h5 class="border-bottom pb-2 mb-3"><i class="bx bx-dollar"></i> Información Fiscal y Empresarial</h5>
    </div>
    
    <div class="col-md-6">
        <label class="form-label">Fecha de Inicio de Actividades</label>
        <input type="text" class="form-control" value="{{ $supplier->activities_start_date ? $supplier->activities_start_date->format('d/m/Y') : '-' }}" readonly>
    </div>
    
    <div class="col-md-6">
        <label class="form-label">Capital Contable</label>
        <input type="text" class="form-control" value="{{ $supplier->equity_capital ? '$' . number_format($supplier->equity_capital, 2) : '-' }}" readonly>
    </div>
    
    <div class="col-md-6">
        <label class="form-label">Registro de Cámara</label>
        <input type="text" class="form-control" value="{{ $supplier->chamber_registration ?? '-' }}" readonly>
    </div>
    
    <div class="col-md-6">
        <label class="form-label">Giro del Negocio</label>
        <input type="text" class="form-control" value="{{ $supplier->business_line ?? '-' }}" readonly>
    </div>
    
    <!-- Información de Contacto -->
    <div class="col-12 mt-4">
        <h5 class="border-bottom pb-2 mb-3"><i class="bx bx-phone"></i> Información de Contacto</h5>
    </div>
    
    <div class="col-md-6">
        <label class="form-label">Email</label>
        <input type="text" class="form-control" value="{{ $supplier->email }}" readonly>
    </div>
    
    <div class="col-md-6">
        <label class="form-label">Teléfono</label>
        <input type="text" class="form-control" value="{{ $supplier->phone ?? '-' }}" readonly>
    </div>
    
    <div class="col-md-6">
        <label class="form-label">Celular</label>
        <input type="text" class="form-control" value="{{ $supplier->mobile_phone ?? '-' }}" readonly>
    </div>
    
    <div class="col-md-6">
        <label class="form-label">Fax</label>
        <input type="text" class="form-control" value="{{ $supplier->fax ?? '-' }}" readonly>
    </div>
    
    <div class="col-md-6">
        <label class="form-label">Nextel</label>
        <input type="text" class="form-control" value="{{ $supplier->nextel_phone ?? '-' }}" readonly>
    </div>
    
    <!-- Dirección -->
    <div class="col-12 mt-4">
        <h5 class="border-bottom pb-2 mb-3"><i class="bx bx-map"></i> Dirección</h5>
    </div>
    
    <div class="col-12">
        <label class="form-label">Dirección Completa</label>
        <textarea class="form-control" rows="2" readonly>{{ $supplier->address ?? '-' }}</textarea>
    </div>
    
    <div class="col-md-4">
        <label class="form-label">Ciudad</label>
        <input type="text" class="form-control" value="{{ $supplier->city ?? '-' }}" readonly>
    </div>
    
    <div class="col-md-4">
        <label class="form-label">Estado</label>
        <input type="text" class="form-control" value="{{ $supplier->state ?? '-' }}" readonly>
    </div>
    
    <div class="col-md-4">
        <label class="form-label">Código Postal</label>
        <input type="text" class="form-control" value="{{ $supplier->postal_code ?? '-' }}" readonly>
    </div>
</div>
