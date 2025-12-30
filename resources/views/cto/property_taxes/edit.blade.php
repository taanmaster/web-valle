@extends('layouts.master')
@section('title')Intranet @endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') Tesorería @endslot
@slot('li_3') <a href="{{ route('property_taxes.index') }}">Recibos</a> @endslot
@slot('title') Editar Recibo @endslot
@endcomponent

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-lg-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0"><i class="fas fa-edit me-2"></i> Editar Recibo de Predial</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('property_taxes.update', $propertyTax->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Selección de Propiedad -->
                        <h6 class="border-bottom pb-2 mb-3"><i class="fas fa-home me-2 text-primary"></i> Propiedad</h6>
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <label class="form-label">Propiedad <span class="text-danger">*</span></label>
                                <select name="c_t_o_property_id" class="form-select @error('c_t_o_property_id') is-invalid @enderror" required>
                                    <option value="">Seleccionar propiedad...</option>
                                    @foreach($properties as $prop)
                                        <option value="{{ $prop->id }}" {{ old('c_t_o_property_id', $propertyTax->c_t_o_property_id) == $prop->id ? 'selected' : '' }}>
                                            {{ $prop->taxpayer_name }} - {{ $prop->location_account }} ({{ $prop->street }} {{ $prop->street_num }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('c_t_o_property_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Información del Periodo -->
                        <h6 class="border-bottom pb-2 mb-3"><i class="fas fa-calendar-alt me-2 text-primary"></i> Información del Periodo</h6>
                        <div class="row mb-4">
                            <div class="col-md-3">
                                <label class="form-label">Año <span class="text-danger">*</span></label>
                                <input type="number" name="tax_year" class="form-control @error('tax_year') is-invalid @enderror" value="{{ old('tax_year', $propertyTax->tax_year) }}" min="2000" max="2100" required>
                                @error('tax_year')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Bimestre <span class="text-danger">*</span></label>
                                <select name="bimonthly_period" class="form-select @error('bimonthly_period') is-invalid @enderror" required>
                                    <option value="">Seleccionar...</option>
                                    @for($i = 1; $i <= 6; $i++)
                                        <option value="{{ $i }}" {{ old('bimonthly_period', $propertyTax->bimonthly_period) == $i ? 'selected' : '' }}>{{ $i }}° Bimestre</option>
                                    @endfor
                                </select>
                                @error('bimonthly_period')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Tipo de Cuota <span class="text-danger">*</span></label>
                                <select name="cuota_type" class="form-select @error('cuota_type') is-invalid @enderror" required>
                                    <option value="">Seleccionar...</option>
                                    <option value="cuota_minima" {{ old('cuota_type', $propertyTax->cuota_type) == 'cuota_minima' ? 'selected' : '' }}>Cuota Mínima</option>
                                    <option value="cuota_normal" {{ old('cuota_type', $propertyTax->cuota_type) == 'cuota_normal' ? 'selected' : '' }}>Cuota Normal</option>
                                </select>
                                @error('cuota_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Folio</label>
                                <input type="text" name="folio" class="form-control @error('folio') is-invalid @enderror" value="{{ old('folio', $propertyTax->folio) }}">
                                @error('folio')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <label class="form-label">Fecha de Emisión</label>
                                <input type="date" name="issue_date" class="form-control @error('issue_date') is-invalid @enderror" value="{{ old('issue_date', $propertyTax->issue_date ? $propertyTax->issue_date->format('Y-m-d') : '') }}">
                                @error('issue_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Valores y Pagos -->
                        <h6 class="border-bottom pb-2 mb-3"><i class="fas fa-dollar-sign me-2 text-primary"></i> Valores y Pagos</h6>
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <label class="form-label">Valor del Predio</label>
                                <input type="number" step="0.01" name="property_value" class="form-control @error('property_value') is-invalid @enderror" value="{{ old('property_value', $propertyTax->property_value) }}">
                                @error('property_value')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Pago Bimestral</label>
                                <input type="number" step="0.01" name="bimonthly_payment" class="form-control @error('bimonthly_payment') is-invalid @enderror" value="{{ old('bimonthly_payment', $propertyTax->bimonthly_payment) }}">
                                @error('bimonthly_payment')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Tasa</label>
                                <input type="number" step="0.0001" name="tax_rate" class="form-control @error('tax_rate') is-invalid @enderror" value="{{ old('tax_rate', $propertyTax->tax_rate) }}">
                                @error('tax_rate')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Conceptos de Pago -->
                        <h6 class="border-bottom pb-2 mb-3"><i class="fas fa-list me-2 text-primary"></i> Conceptos de Pago</h6>
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <label class="form-label">Cuenta Corriente (Cve.)</label>
                                <input type="number" step="0.01" name="current_amount" class="form-control @error('current_amount') is-invalid @enderror" value="{{ old('current_amount', $propertyTax->current_amount) }}">
                                @error('current_amount')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Movimientos/Rezagos (Mov.)</label>
                                <input type="number" step="0.01" name="arrears_amount" class="form-control @error('arrears_amount') is-invalid @enderror" value="{{ old('arrears_amount', $propertyTax->arrears_amount) }}">
                                @error('arrears_amount')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Efectos</label>
                                <input type="number" step="0.01" name="effects" class="form-control @error('effects') is-invalid @enderror" value="{{ old('effects', $propertyTax->effects) }}">
                                @error('effects')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-3">
                                <label class="form-label">Periodo de Rezago</label>
                                <input type="text" name="arrears_period" class="form-control @error('arrears_period') is-invalid @enderror" value="{{ old('arrears_period', $propertyTax->arrears_period) }}">
                                @error('arrears_period')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Periodo Corriente</label>
                                <input type="number" step="0.01" name="current_period_amount" class="form-control @error('current_period_amount') is-invalid @enderror" value="{{ old('current_period_amount', $propertyTax->current_period_amount) }}">
                                @error('current_period_amount')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Total Rezago</label>
                                <input type="number" step="0.01" name="total_arrears" class="form-control @error('total_arrears') is-invalid @enderror" value="{{ old('total_arrears', $propertyTax->total_arrears) }}">
                                @error('total_arrears')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Total Impuesto Predial</label>
                                <input type="number" step="0.01" name="property_tax_total" class="form-control @error('property_tax_total') is-invalid @enderror" value="{{ old('property_tax_total', $propertyTax->property_tax_total) }}">
                                @error('property_tax_total')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Descuentos y Recargos -->
                        <h6 class="border-bottom pb-2 mb-3"><i class="fas fa-percentage me-2 text-primary"></i> Descuentos y Recargos</h6>
                        <div class="row mb-4">
                            <div class="col-md-3">
                                <label class="form-label">Descuento</label>
                                <input type="number" step="0.01" name="discount" class="form-control @error('discount') is-invalid @enderror" value="{{ old('discount', $propertyTax->discount) }}">
                                @error('discount')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Recargos</label>
                                <input type="number" step="0.01" name="surcharges" class="form-control @error('surcharges') is-invalid @enderror" value="{{ old('surcharges', $propertyTax->surcharges) }}">
                                @error('surcharges')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Descuento en Recargos</label>
                                <input type="number" step="0.01" name="surcharges_discount" class="form-control @error('surcharges_discount') is-invalid @enderror" value="{{ old('surcharges_discount', $propertyTax->surcharges_discount) }}">
                                @error('surcharges_discount')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Desc. Gastos de Ejecución</label>
                                <input type="number" step="0.01" name="execution_expenses_discount" class="form-control @error('execution_expenses_discount') is-invalid @enderror" value="{{ old('execution_expenses_discount', $propertyTax->execution_expenses_discount) }}">
                                @error('execution_expenses_discount')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Total -->
                        <h6 class="border-bottom pb-2 mb-3"><i class="fas fa-calculator me-2 text-primary"></i> Total</h6>
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label">Pago Total</label>
                                <input type="number" step="0.01" name="total_payment" class="form-control @error('total_payment') is-invalid @enderror" value="{{ old('total_payment', $propertyTax->total_payment) }}">
                                @error('total_payment')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Pago Total en Letra</label>
                                <input type="text" name="total_payment_text" class="form-control @error('total_payment_text') is-invalid @enderror" value="{{ old('total_payment_text', $propertyTax->total_payment_text) }}">
                                @error('total_payment_text')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Estado del Pago -->
                        <h6 class="border-bottom pb-2 mb-3"><i class="fas fa-info-circle me-2 text-primary"></i> Estado del Pago</h6>
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <label class="form-label">Estado <span class="text-danger">*</span></label>
                                <select name="payment_status" class="form-select @error('payment_status') is-invalid @enderror" required>
                                    <option value="pendiente" {{ old('payment_status', $propertyTax->payment_status) == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                    @hasanyrole(['all', 'tesoreria_caja_admin'])
                                    <option value="pagado" {{ old('payment_status', $propertyTax->payment_status) == 'pagado' ? 'selected' : '' }}>Pagado</option>
                                    @endhasanyrole
                                    <option value="vencido" {{ old('payment_status', $propertyTax->payment_status) == 'vencido' ? 'selected' : '' }}>Vencido</option>
                                </select>
                                @error('payment_status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Fecha de Pago</label>
                                <input type="date" name="payment_date" class="form-control @error('payment_date') is-invalid @enderror" value="{{ old('payment_date', $propertyTax->payment_date ? $propertyTax->payment_date->format('Y-m-d') : '') }}">
                                @error('payment_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Referencia Bancaria</label>
                                <input type="text" name="bank_reference" class="form-control @error('bank_reference') is-invalid @enderror" value="{{ old('bank_reference', $propertyTax->bank_reference) }}">
                                @error('bank_reference')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Notas -->
                        <h6 class="border-bottom pb-2 mb-3"><i class="fas fa-sticky-note me-2 text-primary"></i> Notas</h6>
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <label class="form-label">Notas Adicionales</label>
                                <textarea name="notes" class="form-control @error('notes') is-invalid @enderror" rows="3">{{ old('notes', $propertyTax->notes) }}</textarea>
                                @error('notes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Botones -->
                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="{{ route('property_taxes.show', $propertyTax->id) }}" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i> Cancelar
                            </a>
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-save me-2"></i> Actualizar Recibo
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
