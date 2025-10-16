@extends('front.layouts.app')

@section('content')
    <div class="container">
        @include('front.contraloria.utilities._nav')

        <div class="row justify-content-center mb-4">
            <div class="col-md-12">
                <div class="card card-image card-image-banner justify-content-center wow fadeInUp">
                    <img class="card-img-top" src="{{ asset('front/img/placeholder-8.jpg') }}" alt="">
                    <div class="overlay" style="opacity: .4"></div>
                    <div class="card-content text-center w-100">
                        <p class="small-uppercase mb-0">Bienvenidos a la página oficial de</p>
                        <h1 class="display-1 mb-3">Contraloría Interna Municipal</h1>
                        <p class="p mb-0 ms-auto me-auto" style="width: 70%;">La contraloría municipal es el órgano interno de control que tiene por objeto la evaluación de la gestión municipal y desarrollo administrativo, así como el control de los ingresos, egresos, manejo, custodia y aplicación de los recursos públicos; con la finalidad de prevenir, corregir, investigar y, en su caso, sancionar actos y omisiones que pudieran constituir responsabilidades administrativas.</p>
                    </div>
                </div>
            </div>
        </div>


        {{-- BLOQUE ¿QUÉ HACE? --}}
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="d-flex align-items-center mb-4 wow fadeInUp" style="gap: 12px">
                    <div class="icon bg-primary">
                        <ion-icon name="help-circle-outline"></ion-icon>
                    </div>
                    <h3 class="mb-0">¿Qué hace?</h3>
                </div>
            </div>
            
            <div class="col-md-6 mb-3">
                <div class="card wow fadeInUp h-100" style="overflow: hidden;">
                    <div class="row g-0 h-100">
                        <div class="col-4">
                            <img src="{{ asset('front/img/placeholder-8.jpg') }}" class="img-fluid h-100 w-100" style="object-fit: cover;" alt="">
                        </div>
                        <div class="col-8">
                            <div class="card-content p-5 d-flex align-items-center h-100">
                                <p class="mb-0">Verifica que las dependencias de la administración pública que reciben, manejan y administran o ejercen recursos públicos lo hagan conforme a la normatividad aplicable</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <div class="card wow fadeInUp h-100" style="overflow: hidden;">
                    <div class="row g-0 h-100">
                        <div class="col-4">
                            <img src="{{ asset('front/img/placeholder-8.jpg') }}" class="img-fluid h-100 w-100" style="object-fit: cover;" alt="">
                        </div>
                        <div class="col-8">
                            <div class="card-content p-5 d-flex align-items-center h-100">
                                <p class="mb-0">A través de su unidad de investigación, instrucción y resolución investiga, sustancia y en su caso sanciona los actos u omisiones que pueden derivar en responsabilidades administrativas</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <div class="card wow fadeInUp h-100" style="overflow: hidden;">
                    <div class="row g-0 h-100">
                        <div class="col-4">
                            <img src="{{ asset('front/img/placeholder-8.jpg') }}" class="img-fluid h-100 w-100" style="object-fit: cover;" alt="">
                        </div>
                        <div class="col-8">
                            <div class="card-content p-5 d-flex align-items-center h-100">
                                <p class="mb-0">Vigila el cumplimiento de las disposiciones legales en materia administrativa</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <div class="card wow fadeInUp h-100" style="overflow: hidden;">
                    <div class="row g-0 h-100">
                        <div class="col-4">
                            <img src="{{ asset('front/img/placeholder-8.jpg') }}" class="img-fluid h-100 w-100" style="object-fit: cover;" alt="">
                        </div>
                        <div class="col-8">
                            <div class="card-content p-5 d-flex align-items-center h-100">
                                <p class="mb-0">Recibe y brinda el seguimiento correspondiente a las quejas, denuncias y sugerencias presentadas por los ciudadanos relativos al actuar de los funcionarios en el desempeño de sus facultades y atribuciones</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- BLOQUE ¿QUIENES SOMOS? --}}
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="d-flex align-items-center mb-4 wow fadeInUp" style="gap: 12px">
                    <div class="icon bg-success">
                        <ion-icon name="people-outline"></ion-icon>
                    </div>
                    <h3 class="mb-0">¿Quiénes Somos?</h3>
                </div>
            </div>
            
            <div class="col-md-4 mb-3">
                <div class="card card-normal h-100 wow fadeInUp">
                    <div class="card-content align-items-center d-flex text-center">
                        <p class="mb-0">La Contraloría Municipal es un Órgano interno de control encargado de vigilar el actuar de los servidores públicos.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="card card-normal h-100 wow fadeInUp">
                    <div class="card-content align-items-center d-flex text-center">
                        <p class="mb-0">Busca prevenir, investigar, detectar y sancionar en el ámbito de su competencia, conductas que constituyan faltas administrativas de los servidores públicos y particulares</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="card card-normal h-100 wow fadeInUp">
                    <div class="card-content align-items-center d-flex text-center">
                        <p class="mb-0">Promoviendo la participación ciudadana en la toma de decisiones de la administración</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- BLOQUE VALORES Y PRINCIPIOS --}}
        <div class="row mb-2">
            <div class="col-md-12">
                <div class="d-flex align-items-center mb-4 wow fadeInUp" style="gap: 12px">
                    <div class="icon bg-warning">
                        <ion-icon name="star-outline"></ion-icon>
                    </div>
                    <h3 class="mb-0">Valores y Principios</h3>
                </div>
            </div>

            <div class="col-md-12 mb-0">
                <div class=" wow fadeInUp">
                    <div id="word-cloud" class="text-center py-4">
                        <span class="word-item" data-color="#3498db">Disciplina</span>
                        <span class="word-item" data-color="#e74c3c">Legalidad</span>
                        <span class="word-item" data-color="#2ecc71">Objetividad</span>
                        <span class="word-item" data-color="#9b59b6">Profesionalismo</span>
                        <span class="word-item" data-color="#f39c12">Honradez</span>
                        <span class="word-item" data-color="#1abc9c">Lealtad</span> <br>
                        <span class="word-item" data-color="#e67e22">Imparcialidad</span>
                        <span class="word-item" data-color="#3498db">Eficiencia</span>
                        <span class="word-item" data-color="#9b59b6">Eficacia</span>
                        <span class="word-item" data-color="#e74c3c">Equidad</span>
                        <span class="word-item" data-color="#2ecc71">Transparencia</span>
                        <span class="word-item" data-color="#f39c12">Economía</span>
                        <span class="word-item" data-color="#1abc9c">Integridad</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-6 mb-3">
                <div class="card card-normal wow fadeInUp h-100">
                    <div class="d-flex align-items-center mb-3" style="gap: 12px">
                        <div class="icon bg-success" style="width: 50px; height: 50px;">
                            <ion-icon name="flag-outline"></ion-icon>
                        </div>
                        <h4 class="mb-0">Misión</h4>
                    </div>
                    <p class="mb-0">Ser reconocido como un órgano interno de control con capital humano que ayude a prevenir y corregir irregularidades para transparentar los recursos públicos por medio de auditorías y revisiones administrativas que fomenten la rendición de cuentas sanas que ayuden a evitar posibles observaciones Estatales y Federales así como vigilar que el desempeño de los servidores públicos se realice apegado a la normatividad establecida con el fin de brindar una mejor atención a la ciudadanía de Valle de Santiago.</p>
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <div class="card card-normal wow fadeInUp h-100">
                    <div class="d-flex align-items-center mb-3" style="gap: 12px">
                        <div class="icon bg-info" style="width: 50px; height: 50px;">
                            <ion-icon name="eye-outline"></ion-icon>
                        </div>
                        <h4 class="mb-0">Visión</h4>
                    </div>
                    <p class="mb-0">Realizar a corto plazo un mejor desempeño de labores que caracterice a este órgano interno de control, como un departamento que contribuya en conjunto con las direcciones de la administración a lograr un Gobierno Eficaz, Transparente y sin Corrupción.</p>
                </div>
            </div>
        </div>

        {{-- BLOQUE MAPA --}}
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="d-flex align-items-center mb-4 wow fadeInUp" style="gap: 12px">
                    <div class="icon bg-danger">
                        <ion-icon name="git-network-outline"></ion-icon>
                    </div>
                    <h3 class="mb-0">Nuestro Marco Normativo</h3>
                </div>
            </div>
            
            <div class="col-md-12 mb-4 text-center wow fadeInUp">
                <img src="{{ asset('front/img/map-contralory.png') }}" alt="" class="img-fluid">
            </div>
        </div>

        @include('front.contraloria.utilities._footer')
    </div>
