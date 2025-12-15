@extends('layouts.master')
@section('title')Intranet @endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') Tesorería @endslot
@slot('li_3') <a href="{{ route('properties.index') }}">Propiedades</a> @endslot
@slot('title') Editar Propiedad @endslot
@endcomponent

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-lg-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0"><i class="fas fa-edit me-2"></i> Editar Propiedad</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('properties.update', $property->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Información del Contribuyente -->
                        <h6 class="border-bottom pb-2 mb-3"><i class="fas fa-user me-2 text-primary"></i> Información del Contribuyente</h6>
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <label class="form-label">Tipo de Contribuyente</label>
                                <select name="taxpayer_type" class="form-select @error('taxpayer_type') is-invalid @enderror">
                                    <option value="">Seleccionar...</option>
                                    <option value="fisica" {{ old('taxpayer_type', $property->taxpayer_type) == 'fisica' ? 'selected' : '' }}>Persona Física</option>
                                    <option value="moral" {{ old('taxpayer_type', $property->taxpayer_type) == 'moral' ? 'selected' : '' }}>Persona Moral</option>
                                </select>
                                @error('taxpayer_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Nombre del Contribuyente</label>
                                <input type="text" name="taxpayer_name" class="form-control @error('taxpayer_name') is-invalid @enderror" value="{{ old('taxpayer_name', $property->taxpayer_name) }}">
                                @error('taxpayer_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Teléfono</label>
                                <input type="text" name="taxpayer_phone" class="form-control @error('taxpayer_phone') is-invalid @enderror" value="{{ old('taxpayer_phone', $property->taxpayer_phone) }}">
                                @error('taxpayer_phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Dirección -->
                        <h6 class="border-bottom pb-2 mb-3"><i class="fas fa-map-marker-alt me-2 text-primary"></i> Dirección de la Propiedad</h6>
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label">Calle <span class="text-danger">*</span></label>
                                <input type="text" name="street" class="form-control @error('street') is-invalid @enderror" value="{{ old('street', $property->street) }}" required>
                                @error('street')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Número Exterior <span class="text-danger">*</span></label>
                                <input type="text" name="street_num" class="form-control @error('street_num') is-invalid @enderror" value="{{ old('street_num', $property->street_num) }}" required>
                                @error('street_num')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Número Interior</label>
                                <input type="text" name="int_num" class="form-control @error('int_num') is-invalid @enderror" value="{{ old('int_num', $property->int_num) }}">
                                @error('int_num')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label">Colonia <span class="text-danger">*</span></label>
                                <input type="text" name="suburb" class="form-control @error('suburb') is-invalid @enderror" value="{{ old('suburb', $property->suburb) }}" required>
                                @error('suburb')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Dirección de Notificación</label>
                                <textarea name="notification_address" class="form-control @error('notification_address') is-invalid @enderror" rows="2">{{ old('notification_address', $property->notification_address) }}</textarea>
                                @error('notification_address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Información del Predio -->
                        <h6 class="border-bottom pb-2 mb-3"><i class="fas fa-home me-2 text-primary"></i> Información del Predio</h6>
                        <div class="row mb-4">
                            <div class="col-md-3">
                                <label class="form-label">Cuenta Catastral</label>
                                <input type="text" name="location_account" class="form-control @error('location_account') is-invalid @enderror" value="{{ old('location_account', $property->location_account) }}">
                                @error('location_account')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Tipo de Ubicación</label>
                                <input type="text" name="location_type" class="form-control @error('location_type') is-invalid @enderror" value="{{ old('location_type', $property->location_type) }}">
                                @error('location_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Número de Ubicación</label>
                                <input type="text" name="location_num" class="form-control @error('location_num') is-invalid @enderror" value="{{ old('location_num', $property->location_num) }}">
                                @error('location_num')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Tipo de Cuota</label>
                                <select name="cuota_type" class="form-select @error('cuota_type') is-invalid @enderror">
                                    <option value="">Seleccionar...</option>
                                    <option value="cuota_minima" {{ old('cuota_type', $property->cuota_type) == 'cuota_minima' ? 'selected' : '' }}>Cuota Mínima</option>
                                    <option value="cuota_normal" {{ old('cuota_type', $property->cuota_type) == 'cuota_normal' ? 'selected' : '' }}>Cuota Normal</option>
                                </select>
                                @error('cuota_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <label class="form-label">Superficie del Terreno (m²)</label>
                                <input type="number" step="0.01" name="location_surface" class="form-control @error('location_surface') is-invalid @enderror" value="{{ old('location_surface', $property->location_surface) }}">
                                @error('location_surface')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Superficie Construida (m²)</label>
                                <input type="number" step="0.01" name="location_surface_built" class="form-control @error('location_surface_built') is-invalid @enderror" value="{{ old('location_surface_built', $property->location_surface_built) }}">
                                @error('location_surface_built')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Uso del Predio</label>
                                <input type="text" name="location_use" class="form-control @error('location_use') is-invalid @enderror" value="{{ old('location_use', $property->location_use) }}">
                                @error('location_use')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <label class="form-label">Valor Catastral</label>
                                <input type="number" step="0.01" name="location_law_value" class="form-control @error('location_law_value') is-invalid @enderror" value="{{ old('location_law_value', $property->location_law_value) }}">
                                @error('location_law_value')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Condición del Predio</label>
                                <input type="text" name="location_condition" class="form-control @error('location_condition') is-invalid @enderror" value="{{ old('location_condition', $property->location_condition) }}">
                                @error('location_condition')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Origen del Predio</label>
                                <input type="text" name="location_origin" class="form-control @error('location_origin') is-invalid @enderror" value="{{ old('location_origin', $property->location_origin) }}">
                                @error('location_origin')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <label class="form-label">Notas del Predio</label>
                                <textarea name="location_note" class="form-control @error('location_note') is-invalid @enderror" rows="2">{{ old('location_note', $property->location_note) }}</textarea>
                                @error('location_note')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Información de Pagos -->
                        <h6 class="border-bottom pb-2 mb-3"><i class="fas fa-dollar-sign me-2 text-primary"></i> Información de Pagos</h6>
                        <div class="row mb-4">
                            <div class="col-md-3">
                                <label class="form-label">Tasa de Impuesto</label>
                                <input type="number" step="0.0001" name="tax_rate" class="form-control @error('tax_rate') is-invalid @enderror" value="{{ old('tax_rate', $property->tax_rate) }}">
                                @error('tax_rate')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Pago Anual</label>
                                <input type="number" step="0.01" name="payment_anual" class="form-control @error('payment_anual') is-invalid @enderror" value="{{ old('payment_anual', $property->payment_anual) }}">
                                @error('payment_anual')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Pago Bimestral</label>
                                <input type="number" step="0.01" name="payment_bimonthly" class="form-control @error('payment_bimonthly') is-invalid @enderror" value="{{ old('payment_bimonthly', $property->payment_bimonthly) }}">
                                @error('payment_bimonthly')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Fecha Último Avalúo</label>
                                <input type="date" name="last_appraisal" class="form-control @error('last_appraisal') is-invalid @enderror" value="{{ old('last_appraisal', $property->last_appraisal ? $property->last_appraisal->format('Y-m-d') : '') }}">
                                @error('last_appraisal')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Notas Adicionales -->
                        <h6 class="border-bottom pb-2 mb-3"><i class="fas fa-sticky-note me-2 text-primary"></i> Notas Adicionales</h6>
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <label class="form-label">Notas</label>
                                <textarea name="notes" class="form-control @error('notes') is-invalid @enderror" rows="3">{{ old('notes', $property->notes) }}</textarea>
                                @error('notes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Botones -->
                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="{{ route('properties.show', $property->id) }}" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i> Cancelar
                            </a>
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-save me-2"></i> Actualizar Propiedad
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
