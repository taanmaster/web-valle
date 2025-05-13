<div>

    @if ($mode == '1')
        <div class="row mb-4">
            <div class="col-md-4">
                <label for="published_date" class="form-label">Fecha de publicación</label>
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
    @endif

    <div class="row">
        @foreach ($blogs as $blog)
            @include('front.blog.utilities.blog-card')
        @endforeach
    </div>


    @if ($mode == '1')
        <div class="d-flex align-items-center justify-content-center">
            {{ $blogs->links() }}
        </div>
    @endif
</div>
