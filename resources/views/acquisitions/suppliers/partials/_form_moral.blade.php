<div class="row g-3">
    <!-- Información de la Empresa -->
    <div class="col-12">
        <h5 class="border-bottom pb-2 mb-3"><i class="bx bx-buildings"></i> Información de la Empresa</h5>
    </div>
    
    <div class="col-md-6">
        <label class="form-label">Razón Social</label>
        <input type="text" class="form-control" value="{{ $supplier->legal_name }}" readonly>
    </div>
    
    <div class="col-md-6">
        <label class="form-label">RFC</label>
        <input type="text" class="form-control" value="{{ $supplier->rfc }}" readonly>
    </div>
    
    <div class="col-md-6">
        <label class="form-label">Fecha de Constitución</label>
        <input type="text" class="form-control" value="{{ $supplier->incorporation_date ? $supplier->incorporation_date->format('d/m/Y') : '-' }}" readonly>
    </div>
    
    <div class="col-md-6">
        <label class="form-label">Capital Social</label>
        <input type="text" class="form-control" value="{{ $supplier->share_capital ? '$' . number_format($supplier->share_capital, 2) : '-' }}" readonly>
    </div>
    
    <div class="col-md-6">
        <label class="form-label">Actividad Preponderante</label>
        <input type="text" class="form-control" value="{{ $supplier->predominant_activity ?? '-' }}" readonly>
    </div>
    
    <!-- Información Legal -->
    <div class="col-12 mt-4">
        <h5 class="border-bottom pb-2 mb-3"><i class="bx bx-file-blank"></i> Información Legal</h5>
    </div>
    
    <div class="col-md-6">
        <label class="form-label">Número de Escritura</label>
        <input type="text" class="form-control" value="{{ $supplier->deed_number ?? '-' }}" readonly>
    </div>
    
    <div class="col-md-6">
        <label class="form-label">Nombre del Notario</label>
        <input type="text" class="form-control" value="{{ $supplier->notary_name ?? '-' }}" readonly>
    </div>
    
    <div class="col-md-6">
        <label class="form-label">Apoderado Legal / Representante</label>
        <input type="text" class="form-control" value="{{ $supplier->legal_representative ?? '-' }}" readonly>
    </div>
    
    <div class="col-md-6">
        <label class="form-label">CURP del Representante Legal</label>
        <input type="text" class="form-control" value="{{ $supplier->legal_representative_curp ?? '-' }}" readonly>
    </div>
    
    <!-- Socios y Accionistas -->
    <div class="col-12 mt-4">
        <h5 class="border-bottom pb-2 mb-3"><i class="bx bx-group"></i> Socios y Accionistas</h5>
    </div>
    
    <div class="col-12">
        <label class="form-label">Nombre de los Socios</label>
        <textarea class="form-control" rows="3" readonly>{{ $supplier->partners_names ?? '-' }}</textarea>
    </div>
    
    <div class="col-12">
        <label class="form-label">CURP de los Accionistas</label>
        <textarea class="form-control" rows="3" readonly>{{ $supplier->shareholders_curp ?? '-' }}</textarea>
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
