<a href="{{ route('turismo.front.blog.detail', $blog->slug) }}" class="col-md-6 card-blog">
    <div class="card card-blog">
        <img src="{{ asset('images/tourism/blog/' . $blog->hero_img) }}" class="card-img-top" alt="Portada de {{ $blog->title }}">
        <div class="card-body">
            <small>
                {{ $blog->published_at }}
            </small>
            <h5 class="card-title mb-3">{{ $blog->title }}</h5>
            <p class="truncate-text">
                {{ $blog->description }}
            </p>

            <p class="mb-0">
                {{ $blog->writer }}
            </p>

        </div>
    </div>
</a>
