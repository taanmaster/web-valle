@extends('front.layouts.app')

@section('content')
    <div class="content">
        <div class="row mb-4">
            <div class="col-md-12 mb-4">
                <div class="card card-normal wow fadeInUp h-100">
                    <div class="card-content">
                        <h2>Regulación Municipal</h2>
                        <p>
                            Nuestro Compromiso con la Transparencia y la Eficiencia: Registro Municipal de Regulaciones
                            En el Municipio de Valle de Santiago, Guanajuato, estamos firmemente comprometidos con un
                            gobierno transparente, eficiente y que facilite la vida de nuestros ciudadanos y empresas.
                            Entendemos que un marco normativo claro y accesible es fundamental para lograrlo.
                            Por eso, en este apartado, ponemos a tu disposición el Registro Municipal de Regulaciones de
                            Valle de Santiago, Guanajuato. Este registro es una herramienta clave para alcanzar nuestros
                            objetivos. Aquí encontrarás de forma sencilla y clara toda la normativa vigente que rige en
                            nuestro municipio, desde reglamentos hasta disposiciones administrativas.
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="card card-normal">
                    <div class="card-content w-100">
                        <livewire:municipal-regulations.table :mode="1" />
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
