<a href="" class="col-md-6 mb-4">
    <div class="card">
        <img src="{{ asset('images/blog/' . $blog->hero_img) }}" class="card-img-top" alt="Portada de {{ $blog->title }}">
        <div class="card-body">
            <p>
                {{ $blog->published_at }}
            </p>
            <h5 class="card-title mb-3">{{ $blog->title }}</h5>
            <p class="card-text">
                {{ $blog->description }}
            </p>

            <div class="d-flex mt-3 w-100 justify-content-between align-items-center">
                <p class="mb-0">
                    {{ $blog->category }}
                </p>
            </div>
        </div>
    </div>
</a>
