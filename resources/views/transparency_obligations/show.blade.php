@extends('layouts.master')
@section('title')Intranet @endsection
@section('content')
<!-- this is breadcrumbs -->
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') Transparencia @endslot
@slot('title') Obligaciones @endslot
@endcomponent

<div class="row layout-spacing">
    <div class="main-content">

        <div class="row"> 
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5>#{{ $transparency_obligation->id }} - {{ $transparency_obligation->name }}</h5>
                    </div>
                    <div class="card-body">
                        
                    </div>
                    <div class="card-footer text-muted">
                        <div class="row">
                            <div class="col-md-6">
                                <small>Creado: {{ $transparency_obligation->created_at }}</small><br>
                                <small>Actualizado: {{ $transparency_obligation->updated_at }}</small>
                            </div>
                            <div class="col-md-6 text-right">
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <form method="POST" action="{{ route('transparency_obligations.destroy', $transparency_obligation->id) }}" style="display: inline-block;">
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class='bx bx-trash-alt'></i> Eliminar
                                        </button>
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
  
    </div>
</div>
@endsection
