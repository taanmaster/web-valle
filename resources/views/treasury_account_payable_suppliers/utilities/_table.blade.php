<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Información del Proveedor</th>
                <th>Cuenta Bancaria</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($suppliers as $supplier)
            <tr>
                <td>{{ $supplier->id }}</td>
                <td>
                    <strong>Nombre:</strong> {{ $supplier->name }}<br>
                    <strong>RFC:</strong> {{ $supplier->rfc ?? 'N/A' }}<br>
                    <strong>Email:</strong> {{ $supplier->email ?? 'N/A' }}<br>
                    <strong>Teléfono:</strong> {{ $supplier->phone ?? 'N/A' }}
                </td>
                <td>
                    <strong>Cuenta:</strong> {{ $supplier->account_name ?? 'N/A' }}<br>
                    <strong>Número:</strong> {{ $supplier->account_number ?? 'N/A' }}<br>
                    <strong>Banco:</strong> {{ $supplier->bank_name ?? 'N/A' }}
                </td>
                <td>
                    @if($supplier->status === 'active')
                        <span class="badge bg-success">Activo</span>
                    @else
                        <span class="badge bg-danger">Inactivo</span>
                    @endif
                </td>
                <td>
                    <div class="btn-group" role="group">
                        <a href="{{ route('treasury_account_payable_suppliers.show', $supplier->id) }}" class="btn btn-sm btn-outline-primary">
                            <i class="bx bx-show-alt"></i> Ver
                        </a>
                        <a href="{{ route('treasury_account_payable_suppliers.edit', $supplier->id) }}" class="btn btn-sm btn-outline-secondary">
                            <i class="bx bx-edit"></i> Editar
                        </a>
                        <form method="POST" action="{{ route('treasury_account_payable_suppliers.destroy', $supplier->id) }}" style="display: inline-block;">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                <i class="bx bx-trash-alt"></i> Eliminar
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>