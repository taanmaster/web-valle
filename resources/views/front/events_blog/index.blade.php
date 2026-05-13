@extends('front.layouts.app')

@section('content')
    <div class="container">

        <div class="row justify-content-center mb-4">
            <div class="col-md-12">
                <h2 class="text-center mb-4">Eventos conmemorativos</h2>
            </div>
        </div>

        {{-- Filtro de fecha --}}
        <div class="row justify-content-center mb-4">
            <div class="col-md-10">
                <form method="GET" action="{{ route('events_blog.front.index') }}"
                    class="d-flex flex-wrap gap-3 align-items-end">
                    <div>
                        <label class="form-label small mb-1">Fecha</label>
                        <input type="date" name="fecha" class="form-control form-control-sm"
                            value="{{ request('fecha') }}">
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-secondary btn-sm">Filtrar</button>
                        @if (request('fecha'))
                            <a href="{{ route('events_blog.front.index') }}"
                                class="btn btn-outline-secondary btn-sm">Limpiar</a>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        {{-- Cards --}}
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="row">
                    @forelse ($entries as $entry)
                        <div class="col-md-6 mb-4">
                            <a href="{{ route('events_blog.front.show', $entry->slug) }}"
                                class="text-decoration-none text-dark">
                                <div class="card h-100 border-0 shadow-sm">
                                    <img src="{{ asset('images/events-blog/' . $entry->hero_img) }}"
                                        class="card-img-top"
                                        style="height:220px;object-fit:cover;background:#e0e0e0;"
                                        alt="{{ $entry->title }}">
                                    <div class="card-body">
                                        <p class="text-muted mb-1">
                                            <small>{{ \Carbon\Carbon::parse($entry->published_at)->format('M d, Y') }}</small>
                                        </p>
                                        <h5 class="card-title">{{ $entry->title }}</h5>
                                        <p class="card-text text-muted">{{ $entry->description }}</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @empty
                        <div class="col-12 text-center py-5">
                            <p class="text-muted">No hay eventos disponibles.</p>
                        </div>
                    @endforelse
                </div>

                <div class="d-flex justify-content-center mt-4">
                    {{ $entries->appends(request()->query())->links() }}
                </div>
            </div>
        </div>

    </div>
@endsection
