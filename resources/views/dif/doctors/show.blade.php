@extends('layouts.master')
@section('title')Intranet @endsection
@section('content')
<!-- this is breadcrumbs -->
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') DIF @endslot
@slot('title') Doctor: {{ $doctor->name }} @endslot
@endcomponent

<div class="row layout-spacing">
    <div class="main-content">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $doctor->name }}</h5>
                        <p class="card-text"><strong>Número de Empleado:</strong> {{ $doctor->employee_num }}</p>
                        <p class="card-text"><strong>Especialidad:</strong> {{ $doctor->speciality->name ?? 'N/A' }}</p>
                        
                        @if($doctor->phone)
                            <p class="card-text"><strong>Teléfono:</strong> {{ $doctor->phone }}</p>
                        @endif
                        
                        @if($doctor->email)
                            <p class="card-text"><strong>Email:</strong> {{ $doctor->email }}</p>
                        @endif
                        
                        @if($doctor->full_address)
                            <p class="card-text"><strong>Dirección:</strong> {{ $doctor->full_address }}</p>
                        @endif

                        <hr>

                        <div class="d-flex gap-2" role="group" aria-label="Basic example">
                            <a href="{{ route('dif.doctors.edit', $doctor->id) }}" class="btn btn-sm btn-secondary">Editar</a>
                            <form method="POST" action="{{ route('dif.doctors.destroy', $doctor->id) }}" style="display: inline-block;">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de que deseas eliminar este doctor?')">
                                    Eliminar
                                </button>
                            </form>
                            <a href="{{ route('dif.doctors.index') }}" class="btn btn-sm btn-primary">Volver al listado</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Información adicional del Doctor</h5>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h6>Consultas realizadas</h6>
                                <p class="text-muted">{{ $doctor->consultations->count() ?? 0 }} consultas registradas</p>
                            </div>
                            <div class="col-md-6">
                                <h6>Prescripciones</h6>
                                <p class="text-muted">{{ $doctor->prescriptions->count() ?? 0 }} prescripciones registradas</p>
                            </div>
                        </div>
                        
                        <hr>
                        
                        <div class="row">
                            <div class="col-12">
                                <h6>Fechas importantes</h6>
                                <p class="text-muted">
                                    <strong>Registrado:</strong> {{ $doctor->created_at->format('d/m/Y H:i') }}<br>
                                    <strong>Última actualización:</strong> {{ $doctor->updated_at->format('d/m/Y H:i') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
