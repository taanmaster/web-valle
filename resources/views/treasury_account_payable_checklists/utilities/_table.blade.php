<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Estado</th>
                <th>Fecha de Creación</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($checklists as $checklist)
            <tr>
                <td>{{ $checklist->id }}</td>
                <td>{{ $checklist->name }}</td>
                <td>{{ $checklist->description ?? 'N/A' }}</td>
                <td>
                    @if($checklist->status === 'active')
                        <span class="badge bg-success">Activo</span>
                    @else
                        <span class="badge bg-danger">Inactivo</span>
                    @endif
                </td>
                <td>{{ $checklist->created_at->format('d/m/Y') }}</td>
                <td>
                    <div class="btn-group" role="group">
                        <a href="{{ route('treasury_account_payable_checklists.show', $checklist->id) }}" class="btn btn-sm btn-outline-primary">
                            <i class="bx bx-show-alt"></i> Ver
                        </a>
                        <a href="{{ route('treasury_account_payable_checklists.edit', $checklist->id) }}" class="btn btn-sm btn-outline-secondary">
                            <i class="bx bx-edit"></i> Editar
                        </a>
                        <form method="POST" action="{{ route('treasury_account_payable_checklists.destroy', $checklist->id) }}" style="display: inline-block;">
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