@endsection

@push('styles')
<style>
    /* Estilos para la nube de palabras */
    #word-cloud {
        line-height: 3;
        min-height: 150px;
    }

    .word-item {
        display: inline-block;
        margin: 5px 15px;
        font-size: 1.2rem;
        font-weight: 600;
        color: #6c757d;
        transition: all 0.4s ease;
        cursor: pointer;
        opacity: 0.7;
    }

    .word-item:nth-child(odd) {
        font-size: 1.4rem;
    }

    .word-item:nth-child(3n) {
        font-size: 1.6rem;
    }

    .word-item.active {
        font-size: 2rem !important;
        opacity: 1;
        transform: scale(1.2);
    }

    .word-item:hover {
        transform: scale(1.15);
        opacity: 1;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Animación de nube de palabras
        const wordItems = document.querySelectorAll('.word-item');
        let currentIndex = 0;

        function highlightNextWord() {
            // Remover active de todas las palabras
            wordItems.forEach(item => item.classList.remove('active'));
            
            // Aplicar color y active a la palabra actual
            const currentWord = wordItems[currentIndex];
            currentWord.classList.add('active');
            currentWord.style.color = currentWord.getAttribute('data-color');
            
            currentIndex = (currentIndex + 1) % wordItems.length;
        }

        // Iniciar la animación
        highlightNextWord();
        setInterval(highlightNextWord, 1500);

        // Hover manual en las palabras
        wordItems.forEach(item => {
            item.addEventListener('mouseenter', function() {
                this.style.color = this.getAttribute('data-color');
            });

            item.addEventListener('mouseleave', function() {
                if (!this.classList.contains('active')) {
                    this.style.color = '#6c757d';
                }
            });
        });
    });
