<div>
    @if (session('success'))
        <div class="alert alert-success d-flex align-items-center border-0 shadow-sm mb-4" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    @endif

    {{--
        El layout de intranet (layouts.master) sólo expone @stack('stylesheets'),
        no @stack('styles')/@stack('scripts') como el layout público. El
        partial front.utilities._events_calendar usa esos dos últimos, así
        que aquí se referencian los mismos assets directamente en vez de
        reusar el partial — mismo widget, sin tocar el layout compartido.
    --}}
    @push('stylesheets')
        <link rel="stylesheet" href="{{ asset('front/css/calendar.css') }}">
    @endpush

    <div class="row mb-4">
        <div class="col-md-6">
            <div id="calendar" class="wow fadeInUp"></div>
        </div>
        <div class="col-md-6 d-flex align-items-start justify-content-end">
            <a href="{{ route('environment_events.admin.create') }}" class="btn btn-warning">
                <i class="fas fa-plus"></i> Crear evento
            </a>
        </div>
    </div>

    <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.5.1/moment.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.5.1/lang/es.js"></script>
    <script src="{{ asset('front/js/events-calendar.js') }}"></script>
    <script>
        (function () {
            var data = [
                @foreach ($calendarEvents as $event)
                    {
                        eventName: '{!! addslashes($event->title) !!}',
                        eventDateTime: '{{ $event->date_start->format('H:i') }}',
                        eventLocation: '{!! addslashes($event->location ?? '') !!}',
                        @if ($event->blog_url)
                            eventUrl: '{!! addslashes($event->blog_url) !!}',
                        @else
                            eventUrl: null,
                        @endif
                        date: moment('{{ $event->date_start }}'),
                        color: 'primary'
                    }
                    @if (!$loop->last)
                        ,
                    @endif
                @endforeach
            ];

            if (typeof moment === 'function' && document.getElementById('calendar')) {
                new Calendar('#calendar', data);
            }
        })();
    </script>

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th class="fw-semibold">Fecha</th>
                    <th class="fw-semibold">Hora</th>
                    <th class="fw-semibold">Título</th>
                    <th class="fw-semibold">Lugar</th>
                    <th class="fw-semibold">Link</th>
                    <th class="fw-semibold text-end">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($events as $event)
                    <tr>
                        <td>{{ $event->date_start->format('d/m/Y') }}</td>
                        <td>{{ $event->date_start->format('g:i A') }}</td>
                        <td>{{ $event->title }}</td>
                        <td>{{ $event->location ?: '—' }}</td>
                        <td>
                            @if ($event->blog_url)
                                <a href="{{ $event->blog_url }}" target="_blank" class="text-truncate d-inline-block" style="max-width: 160px;">
                                    {{ $event->blog_url }}
                                </a>
                            @else
                                —
                            @endif
                        </td>
                        <td class="text-end">
                            <a href="{{ route('environment_events.admin.show', $event->id) }}" class="btn btn-sm btn-outline-primary" title="Ver" aria-label="Ver">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('environment_events.admin.edit', $event->id) }}" class="btn btn-sm btn-outline-secondary" title="Editar" aria-label="Editar">
                                <i class="fas fa-edit"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">
                            <div class="text-center py-4">
                                <i class="far fa-folder-open fa-4x text-muted"></i>
                                <p class="mt-3 mb-0 text-muted">No hay eventos registrados.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center mt-3">
        {{ $events->links('pagination::bootstrap-5') }}
    </div>
</div>
