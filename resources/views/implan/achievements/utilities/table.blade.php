<div>

    @if ($achievements->count() > 0)
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Visible</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($achievements as $item)
                        <tr>
                            <td>{{ $item->title }}</td>
                            <td>

                                <div class="form-check form-switch">
                                    <input type="checkbox" class="form-check-input" role="switch"
                                        id="switchCheckDefault-{{ $item->id }}"
                                        wire:click="statusUpdate({{ $item->id }})" @checked($item->is_active)>
                                    <label class="form-check-label" for="switchCheckDefault">
                                        @if ($item->is_active == 1)
                                            Si
                                        @else
                                            No
                                        @endif
                                    </label>
                                </div>
                            </td>
                            <td>
                                <a href="{{ route('implan.achievements.show', $item->id) }}" class="btn btn-primary"
                                    data-toggle="tooltip" data-original-title="Ver Detalle">
                                    Ver
                                </a>
                                <a href="{{ route('implan.achievements.edit', $item->id) }}"
                                    class="btn btn-outline-secondary" data-toggle="tooltip"
                                    data-original-title="Editar">
                                    Editar
                                </a>
                                <form action="{{ route('implan.achievements.destroy', $item->id) }}" method="POST"
                                    style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" data-toggle="tooltip"
                                        data-original-title="Eliminar"
                                        onclick="return confirm('¿Estás seguro de que deseas eliminar este logro?')">
                                        Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="align-items-center mt-4">
                {{ $achievements->links('pagination::bootstrap-5') }}
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-lg-12">
                <div class="box">
                    <div class="box-body">
                        <div class="text-center" style="padding:80px 0px 100px 0px;">
                            <img src="{{ asset('assets/images/empty.svg') }}" class="ml-auto mr-auto"
                                style="width:30%; margin-bottom: 40px;">
                            <h4>¡No hay logros guardados en la base de datos!</h4>
                            <p class="mb-4">Empieza a cargarlos en la sección correspondiente.</p>
                            <a href="{{ route('implan.achievements.create') }}" class="btn btn-primary btn-sm">Nuevo
                                Logro</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
