@extends('front.layouts.app')

@section('content')
    <div class="container">

        <div class="row justify-content-center mb-4">
            <div class="col-md-12">
                <div class="card card-image card-image-banner wow fadeInUp">
                    <img class="card-img-top" src="{{ asset('front/img/placeholder.jpg') }}" alt="">
                    <div class="overlay"></div>
                    <div class="card-content">
                        <p>Bienvenido al</p>
                        <h2>Sistema de Apertura Rápida de Empresas</h2>
                        <p>del H. Ayuntamiento de Valle de Santiago, Guanajuato.</p>
                    </div>
                </div>
            </div>
        </div>

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
                        <h2>¿Qué es?</h2>
                        <p>El Sistema de Apertura Rápida de Empresas, SARE, es un programa permanente de la administración
                            pública, cuyo objetivo es el establecimiento e inicio de operaciones de nuevos negocios
                            considerados de bajo riesgo, facilitar su realización y promover su resolución ágil y expedita
                            por medio de la coordinación de los 3 órdenes de gobierno y la simplificación de trámites.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card card-normal wow fadeInUp h-100">
                    <div class="card-content">
                        <h2>Deberán cumplirse los siguientes criterios:</h2>
                        <p>I. El giro solicitado por el ciudadano deberá estar contenido dentro del
                            <a href="{{ asset('files/sare/Bajo_Riesgo_Catalog.pdf') }}" target="_blank">Catálogo de Giros
                                Comerciales y de Servicios SARE</a>
                            que determine el H. Ayuntamiento de Valle de Santiago y las Direcciones correspondientes.
                            II. El local deberá estar previamente edificado o construido.
                            III. El inmueble destinado a la actividad de comercio o servicio no deberá exceder de un
                            área de 240 m2.
                            IV. Contar con servicios básicos de agua potable, luz y alcantarillado.
                            V. Sin venta de bebidas alcohólicas.
                            VI. Vigencia de Permiso de un año.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-8">
                <div class="card card-normal wow fadeInUp h-100">
                    <div class="card-content">
                        <h2>Requisitos:</h2>
                        <p>Se deberá completar el expediente de solicitud con el
                            <a href="{{ asset('files/sare/Permiso_de_Suelo.pdf') }}" target="_blank">Formato Único SARE</a>
                            y copia simple de la siguiente documentación:
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card card-image wow fadeInUp h-100">
                    <img class="card-img-top" src="{{ asset('front/img/placeholder.jpg') }}" alt="">
                    <div class="overlay"></div>
                </div>
            </div>
        </div>


        <div class="mb-3">
            <div class="d-flex align-items-center" style="gap: 12px">
                <div class="icon">
                    <ion-icon name="copy-outline"></ion-icon>
                </div>
                <h2>Si tu negocio se encuentra en Zona Urbana</h2>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="card card-normal wow fadeInUp h-100">
                        <div class="card-content">
                            <h3>Persona Física:</h3>
                            <ol>
                                <li>
                                    Documento que acredite propiedad del inmueble (Título de propiedad, Escrituras, Cesión
                                    de derechos, Contrato de compra venta o Contrato de arrendamiento o comodato).
                                </li>
                                <li>
                                    Identificación oficial del solicitante y del propietario en su caso (Credencial de
                                    elector o pasaporte por ambos lados).
                                </li>
                                <li>
                                    Comprobante de domicilio con antigüedad no mayor a 2 meses (Agua o Luz).
                                </li>
                                <li>
                                    Pago predial del presente año.
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card card-normal wow fadeInUp h-100">
                        <div class="card-content">
                            <h3>Persona Moral:</h3>
                            <ol>
                                <li>
                                    Acta constitutiva de la Empresa.
                                </li>
                                <li>
                                    Poder Simple o notariado del representante legal.
                                </li>
                                <li>
                                    Documento que acredite propiedad del inmueble (Título de propiedad, Escrituras, Cesión
                                    de derechos, Contrato de compra venta o Contrato de arrendamiento o comodato).
                                </li>
                                <li>
                                    Identificación oficial del solicitante y del propietario en su caso (Credencial de
                                    elector o pasaporte por ambos lados).
                                </li>
                                <li>
                                    Comprobante de domicilio con antigüedad no mayor a 2 meses (Agua o Luz).
                                </li>
                                <li>
                                    Pago predial del presente año.
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mb-3">
            <div class="d-flex align-items-center" style="gap: 12px">
                <div class="icon">
                    <ion-icon name="copy-outline"></ion-icon>
                </div>
                <h2>Si tu negocio se encuentra en Zona Rural</h2>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="card card-normal wow fadeInUp h-100">
                        <div class="card-content">
                            <h3>Persona Física:</h3>
                            <ol>
                                <li>
                                    Documento que acredite propiedad del inmueble (Constancia del delegado/comisariado o
                                    contrato de arrendamiento o comodato).
                                </li>
                                <li>
                                    Identificación oficial del solicitante y del propietario en su caso (Credencial de
                                    elector o pasaporte por ambos lados).
                                </li>
                                <li>
                                    Comprobante de domicilio con antigüedad no mayor a 2 meses (Agua o Luz).
                                </li>
                                <li>
                                    Pago predial del presente año. (Opcional)
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card card-normal wow fadeInUp h-100">
                        <div class="card-content">
                            <h3>Persona Moral:</h3>
                            <ol>
                                <li>
                                    Acta constitutiva de la Empresa.
                                </li>
                                <li>
                                    Poder Simple o notariado del representante legal.
                                </li>
                                <li>
                                    Documento que acredite propiedad del inmueble (Título de propiedad, Escrituras, Cesión
                                    de derechos, Contrato de compra venta o Contrato de arrendamiento o comodato).
                                </li>
                                <li>
                                    Identificación oficial del solicitante y del propietario en su caso (Credencial de
                                    elector o pasaporte por ambos lados).
                                </li>
                                <li>
                                    Comprobante de domicilio con antigüedad no mayor a 2 meses (Agua o Luz).
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
