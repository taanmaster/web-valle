@extends('layouts.master')
@section('title')Intranet @endsection
@section('content')
<!-- this is breadcrumbs -->
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') Eventos @endslot
@slot('title') Eventos @endslot
@endcomponent

<style>
    .text-primary{
        color: #551312;
    }

    .primary{
        background-color: #551312;
    }

    #calendar {
        width: 100%;
        margin: 0 auto;
        height: auto;
        overflow: hidden;
        border-radius: 0.25rem;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        background-color: #fff;
        font-family: var(--bs-body-font-family);
        position: relative; /* Añadido para posicionamiento de elementos hijos */
    }
    
    /* Clase para controlar el estado durante la animación */
    .calendar-animating .month.in {
        opacity: 1 !important; /* Forzar visibilidad durante la animación */
    }

    .cal-header {
        height: 60px;
        width: 100%;
        background: #551312;
        text-align: center;
        position: relative;
        z-index: 100;
        border-radius: 0.25rem 0.25rem 0 0;
    }

    .cal-header h1 {
        margin: 0;
        padding: 0;
        font-size: 24px;
        line-height: 60px;
        font-weight: 500;
        color: #fff;
        text-transform: capitalize;
    }

    .left,
    .right {
        position: absolute;
        width: 40px;
        height: 40px;
        top: 50%;
        margin-top: -20px;
        cursor: pointer;
        border-radius: 50%;
        background-color: rgba(255, 255, 255, 0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background-color 0.3s;
    }

    .left:hover,
    .right:hover {
        background-color: rgba(255, 255, 255, 0.4);
    }

    .left {
        left: 20px;
    }

    .left:before {
        content: '';
        border-width: 8px 10px 8px 0;
        border-style: solid;
        border-color: transparent #fff transparent transparent;
        display: block;
    }

    .right {
        right: 20px;
    }

    .right:before {
        content: '';
        border-width: 8px 0 8px 10px;
        border-style: solid;
        border-color: transparent transparent transparent #fff;
        display: block;
    }

    .month {
        opacity: 0;
        position: relative;
    }

    .month.new {
        animation: fadeIn 0.5s ease-out forwards;
    }

    .month.in {
        opacity: 1; /* Aseguramos que el mes entrante sea visible */
    }

    .month.in.next {
        animation: moveFromTopFadeMonth 0.4s ease-out forwards;
    }

    .month.out.next {
        animation: moveToTopFadeMonth 0.4s ease-in forwards;
    }

    .month.in.prev {
        animation: moveFromBottomFadeMonth 0.4s ease-out forwards;
    }

    .month.out.prev {
        animation: moveToBottomFadeMonth 0.4s ease-in forwards;
    }

    .week {
        background: #f8f9fa;
        display: flex;
        border-bottom: 1px solid #dee2e6;
        margin-bottom: 5px;
        position: relative;
    }

    .day {
        flex: 1;
        padding: 12px;
        text-align: center;
        cursor: pointer;
        position: relative;
        z-index: 100;
        transition: background-color 0.2s;
        border-right: 1px solid #dee2e6;
    }

    .day:last-child {
        border-right: none;
    }

    .day:hover {
        background-color: #e9ecef;
    }

    .day.other {
        color: #adb5bd;
    }

    .day.today {
        background-color: rgba(var(--bs-primary-rgb), 0.1);
        font-weight: bold;
    }

    .day-name {
        font-size: 0.75rem;
        text-transform: uppercase;
        margin-bottom: 5px;
        color: #6c757d;
        font-weight: 500;
    }

    .day-number {
        font-size: 1.5rem;
        font-weight: 400;
    }

    .day .day-events {
        list-style: none;
        margin: 5px 0 0;
        padding: 0;
        text-align: center;
        height: 12px;
        line-height: 6px;
        overflow: hidden;
        display: flex;
        justify-content: center;
    }

    .day .day-events span {
        display: inline-block;
        width: 6px;
        height: 6px;
        border-radius: 50%;
        margin: 0 1px;
    }

    .primary {
        background: #551312;
    }
    .success {
        background: var(--bs-success);
    }
    .info {
        background: var(--bs-info);
    }
    .warning {
        background: var(--bs-warning);
    }
    .danger {
        background: var(--bs-danger);
    }

    .details {
        position: relative;
        width: 100%;
        min-height: 120px;
        background: #fff;
        margin: 10px 0;
        border-radius: 0.25rem;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        border: 1px solid #dee2e6;
        clear: both;
        overflow: hidden;
        display: block;
        z-index: 200;
    }

    .details.in {
        animation: moveFromTopFade 0.5s ease forwards;
    }

    .details.out {
        animation: moveToTopFade 0.5s ease forwards;
        display: none;
    }

    .arrow {
        position: absolute;
        top: -10px;
        width: 0;
        height: 0;
        border-style: solid;
        border-width: 0 10px 10px 10px;
        border-color: transparent transparent #fff transparent;
        filter: drop-shadow(0px -2px 1px rgba(0,0,0,0.1));
    }

    .events {
        padding: 15px;
        overflow-y: auto;
        max-height: 250px;
    }

    .events.in {
        animation: fadeIn 0.3s ease both;
        animation-delay: 0.3s;
    }

    .details.out .events {
        animation: fadeOutShrink 0.4s ease forwards;
    }

    .events.out {
        animation: fadeOut 0.3s ease forwards;
    }

    .event {
        display: flex;
        align-items: flex-start;
        padding: 10px 15px;
        border-radius: 0.25rem;
        margin-bottom: 10px;
        background-color: rgba(var(--bs-primary-rgb), 0.05);
        border-left: 4px solid #551312;
    }

    .event:last-child {
        margin-bottom: 0;
    }

    .event.empty {
        color: #6c757d;
        justify-content: center;
    }

    .event-category {
        height: 12px;
        width: 12px;
        border-radius: 50%;
        margin: 5px 0 0;
    }

    .event-content {
        margin-left: 10px;
        flex: 1;
    }

    .event-name {
        font-weight: 500;
        font-size: 1rem;
        color: #212529;
        margin-bottom: 2px;
    }

    .event-time {
        font-size: 0.875rem;
        color: #6c757d;
        margin-bottom: 2px;
    }

    .event-location {
        font-size: 0.875rem;
        color: #6c757d;
        margin-bottom: 4px;
    }

    .event-url {
        display: inline-block;
        font-size: 0.875rem;
        color: #551312;
        text-decoration: none;
        padding: 2px 0;
    }

    .event-url:hover {
        text-decoration: underline;
    }

    /* Estilos para los indicadores de eventos */
    .day.has-events {
        position: relative;
    }
    
    .event-indicator {
        display: inline-block;
        width: 6px;
        height: 6px;
        border-radius: 50%;
        margin: 0 1px;
    }
    
    .more-events {
        display: inline-block;
        font-size: 10px;
        color: #6c757d;
        margin-left: 2px;
    }
    
    /* Mejoras para dispositivos móviles */
    @media (max-width: 576px) {
        .day-name {
            font-size: 0.65rem;
        }
        
        .day-number {
            font-size: 1.2rem;
        }
        
        .day {
            padding: 8px 4px;
        }
        
        .event-name {
            font-size: 0.9rem;
        }
    }
    
    /* Animación suave al hacer hover en días con eventos */
    .day.has-events:hover {
        background-color: rgba(var(--bs-primary-rgb), 0.1);
        transition: background-color 0.3s ease;
    }

    @keyframes moveFromTopFade {
        from {
            opacity: 0;
            max-height: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            max-height: 500px;
            transform: translateY(0);
        }
    }

    @keyframes moveToTopFade {
        from {
            opacity: 1;
            max-height: 500px;
        }
        to {
            opacity: 0;
            max-height: 0;
            transform: translateY(-20px);
        }
    }

    @keyframes moveToTopFadeMonth {
        to {
            opacity: 0;
            transform: translateY(-30%) scale(0.95);
        }
    }

    @keyframes moveFromTopFadeMonth {
        from {
            opacity: 0;
            transform: translateY(30%) scale(0.95);
        }
        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    @keyframes moveToBottomFadeMonth {
        to {
            opacity: 0;
            transform: translateY(30%) scale(0.95);
        }
    }

    @keyframes moveFromBottomFadeMonth {
        from {
            opacity: 0;
            transform: translateY(-30%) scale(0.95);
        }
        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
            visibility: visible; /* Asegurar que el elemento sea visible */
        }
    }

    @keyframes fadeOut {
        from {
            opacity: 1;
        }
        to {
            opacity: 0;
        }
    }

    @keyframes fadeOutShrink {
        to {
            opacity: 0;
            padding: 0;
            height: 0;
        }
    }
</style>

<!-- Contenedor principal del calendario -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <!-- Sección de filtros y búsqueda -->
                <div class="row mb-4">
                    {{--  
                    <div class="col-md-8">
                        <form action="{{ route('events.index') }}" method="GET" class="row g-3">
                            <div class="col-md-4">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Buscar eventos..." name="search" value="{{ request('search') }}">
                                    <button class="btn btn-outline-secondary" type="submit">
                                        <i class="bx bx-search"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <select class="form-select" name="status">
                                    <option value="">Todos los estados</option>
                                    <option value="upcoming" {{ request('status') == 'upcoming' ? 'selected' : '' }}>Próximos</option>
                                    <option value="ongoing" {{ request('status') == 'ongoing' ? 'selected' : '' }}>En curso</option>
                                    <option value="past" {{ request('status') == 'past' ? 'selected' : '' }}>Finalizados</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-secondary">Filtrar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    --}}
                    <div class="col-md-4 text-start">
                        <a href="{{ route('events.create') }}" class="btn btn-primary">
                            <i class="bx bx-plus me-1"></i> Crear Evento
                        </a>
                    </div>
                </div>

                <div id="calendar"></div>
                
                @include('events.utilities._table')
            </div>
        </div>
    </div>
</div>

<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.5.1/moment.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.5.1/lang/es.js"></script>

<script>
    !function() {
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
            if(current) {
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
            if(!this.header) {
            //Crear los elementos de la cabecera
            this.header = createElement('div', 'cal-header');
            this.header.className = 'cal-header';

            this.title = createElement('h1');

            var right = createElement('div', 'right');
            right.addEventListener('click', function() { self.nextMonth(); });

            var left = createElement('div', 'left');
            left.addEventListener('click', function() { self.prevMonth(); });

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
            
            if(this.month) {
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
                this.oldMonth.addEventListener('webkitAnimationEnd', handleAnimationEnd, { once: true });
                this.oldMonth.addEventListener('oanimationend', handleAnimationEnd, { once: true });
                this.oldMonth.addEventListener('msAnimationEnd', handleAnimationEnd, { once: true });
                this.oldMonth.addEventListener('animationend', handleAnimationEnd, { once: true });
                
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

            if(!dayOfWeek) { return; }

            clone.subtract('days', dayOfWeek+1);

            for(var i = dayOfWeek; i > 0 ; i--) {
            this.drawDay(clone.add('days', 1));
            }
        }

        Calendar.prototype.fowardFill = function() {
            var clone = this.current.clone().add('months', 1).subtract('days', 1);
            var dayOfWeek = clone.day();

            if(dayOfWeek === 6) { return; }

            for(var i = dayOfWeek; i < 6 ; i++) {
            this.drawDay(clone.add('days', 1));
            }
        }

        Calendar.prototype.currentMonth = function() {
            var clone = this.current.clone();

            while(clone.month() === this.current.month()) {
            this.drawDay(clone);
            clone.add('days', 1);
            }
        }

        Calendar.prototype.getWeek = function(day) {
            if(!this.week || day.day() === 0) {
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
            if(day.month() === this.current.month()) {
                if (!this.events || !Array.isArray(this.events)) {
                    console.error('Lista de eventos no válida en drawEvents');
                    return;
                }
                
                var todaysEvents = this.events.reduce(function(memo, ev) {
                    if(ev.date && ev.date.isSame && ev.date.isSame(day, 'day')) {
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
                    var moreEventsSpan = createElement('span', 'more-events', '+' + (todaysEvents.length - maxIndicators));
                    element.appendChild(moreEventsSpan);
                }
            }
        }

        Calendar.prototype.getDayClass = function(day) {
            classes = ['day'];
            if(day.month() !== this.current.month()) {
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
            if(currentOpened) {
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
                if(ev.date.isSame(day, 'day')) {
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
                    eventUrl.textContent = 'Ver más';
                    eventContent.appendChild(eventUrl);
                }
                
                div.appendChild(square);
                div.appendChild(eventContent);
                wrapper.appendChild(div);
            });

            if(!events.length) {
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

            if(currentWrapper) {
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
            if(className) {
            ele.className = className;
            }
            if(innerText) {
            ele.innerText = ele.textContent = innerText;
            }
            return ele;
        }
    }();

    !function() {
        // Asegurarse de que los datos sean válidos
        var data = [
            @foreach($events as $event)
            { 
                eventName: '{!! addslashes($event->name) !!}', 
                eventDateTime: '{{ \Carbon\Carbon::parse($event->date_start)->format('H:i') }}',
                eventLocation: '{!! addslashes($event->location) !!}',
                @if($event->blog_url)
                eventUrl: '{!! addslashes($event->blog_url) !!}',
                @else
                eventUrl: null,
                @endif
                date: moment('{{ $event->date_start }}'),
                color: 'primary'
            }@if(!$loop->last),@endif
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
@endsection