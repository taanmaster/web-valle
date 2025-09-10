<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>Título</th>
                <th>Tipo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($posts as $post)
                <tr>
                    <td>{{ $post->title }}</td>
                    <td>{{ $post->type }}</td>
                    <td>
                        <a href="{{ route('implan.blog.show', $post->id) }}" class="btn btn-primary" data-toggle="tooltip"
                            data-original-title="Ver Detalle">
                            Ver Detalle
                        </a>
                        <a href="{{ route('implan.blog.edit', $post->id) }}" class="btn btn-warning" data-toggle="tooltip"
                            data-original-title="Editar">
                            Editar
                        </a>
                        <form action="{{ route('implan.blog.destroy', $post->id) }}" method="POST"
                            style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" data-toggle="tooltip"
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
