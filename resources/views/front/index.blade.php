@extends('front.layouts.app')

@section('content')
    <div class="container">
        @if (!empty($headerbands))
            <div class="row justify-content-center mt-4">
                <div class="col-md-12">
                    <div class="d-flex gap-4">
                        @foreach ($headerbands as $hb)
                            <style type="text/css">
                                .headerband-{{ Str::slug($hb->title) }} {
                                    background-color: {{ $hb->hex_background }} !important;
                                    color: {{ $hb->hex_text }} !important;
                                }

                                .headerband {
                                    padding: 15px 25px;
                                    width: 100%;
                                }

                                .headerband h6 {
                                    letter-spacing: -1px;
                                }
                            </style>

                            <div class="col card headerband headerband-{{ Str::slug($hb->title) }}">
                                <div class=" d-flex align-items-center justify-content-center">
                                    <h6 class="mb-0 me-3">{{ $hb->title }}</h6>
                                    {!! $hb->text !!}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        <div class="row justify-content-center">
            <div class="col-md-8">
                @if (!empty($banners))
                    <div class="owl-carousel owl-theme main-carousel h-100">
                        @foreach ($banners as $banner)
                            <div class="item main-banner banner-{{ $banner->id }} h-100">
                                <div class="card card-image card-image-banner wow fadeInUp h-100">
                                    <img class="card-img-top desktop-banner"
                                        src="{{ asset('front/img/banners/' . $banner->image) }}" alt="">
                                    <img class="card-img-top responsive-banner"
                                        src="{{ asset('front/img/banners/' . $banner->image_responsive) }}" alt="">

                                    <div class="overlay"></div>
                                    <div class="card-content">
                                        <h2>{{ $banner->title }}</h2>
                                        <p>{{ $banner->subtitle }}</p>

                                        @if ($banner->has_button == true)
                                            <a href="{{ $banner->link }}" class="btn btn-primary"
                                                style="background-color: {{ $banner->hex_button ?? 'black' }} !important; color:{{ $banner->hex_text_button ?? 'white' }} !important; border: {{ $banner->hex_button }} !important;">{{ $banner->text_button }}</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="card card-image card-image-banner wow fadeInUp h-100">
                        <img class="card-img-top" src="{{ asset('front/img/placeholder.jpg') }}" alt="">
                        <div class="overlay"></div>
                        <div class="card-content">
                            <h2>Un gobierno de ciudadanos <br> para ciudadanos</h2>
                            <p>¡Un valle para todos! se construye mejorando la transparencia y facilitando el acceso de los
                                ciudadanos a su gestión con el gobierno y la información pública</p>
                        </div>
                    </div>
                @endif
            </div>

            <div class="col-md-4 mb-4">
                <div id="calendar" class="wow fadeInUp"></div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card card-normal wow fadeInUp">
                    <div class="card-title">
                        <div class="d-flex gap-3">
                            <div class="card-icon bg-primary text-white d-flex align-items-center justify-content-center">
                                <ion-icon name="documents-outline"></ion-icon>
                            </div>
                            <h3>Gaceta Municipal</h3>
                        </div>
                        <p class="card-title-description mb-0">Entérate aquí de las decisiones tomadas por las y los
                            integrantes del H. Ayuntamiento</p>
                    </div>

                    <div class="row w-100">
                        <div class="col-md-4 mb-4 mb-md-0">
                            <a href="{{ route('gazette.list', 'ordinary') }}" class="folder-card folder-green">
                                <div class="folder-head"></div>
                                <div class="folder-body">
                                    <div class="folder-document"></div>
                                    <div class="folder-document"></div>
                                </div>
                                <div class="folder-overlay"></div>
                                <div class="folder-text">
                                    <div class="d-flex align-items-start justify-content-between">
                                        <h6>Sesiones Ordinarias <br> H. Ayuntamiento 2024-2027</h6>
                                        <div
                                            class="card-icon bg-white text-dark d-flex align-items-center justify-content-center">
                                            <ion-icon name="arrow-forward-outline"></ion-icon>
                                        </div>
                                    </div>
                                    <p class="mb-0"><strong>{{ $ordinary_gazette_sessions }}</strong></p>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-4 mb-4 mb-md-0">
                            <a href="{{ route('gazette.list', 'solemn') }}" class="folder-card folder-yellow">
                                <div class="folder-head"></div>
                                <div class="folder-body">
                                    <div class="folder-document"></div>
                                    <div class="folder-document"></div>
                                </div>
                                <div class="folder-overlay"></div>
                                <div class="folder-text">
                                    <div class="d-flex align-items-start justify-content-between">
                                        <h6>Sesiones Solemnes <br> H. Ayuntamiento 2024-2027</h6>
                                        <div
                                            class="card-icon bg-white text-dark d-flex align-items-center justify-content-center">
                                            <ion-icon name="arrow-forward-outline"></ion-icon>
                                        </div>
                                    </div>
                                    <p class="mb-0"><strong>{{ $solemn_gazette_sessions }}</strong></p>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-4 mb-3 mb-md-0">
                            <a href="{{ route('gazette.list', 'extraordinary') }}" class="folder-card folder-blue">
                                <div class="folder-head"></div>
                                <div class="folder-body">
                                    <div class="folder-document"></div>
                                </div>
                                <div class="folder-overlay"></div>
                                <div class="folder-text">
                                    <div class="d-flex align-items-start justify-content-between">
                                        <h6>Sesiones Extraordinarias <br> H. Ayuntamiento 2024-2027</h6>
                                        <div
                                            class="card-icon bg-white text-dark d-flex align-items-center justify-content-center">
                                            <ion-icon name="arrow-forward-outline"></ion-icon>
                                        </div>
                                    </div>
                                    <p class="mb-0"><strong>{{ $extraordinary_gazette_sessions }}</strong></p>
                                </div>
                            </a>
                        </div>
                    </div>

                    <a href="{{ route('gazette.list', 'all') }}"
                        class="btn btn-secondary d-flex align-items-center gap-2">Acceder a todo el archivo <ion-icon
                            name="caret-forward-outline"></ion-icon></a>
                </div>
            </div>
        </div>


        <!-- Dependencias -->
        <div class="row">
            <div class="col-md-6 mb-4">
                @php
                    $transparency_dependency = App\Models\TransparencyDependency::where(
                        'slug',
                        'unidad-de-transparencia-y-acceso-a-la-informacion',
                    )->first();
                @endphp

                @if ($transparency_dependency->image_cover != null)
                    <a href="{{ route('transparency.index') }}"
                        class="card link-card card-image card-alignment-bottom wow fadeInUp h-100">
                        <img src="{{ asset('images/dependencies/' . $transparency_dependency->image_cover) }}"
                            class="card-img-top" alt="Portada de {{ $transparency_dependency->name }}">
                        <div class="overlay"></div>

                        <div class="card-icon bg-white text-dark d-flex align-items-center justify-content-center">
                            <ion-icon name="arrow-forward-outline" class="md hydrated"></ion-icon>
                        </div>

                        <div class="card-content">
                            <img src="{{ asset('images/dependencies/' . $transparency_dependency->logo) }}"
                                class="card-logo mb-3" alt="Logotipo de {{ $transparency_dependency->name }}"
                                style="height: 80px;">
                            <h4>{{ $transparency_dependency->name }}</h4>
                            <p class="mb-0">{{ $transparency_dependency->description }}</p>
                        </div>
                    </a>
                @endif
            </div>

            @foreach ($dependencies as $dependency)
                <div class="col-md-6" style="margin-bottom: 30px;">
                    @if ($dependency->image_cover != null)
                        <a href="{{ route('dependency.detail', $dependency->slug) }}"
                            class="card link-card card-image card-alignment-bottom wow fadeInUp h-100">
                            <img src="{{ asset('images/dependencies/' . $dependency->image_cover) }}"
                                class="card-img-top" alt="Portada de {{ $dependency->name }}">
                            <div class="overlay"></div>

                            <div class="card-icon bg-white text-dark d-flex align-items-center justify-content-center">
                                <ion-icon name="arrow-forward-outline" class="md hydrated"></ion-icon>
                            </div>

                            <div class="card-content">
                                <img src="{{ asset('images/dependencies/' . $dependency->logo) }}" class="card-logo mb-3"
                                    alt="Logotipo de {{ $dependency->name }}" style="height: 80px;">
                                <h4>{{ $dependency->name }}</h4>
                                <p class="mb-0">{{ $dependency->description }}</p>
                            </div>
                        </a>
                    @else
                        <a href="{{ route('dependency.detail', $dependency->slug) }}"
                            class="card link-card card-normal card-alignment-bottom wow fadeInUp h-100">
                            <div class="card-icon bg-white text-dark d-flex align-items-center justify-content-center">
                                <ion-icon name="arrow-forward-outline" class="md hydrated"></ion-icon>
                            </div>

                            <div class="card-content">
                                <img src="{{ asset('images/dependencies/' . $dependency->logo) }}" class="card-logo mb-3"
                                    alt="Logotipo de {{ $dependency->name }}" style="height: 80px;">

                                <h4>{{ $dependency->name }}</h4>
                                <p class="mb-0">{{ $dependency->description }}</p>
                            </div>
                        </a>
                    @endif
                </div>
            @endforeach
        </div>

        <!--Agenda Regulatoria -->
        <div href="{{ route('urban_dev.index') }}"
            class="card card-image card-alignment-bottom wow fadeInUp h-100 d-block">
            <img src="{{ asset('front/img/placeholder-3.jpg') }}" class="card-img-top"
                alt="Portada de Desarrollo Urbano">
            <div class="overlay"></div>

            <div class="card-content">
                <h2 style="padding-top: 120px;">Agenda Regulatoria</h2>
                <p class="mb-4">Son las propuestas de regulaciones que los sujetos obligados pretenden expedir.</p>
                <a href="{{ route('regulatory-agenda.index') }}"
                    class="btn btn-secondary d-flex align-items-center gap-2 mb-4 mb-md-0"
                    style="width: fit-content">Acceder a directorio de Dependencias <ion-icon
                        name="caret-forward-outline"></ion-icon></a>
            </div>
        </div>

        <a href="{{ route('urban_dev.index') }}"
            class="card link-card card-image card-alignment-bottom wow fadeInUp h-100">
            <img src="{{ asset('front/img/placeholder-6.jpg') }}" class="card-img-top"
                alt="Portada de Desarrollo Urbano">
            <div class="overlay"></div>

            <div class="card-icon bg-white text-dark d-flex align-items-center justify-content-center">
                <ion-icon name="arrow-forward-outline" class="md hydrated"></ion-icon>
            </div>

            <div class="card-content">
                <h2 style="padding-top: 120px;">Desarrollo Urbano</h2>
                <p class="mb-0">Conoce los trámites que impulsan el desarrollo urbano en nuestro municipio.</p>
            </div>
        </a>

        <div class="row">
            <div class="col-md-6">
                <a href="{{ route('casa_mujer.index') }}"
                    class="card link-card card-image card-alignment-bottom wow fadeInUp h-100">
                    <img src="{{ asset('front/img/mujer-placeholder.jpg') }}" class="card-img-top"
                        alt="Portada de Desarrollo Urbano">
                    <div class="overlay"></div>

                    <div class="card-icon bg-white text-dark d-flex align-items-center justify-content-center">
                        <ion-icon name="arrow-forward-outline" class="md hydrated"></ion-icon>
                    </div>

                    <div class="card-content">
                        <h2>Casa de la Mujer</h2>
                        <p class="mb-0">Un espacio donde nos reconocemos unas a otras y ejercemos un poder transformador
                            que da testimonio de nuestra ciudadanía en la reivindicación de nuestros derechos, para que
                            ninguna se quede atrás.</p>
                    </div>
                </a>
            </div>
            <div class="col-md-6">
                <a href="{{ route('desarrollo_institucional.index') }}"
                    class="card link-card card-image card-alignment-bottom wow fadeInUp h-100">
                    <img src="{{ asset('front/img/placeholder.jpg') }}" class="card-img-top"
                        alt="Portada de Desarrollo Urbano">
                    <div class="overlay"></div>

                    <div class="card-icon bg-white text-dark d-flex align-items-center justify-content-center">
                        <ion-icon name="arrow-forward-outline" class="md hydrated"></ion-icon>
                    </div>

                    <div class="card-content">
                        <h2>Desarrollo Institucional</h2>
                        <p class="mb-0">Valle de Santiago busca modernizar la administración pública municipal, hacerla
                            más eficiente y transparente, y generar un entorno favorable para el desarrollo económico y el
                            bienestar de sus habitantes.</p>
                    </div>
                </a>
            </div>
        </div>

        <!--IMPLAN-->
