@extends('front.layouts.app')

@section('content')
<div class="container">
    <div class="row w-100 mt-4">
        <div class="col-md-6 h-100 mb-4">
            <a href="{{ route('transparency.obligations', 'Proactiva') }}" class="card link-card card-normal card-alignment-bottom wow fadeInUp h-100">
                <div class="card-icon bg-white text-dark d-flex align-items-center justify-content-center">
                    <ion-icon name="arrow-forward-outline" class="md hydrated"></ion-icon>
                </div>

                <div class="card-content">
                    <div class="d-flex align-items-center gap-3">
                        <div class="card-icon card-icon-static bg-primary text-white d-flex align-items-center justify-content-center">
                            <ion-icon name="documents-outline"></ion-icon>
                        </div>
                        <h4 class="mb-0">Quejas, Denuncias y Sugerencias</h4>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-6 h-100 mb-4">
            <a href="https://declaranetmunicipios.strc.guanajuato.gob.mx/#login" target="_blank" class="card link-card card-normal card-alignment-bottom wow fadeInUp h-100">
                <div class="card-icon bg-white text-dark d-flex align-items-center justify-content-center">
                    <ion-icon name="arrow-forward-outline" class="md hydrated"></ion-icon>
                </div>

                <div class="card-content">
                    <h4>Haz tu declaración patrimonial.</h4>
                </div>
            </a>

            <a href="{{ asset('transparencia/static_files/guia_solicitudes_informacion.pdf') }}" target="_blank" class="card link-card card-normal card-alignment-bottom wow fadeInUp h-100">
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