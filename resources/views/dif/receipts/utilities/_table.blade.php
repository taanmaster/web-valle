@if ($receipts->count() > 0)
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Folio</th>
                    <th>Fecha</th>
                    <th>Paciente</th>
                    <th>Total</th>
                    <th>Método de Pago</th>
                    <th>Estado</th>
                    <th>Expedido por</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($receipts as $receipt)
                    <tr>
                        <td>
                            <span class="badge bg-primary">{{ $receipt->receipt_num }}</span>
                        </td>
                        <td>{{ $receipt->receipt_date->format('d/m/Y') }}</td>
                        <td>{{ $receipt->pacient_id }}</td>
                        <td class="text-end">
                            <strong>${{ number_format($receipt->total, 2) }}</strong>
                        </td>
                        <td>
                            @switch($receipt->payment_method)
                                @case('cash')
                                    <i class="fas fa-money-bill-wave text-success"></i> Efectivo
                                    @break
                                @case('card')
                                    <i class="fas fa-credit-card text-primary"></i> Tarjeta
                                    @break
                                @case('transfer')
                                    <i class="fas fa-exchange-alt text-info"></i> Transferencia
                                    @break
                                @case('check')
                                    <i class="fas fa-money-check text-warning"></i> Cheque
                                    @break
                            @endswitch
                        </td>
                        <td>
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
                        </td>
                        <td>{{ $receipt->issued_by }}</td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('dif.receipts.show', $receipt->id) }}" 
                                   class="btn btn-info btn-sm" title="Ver">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('dif.receipts.edit', $receipt->id) }}" 
                                   class="btn btn-warning btn-sm" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-danger btn-sm" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#deleteModal{{ $receipt->id }}" 
                                        title="Eliminar">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>

                            <!-- Modal de Confirmación para cada registro -->
                            <div class="modal fade" id="deleteModal{{ $receipt->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">
                                                <i class="fas fa-exclamation-triangle text-warning"></i> Confirmar Eliminación
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>¿Estás seguro de que deseas eliminar este recibo?</p>
                                            <div class="alert alert-info">
                                                <strong>Folio:</strong> {{ $receipt->receipt_num }}<br>
                                                <strong>Paciente:</strong> {{ $receipt->pacient_id }}<br>
                                                <strong>Total:</strong> ${{ number_format($receipt->total, 2) }}
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                            <form method="POST" action="{{ route('dif.receipts.destroy', $receipt->id) }}" style="display:inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Eliminar</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@else
    <div class="alert alert-info">
        <i class="fas fa-info-circle"></i> No hay recibos registrados.
        <a href="{{ route('dif.receipts.create') }}" class="btn btn-primary btn-sm ms-2">
            <i class="fas fa-plus"></i> Crear el primer recibo
        </a>
    </div>
@endif
