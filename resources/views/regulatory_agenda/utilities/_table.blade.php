@foreach ($dependecies as $dependency)
    <div class="col-md-4 mb-4">
        <div class="card">
            <div class="card-body text-center">
                <h5 class="card-title mb-3">{{ $dependency->name }}</h5>
                <p class="card-text">
                    <small>Creado: {{ $dependency->created_at }}</small><br>
                    <small>Actualizado: {{ $dependency->updated_at }}</small>
                </p>
                @if ($dependency->in_index)
                    <span class="badge bg-success">Se muestra en inicio</span>
                @else
                    <span class="badge bg-secondary">No se muestra en inicio</span>
                @endif
                <br>

                <div class="btn-group mt-3" role="group" aria-label="Basic example">
                    <a href="{{ route('regulatory_agenda.show', $dependency->id) }}"
                        class="btn btn-sm btn-outline-primary"><i class='bx bx-show-alt'></i> Ver
                        Detalle</a>
                    <a href="javascript:void(0)" class="btn btn-sm btn-outline-primary edit-dependency"
                        data-id="{{ $dependency->id }}">
                        <i class="bx bx-edit"></i> Editar Dependencia
                    </a>
                    <form method="POST" action="{{ route('regulatory_agenda_dependency.destroy', $dependency->id) }}"
                        style="display: inline-block;">
                        <button type="submit" class="btn btn-sm btn-outline-danger">
                            <i class='bx bx-trash-alt text-danger'></i> Eliminar
                        </button>
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach
