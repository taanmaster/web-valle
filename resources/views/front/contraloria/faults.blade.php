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
        <div class="col-md-4 mb-4">
            <a href="{{ route('contraloria.faults.not-serious') }}" class="card link-card card-normal card-alignment-bottom wow fadeInUp" style="height: 430px;">
                <div class="card-icon bg-white text-dark d-flex align-items-center justify-content-center">
                    <ion-icon name="arrow-forward-outline" class="md hydrated"></ion-icon>
                </div>

                <div class="card-content">
                    <div class="d-flex flex-column mb-2 gap-3">
                        <div class="card-icon card-icon-static bg-warning text-white d-flex align-items-center justify-content-center">
                            <ion-icon name="document-text-outline"></ion-icon>
                        </div>
                        <h4 class="mb-0">Faltas administrativas no graves de los servidores públicos</h4>
                    </div>
                    <p class="mb-0">Art. 49 Ley de responsabilidades administrativas para el estado de Guanajuato</p>
                </div>
            </a>
        </div>

        <div class="col-md-4 mb-4">
            <a href="{{ route('contraloria.faults.not-serious-rules') }}" class="card link-card card-normal card-alignment-bottom wow fadeInUp" style="height: 430px;">
                <div class="card-icon bg-white text-dark d-flex align-items-center justify-content-center">
                    <ion-icon name="arrow-forward-outline" class="md hydrated"></ion-icon>
                </div>

                <div class="card-content">
                    <div class="d-flex flex-column mb-2 gap-3">
                        <div class="card-icon card-icon-static bg-info text-white d-flex align-items-center justify-content-center">
                            <ion-icon name="file-tray-full-outline"></ion-icon>
                        </div>
                        <h4 class="mb-0">Posibles sanciones de los servidores públicos por faltas administrativas no graves</h4>
                    </div>
                    <p class="mb-0">Art. 75 Ley de responsabilidades administrativas para el estado de Guanajuato.</p>
                </div>
            </a>
        </div>

        <div class="col-md-4 mb-4">
            <a href="{{ route('contraloria.faults.serious') }}" class="card link-card card-normal card-alignment-bottom wow fadeInUp" style="height: 430px;">
                <div class="card-icon bg-white text-dark d-flex align-items-center justify-content-center">
                    <ion-icon name="arrow-forward-outline" class="md hydrated"></ion-icon>
                </div>

                <div class="card-content">
                    <div class="d-flex flex-column mb-2 gap-3">
                        <div class="card-icon card-icon-static bg-danger text-white d-flex align-items-center justify-content-center">
                            <ion-icon name="hand-left-outline"></ion-icon>
                        </div>
                        <h4 class="mb-0">Faltas administrativas graves de los servidores públicos</h4>
                    </div>
                    <p class="mb-0">Art. 52-55 Ley de responsabilidades administrativas para el estado de Guanajuato.</p>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection