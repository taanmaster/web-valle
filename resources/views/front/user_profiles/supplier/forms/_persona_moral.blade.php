<div class="row g-3">
    <div class="col-12">
        <h6 class="text-primary border-bottom pb-2 mb-3">
            <ion-icon name="business-outline"></ion-icon> Información de la Empresa
        </h6>
    </div>

    <div class="col-md-12">
        <label for="legal_name" class="form-label">Razón Social <span class="text-danger">*</span></label>
        <input type="text" class="form-control @error('legal_name') is-invalid @enderror" 
               id="legal_name" name="legal_name" 
               value="{{ old('legal_name', $supplier->legal_name) }}" required>
        @error('legal_name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="incorporation_date" class="form-label">Fecha de Constitución de la Sociedad</label>
        <input type="date" class="form-control @error('incorporation_date') is-invalid @enderror" 
               id="incorporation_date" name="incorporation_date" 
               value="{{ old('incorporation_date', $supplier->incorporation_date?->format('Y-m-d')) }}">
        @error('incorporation_date')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="share_capital" class="form-label">Capital Social</label>
        <div class="input-group">
            <span class="input-group-text">$</span>
            <input type="number" step="0.01" class="form-control @error('share_capital') is-invalid @enderror" 
                   id="share_capital" name="share_capital" 
                   value="{{ old('share_capital', $supplier->share_capital) }}">
            @error('share_capital')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
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
        <label for="predominant_activity" class="form-label">Actividad Preponderante</label>
        <input type="text" class="form-control @error('predominant_activity') is-invalid @enderror" 
               id="predominant_activity" name="predominant_activity" 
               value="{{ old('predominant_activity', $supplier->predominant_activity) }}">
        @error('predominant_activity')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- Información Notarial -->
    <div class="col-12 mt-4">
        <h6 class="text-primary border-bottom pb-2 mb-3">
            <ion-icon name="document-outline"></ion-icon> Información Notarial
        </h6>
    </div>

    <div class="col-md-6">
        <label for="deed_number" class="form-label">Número de la Escritura</label>
        <input type="text" class="form-control @error('deed_number') is-invalid @enderror" 
               id="deed_number" name="deed_number" 
               value="{{ old('deed_number', $supplier->deed_number) }}">
        @error('deed_number')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="notary_name" class="form-label">Nombre del Notario</label>
        <input type="text" class="form-control @error('notary_name') is-invalid @enderror" 
               id="notary_name" name="notary_name" 
               value="{{ old('notary_name', $supplier->notary_name) }}">
        @error('notary_name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- Información de Representantes -->
    <div class="col-12 mt-4">
        <h6 class="text-primary border-bottom pb-2 mb-3">
            <ion-icon name="people-outline"></ion-icon> Representantes y Socios
        </h6>
    </div>

    <div class="col-md-12">
        <label for="legal_representative" class="form-label">Apoderado Legal y/o Representantes</label>
        <input type="text" class="form-control @error('legal_representative') is-invalid @enderror" 
               id="legal_representative" name="legal_representative" 
               value="{{ old('legal_representative', $supplier->legal_representative) }}">
        @error('legal_representative')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="legal_representative_curp" class="form-label">CURP del Representante Legal</label>
        <input type="text" class="form-control @error('legal_representative_curp') is-invalid @enderror" 
               id="legal_representative_curp" name="legal_representative_curp" maxlength="18"
               value="{{ old('legal_representative_curp', $supplier->legal_representative_curp) }}">
        @error('legal_representative_curp')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-12">
        <label for="partners_names" class="form-label">Nombre de los Socios</label>
        <textarea class="form-control @error('partners_names') is-invalid @enderror" 
                  id="partners_names" name="partners_names" rows="2"
                  placeholder="Separar por comas">{{ old('partners_names', $supplier->partners_names) }}</textarea>
        @error('partners_names')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-12">
        <label for="shareholders_curp" class="form-label">CURP de los Accionistas</label>
        <textarea class="form-control @error('shareholders_curp') is-invalid @enderror" 
                  id="shareholders_curp" name="shareholders_curp" rows="2"
                  placeholder="Separar por comas">{{ old('shareholders_curp', $supplier->shareholders_curp) }}</textarea>
        @error('shareholders_curp')
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
