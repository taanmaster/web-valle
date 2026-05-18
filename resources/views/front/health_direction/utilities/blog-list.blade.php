<div>
    <div class="row mb-4 align-items-end">
        <div class="col-md-4">
            <label for="published_date" class="form-label">Fecha de publicación</label>
            <input type="date" class="form-control" id="published_date" name="published_date"
                wire:model.live="published_date">
        </div>
        <div class="col-md text-end">
            @if ($published_date != '')
                <button wire:click="resetFilters" class="btn btn-secondary">Reiniciar filtros</button>
            @endif
        </div>
    </div>

    @if ($blogs->count() > 0)
        <div class="row g-4">
            @foreach ($blogs as $blog)
                <div class="col-md-6">
                    <div class="card card-blog h-100">
                        <div class="card card-image" style="height: 220px; border-radius: 12px 12px 0 0; overflow: hidden;">
                            <img src="{{ asset('images/health_direction/blog/' . $blog->hero_img) }}"
                                class="card-img-top" alt="{{ $blog->title }}"
                                style="height: 100%; object-fit: cover;">
                            <div class="overlay"></div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <small class="text-muted">{{ $blog->published_at }}</small>
                                <span class="badge rounded-pill bg-primary bg-opacity-10 text-primary">
                                    {{ $blog->category }}
                                </span>
                            </div>
                            <h5 class="card-title mb-2">{{ $blog->title }}</h5>
                            <p class="card-text text-muted" style="font-size: 0.9rem; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;">
                                {{ $blog->description }}
                            </p>
                            @if ($blog->writer)
                                <small class="text-muted">{{ $blog->writer }}</small>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="d-flex align-items-center justify-content-center mt-4">
            {{ $blogs->links('pagination::bootstrap-5') }}
        </div>
    @else
        <div class="text-center py-5">
            <ion-icon name="document-text-outline" style="font-size: 3rem; color: #cbd5e1;"></ion-icon>
            <p class="text-muted mt-3">No hay entradas disponibles en esta categoría.</p>
        </div>
    @endif
</div>
