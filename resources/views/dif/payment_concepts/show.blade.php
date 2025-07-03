@extends('layouts.master')
@section('title')Intranet @endsection
@section('content')
<!-- this is breadcrumbs -->
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') DIF @endslot
@slot('title') Concepto: {{ $paymentConcept->name }} @endslot
@endcomponent

<div class="row layout-spacing">
    <div class="main-content">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $paymentConcept->name }}</h5>
                        
                        <div class="mb-3">
                            @if($paymentConcept->is_active)
                                <span class="badge bg-success">Concepto Activo</span>
                            @else
                                <span class="badge bg-danger">Concepto Inactivo</span>
                            @endif
                        </div>

                        <div class="mb-3">
                            <h6 class="text-success">Monto</h6>
                            <h4 class="text-success fw-bold">${{ number_format($paymentConcept->amount, 2) }}</h4>
                        </div>
                        
                        @if($paymentConcept->description)
                            <p class="card-text"><strong>Descripción:</strong></p>
                            <p class="card-text">{{ $paymentConcept->description }}</p>
                        @endif

                        <hr>

                        <div class="d-flex gap-2" role="group" aria-label="Basic example">
                            <a href="{{ route('dif.payment_concepts.edit', $paymentConcept->id) }}" class="btn btn-sm btn-secondary">Editar</a>
                            <form method="POST" action="{{ route('dif.payment_concepts.destroy', $paymentConcept->id) }}" style="display: inline-block;">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de que deseas eliminar este concepto de pago?')">
                                    Eliminar
                                </button>
                            </form>
                            <a href="{{ route('dif.payment_concepts.index') }}" class="btn btn-sm btn-primary">Volver al listado</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Información adicional del Concepto</h5>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h6>Estado del Concepto</h6>
                                <p class="text-muted">
                                    @if($paymentConcept->is_active)
                                        <i class="fas fa-check-circle text-success"></i> Concepto activo y disponible para cobro
                                    @else
                                        <i class="fas fa-times-circle text-danger"></i> Concepto inactivo
                                    @endif
                                </p>
                            </div>
                            <div class="col-md-6">
                                <h6>Información del concepto</h6>
                                <p class="text-muted">
                                    @if($paymentConcept->description)
                                        <i class="fas fa-info-circle text-info"></i> Descripción disponible
                                    @else
                                        <i class="fas fa-exclamation-circle text-warning"></i> Sin descripción
                                    @endif
                                </p>
                            </div>
                        </div>
                        
                        <hr>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <h6>Detalles financieros</h6>
                                <p class="text-muted">
                                    <strong>Monto:</strong> ${{ number_format($paymentConcept->amount, 2) }} MXN<br>
                                    <strong>Tipo:</strong> {{ $paymentConcept->amount > 0 ? 'Concepto con costo' : 'Concepto gratuito' }}
                                </p>
                            </div>
                            <div class="col-md-6">
                                <h6>Fechas importantes</h6>
                                <p class="text-muted">
                                    <strong>Registrado:</strong> {{ $paymentConcept->created_at->format('d/m/Y H:i') }}<br>
                                    <strong>Última actualización:</strong> {{ $paymentConcept->updated_at->format('d/m/Y H:i') }}
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
