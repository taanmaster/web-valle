@extends('front.layouts.app')

@section('content')
<div class="container">
    <div class="row mt-4">
        <div class="col-12">
            <div class="card card-normal card-alignment-bottom wow fadeInUp">
                <div class="card-title">
                    <div class="d-flex gap-3">
                        <div class="card-icon bg-secondary text-white d-flex align-items-center justify-content-center">
                            <ion-icon name="documents-outline"></ion-icon>
                        </div>
                        
                        <h3 class="mb-0">Ley General de Contabilidad Gubernamental <br>y las Normas Expedidas por la CONAC</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row w-100">
        <div class="col-md-6 mb-4">
            <a href="http://186.96.176.239/ley-general-de-contabilidad-gubernamental-casa-de-cultura" target="_blank" class="card link-card card-normal card-alignment-bottom wow fadeInUp h-100">
                <div class="card-icon bg-white text-dark d-flex align-items-center justify-content-center">
                    <ion-icon name="arrow-forward-outline" class="md hydrated"></ion-icon>
                </div>

                <div class="card-content">
                    <h4>Casa de la Cultura</h4>
                </div>
            </a>
        </div>

        <div class="col-md-6 mb-4">
            <a href="http://186.96.176.239/ley-general-de-contabilidad-gubernamental-y-las-normas-expedidas-por-la-conac-municipios/64-apartado-unidad-de-transparencia/descentralizados/797-ley-general-de-contabilidad-gubernamental-y-las-normas-expedidas-por-la-conac-municipios-dif" target="_blank" class="card link-card card-normal card-alignment-bottom wow fadeInUp h-100">
                <div class="card-icon bg-white text-dark d-flex align-items-center justify-content-center">
                    <ion-icon name="arrow-forward-outline" class="md hydrated"></ion-icon>
                </div>

                <div class="card-content">
                    <h4>DIF</h4>
                </div>
            </a>
        </div>

        <div class="col-md-6 mb-4">
            <a href="http://186.96.176.239/ley-general-de-contabilidad-gubernamental-y-las-normas-expedidas-por-la-conac-municipios-sapam" target="_blank" class="card link-card card-normal card-alignment-bottom wow fadeInUp h-100">
                <div class="card-icon bg-white text-dark d-flex align-items-center justify-content-center">
                    <ion-icon name="arrow-forward-outline" class="md hydrated"></ion-icon>
                </div>

                <div class="card-content">
                    <h4>SAPAM</h4>
                </div>
            </a>
        </div>

        <div class="col-md-6 mb-4">
            <a href="http://186.96.176.239/tesoreria" target="_blank" class="card link-card card-normal card-alignment-bottom wow fadeInUp h-100">
                <div class="card-icon bg-white text-dark d-flex align-items-center justify-content-center">
                    <ion-icon name="arrow-forward-outline" class="md hydrated"></ion-icon>
                </div>

                <div class="card-content">
                    <h4>Tesorería</h4>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection