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
            @foreach($financial_supports as $financial_support)
            <tr>
                <th scope="row">#{{ $financial_support->int_num }}</th>
                <td>
                    <a href="{{ route('financial_supports.show', $financial_support->id) }}">
                        {{ $financial_support->citizen->name }} {{ $financial_support->citizen->first_name }} {{ $financial_support->citizen->last_name }}
                    </a>
                </td>
                <td>${{ number_format($financial_support->qty,2) }}</td>
                <td>{{ $financial_support->receipt_num }}</td>
                <td>{{ $financial_support->type->name }}</td>
                <td>{{ $financial_support->created_at }}</td>

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
    </table>                    
</div>