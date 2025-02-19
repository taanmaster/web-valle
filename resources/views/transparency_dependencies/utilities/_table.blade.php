@foreach($transparency_dependencies as $dependency)
    <div class="col-md-4 mb-4">
        <div class="card">
            <img src="{{ asset('images/dependencies/' . $dependency->image_cover) }}" class="card-img-top" alt="Portada de {{ $dependency->name }}">
            <div class="card-body text-center">
                <img src="{{ asset('images/dependencies/' . $dependency->logo) }}" class="rounded-circle mb-3" alt="Logotipo de {{ $dependency->name }}" style="width: 50px; height: 50px;">
                <h5 class="card-title mb-3">{{ $dependency->name }}</h5>
                <p class="card-text">
                    <small>Creado: {{ $dependency->created_at }}</small><br>
                    <small>Actualizado: {{ $dependency->updated_at }}</small>
                </p>
                @if($dependency->in_index)
                <span class="badge bg-success">Se muestra en inicio</span>
                @else
                <span class="badge bg-secondary">No se muestra en inicio</span>
                @endif
                <br>

                <div class="btn-group mt-3" role="group" aria-label="Basic example">
                    <a href="{{ route('transparency_dependencies.show', $dependency->id) }}" class="btn btn-sm btn-outline-primary"><i class='bx bx-show-alt'></i> Ver Detalle</a>
                    <a href="{{ route('transparency_dependencies.edit', $dependency->id) }}" class="btn btn-sm btn-outline-secondary"><i class='bx bx-edit'></i> Editar</a>
                    <form method="POST" action="{{ route('transparency_dependencies.destroy', $dependency->id) }}" style="display: inline-block;">
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