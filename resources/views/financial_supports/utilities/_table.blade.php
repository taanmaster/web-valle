<div>
    <table class="table">
        <thead class="thead-light">
            <tr>
                <th>Folio</th>
                <th>Nombre del Beneficiario</th>
                <th>Cantidad del Apoyo</th>
                <th>Número de Recibo</th>
                <th>Tipo de Apoyo</th>
                <th>Creado</th>
                <th scope="col">Acciones</th>
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
                <th scope="row">#{{ $financial_support->int_num }}</th>
                <td>
                    @if($financial_support->citizen == null)
                        <span class="badge bg-danger">Ciudadano Eliminado por Administrador</span>
                    @else
                        {{ $financial_support->citizen->name ?? '' }} {{ $financial_support->citizen->first_name ?? '' }} {{ $financial_support->citizen->last_name ?? '' }}
                    @endif
                </td>
                <td>${{ number_format($financial_support->qty ?? 0, 2) }}</td>
                <td>{{ $financial_support->receipt_num ?? 'N/A' }}</td>
                <td>{{ $financial_support->type->name ?? 'N/A' }}</td>
                <td>{{ $financial_support->created_at ?? 'N/A' }}</td>

                <td>
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            Descarga de Documentos
                        </button>
                        <ul class="dropdown-menu">
                            <li>
                                <form method="POST" action="{{ route('financial_supports.downloadGratefulness', $financial_support->id) }}" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <button type="submit" class="dropdown-item">Descarga Agradecimiento</button>
                                </form>
                            </li>
                            <li>
                                <form method="POST" action="{{ route('financial_supports.downloadRequest', $financial_support->id) }}" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <button type="submit" class="dropdown-item">Descarga Petición</button>
                                </form>
                            </li>
                            <li>
                                <form method="POST" action="{{ route('financial_supports.downloadSupportReceipt', $financial_support->id) }}" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <button type="submit" class="dropdown-item">Descarga Recibo de Apoyo</button>
                                </form>
                            </li>
                            <li>
                                <form method="POST" action="{{ route('financial_supports.downloadUnderOath', $financial_support->id) }}" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <button type="submit" class="dropdown-item">Descarga Bajo Protesta</button>
                                </form>
                            </li>
                            <li>
                                <form method="POST" action="{{ route('financial_supports.downloadReceived', $financial_support->id) }}" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <button type="submit" class="dropdown-item">Descarga Recibí</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </td> 
            </tr>
            @endforeach                           
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2"><strong>TOTAL</strong></td>
                <td><strong>${{ number_format($totalQty, 2) }}</strong></td>
                <td colspan="4"></td>
            </tr>
        </tfoot>
    </table>                    
</div>