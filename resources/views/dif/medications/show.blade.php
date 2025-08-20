@extends('layouts.master')
@section('title')Intranet @endsection
@section('content')
<!-- this is breadcrumbs -->
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') DIF @endslot
@slot('title') Medicamento: {{ $medication->generic_name }} @endslot
@endcomponent

<div class="row layout-spacing">
    <div class="main-content">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $medication->generic_name }}</h5>

                        <p class="card-text"><strong>Nombre comercial:</strong> {{ $medication->commercial_name ?? 'N/A' }}</p>

                        <div class="mb-3">
                            @if($medication->is_active)
                                <span class="badge bg-success">Activo</span>
                            @else
                                <span class="badge bg-danger">Inactivo</span>
                            @endif
                        </div>

                        @if($medication->description)
                            <p class="card-text"><strong>Descripción:</strong></p>
                            <p class="card-text">{{ $medication->description }}</p>
                        @endif

                        @if($medication->formula)
                            <p class="card-text"><strong>Fórmula:</strong></p>
                            <p class="card-text">{{ $medication->formula }}</p>
                        @endif

                        <hr>

                        <div class="d-flex gap-2" role="group" aria-label="Basic example">
                            <a href="{{ route('dif.medications.edit', $medication->id) }}" class="btn btn-sm btn-secondary">Editar</a>
                            <form method="POST" action="{{ route('dif.medications.destroy', $medication->id) }}" style="display: inline-block;">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de que deseas eliminar este medicamento?')">
                                    Eliminar
                                </button>
                            </form>
                            <a href="{{ route('dif.medications.index') }}" class="btn btn-sm btn-primary">Volver al listado</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Información adicional</h5>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h6>Presentación</h6>
                                <p class="text-muted">
                                    {{ $medication->type ?? 'N/A' }} {{ $medication->type_num ? ' - ' . $medication->type_num : '' }} {{ $medication->type_dosage ?? '' }}
                                </p>
                            </div>
                            <div class="col-md-6">
                                <h6>Vía de administración</h6>
                                <p class="text-muted">{{ $medication->use_type ?? 'N/A' }}</p>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-md-6">
                                <h6>Fechas</h6>
                                @php
                                    $exp = \Carbon\Carbon::parse($medication->expiration_date);
                                    $isExpired = $exp->lt(\Carbon\Carbon::now());
                                    $isSoon = !$isExpired && $exp->lte(\Carbon\Carbon::now()->addMonth());
                                @endphp
                                
                                <p class="text-muted">
                                    <strong>Expira:</strong>
                                    @if($isExpired)
                                        <span class="text-danger fw-bold">{{ $exp->format('d/m/Y') }}</span>
                                        <span class="badge bg-danger ms-2">Vencido</span>
                                    @elseif($isSoon)
                                        <span class="text-danger fw-bold">{{ $exp->format('d/m/Y') }}</span>
                                        <span class="badge bg-danger ms-2">Caduca pronto</span>
                                    @else
                                        {{ $exp->format('d/m/Y') }}
                                    @endif
                                </p>
                            </div>
                            <div class="col-md-6">
                                <h6>Metadatos</h6>
                                <p class="text-muted">
                                    <strong>Registrado:</strong> {{ $medication->created_at->format('d/m/Y H:i') }}<br>
                                    <strong>Última actualización:</strong> {{ $medication->updated_at->format('d/m/Y H:i') }}
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
