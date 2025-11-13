<div>
    <div class="row mb-3 align-items-center justify-content-end">
        <div class="col-md-2 text-end">
            <a href="{{ route('acquisitions.biddings.create') }}" class="btn btn-primary btn-sm"
                wire:click="resetFilters">Nueva Licitación</a>
        </div>
    </div>

    @if ($biddings->count() != 0)

        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th></th>
                        <th>Título</th>
                        <th>Dependencia</th>
                        <th>Tipo</th>
                        <th>Monto</th>
                        <th>Estatus</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($biddings as $bidding)
                        <tr>
                            <td>{{ $bidding->id }}</td>
                            <td>{{ $bidding->title }}</td>
                            <td>{{ $bidding->dependency_name }}</td>
                            <td>{{ $bidding->bidding_type }}</td>
                            <td>{{ $bidding->ammount }}</td>
                            <td>{{ $bidding->status }}</td>
                            <td>
                                <a href="{{ route('acquisitions.biddings.show', $bidding->id) }}"
                                    class="btn btn-sm btn-outline-primary mb-2">
                                    Editar
                                </a>

                                <a href="{{ route('acquisitions.biddings.edit', $bidding->id) }}"
                                    class="btn btn-sm btn-outline-secondary mb-2">
                                    Editar
                                </a>

                                <form action="{{ route('acquisitions.biddings.destroy', $bidding->id) }}" method="POST"
                                    style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" data-toggle="tooltip"
                                        data-original-title="Eliminar"
                                        onclick="return confirm('¿Estás seguro de que deseas eliminar esta licitación?')">
                                        Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="align-items-center mt-4">
            {{ $biddings->links('pagination::bootstrap-5') }}
        </div>
    @else
        <div class="row">
            <div class="col-lg-12">
                <div class="box">
                    <div class="box-body">
                        <div class="text-center" style="padding:80px 0px 100px 0px;">
                            <img src="{{ asset('assets/images/empty.svg') }}" class="ml-auto mr-auto"
                                style="width:30%; margin-bottom: 40px;">
                            <h4>¡No hay licitaciones guardadas en la base de datos!</h4>
                            <p class="mb-4">Empieza a cargar licitaciones en tu plataforma usando el botón superior.
                            </p>
                            <a href="{{ route('acquisitions.biddings.create') }}"
                                class="btn btn-sm btn-primary btn-uppercase"><i class="fas fa-plus"></i> Crear nueva
                                Licitación</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
