@extends('front.layouts.app')

@section('content')
    <div class="container">
        @include('front.contraloria.utilities._nav')

        <div class="row justify-content-center mb-5">
            <div class="col-md-12">
                <div class="card card-image card-image-banner justify-content-center wow fadeInUp">
                    <img class="card-img-top" src="{{ asset('front/img/placeholder-8.jpg') }}" alt="">
                    <div class="overlay" style="opacity: .4"></div>
                    <div class="card-content text-center w-100">
                        <p class="small-uppercase mb-0">Contraloría Interna Municipal</p>
                        <h1 class="display-1 mb-3">Declaración Patrimonial</h1>
                        <p class="p mb-0 ms-auto me-auto" style="width: 70%;">La declaración patrimonial es el documento mediante el cual los servidores públicos manifiestan los bienes muebles e inmuebles que integran su patrimonio con la finalidad de transparentar su evolución patrimonial y su congruencia que tiene con los ingresos y egresos percibidos en un año.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4 mt-4">
            <div class="col-md-6 mb-3 pe-3">
                {{-- BLOQUE Plazos para presentarla --}}
                <div class="d-flex align-items-center mb-4 wow fadeInUp" style="gap: 12px">
                    <div class="icon bg-success">
                        <ion-icon name="calendar-outline"></ion-icon>
                    </div>
                    <h3 class="mb-0">Plazos para presentarla</h3>
                </div>

                <div class="declaration-timeline">
                    <div class="timeline-item wow fadeInUp" data-step="1">
                        <div class="timeline-number">1</div>
                        <div class="timeline-content">
                            <h5 class="mb-2">Declaración inicial</h5>
                            <p class="mb-0">Dentro de los sesenta días naturales siguientes a la toma de posesión con motivo del: a) Ingreso al servicio público por primera vez; o b) Reingreso al servicio público después de sesenta días naturales de la conclusión de su último encargo.</p>
                        </div>
                    </div>

                    <div class="timeline-item wow fadeInUp" data-step="2">
                        <div class="timeline-number">2</div>
                        <div class="timeline-content">
                            <h5 class="mb-2">Declaración de modificación patrimonial</h5>
                            <p class="mb-0">En el mes de mayo de cada año.</p>
                        </div>
                    </div>

                    <div class="timeline-item wow fadeInUp" data-step="3">
                        <div class="timeline-number">3</div>
                        <div class="timeline-content">
                            <h5 class="mb-2">Declaración Final</h5>
                            <p class="mb-0">Dentro de los sesenta días naturales siguientes a la conclusión del cargo.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-3 ps-3">
                {{-- bloque ¿Qué pasa si no la hago? --}}
                <div class="d-flex align-items-center mb-4 wow fadeInUp" style="gap: 12px">
                    <div class="icon bg-danger">
                        <ion-icon name="alert-circle-outline"></ion-icon>
                    </div>
                    <h3 class="mb-0">¿Qué pasa si no la hago?</h3>
                </div>

                <div class="alert-box danger-alert wow fadeInUp">
                    <div class="alert-icon">
                        <ion-icon name="warning-outline"></ion-icon>
                    </div>
                    <div class="alert-content">
                        <p class="mb-0">En caso de que no realices este trámite, se iniciará un procedimiento de responsabilidad administrativa por la omisión a la presentación de tu declaración; una vez realizada la investigación correspondiente y en caso de existir la falta, se substanciará y resolverá conforme a la Ley.</p>
                    </div>
                </div>

                <div class="card card-normal wow fadeInUp mt-4">
                    <div class="card-content">
                        <h5 class="mb-3">Realiza tu declaración</h5>
                        <p class="mb-3">Accede al sistema DeclaraNet para realizar tu declaración patrimonial de manera electrónica.</p>
                        <a href="https://declaranetmunicipios.strc.guanajuato.gob.mx/#login" target="_blank" class="btn btn-primary w-100">
                            <ion-icon name="open-outline" class="me-2"></ion-icon>
                            Ir a DeclaraNet
                        </a>
                    </div>
                </div>
            </div>
        </div>

        @include('front.contraloria.utilities._footer')
    </div>
@endsection

