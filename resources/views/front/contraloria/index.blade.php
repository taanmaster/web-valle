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