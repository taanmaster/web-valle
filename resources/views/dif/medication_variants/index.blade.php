@extends('layouts.master')
@section('title')Variantes de Medicamentos @endsection
@section('content')
<!-- this is breadcrumbs -->
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') DIF @endslot
@slot('title') Variantes de Medicamentos @endslot
@endcomponent

<div class="row layout-spacing">
    <div class="main-content">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Variantes de Medicamentos</h5>

                        <div class="d-flex justify-content-end">
                            <a href="{{ route('dif.medication_variants.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Agregar Variante
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        <!-- Formulario de búsqueda -->
                        <form method="GET" action="{{ route('dif.medication_variants.index') }}" class="mb-3">
                            <div class="row">
                                <div class="col-md-10">
                                    <input type="text" name="search" class="form-control" placeholder="Buscar por nombre, SKU, presentación o medicamento..." value="{{ request('search') }}">
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-primary w-100">Buscar</button>
                                </div>
                            </div>
                        </form>

                        @if($variants->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Medicamento</th>
                                            <th>Nombre de Variante</th>
                                            <th>SKU</th>
                                            <th>Presentación</th>
                                            <th>Vía de Administración</th>
                                            <th>Precio</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($variants as $variant)
                                            <tr>
                                                <td>
                                                    <strong>{{ $variant->medication->generic_name }}</strong>
                                                    @if($variant->medication->commercial_name)
                                                        <br><small class="text-muted">{{ $variant->medication->commercial_name }}</small>
                                                    @endif
                                                </td>
                                                <td>{{ $variant->name }}</td>
                                                <td><code>{{ $variant->sku }}</code></td>
                                                <td>
                                                    {{ $variant->type ?? 'N/A' }}
                                                    @if($variant->type_num)
                                                        - {{ $variant->type_num }}
                                                    @endif
                                                    @if($variant->type_dosage)
                                                        {{ $variant->type_dosage }}
                                                    @endif
                                                </td>
                                                <td>{{ $variant->use_type ?? 'N/A' }}</td>
                                                <td>
                                                    @if($variant->price)
                                                        ${{ number_format($variant->price, 2) }}
                                                    @else
                                                        <span class="text-muted">N/A</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        <a href="{{ route('dif.medication_variants.show', $variant->id) }}" class="btn btn-sm btn-info">Ver</a>
                                                        <a href="{{ route('dif.medication_variants.edit', $variant->id) }}" class="btn btn-sm btn-secondary">Editar</a>
                                                        <form method="POST" action="{{ route('dif.medication_variants.destroy', $variant->id) }}" style="display: inline-block;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de que deseas eliminar esta variante?')">
                                                                Eliminar
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Paginación -->
                            <div class="d-flex justify-content-center">
                                {{ $variants->appends(request()->query())->links() }}
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-pills fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">No hay variantes registradas</h5>
                                <p class="text-muted">Comienza agregando la primera variante de medicamento.</p>
                                <a href="{{ route('dif.medication_variants.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Agregar Primera Variante
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
