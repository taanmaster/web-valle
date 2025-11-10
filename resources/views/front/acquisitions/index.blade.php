@extends('front.layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center mb-4">
            <div class="col-md-12">
                <div class="card card-image card-image-banner justify-content-center wow fadeInUp">
                    <img class="card-img-top" src="{{ asset('front/img/placeholder-9.jpg') }}" alt="">
                    <div class="overlay" style="opacity: .4"></div>
                    <div class="card-content text-center w-100">
                        <p class="small-uppercase mb-0">Bienvenidos a la página oficial de</p>
                        <h1 class="display-1 mb-0">Adquisiciones</h1>
                    </div>
                </div>
            </div>
        </div>

        {{-- BLOQUE VALORES Y PRINCIPIOS --}}
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="d-flex align-items-start mb-4 wow fadeInUp" style="gap: 12px">
                    <div class="icon bg-warning">
                        <ion-icon name="star-outline"></ion-icon>
                    </div>
                    <div style="flex-basis: fit-content;">
                        <h3 class="mb-1">Requisitos</h3>
                        <p class="mb-0">De acuerdo al artículo 83 del Reglamento de Contrataciones Públicas para el Municipio de Valle de Santiago, Gto. Los requisitos para pertenecer al padrón de proveedores son los siguientes:</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-6 mb-3">
                <div class="card card-normal wow fadeInUp h-100">
                    <div class="d-flex align-items-center mb-3" style="gap: 12px">
                        <div class="icon bg-info" style="width: 50px; height: 50px;">
                            <ion-icon name="person"></ion-icon>
                        </div>
                        <h4 class="mb-0">Persona Física</h4>
                    </div>
                    
                    <ul class="checklist-requirements list-unstyled mb-0">
                        <li class="checklist-item wow fadeInUp" data-wow-delay="0.1s">
                            <span class="checklist-number">1</span>
                            <span class="checklist-text">Registrar tu perfil de proveedor</span>
                        </li>
                        <li class="checklist-item wow fadeInUp" data-wow-delay="0.15s">
                            <span class="checklist-number">2</span>
                            <span class="checklist-text">Iniciar alta como proveedor</span>
                        </li>
                        <li class="checklist-item wow fadeInUp" data-wow-delay="0.2s">
                            <span class="checklist-number">3</span>
                            <span class="checklist-text">Presentar la solicitud correspondiente debidamente elaborada y firmada por el representante legal o por el interesado personalmente</span>
                        </li>
                        <li class="checklist-item wow fadeInUp" data-wow-delay="0.25s">
                            <span class="checklist-number">4</span>
                            <span class="checklist-text">Constancia de situación fiscal</span>
                        </li>
                        <li class="checklist-item wow fadeInUp" data-wow-delay="0.3s">
                            <span class="checklist-number">5</span>
                            <span class="checklist-text">Copia certificada de identificación oficial del solicitante</span>
                        </li>
                        <li class="checklist-item wow fadeInUp" data-wow-delay="0.35s">
                            <span class="checklist-number">6</span>
                            <span class="checklist-text">En caso de que sea un representante legal acreditar su personalidad en original o copia certificada</span>
                        </li>
                        <li class="checklist-item wow fadeInUp" data-wow-delay="0.4s">
                            <span class="checklist-number">7</span>
                            <span class="checklist-text">Proporcionar catálogo, y listado de bienes o servicios, según sea el caso</span>
                        </li>
                        <li class="checklist-item wow fadeInUp" data-wow-delay="0.45s">
                            <span class="checklist-number">8</span>
                            <span class="checklist-text">Comprobante original o certificado actualizado de domicilio</span>
                        </li>
                        <li class="checklist-item wow fadeInUp" data-wow-delay="0.5s">
                            <span class="checklist-number">9</span>
                            <span class="checklist-text">CURP</span>
                        </li>
                        <li class="checklist-item wow fadeInUp" data-wow-delay="0.55s">
                            <span class="checklist-number">10</span>
                            <span class="checklist-text">Opinión de cumplimiento</span>
                        </li>
                        <li class="checklist-item wow fadeInUp" data-wow-delay="0.6s">
                            <span class="checklist-number">11</span>
                            <span class="checklist-text">Datos Bancarios</span>
                        </li>
                        <li class="checklist-item wow fadeInUp" data-wow-delay="0.65s">
                            <span class="checklist-number">12</span>
                            <span class="checklist-text">Carátula del Banco</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <div class="card card-normal wow fadeInUp h-100">
                    <div class="d-flex align-items-center mb-3" style="gap: 12px">
                        <div class="icon bg-info" style="width: 50px; height: 50px;">
                            <ion-icon name="business"></ion-icon>
                        </div>
                        <h4 class="mb-0">Persona Moral</h4>
                    </div>
                    
                    <ul class="checklist-requirements list-unstyled mb-0">
                        <li class="checklist-item wow fadeInUp" data-wow-delay="0.1s">
                            <span class="checklist-number">1</span>
                            <span class="checklist-text">Registrar tu perfil de proveedor</span>
                        </li>
                        <li class="checklist-item wow fadeInUp" data-wow-delay="0.15s">
                            <span class="checklist-number">2</span>
                            <span class="checklist-text">Iniciar alta como proveedor</span>
                        </li>
                        <li class="checklist-item wow fadeInUp" data-wow-delay="0.2s">
                            <span class="checklist-number">3</span>
                            <span class="checklist-text">Presentar la solicitud correspondiente debidamente elaborada y firmada por el representante legal</span>
                        </li>
                        <li class="checklist-item wow fadeInUp" data-wow-delay="0.25s">
                            <span class="checklist-number">4</span>
                            <span class="checklist-text">Constancia de situación fiscal</span>
                        </li>
                        <li class="checklist-item wow fadeInUp" data-wow-delay="0.3s">
                            <span class="checklist-number">5</span>
                            <span class="checklist-text">Copia certificada de identificación oficial del representante legal</span>
                        </li>
                        <li class="checklist-item wow fadeInUp" data-wow-delay="0.35s">
                            <span class="checklist-number">6</span>
                            <span class="checklist-text">Proporcionar catálogo, y listado de bienes o servicios, según sea el caso</span>
                        </li>
                        <li class="checklist-item wow fadeInUp" data-wow-delay="0.4s">
                            <span class="checklist-number">7</span>
                            <span class="checklist-text">Copia certificada de Acta constitutiva, así como de su última modificación si existiere</span>
                        </li>
                        <li class="checklist-item wow fadeInUp" data-wow-delay="0.45s">
                            <span class="checklist-number">8</span>
                            <span class="checklist-text">Copia certificada donde acredite la personalidad el representante legal</span>
                        </li>
                        <li class="checklist-item wow fadeInUp" data-wow-delay="0.5s">
                            <span class="checklist-number">9</span>
                            <span class="checklist-text">Comprobante original o certificado actualizado de domicilio de la persona moral</span>
                        </li>
                        <li class="checklist-item wow fadeInUp" data-wow-delay="0.55s">
                            <span class="checklist-number">10</span>
                            <span class="checklist-text">Constancia de Situación Fiscal de los accionistas</span>
                        </li>
                        <li class="checklist-item wow fadeInUp" data-wow-delay="0.6s">
                            <span class="checklist-number">11</span>
                            <span class="checklist-text">CURP de los accionistas</span>
                        </li>
                        <li class="checklist-item wow fadeInUp" data-wow-delay="0.65s">
                            <span class="checklist-number">12</span>
                            <span class="checklist-text">Opinión de cumplimiento</span>
                        </li>
                        <li class="checklist-item wow fadeInUp" data-wow-delay="0.7s">
                            <span class="checklist-number">13</span>
                            <span class="checklist-text">Datos Bancarios</span>
                        </li>
                        <li class="checklist-item wow fadeInUp" data-wow-delay="0.75s">
                            <span class="checklist-number">14</span>
                            <span class="checklist-text">Carátula del Banco</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <a href="{{ route('register', 'supplier') }}" class="btn-suppliers btn-cta mb-4 text-center wow fadeInUp">
            <h3>Quiero ser Proveedor</h3>

            <div>Clic aquí <ion-icon name="arrow-forward"></ion-icon></div>
        </a>

        <div class="row">
            <div class="col-md-12 text-center">
                <hr>
                <p>El registro del patrón de proveedores municipal tendrá de vigencia hasta el <strong>treinta y uno de diciembre del año de registro</strong>. Para el trámite de refrendo del registro en el Padrón, los proveedores deben presentar, dentro de los tres primeros meses del año siguiente al vencimiento del registro, un oficio solicitando el refrendo.</p>
                <p>El costo de la inscripción, así como del refrendo, es de <strong>$1,000.00</strong> (UN MIL PESOS 00/100 M.N) de acuerdo al <strong>ART. 22 DE LAS DISPOSICIONES ADMINISTRATIVAS PARA EL EJERCICIO FISCAL 2025 del municipio de Valle de Santiago, Gto. El pago se hará en las cajas de la Tesorería Municipal.</strong></p>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    /* CTA Button Styles */
    .btn-cta {
        display: block;
        width: 100%;
        max-width: 600px;
        margin: 0 auto;
        padding: 32px 48px;
        background: #0d6efd;
        color: white;
        text-decoration: none;
        border-radius: 16px;
        border: 3px solid #0d6efd;
        box-shadow: 0 8px 24px rgba(13, 110, 253, 0.25);
        transition: all 0.4s ease;
        position: relative;
        overflow: hidden;
    }

    .btn-cta::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.1);
        transition: left 0.5s ease;
    }

    .btn-cta:hover::before {
        left: 100%;
    }

    .btn-cta h3 {
        margin: 0 0 12px 0;
        font-size: 28px;
        font-weight: 700;
        letter-spacing: -0.5px;
        color: white;
        transition: all 0.3s ease;
    }

    .btn-cta div {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        font-size: 16px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        padding: 8px 24px;
        background: white;
        color: #0d6efd;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .btn-cta div ion-icon {
        font-size: 22px;
        transition: transform 0.3s ease;
        --ionicon-stroke-width: 56px;
    }

    .btn-cta:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 32px rgba(13, 110, 253, 0.35);
        border-color: #0b5ed7;
        background: #0b5ed7;
        color: white;
    }

    .btn-cta:hover h3 {
        transform: scale(1.05);
    }

    .btn-cta:hover div {
        background: #fff;
        color: #0b5ed7;
        transform: scale(1.05);
    }

    .btn-cta:hover div ion-icon {
        transform: translateX(4px);
    }

    .btn-cta:active {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(13, 110, 253, 0.3);
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .btn-cta {
            padding: 24px 32px;
            max-width: 100%;
        }

        .btn-cta h3 {
            font-size: 22px;
            margin-bottom: 10px;
        }

        .btn-cta div {
            font-size: 14px;
            padding: 6px 20px;
        }
    }

    /* Checklist Requirements Styles */
    .checklist-requirements {
        padding: 0;
        margin: 0;
    }

    .checklist-item {
        display: flex;
        align-items: flex-start;
        padding: 14px 16px;
        margin-bottom: 8px;
        background: #f8f9fa;
        border-radius: 8px;
        transition: all 0.3s ease;
        cursor: default;
        border-left: 3px solid transparent;
    }

    .checklist-item:hover {
        background: #e9ecef;
        border-left-color: #0d6efd;
        transform: translateX(4px);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    }

    .checklist-number {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 28px;
        height: 28px;
        background: #0d6efd;
        color: white;
        border-radius: 50%;
        font-weight: 600;
        font-size: 13px;
        margin-right: 12px;
        flex-shrink: 0;
        transition: all 0.3s ease;
    }

    .checklist-item:hover .checklist-number {
        background: #0b5ed7;
        transform: scale(1.1);
    }

    .checklist-text {
        flex: 1;
        color: #495057;
        font-size: 14px;
        line-height: 1.6;
        padding-top: 3px;
    }

    .checklist-item:hover .checklist-text {
        color: #212529;
        font-weight: 500;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .checklist-item {
            padding: 12px 14px;
        }

        .checklist-number {
            min-width: 26px;
            height: 26px;
            font-size: 12px;
        }

        .checklist-text {
            font-size: 13px;
        }
    }
</style>
@endpush

@push('scripts')
@endpush