@push('styles')
<style>
    /* Estilos para la línea de tiempo */
    .declaration-timeline {
        position: relative;
        padding: 20px 0;
    }

    .timeline-item {
        display: flex;
        gap: 20px;
        margin-bottom: 30px;
        position: relative;
        opacity: 0;
        animation: fadeInLeft 0.6s ease-out forwards;
    }

    .timeline-item[data-step="1"] { animation-delay: 0.1s; }
    .timeline-item[data-step="2"] { animation-delay: 0.3s; }
    .timeline-item[data-step="3"] { animation-delay: 0.5s; }

    @keyframes fadeInLeft {
        from {
            opacity: 0;
            transform: translateX(-30px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .timeline-item:not(:last-child)::before {
        content: '';
        position: absolute;
        left: 30px;
        top: 70px;
        width: 2px;
        height: calc(100% + 10px);
        background: linear-gradient(180deg, #4caf50 0%, #81c784 100%);
        z-index: 0;
    }

    .timeline-number {
        min-width: 60px;
        height: 60px;
        background: linear-gradient(135deg, #4caf50 0%, #66bb6a 100%);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        font-weight: bold;
        box-shadow: 0 4px 12px rgba(76, 175, 80, 0.3);
        z-index: 1;
        position: relative;
        transition: all 0.3s ease;
    }

    .timeline-item:hover .timeline-number {
        transform: scale(1.15);
        box-shadow: 0 6px 20px rgba(76, 175, 80, 0.5);
    }

    .timeline-content {
        flex: 1;
        background: white;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        border-left: 4px solid #4caf50;
    }

    .timeline-item:hover .timeline-content {
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        transform: translateY(-5px);
    }

    .timeline-content h5 {
        color: #2c3e50;
        font-weight: 600;
        font-size: 1.1rem;
    }

    .timeline-content p {
        color: #555;
        line-height: 1.6;
        font-size: 0.95rem;
    }

    /* Estilos para el cuadro de alerta */
    .alert-box {
        display: flex;
        gap: 20px;
        padding: 25px;
        border-radius: 12px;
        border: 2px solid #dc3545;
        background: linear-gradient(135deg, #ffe5e8 0%, #fff5f5 100%);
        box-shadow: 0 4px 12px rgba(220, 53, 69, 0.15);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .alert-box::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 5px;
        height: 100%;
        background: linear-gradient(180deg, #dc3545 0%, #c82333 100%);
    }

    .alert-box:hover {
        box-shadow: 0 8px 24px rgba(220, 53, 69, 0.25);
        transform: translateY(-3px);
    }

    .alert-icon {
        min-width: 50px;
        height: 50px;
        background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        box-shadow: 0 4px 12px rgba(220, 53, 69, 0.3);
    }

    .alert-icon ion-icon {
        font-size: 1.8rem;
    }

    .alert-content p {
        color: #721c24;
        line-height: 1.6;
        font-size: 0.95rem;
        margin: 0;
    }

    /* Botón personalizado */
    .btn-primary {
        background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
        border: none;
        padding: 12px 24px;
        font-weight: 600;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0, 123, 255, 0.4);
        background: linear-gradient(135deg, #0056b3 0%, #004085 100%);
    }

    .btn-primary ion-icon {
        font-size: 1.2rem;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .timeline-item {
            gap: 15px;
        }

        .timeline-number {
            min-width: 50px;
            height: 50px;
            font-size: 1.2rem;
        }

        .timeline-item:not(:last-child)::before {
            left: 25px;
            top: 60px;
        }

        .timeline-content {
            padding: 15px;
        }

        .timeline-content h5 {
            font-size: 1rem;
        }

        .timeline-content p {
            font-size: 0.9rem;
        }

        .alert-box {
            flex-direction: column;
            padding: 20px;
            gap: 15px;
        }

        .alert-icon {
            min-width: 45px;
            height: 45px;
            font-size: 1.5rem;
            margin: 0 auto;
        }

        .alert-content p {
            font-size: 0.9rem;
            text-align: center;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Observador de intersección para animaciones al hacer scroll
        const observerOptions = {
            threshold: 0.3,
            rootMargin: '0px 0px -100px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, observerOptions);

        // Observar items de la línea de tiempo
        const timelineItems = document.querySelectorAll('.timeline-item');
        timelineItems.forEach(item => observer.observe(item));

        // Observar la alerta
        const alertBox = document.querySelector('.alert-box');
        if (alertBox) {
            observer.observe(alertBox);
        }

        // Efecto de pulso en el ícono de alerta
        const alertIcon = document.querySelector('.alert-icon');
        if (alertIcon) {
            setInterval(() => {
                alertIcon.style.animation = 'pulse 0.5s ease';
                setTimeout(() => {
                    alertIcon.style.animation = '';
                }, 500);
            }, 3000);
        }

        // Animación de pulso CSS
        const style = document.createElement('style');
        style.textContent = `
            @keyframes pulse {
                0%, 100% {
                    transform: scale(1);
                }
                50% {
                    transform: scale(1.1);
                }
            }
        `;
        document.head.appendChild(style);

        // Highlight activo en la línea de tiempo al hacer hover
        timelineItems.forEach((item, index) => {
            item.addEventListener('mouseenter', function() {
                // Destacar el número con un efecto
                const number = this.querySelector('.timeline-number');
                number.style.background = 'linear-gradient(135deg, #ff9800 0%, #f57c00 100%)';
            });

            item.addEventListener('mouseleave', function() {
                const number = this.querySelector('.timeline-number');
                number.style.background = 'linear-gradient(135deg, #4caf50 0%, #66bb6a 100%)';
            });
        });

        // Efecto de contador en los números
        timelineItems.forEach((item, index) => {
            const number = item.querySelector('.timeline-number');
            const targetNumber = parseInt(number.textContent);
            let currentNumber = 0;
            
            const updateCounter = () => {
                if (currentNumber < targetNumber) {
                    currentNumber++;
                    number.textContent = currentNumber;
                    setTimeout(updateCounter, 100);
                } else {
                    number.textContent = targetNumber;
                }
            };

            // Iniciar contador cuando sea visible
            const counterObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting && number.textContent === targetNumber.toString()) {
                        number.textContent = '0';
                        updateCounter();
                        counterObserver.disconnect();
                    }
                });
            }, { threshold: 0.5 });

            counterObserver.observe(item);
        });
    });
</script>
@endpush
