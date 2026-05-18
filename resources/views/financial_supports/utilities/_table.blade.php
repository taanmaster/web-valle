<div class="table-responsive">
    <table class="table table-hover align-middle">
        <thead class="table-light">
            <tr>
                <th class="fw-semibold">Folio</th>
                <th class="fw-semibold">Nombre del Beneficiario</th>
                <th class="fw-semibold">Cantidad del Apoyo</th>
                <th class="fw-semibold">Número de Recibo</th>
                <th class="fw-semibold">Tipo de Apoyo</th>
                <th class="fw-semibold">Creado</th>
                <th class="fw-semibold text-center">Acciones</th>
            </tr>
        </thead>

        <tbody>
            @php
                $totalQty = 0;
            @endphp
            @foreach($financial_supports as $financial_support)
            @php
                $totalQty += $financial_support->qty;
            @endphp
            <tr>
                <td>
                    <span class="badge bg-primary">#{{ $financial_support->int_num }}</span>
                </td>
                <td>
                    @if($financial_support->citizen == null)
                        <span class="badge bg-danger">Ciudadano Eliminado</span>
                    @else
                        {{ $financial_support->citizen->name ?? '' }} {{ $financial_support->citizen->first_name ?? '' }} {{ $financial_support->citizen->last_name ?? '' }}
                    @endif
                </td>
                <td>
                    <span class="fw-semibold">${{ number_format($financial_support->qty ?? 0, 2) }}</span>
                </td>
                <td>{{ $financial_support->receipt_num ?? 'N/A' }}</td>
                <td>{{ $financial_support->type->name ?? 'N/A' }}</td>
                <td>
                    <small class="text-muted">{{ $financial_support->created_at ? $financial_support->created_at->format('d/m/Y') : 'N/A' }}</small>
                </td>
                <td class="text-center">
                    <div class="dropdown">
                        <button type="button" class="btn btn-sm btn-outline-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-file-download me-1"></i> Documentos
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <form method="POST" action="{{ route('financial_supports.downloadGratefulness', $financial_support->id) }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item"><i class="fas fa-file me-2"></i> Agradecimiento</button>
                                </form>
                            </li>
                            <li>
                                <form method="POST" action="{{ route('financial_supports.downloadRequest', $financial_support->id) }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item"><i class="fas fa-file me-2"></i> Petición</button>
                                </form>
                            </li>
                            <li>
                                <form method="POST" action="{{ route('financial_supports.downloadSupportReceipt', $financial_support->id) }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item"><i class="fas fa-file me-2"></i> Recibo de Apoyo</button>
                                </form>
                            </li>
                            <li>
                                <form method="POST" action="{{ route('financial_supports.downloadUnderOath', $financial_support->id) }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item"><i class="fas fa-file me-2"></i> Bajo Protesta</button>
                                </form>
                            </li>
                            <li>
                                <form method="POST" action="{{ route('financial_supports.downloadReceived', $financial_support->id) }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item"><i class="fas fa-file me-2"></i> Recibí</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="table-light">
                <td colspan="2"><strong>TOTAL</strong></td>
                <td><strong>${{ number_format($totalQty, 2) }}</strong></td>
                <td colspan="4"></td>
            </tr>
        </tfoot>
    </table>
</div>