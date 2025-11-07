@extends('front.layouts.app')

@section('content')
    <div class="container py-4">
        <div class="row">
            <div class="col-md-12">
                @include('front.user_profiles.partials._profile_card')

                <!-- Menú de navegación -->
                <div class="card wow fadeInUp">
                    <div class="card-header">
                        @include('front.user_profiles.partials._profile_nav')
                    </div>

                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="mb-0">
                                <ion-icon name="receipt-outline"></ion-icon> Mis Refrendos
                            </h5>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#endorsementModal">
                                <ion-icon name="add-circle-outline"></ion-icon> Ingresar Refrendo
                            </button>
                        </div>

                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <ion-icon name="checkmark-circle-outline"></ion-icon> {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <ion-icon name="alert-circle-outline"></ion-icon> {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if($endorsements->isEmpty())
                            <div class="alert alert-info text-center py-5">
                                <ion-icon name="document-outline" style="font-size: 64px; color: #0dcaf0;"></ion-icon>
                                <h5 class="mt-3 mb-2">No tienes refrendos registrados</h5>
                                <p class="text-muted mb-3">
                                    Los refrendos son pagos anuales obligatorios para mantener activo tu registro como proveedor.
                                </p>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#endorsementModal">
                                    <ion-icon name="add-circle-outline"></ion-icon> Registrar Primer Refrendo
                                </button>
                            </div>
                        @else
                            <!-- Lista de refrendos por año -->
                            <div class="accordion" id="endorsementsAccordion">
                                @foreach($endorsements as $year => $yearEndorsements)
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="heading{{ $year }}">
                                            <button class="accordion-button {{ $loop->first ? '' : 'collapsed' }}" 
                                                    type="button" 
                                                    data-bs-toggle="collapse" 
                                                    data-bs-target="#collapse{{ $year }}" 
                                                    aria-expanded="{{ $loop->first ? 'true' : 'false' }}" 
                                                    aria-controls="collapse{{ $year }}">
                                                <strong>Año {{ $year }}</strong>
                                                <span class="badge bg-primary ms-2">{{ $yearEndorsements->count() }} refrendo(s)</span>
                                            </button>
                                        </h2>
                                        <div id="collapse{{ $year }}" 
                                             class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}" 
                                             aria-labelledby="heading{{ $year }}" 
                                             data-bs-parent="#endorsementsAccordion">
                                            <div class="accordion-body">
                                                <div class="table-responsive">
                                                    <table class="table table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th>Año</th>
                                                                <th>Fecha de Registro</th>
                                                                {{-- <th>Proveedor Asociado</th> --}}
                                                                <th>Estado</th>
                                                                <th>Comprobante</th>
                                                                <th>Acciones</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($yearEndorsements as $endorsement)
                                                                <tr>
                                                                    <td><strong>{{ $endorsement->year }}</strong></td>
                                                                    <td>{{ $endorsement->created_at->format('d/m/Y') }}</td>
                                                                    {{--  
                                                                    <td>
                                                                        @if($endorsement->supplier)
                                                                            <strong>{{ $endorsement->supplier->registration_number }}</strong><br>
                                                                            <small class="text-muted">{{ $endorsement->supplier->display_name }}</small>
                                                                        @else
                                                                            <span class="badge bg-secondary">Sin Asociar</span>
                                                                        @endif
                                                                    </td>
                                                                    --}}
                                                                    <td>{!! $endorsement->status_badge !!}</td>
                                                                    <td>
                                                                        <a href="{{ $endorsement->s3_url }}" 
                                                                           target="_blank" 
                                                                           class="btn btn-sm btn-outline-primary">
                                                                            <ion-icon name="eye-outline"></ion-icon> Ver
                                                                        </a>
                                                                    </td>
                                                                    <td>
                                                                        @if(!$endorsement->is_approved)
                                                                            <form action="{{ route('supplier.endorsement.destroy', $endorsement->id) }}" 
                                                                                  method="POST" 
                                                                                  class="d-inline"
                                                                                  onsubmit="return confirm('¿Estás seguro de eliminar este refrendo?');">
                                                                                @csrf
                                                                                @method('DELETE')
                                                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                                                    <ion-icon name="trash-outline"></ion-icon> Eliminar
                                                                                </button>
                                                                            </form>
                                                                        @else
                                                                            <span class="text-muted small">Aprobado</span>
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para nuevo refrendo -->
    <div class="modal fade" id="endorsementModal" tabindex="-1" aria-labelledby="endorsementModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="endorsementModalLabel">
                        <ion-icon name="add-circle-outline"></ion-icon> Nuevo Refrendo
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('supplier.endorsement.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <!-- Selector de proveedor -->
                        {{--  
                        <div class="mb-3">
                            <label for="supplier_id" class="form-label">Selecciona el Alta de Proveedor</label>
                            <select name="supplier_id" id="supplier_id" class="form-select @error('supplier_id') is-invalid @enderror" required>
                                <option value="">-- Selecciona --</option>
                                @foreach($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                                        {{ $supplier->registration_number }} - {{ $supplier->display_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('supplier_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        --}}

                        <!-- Selector de año -->
                        <div class="mb-3">
                            <label for="year" class="form-label">Selecciona Año</label>
                            <select name="year" id="year" class="form-select @error('year') is-invalid @enderror" required>
                                <option value="">-- Selecciona --</option>
                                @foreach($availableYears as $year)
                                    <option value="{{ $year }}" {{ old('year') == $year ? 'selected' : '' }}>
                                        {{ $year }}
                                    </option>
                                @endforeach
                            </select>
                            @error('year')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Subir comprobante -->
                        <div class="mb-3">
                            <label for="file" class="form-label">Subir Comprobante</label>
                            <input type="file" 
                                   name="file" 
                                   id="file" 
                                   class="form-control @error('file') is-invalid @enderror" 
                                   accept=".pdf,.jpg,.jpeg,.png" 
                                   required>
                            <small class="text-muted">Formatos permitidos: PDF, JPG, PNG (Máx. 10MB)</small>
                            @error('file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Nota informativa -->
                        <div class="alert alert-warning">
                            <ion-icon name="alert-circle-outline"></ion-icon>
                            <strong>Recuerda que tienes que acudir presencial a entregar el comprobante de pago para que este sea válido**</strong>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-warning">
                            <ion-icon name="save-outline"></ion-icon> Guardar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Reabrir modal si hay errores de validación
    @if($errors->any())
        var endorsementModal = new bootstrap.Modal(document.getElementById('endorsementModal'));
        endorsementModal.show();
    @endif
</script>
@endpush

