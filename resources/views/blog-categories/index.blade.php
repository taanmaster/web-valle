@extends('layouts.master')
@section('title')
    Categorías de Blog
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Intranet
        @endslot
        @slot('li_2')
            Configuración
        @endslot
        @slot('title')
            Categorías de Blog
        @endslot
    @endcomponent

    <div class="row layout-spacing">
        <div class="col-lg-12">
            <div class="statbox widget box box-shadow">
                <div class="widget-header">
                    <div class="row">
                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                            <h4>Categorías de Blog</h4>
                            <p class="text-muted mb-0">Usadas por las entradas de blog de las distintas direcciones.</p>
                        </div>
                    </div>
                </div>
                <div class="widget-content widget-content-area">

                    @livewire('blog-categories.manager')

                </div>
            </div>
        </div>
    </div>
@endsection
