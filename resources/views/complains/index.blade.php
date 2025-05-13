@extends('layouts.master')
@section('title')
    Intranet
@endsection
@section('content')
    <!-- Breadcrumbs -->
    @component('components.breadcrumb')
        @slot('li_1')
            Intranet
        @endslot
        @slot('li_2')
            Comunicación social
        @endslot
        @slot('title')
            Denuncias ciudadanas
        @endslot
    @endcomponent

    <div class="row layout-spacing">
        <div class="main-content">
            @if ($complains->count() == 0)
                <div class="row">
                    <div class="col-lg-12">
                        <div class="box">
                            <div class="box-body">
                                <div class="text-center" style="padding:80px 0px 100px 0px;">
                                    <img src="{{ asset('assets/images/empty.svg') }}" class="ml-auto mr-auto"
                                        style="width:30%; margin-bottom: 40px;">
                                    <h4>¡No hay dependencias guardadas en la base de datos!</h4>
                                    <p class="mb-4">Empieza a cargarlas en la sección correspondiente.</p>
                                    <a href="javascript:void(0)" class="btn btn-sm btn-primary btn-uppercase new-income"><i
                                            class="fas fa-plus"></i> Nueva dependencia</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="row">
                    @include('complains.utilities._table')
                </div>

                <div class="d-flex align-items-center justify-content-center">
                    {{ $complains->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
