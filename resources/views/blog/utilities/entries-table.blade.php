<div>

    <div class="row mb-4">
        <div class="col-md-4">
            <label for="published_date" class="form-label">Fecha</label>
            <input type="date" class="form-control" id="published_date" name="published_date"
                wire:model.live="published_date">
        </div>

        <div class="col-md-4">
            <label for="category" class="form-label">Categoría</label>
            <select name="category" class="form-control" wire:model.live="category">
                <option value="">Todos</option>
                <option value="General">General</option>
                <option value="Turismo">Turismo</option>
                <option value="Eventos">Eventos</option>
            </select>
        </div>

        <div class="col-md text-end">
            @if ($category != null || $published_date != null)
                <button wire:click="resetFilters" class="btn btn-secondary">Reiniciar Filtros</button>
            @endif
        </div>
    </div>

    <div class="row">
        @foreach ($blogs as $blog)
            <div class="col-md-6 mb-4">
                <div class="card">
                    <img src="{{ asset('images/blog/' . $blog->hero_img) }}" class="card-img-top"
                        alt="Portada de {{ $blog->title }}">
                    <div class="card-body">
                        <p>
                            {{ $blog->published_at }}
                        </p>
                        <h5 class="card-title mb-3">{{ $blog->title }}</h5>
                        <p class="card-text">
                            {{ $blog->description }}
                        </p>
                        @if ($blog->is_fav == 1)
                            <span class="badge bg-success">Se muestra en inicio</span>
                        @else
                            <span class="badge bg-secondary">No se muestra en inicio</span>
                        @endif
                        <br>

                        <div class="d-flex mt-3 w-100 justify-content-between align-items-center">
                            <p class="mb-0">
                                {{ $blog->category }}
                            </p>

                            <div class="btn-group" role="group" aria-label="Basic example">
                                <a href="{{ route('blog.admin.edit', $blog->id) }}"
                                    class="btn btn-sm btn-outline-secondary"><i class='bx bx-edit'></i> Editar</a>
                                <form method="POST" action="{{ route('blog.admin.destroy', $blog->id) }}"
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
            </div>
        @endforeach
    </div>
</div>
