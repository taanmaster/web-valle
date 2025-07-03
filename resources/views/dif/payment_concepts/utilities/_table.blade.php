<div class="table-responsive">
    <table class="table">
        <thead class="thead-light">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Monto</th>
                <th>Estado</th>
                <th scope="col">Acciones</th>
            </tr>
        </thead>

        <tbody>
            @foreach($paymentConcepts as $concept)
            <tr>
                <th scope="row">#{{ $concept->id }}</th>
                <td>{{ $concept->name }}</td>
                <td class="text-muted">
                    {{ $concept->description ? Str::limit($concept->description, 50) : 'Sin descripción' }}
                </td>
                <td>
                    <strong class="text-success">${{ number_format($concept->amount, 2) }}</strong>
                </td>
                <td>
                    @if($concept->is_active)
                        <span class="badge bg-success">Activo</span>
                    @else
                        <span class="badge bg-danger">Inactivo</span>
                    @endif
                </td>
                <td>
                    <div class="d-flex gap-2" role="group" aria-label="Basic example">
                        <a href="{{ route('dif.payment_concepts.show', $concept->id) }}" class="btn btn-sm btn-primary">Ver</a>
                        <a href="{{ route('dif.payment_concepts.edit', $concept->id) }}" class="btn btn-sm btn-secondary">Editar</a>
                        <form method="POST" action="{{ route('dif.payment_concepts.destroy', $concept->id) }}" style="display: inline-block;">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de que deseas eliminar este concepto de pago?')">
                                Eliminar
                            </button>
                        </form>
                    </div>
                </td> 
            </tr>
            @endforeach                           
        </tbody>
    </table>                    
</div>
