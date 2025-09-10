@extends('layouts.master')
@section('title')
    Intranet
@endsection
@section('content')
    <!-- Breadcrumbs -->
    @component('components.breadcrumb')
        @slot('li_1')
            Mejora regulatoria
        @endslot
        @slot('li_2')
            IMPLAN
        @endslot
        @slot('title')
            Blog
        @endslot
    @endcomponent

    <div class="row layout-spacing">
        <div class="main-content">

            <div class="row justify-content-end">
                <div class="col-md-3 text-end">
                    <a href="{{ route('implan.blog.create') }}" class="btn btn-primary btn-sm">Nueva Publicación</a>
                </div>
            </div>

            @if ($posts->count() > 0)
                @include('implan.blog.utilities.table')
            @else
                <div class="row">
                    <div class="col-lg-12">
                        <div class="box">
                            <div class="box-body">
                                <div class="text-center" style="padding:80px 0px 100px 0px;">
                                    <img src="{{ asset('assets/images/empty.svg') }}" class="ml-auto mr-auto"
                                        style="width:30%; margin-bottom: 40px;">
                                    <h4>¡No hay publicaciones guardadas en la base de datos!</h4>
                                    <p class="mb-4">Empieza a cargarlas en la sección correspondiente.</p>
                                    <a href="{{ route('implan.blog.create') }}" class="btn btn-primary btn-sm">Nueva
                                        Publicación</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>
@endsection
