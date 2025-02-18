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
                        <h5>#{{ $financial_support_type->id }} - {{ $financial_support_type->name }}</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            <li class="list-group-item">{!! $financial_support_type->doc_birth_certificate ? '<span class="text-success">✔</span>' : '<span class="text-danger">✘</span>' !!} Acta de nacimiento</li>
                            <li class="list-group-item">{!! $financial_support_type->doc_ine ? '<span class="text-success">✔</span>' : '<span class="text-danger">✘</span>' !!} INE</li>
                            <li class="list-group-item">{!! $financial_support_type->doc_address_proof ? '<span class="text-success">✔</span>' : '<span class="text-danger">✘</span>' !!} Comprobante de domicilio</li>
                            <li class="list-group-item">{!! $financial_support_type->doc_rfc ? '<span class="text-success">✔</span>' : '<span class="text-danger">✘</span>' !!} RFC</li>
                            <li class="list-group-item">{!! $financial_support_type->doc_death_certificate ? '<span class="text-success">✔</span>' : '<span class="text-danger">✘</span>' !!} Acta de defunción</li>
                            <li class="list-group-item">{!! $financial_support_type->doc_funeral_payment ? '<span class="text-success">✔</span>' : '<span class="text-danger">✘</span>' !!} Hoja de paga funeraria</li>
                            <li class="list-group-item">{!! $financial_support_type->doc_cemetery_docs ? '<span class="text-success">✔</span>' : '<span class="text-danger">✘</span>' !!} Documentos del panteón</li>
                            <li class="list-group-item">{!! $financial_support_type->doc_study_certificate ? '<span class="text-success">✔</span>' : '<span class="text-danger">✘</span>' !!} Constancia de estudios</li>
                            <li class="list-group-item">{!! $financial_support_type->doc_medical_prescriptions ? '<span class="text-success">✔</span>' : '<span class="text-danger">✘</span>' !!} Recetas médicas</li>
                            <li class="list-group-item">{!! $financial_support_type->doc_medical_certificate ? '<span class="text-success">✔</span>' : '<span class="text-danger">✘</span>' !!} Constancia médica</li>
                            <li class="list-group-item">{!! $financial_support_type->doc_hospital_visit_card ? '<span class="text-success">✔</span>' : '<span class="text-danger">✘</span>' !!} Tarjetón de visita al hospital</li>
                        </ul>
                    </div>
                    <div class="card-footer text-muted">
                        <div class="row">
                            <div class="col-md-6">
                                <small>Creado: {{ $financial_support_type->created_at }}</small><br>
                                <small>Actualizado: {{ $financial_support_type->updated_at }}</small>
                            </div>
                            <div class="col-md-6 text-right">
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <form method="POST" action="{{ route('financial_support_types.destroy', $financial_support_type->id) }}" style="display: inline-block;">
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
