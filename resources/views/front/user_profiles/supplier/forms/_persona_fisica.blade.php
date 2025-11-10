<div class="row g-3">
    <div class="col-12">
        <h6 class="text-primary border-bottom pb-2 mb-3">
            <ion-icon name="person-outline"></ion-icon> Información del Propietario
        </h6>
    </div>

    <div class="col-md-6">
        <label for="owner_name" class="form-label">Nombre del Propietario <span class="text-danger">*</span></label>
        <input type="text" class="form-control @error('owner_name') is-invalid @enderror" 
               id="owner_name" name="owner_name" 
               value="{{ old('owner_name', $supplier->owner_name) }}" required>
        @error('owner_name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="business_name" class="form-label">Nombre del Negocio</label>
        <input type="text" class="form-control @error('business_name') is-invalid @enderror" 
               id="business_name" name="business_name" 
               value="{{ old('business_name', $supplier->business_name) }}">
        @error('business_name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="curp" class="form-label">CURP</label>
        <input type="text" class="form-control @error('curp') is-invalid @enderror" 
               id="curp" name="curp" maxlength="18"
               value="{{ old('curp', $supplier->curp) }}">
        @error('curp')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="rfc" class="form-label">RFC</label>
        <input type="text" class="form-control @error('rfc') is-invalid @enderror" 
               id="rfc" name="rfc" maxlength="13"
               value="{{ old('rfc', $supplier->rfc) }}">
        @error('rfc')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="activities_start_date" class="form-label">Fecha de Inicio de Actividades</label>
        <input type="date" class="form-control @error('activities_start_date') is-invalid @enderror" 
               id="activities_start_date" name="activities_start_date" 
               value="{{ old('activities_start_date', $supplier->activities_start_date?->format('Y-m-d')) }}">
        @error('activities_start_date')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="equity_capital" class="form-label">Capital Contable</label>
        <div class="input-group">
            <span class="input-group-text">$</span>
            <input type="number" step="0.01" class="form-control @error('equity_capital') is-invalid @enderror" 
                   id="equity_capital" name="equity_capital" 
                   value="{{ old('equity_capital', $supplier->equity_capital) }}">
            @error('equity_capital')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <label for="chamber_registration" class="form-label">Registro de Cámara</label>
        <input type="text" class="form-control @error('chamber_registration') is-invalid @enderror" 
               id="chamber_registration" name="chamber_registration" 
               value="{{ old('chamber_registration', $supplier->chamber_registration) }}">
        @error('chamber_registration')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="business_line" class="form-label">Giro</label>
        <input type="text" class="form-control @error('business_line') is-invalid @enderror" 
               id="business_line" name="business_line" 
               value="{{ old('business_line', $supplier->business_line) }}">
        @error('business_line')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- Información de Contacto -->
    <div class="col-12 mt-4">
        <h6 class="text-primary border-bottom pb-2 mb-3">
            <ion-icon name="mail-outline"></ion-icon> Información de Contacto
        </h6>
    </div>

    <div class="col-md-6">
        <label for="email" class="form-label">Correo Electrónico</label>
        <input type="email" class="form-control @error('email') is-invalid @enderror" 
               id="email" name="email" 
               value="{{ old('email', $supplier->email) }}">
        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="phone" class="form-label">Teléfono</label>
        <input type="text" class="form-control @error('phone') is-invalid @enderror" 
               id="phone" name="phone" 
               value="{{ old('phone', $supplier->phone) }}">
        @error('phone')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="mobile_phone" class="form-label">Teléfono Celular</label>
        <input type="text" class="form-control @error('mobile_phone') is-invalid @enderror" 
               id="mobile_phone" name="mobile_phone" 
               value="{{ old('mobile_phone', $supplier->mobile_phone) }}">
        @error('mobile_phone')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="nextel_phone" class="form-label">Teléfono de Radio Nextel</label>
        <input type="text" class="form-control @error('nextel_phone') is-invalid @enderror" 
               id="nextel_phone" name="nextel_phone" 
               value="{{ old('nextel_phone', $supplier->nextel_phone) }}">
        @error('nextel_phone')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="fax" class="form-label">Fax</label>
        <input type="text" class="form-control @error('fax') is-invalid @enderror" 
               id="fax" name="fax" 
               value="{{ old('fax', $supplier->fax) }}">
        @error('fax')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- Dirección -->
    <div class="col-12 mt-4">
        <h6 class="text-primary border-bottom pb-2 mb-3">
            <ion-icon name="location-outline"></ion-icon> Dirección
        </h6>
    </div>

    <div class="col-12">
        <label for="address" class="form-label">Dirección</label>
        <textarea class="form-control @error('address') is-invalid @enderror" 
                  id="address" name="address" rows="2">{{ old('address', $supplier->address) }}</textarea>
        @error('address')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4">
        <label for="city" class="form-label">Ciudad</label>
        <input type="text" class="form-control @error('city') is-invalid @enderror" 
               id="city" name="city" 
               value="{{ old('city', $supplier->city) }}">
        @error('city')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4">
        <label for="state" class="form-label">Estado</label>
        <input type="text" class="form-control @error('state') is-invalid @enderror" 
               id="state" name="state" 
               value="{{ old('state', $supplier->state) }}">
        @error('state')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4">
        <label for="postal_code" class="form-label">Código Postal</label>
        <input type="text" class="form-control @error('postal_code') is-invalid @enderror" 
               id="postal_code" name="postal_code" maxlength="10"
               value="{{ old('postal_code', $supplier->postal_code) }}">
        @error('postal_code')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- Notas -->
    <div class="col-12 mt-4">
        <label for="notes" class="form-label">Observaciones</label>
        <textarea class="form-control @error('notes') is-invalid @enderror" 
                  id="notes" name="notes" rows="3">{{ old('notes', $supplier->notes) }}</textarea>
        @error('notes')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
