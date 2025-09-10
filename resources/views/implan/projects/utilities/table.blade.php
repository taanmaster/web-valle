<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>Título de Proyecto</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($projects as $project)
                <tr>
                    <td>{{ $project->title }}</td>
                    <td>
                        <a href="{{ route('implan.projects.show', $project->id) }}" class="btn btn-sm btn-primary"
                            data-toggle="tooltip" data-original-title="Ver Detalle">
                            Ver
                        </a>
                        <a href="{{ route('implan.projects.edit', $project->id) }}"
                            class="btn btn-sm btn-outline-secondary" data-toggle="tooltip" data-original-title="Editar">
                            Editar
                        </a>
                        <form action="{{ route('implan.projects.destroy', $project->id) }}" method="POST"
                            style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" data-toggle="tooltip"
                                data-original-title="Eliminar"
                                onclick="return confirm('¿Estás seguro de que deseas eliminar esta regulación?')">
                                Eliminar
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