</script>
@endpush


{{--  
@extends('front.layouts.app')

@section('content')
<div class="container">
    <div class="d-flex align-items-center mb-4 wow fadeInUp" style="gap: 12px">
        <div class="icon bg-secondary">
            <ion-icon name="library-outline"></ion-icon>
        </div>
        <h3 class="mb-0">Contraloría</h3>
    </div>
    
    <div class="row w-100 mt-4">
        <div class="col-md-6 mb-4">
            <a href="{{ route('denuncia.net') }}" class="card link-card card-normal card-alignment-bottom wow fadeInUp" style="height: 430px;">
                <div class="card-icon bg-white text-dark d-flex align-items-center justify-content-center">
                    <ion-icon name="arrow-forward-outline" class="md hydrated"></ion-icon>
                </div>

                <div class="card-content">
                    <div class="d-flex align-items-center mb-2 gap-3">
                        <div class="card-icon card-icon-static bg-primary text-white d-flex align-items-center justify-content-center">
                            <ion-icon name="documents-outline"></ion-icon>
                        </div>
                        <h4 class="mb-0">Quejas, Denuncias y Sugerencias</h4>
                    </div>
                    <p class="mb-0">Estimado usuario, <strong>envíe sus denuncias, quejas o sugerencias</strong> a través del siguiente formulario. Es importante que rellene todos los campos para dar seguimiento a su mensaje. Gracias.</p>
                </div>
            </a>
        </div>

        <div class="col-md-6 mb-4">
            <a href="https://declaranetmunicipios.strc.guanajuato.gob.mx/#login" target="_blank" class="card link-card card-normal card-alignment-bottom wow fadeInUp" style="height: 200px">
                <div class="card-icon bg-white text-dark d-flex align-items-center justify-content-center">
                    <ion-icon name="arrow-forward-outline" class="md hydrated"></ion-icon>
                </div>

                <div class="card-content">
                    <h4>Haz tu declaración patrimonial.</h4>
                </div>
            </a>

            <a href="{{ route('contraloria.faults') }}" class="card link-card card-normal card-alignment-bottom wow fadeInUp" style="height: 200px">
                <div class="card-icon bg-white text-dark d-flex align-items-center justify-content-center">
                    <ion-icon name="arrow-forward-outline" class="md hydrated"></ion-icon>
                </div>

                <div class="card-content">
                    <h4>Catálogo de faltas administrativas.</h4>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection
--}}