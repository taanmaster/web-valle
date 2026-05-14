<div>
    <div class="row mb-4">
        <div class="col-md-4">
            <label class="form-label">Fecha</label>
            <input type="date" class="form-control" wire:model.live="published_date">
        </div>
        <div class="col-md text-end align-self-end">
            @if ($published_date != '')
                <button wire:click="resetFilters" class="btn btn-secondary">Reiniciar Filtros</button>
            @endif
        </div>
    </div>

    <div class="row">
        @foreach ($entries as $entry)
            <div class="col-md-6 mb-4">
                <div class="card h-100">
                    <a href="{{ route('training.admin.detail', $entry->id) }}" class="text-decoration-none">
                        <img src="{{ asset('images/training-blog/' . $entry->hero_img) }}"
                            class="card-img-top" style="height:200px;object-fit:cover;"
                            alt="Portada de {{ $entry->title }}">
                    </a>
                    <div class="card-body d-flex flex-column">
                        <p class="text-muted mb-1"><small>{{ $entry->published_at }}</small></p>
                        <h5 class="card-title mb-2">
                            <a href="{{ route('training.admin.detail', $entry->id) }}"
                                class="text-decoration-none text-dark">
                                {{ $entry->title }}
                            </a>
                        </h5>
                        <p class="card-text flex-grow-1">{{ $entry->description }}</p>

                        <div class="d-flex mt-3 w-100 justify-content-end align-items-center">
                            <div class="btn-group" role="group">
                                <a href="{{ route('training_blog.admin.edit', $entry->id) }}"
                                    class="btn btn-sm btn-outline-secondary">
                                    <i class='bx bx-edit'></i> Editar
                                </a>
                                <form method="POST"
                                    action="{{ route('training_blog.admin.destroy', $entry->id) }}"
                                    style="display:inline-block;"
                                    onsubmit="return confirm('¿Eliminar esta entrada?')">
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

    <div class="d-flex align-items-center justify-content-center">
        {{ $entries->links() }}
    </div>
</div>