<<<<<<< HEAD
        <a href="{{ route('implan.index') }}"
            class="card link-card card-image card-alignment-bottom wow fadeInUp h-100 mt-4">
            <img src="{{ asset('front/img/placeholder-6.jpg') }}" class="card-img-top"
=======
        <a href="{{ route('implan.index') }}" class="card link-card card-image card-alignment-bottom wow fadeInUp h-100 mt-5">
            <img src="{{ asset('front/img/placeholder-7.jpg') }}" class="card-img-top"
>>>>>>> 1e1046704d0773ce8f3ea6490fe3e32f37892581
                alt="Portada de Desarrollo Urbano">
            <div class="overlay"></div>

            <div class="card-icon bg-white text-dark d-flex align-items-center justify-content-center">
                <ion-icon name="arrow-forward-outline" class="md hydrated"></ion-icon>
            </div>

            <div class="card-content">
                <h2 style="padding-top: 120px;">Instituto Municipal de Planeación</h2>
            </div>
        </a>
    </div>

    @if (!empty($popup))
        <div class="modal fade valle-popup-modal" id="vallePopupModal" tabindex="-1"
            aria-labelledby="vallePopupModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                    <div class="modal-body">
                        @if ($popup->image == null)
                        @else
                            <div class="valle-modal-image">
                                <img class="img-fluid" src="{{ asset('front/img/popups/' . $popup->image) }}"
                                    alt="">
                            </div>
                        @endif

                        <div class="valle-info-wrap">
                            <h3>{{ $popup->title }}</h3>

                            @if ($popup->subtitle != null)
                                <h5>{{ $popup->subtitle }}</h5>
                            @endif

                            <p>{{ $popup->text }}</p>

                            @if ($popup->has_button == true)
                                <a href="{{ $popup->link }}" class="btn btn-primary mt-4">{{ $popup->text_button }}</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @push('scripts')
            @if ($popup->show_on_enter == true)
                <script type="text/javascript">
                    if (document.cookie.indexOf('modal=modal_shown') >= 0) {

                    } else {
                        var vallePopupModal = new bootstrap.Modal(document.getElementById('vallePopupModal'), {
                            keyboard: false
                        });

                        vallePopupModal.show();
                        document.cookie = ('modal=modal_shown');
                    }
                </script>
            @endif

            @if ($popup->show_on_exit == true)
                <script type="text/javascript">
                    if (document.cookie.indexOf('modal=modal_shown') >= 0) {

                    } else {
                        $("html").bind("mouseleave", function() {
                            var vallePopupModal = new bootstrap.Modal(document.getElementById('vallePopupModal'), {
                                keyboard: false
                            });

                            vallePopupModal.show();
                            $("html").unbind("mouseleave");
                        });

                        document.cookie = ('modal=modal_shown');
                    }
                </script>
            @endif
        @endpush
    @endif
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('libs/owl-carousel/dist/assets/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/owl-carousel/dist/assets/owl.theme.default.min.css') }}">

    <link rel="stylesheet" href="{{ asset('front/css/calendar.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('libs/owl-carousel/dist/owl.carousel.min.js') }}"></script>

    <script>
        $('.main-carousel').owlCarousel({
            loop: false,
            margin: 0,
            nav: true,
            dots: false,
            items: 1,
        });
    </script>

    <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.5.1/moment.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.5.1/lang/es.js"></script>

    <script>
        ! function() {
            // Configurar Moment.js para usar español
            moment.lang('es');
            var today = moment();

            function Calendar(selector, events) {
                this.el = document.querySelector(selector);
                this.events = events;
                this.current = moment().date(1);
                this.isAnimating = false; // Añadimos esta propiedad para controlar el estado de la animación
                this.draw();
                var current = document.querySelector('.today');
                if (current) {
                    var self = this;
                    window.setTimeout(function() {
                        self.openDay(current);
                    }, 500);
                }
            }

            Calendar.prototype.draw = function() {
                //Crear titular
                this.drawHeader();

                //Crear el més
                this.drawMonth();
            }

            Calendar.prototype.drawHeader = function() {
                var self = this;
                if (!this.header) {
                    //Crear los elementos de la cabecera
                    this.header = createElement('div', 'cal-header');
                    this.header.className = 'cal-header';

                    this.title = createElement('h1');

                    var right = createElement('div', 'right');
                    right.addEventListener('click', function() {
                        self.nextMonth();
                    });

                    var left = createElement('div', 'left');
                    left.addEventListener('click', function() {
                        self.prevMonth();
                    });

                    //Adendo de los elementos
                    this.header.appendChild(this.title);
                    this.header.appendChild(right);
                    this.header.appendChild(left);
                    this.el.appendChild(this.header);
                }

                this.title.innerHTML = this.current.format('MMMM YYYY');
            }

            Calendar.prototype.drawMonth = function() {
                var self = this;

                if (this.month) {
                    this.oldMonth = this.month;
                    this.oldMonth.className = 'month out ' + (self.next ? 'next' : 'prev');

                    // Bandera de estatus para controlar la ejecución única de handleAnimationEnd
                    var animationEndExecuted = false;

                    var handleAnimationEnd = function() {
                        // Evitar ejecuciones múltiples
                        if (animationEndExecuted) return;
                        animationEndExecuted = true;

                        // Verificar si oldMonth y su parentNode todavía existen
                        if (self.oldMonth && self.oldMonth.parentNode) {
                            self.oldMonth.parentNode.removeChild(self.oldMonth);
                        }

                        // Crear nuevo mes y configurar su contenido
                        self.month = createElement('div', 'month');
                        self.el.appendChild(self.month);
                        self.backFill();
                        self.currentMonth();
                        self.fowardFill();

                        // Aplicar la clase después de un pequeño retraso para asegurar que el DOM se haya actualizado
                        requestAnimationFrame(function() {
                            self.month.className = 'month in ' + (self.next ? 'next' : 'prev');
                        });
                    };

                    // Agregar listeners de eventos para diferentes navegadores
                    this.oldMonth.addEventListener('webkitAnimationEnd', handleAnimationEnd, {
                        once: true
                    });
                    this.oldMonth.addEventListener('oanimationend', handleAnimationEnd, {
                        once: true
                    });
                    this.oldMonth.addEventListener('msAnimationEnd', handleAnimationEnd, {
                        once: true
                    });
                    this.oldMonth.addEventListener('animationend', handleAnimationEnd, {
                        once: true
                    });

                    // Fallback por si la animación no se ejecuta correctamente
                    // Usamos un tiempo más largo para dar tiempo a que las animaciones terminen naturalmente
                    setTimeout(handleAnimationEnd, 600);
                } else {
                    // Inicialización del primer mes
                    this.month = createElement('div', 'month');
                    this.el.appendChild(this.month);
                    this.backFill();
                    this.currentMonth();
                    this.fowardFill();

                    // Aplicar la clase new para la animación inicial
                    requestAnimationFrame(function() {
                        self.month.className = 'month new';
                    });
                }
            }

            Calendar.prototype.backFill = function() {
                var clone = this.current.clone();
                var dayOfWeek = clone.day();

                if (!dayOfWeek) {
                    return;
                }

                clone.subtract('days', dayOfWeek + 1);

                for (var i = dayOfWeek; i > 0; i--) {
                    this.drawDay(clone.add('days', 1));
                }
            }

            Calendar.prototype.fowardFill = function() {
                var clone = this.current.clone().add('months', 1).subtract('days', 1);
                var dayOfWeek = clone.day();

                if (dayOfWeek === 6) {
                    return;
                }

                for (var i = dayOfWeek; i < 6; i++) {
                    this.drawDay(clone.add('days', 1));
                }
            }

            Calendar.prototype.currentMonth = function() {
                var clone = this.current.clone();

                while (clone.month() === this.current.month()) {
                    this.drawDay(clone);
                    clone.add('days', 1);
                }
            }

            Calendar.prototype.getWeek = function(day) {
                if (!this.week || day.day() === 0) {
                    this.week = createElement('div', 'week');
                    this.month.appendChild(this.week);
                }
            }

            Calendar.prototype.drawDay = function(day) {
                var self = this;
                this.getWeek(day);

                //Outer Day
                var outer = createElement('div', this.getDayClass(day));
                outer.addEventListener('click', function() {
                    self.openDay(this);
                });

                //Day Name
                var name = createElement('div', 'day-name', day.format('ddd'));

                //Day Number
                var number = createElement('div', 'day-number', day.format('DD'));


                //Events
                var events = createElement('div', 'day-events');
                this.drawEvents(day, events);

                outer.appendChild(name);
                outer.appendChild(number);
                outer.appendChild(events);
                this.week.appendChild(outer);
            }

            Calendar.prototype.drawEvents = function(day, element) {
                if (day.month() === this.current.month()) {
                    if (!this.events || !Array.isArray(this.events)) {
                        console.error('Lista de eventos no válida en drawEvents');
                        return;
                    }

                    var todaysEvents = this.events.reduce(function(memo, ev) {
                        if (ev.date && ev.date.isSame && ev.date.isSame(day, 'day')) {
                            memo.push(ev);
                        }
                        return memo;
                    }, []);

                    // Agregar clase 'has-events' al día si hay eventos
                    if (todaysEvents.length > 0) {
                        element.classList.add('has-events');
                    }

                    // Limitar a máximo 3 indicadores visuales para no sobrecargar el UI
                    var maxIndicators = Math.min(todaysEvents.length, 3);

                    for (var i = 0; i < maxIndicators; i++) {
                        var ev = todaysEvents[i];
                        var evSpan = createElement('span', 'event-indicator ' + (ev.color || 'primary'));
                        element.appendChild(evSpan);
                    }

                    // Si hay más eventos de los que mostramos, agregar indicador "+"
                    if (todaysEvents.length > maxIndicators) {
                        var moreEventsSpan = createElement('span', 'more-events', '+' + (todaysEvents.length -
                            maxIndicators));
                        element.appendChild(moreEventsSpan);
                    }
                }
            }

            Calendar.prototype.getDayClass = function(day) {
                classes = ['day'];
                if (day.month() !== this.current.month()) {
                    classes.push('other');
                } else if (today.isSame(day, 'day')) {
                    classes.push('today');
                }
                return classes.join(' ');
            }

            Calendar.prototype.openDay = function(el) {
                if (!el || !el.querySelector) {
                    console.error('El elemento del día no es válido');
                    return;
                }

                var details, arrow;
                var dayNumberElement = el.querySelector('.day-number');

                if (!dayNumberElement) {
                    console.error('No se encontró el elemento número de día');
                    return;
                }

                var dayNumber = +dayNumberElement.innerText || +dayNumberElement.textContent;
                if (!dayNumber) {
                    console.error('No se pudo determinar el número del día');
                    return;
                }

                var day = this.current.clone().date(dayNumber);
                var weekRow = el.parentNode;
                var calendar = document.getElementById('calendar');

                if (!calendar) {
                    console.error('No se encontró el elemento calendario');
                    return;
                }

                var currentOpened = document.querySelector('.details');

                // Remover cualquier panel de detalles existente
                if (currentOpened) {
                    var removeCurrentOpened = function() {
                        if (currentOpened && currentOpened.parentNode) {
                            currentOpened.parentNode.removeChild(currentOpened);
                        }
                    };

                    currentOpened.addEventListener('webkitAnimationEnd', removeCurrentOpened);
                    currentOpened.addEventListener('oanimationend', removeCurrentOpened);
                    currentOpened.addEventListener('msAnimationEnd', removeCurrentOpened);
                    currentOpened.addEventListener('animationend', removeCurrentOpened);

                    // Si la animación no se activa por alguna razón, eliminamos después de 500ms
                    setTimeout(removeCurrentOpened, 500);

                    currentOpened.className = 'details out';
                }

                //Create the Details Container
                details = createElement('div', 'details in');

                //Create the arrow
                arrow = createElement('div', 'arrow');

                //Create the event wrapper
                details.appendChild(arrow);

                // Insertar el detalle en el lugar correcto
                if (weekRow && weekRow.parentNode) {
                    // Primero, aseguremos que el weekRow es un nodo dentro del calendario
                    var monthElement = weekRow.closest('.month');
                    if (monthElement) {
                        // Si hay un siguiente elemento después de la semana actual, insertar antes de él
                        var nextElement = weekRow.nextElementSibling;
                        if (nextElement && nextElement.parentNode === weekRow.parentNode) {
                            weekRow.parentNode.insertBefore(details, nextElement);
                        } else {
                            // Si no hay un siguiente elemento, agregar al final de la semana
                            weekRow.parentNode.appendChild(details);
                        }
                    } else {
                        // Si no encontramos el elemento month, agregamos al calendario directamente
                        calendar.appendChild(details);
                    }
                } else {
                    // Si por alguna razón no hay una semana válida, agregamos al calendario
                    calendar.appendChild(details);
                }

                var todaysEvents = this.events.reduce(function(memo, ev) {
                    if (ev.date.isSame(day, 'day')) {
                        memo.push(ev);
                    }
                    return memo;
                }, []);

                this.renderEvents(todaysEvents, details);

                // Calcular la posición centrada del día seleccionado
                if (el && arrow) {
                    var dayWidth = el.offsetWidth;
                    var dayLeft = el.getBoundingClientRect().left - calendar.getBoundingClientRect().left;
                    var arrowPosition = dayLeft + (dayWidth / 2);

                    // Posicionar la flecha centrada en el día seleccionado
                    arrow.style.left = arrowPosition + 'px';
                }
            }

            Calendar.prototype.renderEvents = function(events, ele) {
                if (!ele) {
                    console.error('Elemento contenedor de eventos no válido');
                    return;
                }

                //Remove any events in the current details element
                var currentWrapper = ele.querySelector('.events');
                var wrapper = createElement('div', 'events in' + (currentWrapper ? ' new' : ''));

                if (!events || !Array.isArray(events)) {
                    console.error('Lista de eventos no válida');
                    events = [];
                }

                events.forEach(function(ev) {
                    var div = createElement('div', 'event');
                    var square = createElement('div', 'event-category ' + ev.color);
                    var eventContent = createElement('div', 'event-content');

                    // Nombre del evento
                    var eventName = createElement('div', 'event-name', ev.eventName || 'Sin nombre');

                    // Hora del evento
                    var eventTime = createElement('div', 'event-time', ev.eventDateTime || '');

                    // Ubicación
                    var eventLocation = createElement('div', 'event-location', ev.eventLocation || '');

                    eventContent.appendChild(eventName);
                    eventContent.appendChild(eventTime);
                    eventContent.appendChild(eventLocation);

                    // URL del blog (al final para mejor organización visual)
                    if (ev.eventUrl) {
                        var eventUrl = createElement('a', 'event-url');
                        eventUrl.href = ev.eventUrl;
                        eventUrl.target = '_blank';
                        eventUrl.textContent = 'Conoce más';
                        eventContent.appendChild(eventUrl);
                    }

                    div.appendChild(square);
                    div.appendChild(eventContent);
                    wrapper.appendChild(div);
                });

                if (!events.length) {
                    var div = createElement('div', 'event empty');
                    var span = createElement('span', '', 'No hay eventos');

                    div.appendChild(span);
                    wrapper.appendChild(div);
                }

                // Función para añadir el wrapper al elemento contenedor
                var appendWrapper = function() {
                    if (ele && wrapper) {
                        ele.appendChild(wrapper);
                    }
                };

                if (currentWrapper) {
                    currentWrapper.className = 'events out';

                    // Función unificada para eliminar el wrapper anterior
                    var handleAnimationEnd = function() {
                        if (currentWrapper && currentWrapper.parentNode) {
                            currentWrapper.parentNode.removeChild(currentWrapper);
                            appendWrapper();
                        }
                    };

                    currentWrapper.addEventListener('webkitAnimationEnd', handleAnimationEnd);
                    currentWrapper.addEventListener('oanimationend', handleAnimationEnd);
                    currentWrapper.addEventListener('msAnimationEnd', handleAnimationEnd);
                    currentWrapper.addEventListener('animationend', handleAnimationEnd);

                    // Fallback por si la animación no se ejecuta
                    setTimeout(handleAnimationEnd, 500);
                } else {
                    appendWrapper();
                }
            }

            Calendar.prototype.nextMonth = function() {
                // Evita múltiples clics rápidos durante la animación
                if (this.isAnimating) return;
                this.isAnimating = true;

                var self = this;
                this.current.add('months', 1);
                this.next = true;

                // Aplicar una clase al contenedor principal durante la animación
                if (this.el) this.el.classList.add('calendar-animating');

                this.draw();

                // Restablecer el estado después de un tiempo suficiente para la animación
                setTimeout(function() {
                    self.isAnimating = false;
                    if (self.el) self.el.classList.remove('calendar-animating');
                }, 700); // Un poco más largo para asegurar que la animación se complete
            }

            Calendar.prototype.prevMonth = function() {
                // Evita múltiples clics rápidos durante la animación
                if (this.isAnimating) return;
                this.isAnimating = true;

                var self = this;
                this.current.subtract('months', 1);
                this.next = false;

                // Aplicar una clase al contenedor principal durante la animación
                if (this.el) this.el.classList.add('calendar-animating');

                this.draw();

                // Restablecer el estado después de un tiempo suficiente para la animación
                setTimeout(function() {
                    self.isAnimating = false;
                    if (self.el) self.el.classList.remove('calendar-animating');
                }, 700); // Un poco más largo para asegurar que la animación se complete
            }

            window.Calendar = Calendar;

            function createElement(tagName, className, innerText) {
                var ele = document.createElement(tagName);
                if (className) {
                    ele.className = className;
                }
                if (innerText) {
                    ele.innerText = ele.textContent = innerText;
                }
                return ele;
            }
        }();

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
