@extends('layouts.master')

@section('title')Crear Recibo @endsection

@section('content')
    <!-- this is breadcrumbs -->
    @component('components.breadcrumb')
        @slot('li_1') Intranet @endslot
        @slot('li_2') DIF @endslot
        @slot('li_3') <a href="{{ route('dif.receipts.index') }}">Recibos</a> @endslot
        @slot('title') Crear Recibo @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <h5 class="card-title">
                            <i class="fas fa-plus"></i> Crear Recibo
                        </h5>
                        <div class="d-flex">
                            <a href="{{ route('dif.receipts.index') }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-arrow-left"></i> Volver
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('dif.receipts.store') }}" id="receiptForm">
                        @csrf
                        
                        <!-- Encabezado de la Factura -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h4 class="text-primary">
                                    <i class="fas fa-receipt"></i> RECIBO DE PAGO
                                </h4>
                                <p class="text-muted">Sistema Integral Municipal DIF</p>
                            </div>
                            <div class="col-md-6 text-end">
                                <div class="mb-2">
                                    <strong>Folio:</strong>
                                    <span class="badge bg-primary">{{ $receiptNum }}</span>
                                </div>
                                <div class="mb-2">
                                    <strong>Fecha:</strong>
                                    <span>{{ date('d/m/Y H:i:s') }}</span>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <!-- Información del Recibo -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h5>Información del Recibo</h5>
                                
                                <input type="hidden" name="receipt_num" value="{{ $receiptNum }}">
                                <input type="hidden" name="receipt_date" value="{{ date('Y-m-d') }}">
                                <input type="hidden" name="issued_by" value="{{ Auth::user()->name }}">
                                
                                <div class="form-group mb-3">
                                    <label for="pacient_id">ID del Paciente:</label>
                                    <input type="text" name="pacient_id" id="pacient_id" class="form-control" placeholder="Ingresa el ID del paciente" value="{{ old('pacient_id') }}" required>
                                </div>
                                
                                <div class="form-group mb-3">
                                    <label for="appointment">Cita:</label>
                                    <input type="text" name="appointment" id="appointment" class="form-control" placeholder="Número de cita (opcional)" value="{{ old('appointment') }}">
                                </div>
                                
                                <div class="form-group mb-3">
                                    <label for="location">Ubicación:</label>
                                    <input type="text" name="location" id="location" class="form-control" placeholder="Ubicación del servicio (opcional)" value="{{ old('location') }}">
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <h5>Método de Pago</h5>
                                
                                <div class="form-group mb-3">
                                    <label for="payment_method">Método de Pago:</label>
                                    <select name="payment_method" id="payment_method" class="form-control">
                                        <option value="cash" {{ old('payment_method', 'cash') == 'cash' ? 'selected' : '' }}>Efectivo</option>
                                        <option value="card" {{ old('payment_method') == 'card' ? 'selected' : '' }}>Tarjeta</option>
                                        <option value="transfer" {{ old('payment_method') == 'transfer' ? 'selected' : '' }}>Transferencia</option>
                                        <option value="check" {{ old('payment_method') == 'check' ? 'selected' : '' }}>Cheque</option>
                                    </select>
                                </div>
                                
                                <div class="form-group mb-3">
                                    <label for="status">Estado:</label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pendiente</option>
                                        <option value="completed" {{ old('status', 'completed') == 'completed' ? 'selected' : '' }}>Completado</option>
                                        <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelado</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Conceptos de Pago -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5>Conceptos de Pago</h5>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead class="table-light">
                                            <tr>
                                                <th width="5%">Sel.</th>
                                                <th width="40%">Concepto</th>
                                                <th width="30%">Descripción</th>
                                                <th width="25%">Importe</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($paymentConcepts as $concept)
                                                <tr>
                                                    <td class="text-center">
                                                        <input type="checkbox" name="concept_ids[]" value="{{ $concept->id }}" class="form-check-input concept-checkbox" data-amount="{{ $concept->amount }}" {{ in_array($concept->id, old('concept_ids', [])) ? 'checked' : '' }}>
                                                    </td>
                                                    <td>{{ $concept->name }}</td>
                                                    <td>{{ $concept->description ?: 'N/A' }}</td>
                                                    <td class="text-end">
                                                        <strong>${{ number_format($concept->amount, 2) }}</strong>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Totales -->
                        <div class="row mb-4">
                            <div class="col-md-8"></div>
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Resumen</h5>
                                        
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>Subtotal:</span>
                                            <span id="subtotal-display">$0.00</span>
                                        </div>
                                        
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>Descuento:</span>
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-text">$</span>
                                                <input type="number" name="discount" id="discount-input" class="form-control" min="0" step="0.01" value="{{ old('discount', 0) }}">
                                            </div>
                                        </div>
                                        
                                        <hr>
                                        
                                        <div class="d-flex justify-content-between mb-2">
                                            <strong>Total:</strong>
                                            <strong id="total-display">$0.00</strong>
                                        </div>

                                        <input type="hidden" name="subtotal" id="subtotal-hidden" value="{{ old('subtotal', 0) }}">
                                        <input type="hidden" name="total" id="total-hidden" value="{{ old('total', 0) }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Crear Recibo</button>
                            <a href="{{ route('dif.receipts.index') }}" class="btn btn-secondary">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
<script>
$(document).ready(function() {
    // Función para calcular totales
    function calculateTotals() {
        let subtotal = 0;
        
        $('.concept-checkbox:checked').each(function() {
            subtotal += parseFloat($(this).data('amount'));
        });
        
        let discount = parseFloat($('#discount-input').val()) || 0;
        let total = subtotal - discount;
        
        // Actualizar display
        $('#subtotal-display').text('$' + subtotal.toFixed(2));
        $('#total-display').text('$' + total.toFixed(2));
        
        // Actualizar campos ocultos
        $('#subtotal-hidden').val(subtotal.toFixed(2));
        $('#total-hidden').val(total.toFixed(2));
    }
    
    // Eventos
    $('.concept-checkbox').on('change', calculateTotals);
    $('#discount-input').on('input', calculateTotals);
    
    // Validación del formulario
    $('#receiptForm').on('submit', function(e) {
        if ($('.concept-checkbox:checked').length === 0) {
            e.preventDefault();
            alert('Debe seleccionar al menos un concepto de pago.');
            return false;
        }
        
        if (parseFloat($('#total-hidden').val()) < 0) {
            e.preventDefault();
            alert('El total no puede ser negativo.');
            return false;
        }
    });
});
</script>
@endsection
