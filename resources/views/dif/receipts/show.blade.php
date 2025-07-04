@extends('layouts.master')

@section('title')Ver Recibo @endsection

@section('content')
    <!-- this is breadcrumbs -->
    @component('components.breadcrumb')
        @slot('li_1') Intranet @endslot
        @slot('li_2') DIF @endslot
        @slot('li_3') <a href="{{ route('dif.receipts.index') }}">Recibos</a> @endslot
        @slot('title') Ver Recibo @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <h5 class="card-title">
                            <i class="fas fa-eye"></i> Ver Recibo
                        </h5>
                        <div class="d-flex">
                            <a href="{{ route('dif.receipts.edit', $receipt->id) }}" class="btn btn-warning btn-sm me-2">
                                <i class="fas fa-edit"></i> Editar
                            </a>
                            <button type="button" class="btn btn-danger btn-sm me-2" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                <i class="fas fa-trash"></i> Eliminar
                            </button>
                            <button type="button" class="btn btn-info btn-sm me-2" onclick="printReceipt()">
                                <i class="fas fa-print"></i> Imprimir
                            </button>
                            <a href="{{ route('dif.receipts.index') }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-arrow-left"></i> Volver
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body" id="receipt-content">
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
                                <span class="badge bg-primary">{{ $receipt->receipt_num }}</span>
                            </div>
                            <div class="mb-2">
                                <strong>Fecha:</strong>
                                <span>{{ $receipt->receipt_date->format('d/m/Y') }}</span>
                            </div>
                            <div class="mb-2">
                                <strong>Estado:</strong>
                                @switch($receipt->status)
                                    @case('pending')
                                        <span class="badge bg-warning">Pendiente</span>
                                        @break
                                    @case('completed')
                                        <span class="badge bg-success">Completado</span>
                                        @break
                                    @case('cancelled')
                                        <span class="badge bg-danger">Cancelado</span>
                                        @break
                                @endswitch
                            </div>
                        </div>
                    </div>

                    <hr>

                    <!-- Información del Recibo -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5>Información del Recibo</h5>
                            <table class="table table-borderless">
                                <tr>
                                    <th>ID del Paciente:</th>
                                    <td>{{ $receipt->pacient_id }}</td>
                                </tr>
                                <tr>
                                    <th>Cita:</th>
                                    <td>{{ $receipt->appointment ?: 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Ubicación:</th>
                                    <td>{{ $receipt->location ?: 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Expedido por:</th>
                                    <td>{{ $receipt->issued_by }}</td>
                                </tr>
                            </table>
                        </div>
                        
                        <div class="col-md-6">
                            <h5>Método de Pago</h5>
                            <table class="table table-borderless">
                                <tr>
                                    <th>Método:</th>
                                    <td>
                                        @switch($receipt->payment_method)
                                            @case('cash')
                                                <i class="fas fa-money-bill-wave"></i> Efectivo
                                                @break
                                            @case('card')
                                                <i class="fas fa-credit-card"></i> Tarjeta
                                                @break
                                            @case('transfer')
                                                <i class="fas fa-exchange-alt"></i> Transferencia
                                                @break
                                            @case('check')
                                                <i class="fas fa-money-check"></i> Cheque
                                                @break
                                        @endswitch
                                    </td>
                                </tr>
                                <tr>
                                    <th>Fecha de Creación:</th>
                                    <td>{{ $receipt->created_at->format('d/m/Y H:i:s') }}</td>
                                </tr>
                                <tr>
                                    <th>Última Actualización:</th>
                                    <td>{{ $receipt->updated_at->format('d/m/Y H:i:s') }}</td>
                                </tr>
                            </table>
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
                                            <th width="40%">Concepto</th>
                                            <th width="35%">Descripción</th>
                                            <th width="25%">Importe</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($receipt->paymentConcepts as $concept)
                                            <tr>
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
                                        <span>${{ number_format($receipt->subtotal, 2) }}</span>
                                    </div>
                                    
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Descuento:</span>
                                        <span>-${{ number_format($receipt->discount, 2) }}</span>
                                    </div>
                                    
                                    <hr>
                                    
                                    <div class="d-flex justify-content-between mb-2">
                                        <strong>Total:</strong>
                                        <strong>${{ number_format($receipt->total, 2) }}</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pie de página -->
                    <div class="row">
                        <div class="col-12 text-center">
                            <hr>
                            <p class="text-muted">
                                <small>
                                    Este recibo es válido como comprobante de pago.<br>
                                    Para cualquier aclaración, favor de contactar al DIF Municipal.
                                </small>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('dif.receipts.utilities._modal')
@endsection

@section('script')
<script>
function printReceipt() {
    // Crear ventana de impresión
    let printWindow = window.open('', '_blank');
    
    // Obtener el contenido del recibo
    let receiptContent = document.getElementById('receipt-content').innerHTML;
    
    // Crear HTML para imprimir
    let printHTML = `
        <html>
        <head>
            <title>Recibo - {{ $receipt->receipt_num }}</title>
            <style>
                body { font-family: Arial, sans-serif; margin: 20px; }
                .text-primary { color: #0d6efd; }
                .text-muted { color: #6c757d; }
                .text-end { text-align: right; }
                .text-center { text-align: center; }
                .badge { 
                    padding: 4px 8px; 
                    border-radius: 4px; 
                    font-size: 12px; 
                    font-weight: bold; 
                }
                .bg-primary { background-color: #0d6efd; color: white; }
                .bg-success { background-color: #198754; color: white; }
                .bg-warning { background-color: #ffc107; color: black; }
                .bg-danger { background-color: #dc3545; color: white; }
                .table { 
                    width: 100%; 
                    border-collapse: collapse; 
                    margin-bottom: 20px; 
                }
                .table th, .table td { 
                    padding: 8px; 
                    border: 1px solid #ddd; 
                    text-align: left; 
                }
                .table-light { background-color: #f8f9fa; }
                .table-borderless td, .table-borderless th { border: none; }
                .card { 
                    border: 1px solid #ddd; 
                    border-radius: 4px; 
                    padding: 15px; 
                    margin-bottom: 20px; 
                }
                hr { border: 1px solid #ddd; }
                @media print {
                    body { margin: 0; }
                    .card { border: none; }
                }
            </style>
        </head>
        <body>
            ${receiptContent}
        </body>
        </html>
    `;
    
    printWindow.document.write(printHTML);
    printWindow.document.close();
    printWindow.print();
}
</script>
@endsection
