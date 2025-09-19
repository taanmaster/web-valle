@extends('layouts.master')
@section('title')Editar Variante: {{ $variant->name }} @endsection
@section('content')
<!-- this is breadcrumbs -->
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') DIF @endslot
@slot('li_3') <a href="{{ route('dif.medication_variants.index') }}">Variantes de Medicamentos</a> @endslot
@slot('li_4') <a href="{{ route('dif.medication_variants.show', $variant->id) }}">{{ $variant->name }}</a> @endslot
@slot('title') Editar Variante @endslot
@endcomponent

<div class="row layout-spacing">
    <div class="main-content">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Editar Variante: {{ $variant->name }}</h5>
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('dif.medication_variants.update', $variant->id) }}">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="medication_id" class="form-label">Medicamento Base <span class="text-danger">*</span></label>
                                <select class="form-select @error('medication_id') is-invalid @enderror" id="medication_id" name="medication_id" required>
                                    <option value="">Seleccionar medicamento...</option>
                                    @foreach($medications as $medication)
                                        <option value="{{ $medication->id }}" {{ old('medication_id', $variant->medication_id) == $medication->id ? 'selected' : '' }}>
                                            {{ $medication->generic_name }}
                                            @if($medication->commercial_name)
                                                ({{ $medication->commercial_name }})
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                                @error('medication_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Nombre de la Variante <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $variant->name) }}" required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="sku" class="form-label">SKU <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('sku') is-invalid @enderror" id="sku" name="sku" value="{{ old('sku', $variant->sku) }}" required>
                                        <div class="form-text">Código único para identificar esta variante</div>
                                        @error('sku')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="price" class="form-label">Precio</label>
                                        <div class="input-group">
                                            <span class="input-group-text">$</span>
                                            <input type="number" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price', $variant->price) }}" step="0.01" min="0">
                                        </div>
                                        @error('price')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="type" class="form-label">Presentación</label>
                                        <select class="form-select @error('type') is-invalid @enderror" id="type" name="type">
                                            <option value="">Seleccionar...</option>
                                            <option value="Tableta" {{ old('type', $variant->type) == 'Tableta' ? 'selected' : '' }}>Tableta</option>
                                            <option value="Cápsula" {{ old('type', $variant->type) == 'Cápsula' ? 'selected' : '' }}>Cápsula</option>
                                            <option value="Píldora" {{ old('type', $variant->type) == 'Píldora' ? 'selected' : '' }}>Píldora</option>
                                            <option value="Supositorio" {{ old('type', $variant->type) == 'Supositorio' ? 'selected' : '' }}>Supositorio</option>
                                            <option value="Jarabe" {{ old('type', $variant->type) == 'Jarabe' ? 'selected' : '' }}>Jarabe</option>
                                            <option value="Gotas" {{ old('type', $variant->type) == 'Gotas' ? 'selected' : '' }}>Gotas</option>
                                            <option value="Crema" {{ old('type', $variant->type) == 'Crema' ? 'selected' : '' }}>Crema</option>
                                            <option value="Gel" {{ old('type', $variant->type) == 'Gel' ? 'selected' : '' }}>Gel</option>
                                            <option value="Pomada" {{ old('type', $variant->type) == 'Pomada' ? 'selected' : '' }}>Pomada</option>
                                            <option value="Spray" {{ old('type', $variant->type) == 'Spray' ? 'selected' : '' }}>Spray</option>
                                            <option value="Parche" {{ old('type', $variant->type) == 'Parche' ? 'selected' : '' }}>Parche</option>
                                            <option value="Inyectable" {{ old('type', $variant->type) == 'Inyectable' ? 'selected' : '' }}>Inyectable</option>
                                        </select>
                                        @error('type')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="type_num" class="form-label">Cantidad</label>
                                        <input type="text" class="form-control @error('type_num') is-invalid @enderror" id="type_num" name="type_num" value="{{ old('type_num', $variant->type_num) }}" placeholder="ej. 30, 500">
                                        <div class="form-text">Cantidad de unidades o volumen</div>
                                        @error('type_num')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="type_dosage" class="form-label">Unidad de Medida</label>
                                        <select class="form-select @error('type_dosage') is-invalid @enderror" id="type_dosage" name="type_dosage">
                                            <option value="">Seleccionar...</option>
                                            <option value="mg" {{ old('type_dosage', $variant->type_dosage) == 'mg' ? 'selected' : '' }}>mg (miligramos)</option>
                                            <option value="g" {{ old('type_dosage', $variant->type_dosage) == 'g' ? 'selected' : '' }}>g (gramos)</option>
                                            <option value="ml" {{ old('type_dosage', $variant->type_dosage) == 'ml' ? 'selected' : '' }}>ml (mililitros)</option>
                                            <option value="l" {{ old('type_dosage', $variant->type_dosage) == 'l' ? 'selected' : '' }}>l (litros)</option>
                                            <option value="mcg" {{ old('type_dosage', $variant->type_dosage) == 'mcg' ? 'selected' : '' }}>mcg (microgramos)</option>
                                            <option value="UI" {{ old('type_dosage', $variant->type_dosage) == 'UI' ? 'selected' : '' }}>UI (Unidades Internacionales)</option>
                                            <option value="%" {{ old('type_dosage', $variant->type_dosage) == '%' ? 'selected' : '' }}>% (porcentaje)</option>
                                        </select>
                                        @error('type_dosage')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="use_type" class="form-label">Vía de Administración</label>
                                <select class="form-select @error('use_type') is-invalid @enderror" id="use_type" name="use_type">
                                    <option value="">Seleccionar...</option>
                                    <option value="Oral" {{ old('use_type', $variant->use_type) == 'Oral' ? 'selected' : '' }}>Oral</option>
                                    <option value="Tópica" {{ old('use_type', $variant->use_type) == 'Tópica' ? 'selected' : '' }}>Tópica</option>
                                    <option value="Oftálmica" {{ old('use_type', $variant->use_type) == 'Oftálmica' ? 'selected' : '' }}>Oftálmica</option>
                                    <option value="Ótica" {{ old('use_type', $variant->use_type) == 'Ótica' ? 'selected' : '' }}>Ótica</option>
                                    <option value="Inyectable" {{ old('use_type', $variant->use_type) == 'Inyectable' ? 'selected' : '' }}>Inyectable</option>
                                    <option value="Intravenosa" {{ old('use_type', $variant->use_type) == 'Intravenosa' ? 'selected' : '' }}>Intravenosa</option>
                                    <option value="Intramuscular" {{ old('use_type', $variant->use_type) == 'Intramuscular' ? 'selected' : '' }}>Intramuscular</option>
                                    <option value="Subcutánea" {{ old('use_type', $variant->use_type) == 'Subcutánea' ? 'selected' : '' }}>Subcutánea</option>
                                    <option value="Rectal" {{ old('use_type', $variant->use_type) == 'Rectal' ? 'selected' : '' }}>Rectal</option>
                                    <option value="Vaginal" {{ old('use_type', $variant->use_type) == 'Vaginal' ? 'selected' : '' }}>Vaginal</option>
                                    <option value="Nasal" {{ old('use_type', $variant->use_type) == 'Nasal' ? 'selected' : '' }}>Nasal</option>
                                    <option value="Inhalatoria" {{ old('use_type', $variant->use_type) == 'Inhalatoria' ? 'selected' : '' }}>Inhalatoria</option>
                                </select>
                                @error('use_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">Actualizar Variante</button>
                                <a href="{{ route('dif.medication_variants.show', $variant->id) }}" class="btn btn-secondary">Cancelar</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
