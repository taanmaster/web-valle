<div>
    @if ($mode == '1')
        <div class="row mb-4">
            <div class="col-md-4">
                <label for="published_date" class="form-label">Fecha de publicación</label>
                <input type="date" class="form-control" id="published_date" name="published_date"
                    wire:model.live="published_date">
            </div>

            <div class="col-md text-end">
                @if ($published_date != null)
                    <button wire:click="resetFilters" class="btn btn-secondary">Reiniciar Filtros</button>
                @endif
            </div>
        </div>
    @endif

    <div class="row">

        @if ($mode == 0)
            @foreach ($blogs->take(3) as $index => $blog)
                @if ($index === 0)
                    <a href="{{ route('turismo.front.blog.detail', $blog->slug) }}" class="col-md-12 mb-3">
                        <div class="card card-image card-image-banner wow fadeInUp">
                            <img class="card-img-top" src="{{ asset('images/tourism/blog/' . $blog->hero_img) }}"
                                alt="">
                            <div class="overlay"></div>
                            <div class="card-content w-100">
                                <div class="d-flex aling-items-center justify-content-between w-100">
                                    <h1 class="mb-0">{{ $blog->title }}</h1>
                                    <p class="mb-0">{{ $blog->writer }}</p>
                                </div>

                            </div>
                        </div>
                    </a>
                @else
                    <a href="{{ route('turismo.front.blog.detail', $blog->slug) }}" class="col-md-6 mb-4">
                        <div class="card card-image justify-content-end wow fadeInUp" style="height: 400px">
                            <img class="card-img-top" src="{{ asset('images/tourism/blog/' . $blog->hero_img) }}"
                                alt="">
                            <div class="overlay"></div>
                            <div class="card-content w-100">
                                <div class="d-flex aling-items-center justify-content-between w-100">
                                    <h3 class="mb-0">{{ $blog->title }}</h3>
                                    <p class="mb-0 truncate-text">{{ $blog->writer }}</p>
                                </div>

                            </div>
                        </div>
                    </a>
                @endif
            @endforeach
        @else
            @foreach ($blogs as $blog)
                @include('front.tourism.blog.utilities.blog-card')
            @endforeach
        @endif
    </div>


    @if ($mode == '1')
        <div class="d-flex align-items-center justify-content-center">
            {{ $blogs->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>
