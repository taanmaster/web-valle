@extends('layouts.master')
@section('title') Editar Costos @endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1') Desarrollo Urbano @endslot
        @slot('li_2') Actualización de Costos @endslot
        @slot('title') {{ $title }} @endslot
    @endcomponent

    <div class="row layout-spacing">
        <div class="main-content">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                        <div class="card-header bg-success text-white" style="border-radius: 12px 12px 0 0;">
                            <h5 class="mb-0 text-white"><i class="fas fa-money-bill me-2"></i> {{ $title }}</h5>
                        </div>
                        <div class="card-body p-4">

                            <p class="text-muted small mb-4">
                                Actualiza solo los montos. La descripción y la unidad de cada concepto no se modifican.
                            </p>

                            @if ($errors->any())
                                <div class="alert alert-danger border-0 shadow-sm">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                                    </ul>
                                </div>
                            @endif

                            <form action="{{ route('urban_dev.costs.update', $slug) }}" method="POST">
                                @csrf
                                @method('PUT')

                                @foreach ($costs as $cost)
                                    <div class="row align-items-center mb-3">
                                        <div class="col-md-7">
                                            <label class="form-label mb-0">{{ $cost->description }}</label>
                                            @if ($cost->unit)
                                                <small class="text-muted d-block">Unidad: {{ $cost->unit }}</small>
                                            @endif
                                        </div>
                                        <div class="col-md-5">
                                            <div class="input-group">
                                                <span class="input-group-text">$</span>
                                                <input type="number" step="0.01" min="0"
                                                    class="form-control @error('amounts.'.$cost->id) is-invalid @enderror"
                                                    name="amounts[{{ $cost->id }}]"
                                                    value="{{ old('amounts.'.$cost->id, $cost->amount) }}" required>
                                                @if ($cost->unit)
                                                    <span class="input-group-text">{{ $cost->unit }}</span>
                                                @endif
                                            </div>
                                            @error('amounts.'.$cost->id)
                                                <div class="text-danger small mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                @endforeach

                                <div class="d-flex justify-content-end gap-2 mt-4">
                                    <a href="{{ route('urban_dev.costs.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-times me-1"></i> Cancelar
                                    </a>
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-save me-1"></i> Guardar costos
                                    </button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
