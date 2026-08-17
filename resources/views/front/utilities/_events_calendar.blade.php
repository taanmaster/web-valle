{{--
    Widget de calendario de eventos.

    Espera $events: colección cuyos elementos exponen name, date_start,
    location y blog_url. Lo cumplen tanto App\Models\Event (portada
    municipal) como App\Models\EnvironmentEvent (Medio Ambiente), que
    expone `name` como accessor de `title`.

    El prototipo Calendar vive en public/front/js/events-calendar.js.
--}}

<div id="calendar" class="wow fadeInUp"></div>

@push('styles')
    <link rel="stylesheet" href="{{ asset('front/css/calendar.css') }}">
@endpush

@push('scripts')
    <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.5.1/moment.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.5.1/lang/es.js"></script>
    <script src="{{ asset('front/js/events-calendar.js') }}"></script>

    <script>
        ! function() {
            // Asegurarse de que los datos sean válidos
            var data = [
                @foreach ($events as $event)
                    {
                        eventName: '{!! addslashes($event->name) !!}',
                        eventDateTime: '{{ \Carbon\Carbon::parse($event->date_start)->format('H:i') }}',
                        eventLocation: '{!! addslashes($event->location) !!}',
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
        
            // Validar que Moment.js esté disponible
            if (typeof moment !== 'function') {
                console.error('Moment.js no está disponible. El calendario no funcionará correctamente.');
                document.getElementById('calendar').innerHTML =
                    '<div class="alert alert-danger">Error: Moment.js no está disponible. Por favor, recarga la página.</div>';
                return;
            }
        
            // Pre-validar datos antes de inicializar
            if (!Array.isArray(data)) {
                console.error('Los datos proporcionados no son un array válido');
                data = [];
            }
        
            data.forEach(function(event, index) {
                if (event.date && !event.date.isValid()) {
                    console.warn('Evento con fecha inválida en el índice ' + index, event);
                    event.date = moment(); // Dar un valor predeterminado
                }
            });
        
            // Inicializar calendario con manejo de errores
            try {
                var calendar = new Calendar('#calendar', data);
                console.log('Calendario inicializado correctamente con ' + data.length + ' eventos.');
            } catch (error) {
                console.error('Error al inicializar el calendario:', error);
                // Mostrar mensaje de error al usuario
                document.getElementById('calendar').innerHTML =
                    '<div class="alert alert-danger">Error al cargar el calendario. Por favor, recarga la página o contacta al administrador.</div>';
            }
        }();
    </script>
@endpush
