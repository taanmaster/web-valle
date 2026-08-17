/**
 * Widget de calendario de eventos del portal.
 *
 * Extraído de resources/views/front/index.blade.php sin cambios de
 * comportamiento. Lo consume el partial front.utilities._events_calendar,
 * que le pasa los eventos ya serializados.
 *
 * Depende de moment.js (se carga desde el partial).
 */
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
