@if ($photos->count())
    <div class="row g-2">
        @foreach ($photos as $photo)
            <div class="col-6 col-md-4">
                <a href="{{ $photo->s3_asset_url }}" target="_blank" rel="noopener" class="d-block border rounded-3 overflow-hidden text-decoration-none">
                    <img src="{{ $photo->s3_asset_url }}" class="img-fluid" alt="{{ $photo->name }}">
                    <small class="d-block text-truncate text-dark p-2">{{ $photo->name }}</small>
                </a>
            </div>
        @endforeach
    </div>
@else
    <p class="text-muted small mb-0">Sin fotografías.</p>
@endif
