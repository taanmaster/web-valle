@extends('layouts.master')
@section('title')Intranet @endsection
@section('content')
<!-- this is breadcrumbs -->
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') DIF @endslot
@slot('title') Recetas Médicas @endslot
@endcomponent

<div class="row layout-spacing">
    <div class="main-content">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Detalles de la Receta Médica</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h6><strong>Número de Receta:</strong></h6>
                                <p>{{ $prescription->prescription_num }}</p>
                            </div>
                            <div class="col-md-6">
                                <h6><strong>Fecha:</strong></h6>
                                <p>{{ $prescription->prescription_date->format('d/m/Y') }}</p>
                            </div>
                            <div class="col-md-6">
                                <h6><strong>Doctor:</strong></h6>
                                <p>{{ $prescription->doctor->name ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-6">
                                <h6><strong>Estado:</strong></h6>
                                <p>
                                    @if($prescription->status == 'pending')
                                        <span class="badge bg-warning">Pendiente</span>
                                    @elseif($prescription->status == 'completed')
                                        <span class="badge bg-success">Completada</span>
                                    @elseif($prescription->status == 'cancelled')
                                        <span class="badge bg-danger">Cancelada</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Información del Paciente</h5>
                    </div>
                    <div class="card-body">
                        <h6 class="card-title">{{ $prescription->patient->name ?? 'N/A' }} {{ $prescription->patient->first_name ?? '' }} {{ $prescription->patient->last_name ?? '' }}</h6>
                        <p class="card-text"><strong>Teléfono:</strong> {{ $prescription->patient->phone ?? 'N/A' }}</p>
                        <p class="card-text"><strong>Email:</strong> {{ $prescription->patient->email ?? 'N/A' }}</p>
                        <p class="card-text"><strong>CURP:</strong> {{ $prescription->patient->curp ?? 'N/A' }}</p>

                        <hr>

                        <div class="d-flex gap-2" role="group" aria-label="Basic example">
                            <a href="{{ route('dif.prescriptions.edit', $prescription->id) }}" class="btn btn-sm btn-secondary">Editar</a>
                            <form method="POST" action="{{ route('dif.prescriptions.destroy', $prescription->id) }}" style="display: inline-block;">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                                <button type="submit" class="btn btn-sm btn-danger">
                                    Eliminar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
