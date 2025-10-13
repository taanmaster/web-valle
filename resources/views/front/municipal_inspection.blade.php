@extends('front.layouts.app')

@section('content')
    <div class="content">
        <div class="row mb-4">
            <div class="col-md-12 mb-4">
                <div class="card card-normal wow fadeInUp h-100">
                    <div class="card-content">
                        <h2>Registro Municipal de Inspecciones, Verificaciones y Visitas Domiciliarias</h2>
                        <p>
                            Transparencia en Acción: Registro Municipal de Inspecciones, Verificaciones y Visitas
                            Domiciliarias
                            En el Municipio de Valle de Santiago, Guanajuato, la transparencia y la rendición de cuentas son
                            principios rectores de nuestra administración. Entendemos que la interacción entre ciudadanos,
                            empresas y autoridades debe ser clara, predecible y apegada a la legalidad.
                            <br>
                            Por eso, en este apartado, ponemos a tu disposición el Registro Municipal de Inspecciones,
                            Verificaciones y Visitas Domiciliarias. Esta herramienta es crucial para garantizar la
                            legalidad, objetividad y justificación de todas las actuaciones de inspección y verificación
                            realizadas por las autoridades municipales.
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="card card-normal">
                    <div class="card-content w-100">
                        <livewire:municipal-inspection.table :mode="1" />
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
