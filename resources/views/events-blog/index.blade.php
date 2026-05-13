@extends('layouts.master')
@section('title')
    Eventos Conmemorativos
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Intranet
        @endslot
        @slot('li_2')
            Eventos Conmemorativos
        @endslot
        @slot('title')
            Blog Eventos
        @endslot
    @endcomponent

    <div class="row layout-spacing">
        <div class="main-content">
            <div class="row align-items-center mb-4">
                <div class="col text-start">
                    <a href="{{ route('events_blog.admin.create') }}" class="btn btn-primary">Nueva Entrada</a>
                </div>
            </div>

            @if ($entries->count() == 0)
                <div class="row">
                    <div class="col-lg-12">
                        <div class="box">
                            <div class="box-body">
                                <div class="text-center" style="padding:80px 0px 100px 0px;">
                                    <img src="{{ asset('assets/images/empty.svg') }}" class="ml-auto mr-auto"
                                        style="width:30%; margin-bottom: 40px;">
                                    <h4>¡No hay entradas guardadas!</h4>
                                    <p class="mb-4">Empieza a cargarlas en la sección correspondiente.</p>
                                    <a href="{{ route('events_blog.admin.create') }}"
                                        class="btn btn-sm btn-primary"><i class="fas fa-plus"></i> Nueva Entrada</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="row justify-content-center">
                    <div class="col-md-10">
                        <livewire:events-blog.entries-table />
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
