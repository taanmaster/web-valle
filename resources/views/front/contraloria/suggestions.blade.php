@extends('front.layouts.app')

@section('content')
    <div class="container">
        @include('front.contraloria.utilities._nav')

        <div class="row justify-content-center mb-5">
            <div class="col-md-12">
                <div class="card card-image card-image-banner justify-content-center wow fadeInUp">
                    <img class="card-img-top" src="{{ asset('contra-img/contra-8.jpg') }}" alt="">
                    <div class="overlay" style="opacity: .4"></div>
                    <div class="card-content text-center w-100">
                        <p class="small-uppercase mb-0">Contraloría Interna Municipal</p>
                        <h1 class="display-1 mb-3">Quejas, Denuncias y Sugerencias</h1>
                        <p class="p mb-0 ms-auto me-auto" style="width: 70%;">El área de quejas, denuncias y sugerencias de
                            la Contraloría Municipal de Valle de Santiago, Guanajuato es la encargada de establecer y operar
                            el sistema de quejas, denuncias y sugerencias de la administración pública municipal.</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- BLOQUE OBJETIVO --}}
        <div class="row mb-4 mt-5">
            <div class="col-md-12">
                <div class="d-flex align-items-center mb-4 wow fadeInUp" style="gap: 12px">
                    <div class="icon bg-info">
                        <ion-icon name="help-circle-outline"></ion-icon>
                    </div>
                    <h3 class="mb-0">¿Cuál es su objetivo?</h3>
                </div>
            </div>

            <div class="col-md-12 mb-3">
                <div class="card card-normal wow fadeInUp">
                    <div class="card-content">
                        <p class="justify-p mb-3">El área de quejas, denuncias y sugerencias, tiene como objetivo principal
                            recibir, tramitar y dar seguimiento a las quejas, denuncias y sugerencias que se presentan en
                            contra de servidores públicos municipales y que estén relacionadas con el ejercicio de las
                            funciones o cargos que desempeñan. Con este proceso se busca fomentar la participación
                            ciudadana, brindándoles a los mismos la certeza de que trabajamos procurando mejorar la calidad,
                            legalidad y transparencia en el ejercicio de la gestión administrativa del municipio, así como
                            la protección de sus intereses, estableciendo las medidas preventivas necesarias para la
                            comisión o repetición de acciones irregulares o violatorias de la ley y sentando las bases
                            suficientes para que en aquellos casos en los que sean detectadas probables responsabilidades
                            administrativas, se tengan los suficientes elementos para que el área de investigación,
                            instrucción y resolución inicie los procesos administrativos correspondientes.</p>

                        <div
                            style="background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%); padding: 30px; border-radius: 12px; border-left: 4px solid #2196f3;">
                            <p class="justify-p text-dark p mb-0" style="font-size: 1.05rem; line-height: 1.8;">Con la
                                finalidad de proporcionar un medio de contacto efectivo y permanente, se encuentra a su
                                disposición este buzón de denuncias ciudadanas, al cual puede enviar las Quejas, Denuncias o
                                Sugerencias, que tengan relación con la actuación de las dependencias y servidores públicos
                                de la Administración Municipal.</p>

                            <div
                                style="background: #fff3cd; padding: 20px; border-radius: 8px; margin-top: 20px; border-left: 4px solid #ff9800;">
                                <p class="mb-2"><strong style="color: #ff5722;">IMPORTANTE</strong></p>
                                <p class="justify-p text-dark p mb-0" style="font-size: 0.95rem;">¿Pasa algo en tu colonia,
                                    barrio o fraccionamiento?, ¿Ocupas reportar algún servicio?, ¿Ves fallas en el
                                    alumbrado, desperdicio o fugas de agua, mucha basura en la vía pública? Entonces para
                                    agilizar la atención de su reporte, debe presentarlo de manera directa en la dependencia
                                    correspondiente.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- BLOQUE DIFERENCIA ENTRE QUEJA, DENUNCIA Y SUGERENCIA --}}
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="d-flex align-items-center mb-4 wow fadeInUp" style="gap: 12px">
                    <div class="icon bg-primary">
                        <ion-icon name="git-compare-outline"></ion-icon>
                    </div>
                    <h3 class="mb-0">Diferencia entre Queja, Denuncia y Sugerencia</h3>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="card card-normal wow fadeInUp h-100"
                    style="background: linear-gradient(135deg, #e8d5f0 0%, #f3e5f5 100%); border-left: 4px solid #9c27b0;">
                    <div class="card-content">
                        <h4 class="mb-3" style="color: #7b1fa2 !important;">Queja</h4>
                        <p class="justify-p text-dark mb-0">Es el planteamiento derivado de una molestia causada por el
                            actuar de un servidor público que perjudica de forma directa a los intereses de la ciudadanía.
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="card card-normal wow fadeInUp h-100"
                    style="background: linear-gradient(135deg, #ffe8d5 0%, #fff3e0 100%); border-left: 4px solid #ff9800;">
                    <div class="card-content">
                        <h4 class="mb-3" style="color: #e65100 !important;">Denuncia</h4>
                        <p class="justify-p text-dark mb-0">Es el planteamiento derivado del actuar de un servidor público
                            que afecta directamente a la administración pública.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="card card-normal wow fadeInUp h-100"
                    style="background: linear-gradient(135deg, #d5f0f0 0%, #e0f7fa 100%); border-left: 4px solid #00bcd4;">
                    <div class="card-content">
                        <h4 class="mb-3" style="color: #00838f !important;">Sugerencia</h4>
                        <p class="justify-p text-dark mb-0">Es la propuesta o recomendación que el ciudadano presenta a la
                            administración pública con el objetivo de mejorar un servicio o procedimiento.</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- BLOQUE QUE SI Y QUE NO DENUNCIAR --}}
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="d-flex align-items-center mb-4 wow fadeInUp" style="gap: 12px">
                    <div class="icon bg-success">
                        <ion-icon name="checkmark-done-outline"></ion-icon>
                    </div>
                    <h3 class="mb-0">¿Qué sí y qué no denunciar?</h3>
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <div class="card card-normal wow fadeInUp h-100"
                    style="background: linear-gradient(135deg, #d5f5e3 0%, #e8f5e9 100%); border-left: 4px solid #4caf50;">
                    <div class="card-content">
                        <h4 class="mb-3 text-center" style="color: #2e7d32 !important; font-size: 2rem; font-weight: bold;">
                            ¡Sí!</h4>
                        <p class="mb-3 text-dark"><strong>Faltas administrativas, que involucren a:</strong></p>
                        <ol class="mb-0 text-dark" style="line-height: 2;">
                            <li>Servidores públicos municipales en ejercicio de sus funciones</li>
                            <li>Personas físicas o morales que:
                                <ul>
                                    <li>Manejen o apliquen recursos públicos</li>
                                    <li>Participen en contrataciones públicas</li>
                                    <li>Participen en transacciones comerciales con el municipio</li>
                                </ul>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <div class="card card-normal wow fadeInUp h-100"
                    style="background: linear-gradient(135deg, #ffd5d5 0%, #ffebee 100%); border-left: 4px solid #f44336;">
                    <div class="card-content">
                        <h4 class="mb-3 text-center" style="color: #c62828 !important; font-size: 2rem; font-weight: bold;">
                            ¡No!</h4>
                        <p class="mb-3 text-dark"><strong>Quejas o denuncias relacionadas con:</strong></p>
                        <ol class="mb-0 text-dark" style="line-height: 2;">
                            <li>Asuntos laborales cuando no tengan que ver con la administración del municipio</li>
                            <li>Autoridades Estatales o Federales</li>
                            <li>Conflictos entre particulares</li>
                            <li>Delitos que deban ser resueltos por el Poder Judicial</li>
                            <li>Reportes sobre servicios públicos</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="row w-100 mt-4">
            <div class="col-md-4 mb-4">
                <a href="{{ route('contraloria.faults.not-serious') }}"
                    class="card link-card card-normal card-alignment-bottom wow fadeInUp" style="height: 430px;">
                    <div class="card-icon bg-white text-dark d-flex align-items-center justify-content-center">
                        <ion-icon name="arrow-forward-outline" class="md hydrated"></ion-icon>
                    </div>

                    <div class="card-content">
                        <div class="d-flex flex-column mb-2 gap-3">
                            <div
                                class="card-icon card-icon-static bg-warning text-white d-flex align-items-center justify-content-center">
                                <ion-icon name="document-text-outline"></ion-icon>
                            </div>
                            <h4 class="mb-0">Faltas administrativas no graves de los servidores públicos</h4>
                        </div>
                        <p class="mb-0">Art. 49 Ley de responsabilidades administrativas para el estado de Guanajuato</p>
                    </div>
                </a>
            </div>

            <div class="col-md-4 mb-4">
                <a href="{{ route('contraloria.faults.not-serious-rules') }}"
                    class="card link-card card-normal card-alignment-bottom wow fadeInUp" style="height: 430px;">
                    <div class="card-icon bg-white text-dark d-flex align-items-center justify-content-center">
                        <ion-icon name="arrow-forward-outline" class="md hydrated"></ion-icon>
                    </div>

                    <div class="card-content">
                        <div class="d-flex flex-column mb-2 gap-3">
                            <div
                                class="card-icon card-icon-static bg-info text-white d-flex align-items-center justify-content-center">
                                <ion-icon name="file-tray-full-outline"></ion-icon>
                            </div>
                            <h4 class="mb-0">Posibles sanciones de los servidores públicos por faltas administrativas no
                                graves</h4>
                        </div>
                        <p class="mb-0">Art. 75 Ley de responsabilidades administrativas para el estado de Guanajuato.
                        </p>
                    </div>
                </a>
            </div>

            <div class="col-md-4 mb-4">
                <a href="{{ route('contraloria.faults.serious') }}"
                    class="card link-card card-normal card-alignment-bottom wow fadeInUp" style="height: 430px;">
                    <div class="card-icon bg-white text-dark d-flex align-items-center justify-content-center">
                        <ion-icon name="arrow-forward-outline" class="md hydrated"></ion-icon>
                    </div>

                    <div class="card-content">
                        <div class="d-flex flex-column mb-2 gap-3">
                            <div
                                class="card-icon card-icon-static bg-danger text-white d-flex align-items-center justify-content-center">
                                <ion-icon name="hand-left-outline"></ion-icon>
                            </div>
                            <h4 class="mb-0">Faltas administrativas graves de los servidores públicos</h4>
                        </div>
                        <p class="mb-0">Art. 52-55 Ley de responsabilidades administrativas para el estado de Guanajuato.
                        </p>
                    </div>
                </a>
            </div>
        </div>

        {{-- BLOQUE ¿Qué faltas cometidas por un particular puede usted denunciar? --}}
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="d-flex align-items-center mb-4 wow fadeInUp" style="gap: 12px">
                    <div class="icon bg-warning">
                        <ion-icon name="alert-circle-outline"></ion-icon>
                    </div>
                    <h3 class="mb-0">¿Qué faltas cometidas por un particular puede usted denunciar?</h3>
                </div>
            </div>

            <div class="container" style="padding: 30px 20%;">

                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="card card-image card-alignment-center wow fadeInUp h-100">
                            <img class="card-img-top" src="{{ asset('contra-img/contra-21.jpg') }}" alt="">
                            <div class="overlay"></div>

                            <div class="card-content">
                                <div class="d-flex align-items-center mb-0 gap-3">
                                    <div
                                        class="card-icon card-icon-static bg-white text-warning d-flex align-items-center justify-content-center">
                                        <ion-icon name="warning-outline"></ion-icon>
                                    </div>
                                    <h2 class="mb-0">01</h2>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="card card-normal card-alignment-center wow fadeInUp h-100">
                            <div class="card-content mb-0">
                                <h4 class="mb-0">Soborno</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-8">
                        <div class="card card-normal flex-row justify-content-end align-items-center wow fadeInUp h-100">
                            <div class="card-content text-end mb-0">
                                <h4 class="mb-0">Participación ilícita en procedimientos administrativos.</h4>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card card-image card-alignment-center wow fadeInUp h-100">
                            <img class="card-img-top" src="{{ asset('contra-img/contra-48.jpg') }}" alt="">
                            <div class="overlay"></div>

                            <div class="card-content">
                                <div class="d-flex align-items-center mb-0 gap-3">
                                    <div
                                        class="card-icon card-icon-static bg-white text-warning d-flex align-items-center justify-content-center">
                                        <ion-icon name="warning-outline"></ion-icon>
                                    </div>
                                    <h2 class="mb-0">02</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="card card-image card-alignment-center wow fadeInUp h-100">
                            <img class="card-img-top" src="{{ asset('contra-img/contra-49.jpg') }}" alt="">
                            <div class="overlay"></div>

                            <div class="card-content">
                                <div class="d-flex align-items-center mb-0 gap-3">
                                    <div
                                        class="card-icon card-icon-static bg-white text-warning d-flex align-items-center justify-content-center">
                                        <ion-icon name="warning-outline"></ion-icon>
                                    </div>
                                    <h2 class="mb-0">03</h2>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="card card-normal card-alignment-center wow fadeInUp h-100">
                            <div class="card-content mb-0">
                                <h4 class="mb-0">Tráfico de Influencias para inducir a la autoridad.</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-8">
                        <div class="card card-normal flex-row justify-content-end align-items-center wow fadeInUp h-100">
                            <div class="card-content text-end mb-0">
                                <h4 class="mb-0">Utilización de información falsa.</h4>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card card-image card-alignment-center wow fadeInUp h-100">
                            <img class="card-img-top" src="{{ asset('contra-img/contra-50.jpg') }}" alt="">
                            <div class="overlay"></div>

                            <div class="card-content">
                                <div class="d-flex align-items-center mb-0 gap-3">
                                    <div
                                        class="card-icon card-icon-static bg-white text-warning d-flex align-items-center justify-content-center">
                                        <ion-icon name="warning-outline"></ion-icon>
                                    </div>
                                    <h2 class="mb-0">04</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="card card-image card-alignment-center wow fadeInUp h-100">
                            <img class="card-img-top" src="{{ asset('contra-img/contra-51.jpg') }}" alt="">
                            <div class="overlay"></div>

                            <div class="card-content">
                                <div class="d-flex align-items-center mb-0 gap-3">
                                    <div
                                        class="card-icon card-icon-static bg-white text-warning d-flex align-items-center justify-content-center">
                                        <ion-icon name="warning-outline"></ion-icon>
                                    </div>
                                    <h2 class="mb-0">05</h2>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="card card-normal card-alignment-center wow fadeInUp h-100">
                            <div class="card-content mb-0">
                                <h4 class="mb-0">Obstrucción de facultades de investigación.</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-8">
                        <div class="card card-normal flex-row justify-content-end align-items-center wow fadeInUp h-100">
                            <div class="card-content text-end mb-0">
                                <h4 class="mb-0">Colusión. • Uso indebido de recursos públicos.</h4>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card card-image card-alignment-center wow fadeInUp h-100">
                            <img class="card-img-top" src="{{ asset('contra-img/contra-52.jpg') }}" alt="">
                            <div class="overlay"></div>

                            <div class="card-content">
                                <div class="d-flex align-items-center mb-0 gap-3">
                                    <div
                                        class="card-icon card-icon-static bg-white text-warning d-flex align-items-center justify-content-center">
                                        <ion-icon name="warning-outline"></ion-icon>
                                    </div>
                                    <h2 class="mb-0">06</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="card card-image card-alignment-center wow fadeInUp h-100">
                            <img class="card-img-top" src="{{ asset('contra-img/contra-53.jpg') }}" alt="">
                            <div class="overlay"></div>

                            <div class="card-content">
                                <div class="d-flex align-items-center mb-0 gap-3">
                                    <div
                                        class="card-icon card-icon-static bg-white text-warning d-flex align-items-center justify-content-center">
                                        <ion-icon name="warning-outline"></ion-icon>
                                    </div>
                                    <h2 class="mb-0">07</h2>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="card card-normal card-alignment-center wow fadeInUp h-100">
                            <div class="card-content mb-0">
                                <h4 class="mb-0">Contratación indebida de ex Servidores Públicos.</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-8">
                        <div class="card card-normal flex-row justify-content-end align-items-center wow fadeInUp h-100">
                            <div class="card-content text-end mb-0">
                                <h4 class="mb-0">Faltas realizadas por candidatos a cargos de elección popular</h4>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card card-image card-alignment-center wow fadeInUp h-100">
                            <img class="card-img-top" src="{{ asset('contra-img/contra-54.jpg') }}" alt="">
                            <div class="overlay"></div>

                            <div class="card-content">
                                <div class="d-flex align-items-center mb-0 gap-3">
                                    <div
                                        class="card-icon card-icon-static bg-white text-warning d-flex align-items-center justify-content-center">
                                        <ion-icon name="warning-outline"></ion-icon>
                                    </div>
                                    <h2 class="mb-0">08</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        {{-- BLOQUE CRITERIOS DE RESOLUCIÓN --}}
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="d-flex align-items-center mb-4 wow fadeInUp" style="gap: 12px">
                    <div class="icon bg-success">
                        <ion-icon name="document-text-outline"></ion-icon>
                    </div>
                    <h3 class="mb-0">Criterios de resolución</h3>
                </div>
            </div>

            <div class="col-md-12 mb-3">
                <div class="card card-normal wow fadeInUp">
                    <div class="card-content">
                        <p class="mb-4" style="font-size: 1.05rem; line-height: 1.8; text-align: justify;">Cuando
                            durante la investigación inicial de los hechos denunciados por la ciudadanía se encuentren los
                            elementos necesarios que acrediten la presunta comisión de hechos u omisiones que pudieran
                            derivar en probables faltas administrativas, los expedientes se canalizan al Área de
                            Investigación, Instrucción y Resolución de la Contraloría Municipal.</p>

                        <p class="mb-4" style="font-size: 1.05rem; line-height: 1.8; text-align: justify;">En caso de no
                            encontrarlos o ser insuficientes se decreta acuerdo de conclusión y archivo sin perjuicio de que
                            pueda abrirse nuevamente la investigación al encontrarse nuevos elementos.</p>

                        <p class="mb-0" style="font-size: 1.05rem; line-height: 1.8; text-align: justify;">Así mismo, si
                            no se encuentran elementos suficientes, pero se encuentra un área de oportunidad se elabora
                            acuerdo de conclusión y archivo con recomendación.</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- BLOQUE INSTRUCTIVO --}}
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="d-flex align-items-center mb-4 wow fadeInUp" style="gap: 12px">
                    <div class="icon bg-primary">
                        <ion-icon name="list-outline"></ion-icon>
                    </div>
                    <h3 class="mb-0">Instructivo</h3>
                </div>
            </div>

            <div class="col-md-12 mb-3">
                <div class="card card-normal wow fadeInUp">
                    <div class="card-content">
                        <div class="row">
                            <div class="col-md-12 mb-4">
                                <div class="d-flex align-items-center" style="gap: 20px;">
                                    <div
                                        style="min-width: 60px; height: 60px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 1.5rem; font-weight: bold; box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);">
                                        1</div>
                                    <div>
                                        <p class="mb-0" style="font-size: 1.05rem; line-height: 1.8;">Llenar el
                                            formulario con los datos correspondientes</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 mb-4">
                                <div class="d-flex align-items-center" style="gap: 20px;">
                                    <div
                                        style="min-width: 60px; height: 60px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 1.5rem; font-weight: bold; box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);">
                                        2</div>
                                    <div>
                                        <p class="mb-0" style="font-size: 1.05rem; line-height: 1.8;">Los datos marcados
                                            con asterisco son obligatorios</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 mb-4">
                                <div class="d-flex align-items-center" style="gap: 20px;">
                                    <div
                                        style="min-width: 60px; height: 60px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 1.5rem; font-weight: bold; box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);">
                                        3</div>
                                    <div>
                                        <p class="mb-0" style="font-size: 1.05rem; line-height: 1.8;">Es necesario que
                                            proporcione sus datos personales, no obstante, tiene el derecho a que se
                                            mantengan ocultos ante el servidor público del que se realiza la queja/denuncia
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 mb-4">
                                <div class="d-flex align-items-center" style="gap: 20px;">
                                    <div
                                        style="min-width: 60px; height: 60px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 1.5rem; font-weight: bold; box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);">
                                        4</div>
                                    <div>
                                        <p class="mb-0" style="font-size: 1.05rem; line-height: 1.8;">Puede subir algún
                                            tipo de evidencia en foto, audio o video en cualquiera de los formatos listados
                                            en esta página. Sólo puede subir un archivo de evidencias</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="d-flex align-items-center" style="gap: 20px;">
                                    <div
                                        style="min-width: 60px; height: 60px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 1.5rem; font-weight: bold; box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);">
                                        5</div>
                                    <div>
                                        <p class="mb-0" style="font-size: 1.05rem; line-height: 1.8;">Al enviar la
                                            información de la queja/denuncia se generará un folio el cual tiene que
                                            conservar para consultar el status en que se encuentra</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <a href="{{ route('contraloria.privacy_notice') }}" class="btn btn-primary btn-xl">Haz clic y consulta
                    nuestro Aviso de Privacidad</a>
            </div>
        </div>

        {{-- BLOQUE ACCION DE DENUNCIA --}}

        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card card-image wow fadeInUp h-100">
                    <img class="card-img-top" src="{{ asset('front/img/placeholder.jpg') }}" alt="">
                    <div class="overlay"></div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card card-normal wow fadeInUp h-100">
                    <div class="card-content">
                        <h4>TU OPINIÓN CUENTA</h4>
                        <h1>Haz que cuénte</h1>
                        <p>
                            El sistema de <strong>Denuncia Ciudadana</strong> es el medio electrónico mediante el cual se
                            fortalece la
                            participación ciudadana a través de las Quejas, denuncias y sugerencias que emplean la
                            ciudadanía para hacer de conocimiento de la autoridad su inconformidad derivada de las
                            actuaciones u omisiones de los servidores públicos que pueden ser constitutivas de
                            responsabilidades administrativas
                        </p>
                        <div class="d-flex align-items-center" style="gap: 12px">
                            <h2>Quiero hacer una</h2>
                            <a href="{{ route('denuncia.net') }}" class="btn btn-secondary py-1"
                                style="width: fit-content; height:fit-content">Denuncia Ciudadana</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 my-4">
                <a href="{{ route('denuncia.net.show') }}" class="w-100 btn btn-primary">Puedes consultar en cualquier
                    momento
                    el estatus de su folio aquí</a>
            </div>
        </div>

        {{-- BLOQUE ELEMENTOS DE REFUERZO --}}
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="d-flex align-items-center mb-4 wow fadeInUp" style="gap: 12px">
                    <div class="icon bg-info">
                        <ion-icon name="document-attach-outline"></ion-icon>
                    </div>
                    <h3 class="mb-0">Elementos que sirven para reforzar su queja, denuncia o sugerencia</h3>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="card card-normal wow fadeInUp h-100 text-center overflow-hidden"
                    style="border: 2px solid #e0e0e0; transition: all 0.3s ease;">
                    <div class="card-content d-flex flex-column align-items-center justify-content-center"
                        style="min-height: 200px;">
                        <div
                            style="width: 70px; height: 70px; background: #f5f5f5; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-bottom: 15px;">
                            <ion-icon name="camera-outline" style="font-size: 2.5rem; color: #2196f3;"></ion-icon>
                        </div>
                        <h6 class="mb-0" style="color: #333; font-weight: 600;">FOTOGRAFÍAS, AUDIO O VIDEO</h6>
                    </div>
                    <img src="{{ asset('contra-img/contra-38.jpg') }}" alt="FOTOGRAFÍAS, AUDIO O VIDEO"
                        class="position-absolute w-100 h-100 top-0 start-0 object-fit-cover opacity-25 hover-opacity-100 transition-opacity">
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="card card-normal wow fadeInUp h-100 text-center overflow-hidden"
                    style="border: 2px solid #e0e0e0; transition: all 0.3s ease;">
                    <div class="card-content d-flex flex-column align-items-center justify-content-center"
                        style="min-height: 200px;">
                        <div
                            style="width: 70px; height: 70px; background: #f5f5f5; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-bottom: 15px;">
                            <ion-icon name="document-outline" style="font-size: 2.5rem; color: #4caf50;"></ion-icon>
                        </div>
                        <h6 class="mb-0" style="color: #333; font-weight: 600;">DOCUMENTACIÓN EN PAPEL</h6>
                    </div>
                    <img src="{{ asset('contra-img/contra-39.jpg') }}" alt="FOTOGRAFÍAS, AUDIO O VIDEO"
                        class="position-absolute w-100 h-100 top-0 start-0 object-fit-cover opacity-25 hover-opacity-100 transition-opacity">
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="card card-normal wow fadeInUp h-100 text-center overflow-hidden"
                    style="border: 2px solid #e0e0e0; transition: all 0.3s ease;">
                    <div class="card-content d-flex flex-column align-items-center justify-content-center"
                        style="min-height: 200px;">
                        <div
                            style="width: 70px; height: 70px; background: #f5f5f5; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-bottom: 15px;">
                            <ion-icon name="people-outline" style="font-size: 2.5rem; color: #ff9800;"></ion-icon>
                        </div>
                        <h6 class="mb-0" style="color: #333; font-weight: 600;">DECLARACIÓN DE TESTIGOS</h6>
                    </div>
                    <img src="{{ asset('contra-img/contra-40.jpg') }}" alt="FOTOGRAFÍAS, AUDIO O VIDEO"
                        class="position-absolute w-100 h-100 top-0 start-0 object-fit-cover opacity-25 hover-opacity-100 transition-opacity">
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="card card-normal wow fadeInUp h-100 text-center overflow-hidden"
                    style="border: 2px solid #e0e0e0; transition: all 0.3s ease;">
                    <div class="card-content d-flex flex-column align-items-center justify-content-center"
                        style="min-height: 200px;">
                        <div
                            style="width: 70px; height: 70px; background: #f5f5f5; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-bottom: 15px;">
                            <ion-icon name="information-circle-outline"
                                style="font-size: 2.5rem; color: #9c27b0;"></ion-icon>
                        </div>
                        <h6 class="mb-0" style="color: #333; font-weight: 600;">INFORMACIÓN DETALLADA</h6>
                    </div>
                    <img src="{{ asset('contra-img/contra-41.jpg') }}" alt="FOTOGRAFÍAS, AUDIO O VIDEO"
                        class="position-absolute w-100 h-100 top-0 start-0 object-fit-cover opacity-25 hover-opacity-100 transition-opacity">
                </div>
            </div>
        </div>

        {{-- BLOQUE MEDIOS PARA PRESENTAR DENUNCIA --}}
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="d-flex align-items-center mb-4 wow fadeInUp" style="gap: 12px">
                    <div class="icon bg-danger">
                        <ion-icon name="megaphone-outline"></ion-icon>
                    </div>
                    <h3 class="mb-0">Medios por los que puede presentar su queja, denuncia y sugerencia</h3>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="card card-normal wow fadeInUp h-100 text-center overflow-hidden"
                    style="border: 2px solid #e0e0e0; transition: all 0.3s ease;">
                    <div class="card-content d-flex flex-column align-items-center justify-content-center"
                        style="min-height: 200px;">
                        <div
                            style="width: 70px; height: 70px; background: #e3f2fd; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-bottom: 15px;">
                            <ion-icon name="globe-outline" style="font-size: 2.5rem; color: #2196f3;"></ion-icon>
                        </div>
                        <h6 class="mb-0" style="color: #333; font-weight: 600;">EN LÍNEA</h6>
                    </div>
                    <img src="{{ asset('contra-img/contra-42.jpg') }}" alt="FOTOGRAFÍAS, AUDIO O VIDEO"
                        class="position-absolute w-100 h-100 top-0 start-0 object-fit-cover opacity-25 hover-opacity-100 transition-opacity">
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="card card-normal wow fadeInUp h-100 text-center overflow-hidden"
                    style="border: 2px solid #e0e0e0; transition: all 0.3s ease;">
                    <div class="card-content d-flex flex-column align-items-center justify-content-center"
                        style="min-height: 200px;">
                        <div
                            style="width: 70px; height: 70px; background: #e8f5e9; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-bottom: 15px;">
                            <ion-icon name="call-outline" style="font-size: 2.5rem; color: #4caf50;"></ion-icon>
                        </div>
                        <h6 class="mb-0" style="color: #333; font-weight: 600;">VÍA TELEFÓNICA</h6>
                    </div>
                    <img src="{{ asset('contra-img/contra-43.jpg') }}" alt="FOTOGRAFÍAS, AUDIO O VIDEO"
                        class="position-absolute w-100 h-100 top-0 start-0 object-fit-cover opacity-25 hover-opacity-100 transition-opacity">
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="card card-normal wow fadeInUp h-100 text-center overflow-hidden"
                    style="border: 2px solid #e0e0e0; transition: all 0.3s ease;">
                    <div class="card-content d-flex flex-column align-items-center justify-content-center"
                        style="min-height: 200px;">
                        <div
                            style="width: 70px; height: 70px; background: #fff3e0; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-bottom: 15px;">
                            <ion-icon name="business-outline" style="font-size: 2.5rem; color: #ff9800;"></ion-icon>
                        </div>
                        <h6 class="mb-0" style="color: #333; font-weight: 600;">PRESENCIAL</h6>
                    </div>
                    <img src="{{ asset('contra-img/contra-8.jpg') }}" alt="FOTOGRAFÍAS, AUDIO O VIDEO"
                        class="position-absolute w-100 h-100 top-0 start-0 object-fit-cover opacity-25 hover-opacity-100 transition-opacity">
                </div>
            </div>
        </div>

        {{-- ADVERTENCIA LEGAL --}}
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card card-normal wow fadeInUp"
                    style="background: linear-gradient(135deg, #fff3cd 0%, #fff8e1 100%); border-left: 4px solid #ff5722;">
                    <div class="card-content">
                        <p class="mb-0 text-dark" style="font-size: 1rem; line-height: 1.8; text-align: justify;">
                            <strong>¡Atención!</strong> Previo a continuar con su registro, se le informa que el hecho de
                            proporcionar información que no corresponda con la identidad de su persona, o que dicha
                            información no este actualizada, tendrá como consecuencia tener por no admitida su queja,
                            denuncia o sugerencia y que, esta sea desechada de plano. Ya que al presentar información que no
                            coincida con la realidad (falsa) se considera que usted está intentando presentar una queja,
                            denuncia o sugerencia maliciosa. Lo anterior de conformidad con el Reglamento de la Contraloría
                            Municipal de Valle de Santiago, artículo 19 y 20 y Ley de Responsabilidades administrativas para
                            el estado de Guanajuato, artículos 90, 91, 92 y 93.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        @include('front.contraloria.utilities._footer')
    </div>
@endsection

@push('styles')
    <style>
        /* Hover effect para las tarjetas de elementos y medios */
        .card[style*="border: 2px solid #e0e0e0"]:hover {
            border-color: #2196f3 !important;
            box-shadow: 0 4px 12px rgba(33, 150, 243, 0.2);
            transform: translateY(-5px);
        }
    </style>
@endpush

@push('scripts')
@endpush
