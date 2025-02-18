@extends('layouts.master')
@section('title')Intranet @endsection
@section('content')
<!-- this is breadcrumbs -->
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') Transparencia @endslot
@slot('title') Repositorio @endslot
@endcomponent

<div class="row layout-spacing">
    <div class="main-content">
        <div class="row">
            <div class="col-md-12">
                <h3>Resultados de Búsqueda <div class="badge badge-info">{{ $transparency_files->count() }}</div></h3>
                @if(Request::input('query') == NULL)
                @else
                <p>Elementos que contienen: "{{ Request::input('query') }}"</p>
                @endif
                <hr>
            </div>	
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-4">
                                <h4 class="mt-0 header-title mb-4">Listado de Archivos</h4>
                            </div>
        
                            <div class="col-8 text-end">
                                @include('transparency_files.utilities._search_options')
                            </div>
                        </div>
                        
                        @if($transparency_files->count())
                            @include('transparency_files.utilities._table')
                        @else
                        <div class="text-center my-5">
                            <h4 class="mb-0">¡No hay resultados con esa búsqueda!</h4>
                            <p>Mejora tus términos de búsqueda o utiliza la búsqueda avanzada.</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
