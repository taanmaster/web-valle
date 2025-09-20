<div class="table-responsive">
    <table class="table">
        <thead class="thead-light">
            <tr>
                <th>ID</th>
                <th>Medicamento</th>
                <th>Variantes</th>
                <th>Inventario Total</th>
                <th>Estado</th>
                <th scope="col">Acciones</th>
            </tr>
        </thead>

        <tbody>
            @foreach($medications as $medication)
            @php
                $variantsCount = $medication->getVariantsCount();
                $totalStock = $medication->getTotalStock();
                $stockStatus = $medication->getOverallStockStatus();
            @endphp
            <tr>
                <th scope="row">#{{ $medication->id }}</th>
                <td>
                    <div>
                        <strong>{{ $medication->generic_name }}</strong>
                        @if($medication->commercial_name)
                            <br><small class="text-muted">{{ $medication->commercial_name }}</small>
                        @endif
                        {{--  
                        @if($medication->type || $medication->type_num || $medication->type_dosage)
                            <br><small class="text-muted">
                                {{ $medication->type ?? '' }}
                                @if($medication->type_num) - {{ $medication->type_num }} @endif
                                @if($medication->type_dosage) {{ $medication->type_dosage }} @endif
                            </small>
                        @endif
                        --}}
                    </div>
                </td>
                <td>
                    <div class="d-flex align-items-center gap-2">
                        <span class="fw-bold fs-5">{{ $variantsCount }}</span>
                        <small class="text-muted">
                            {{ $variantsCount == 1 ? 'variante' : 'variantes' }}
                        </small>
                    </div>
                    @if($variantsCount > 0)
                        <a href="{{ route('dif.medications.show', $medication->id) }}" class="btn btn-sm btn-outline-info mt-1">
                            <i class="fas fa-list"></i> Ver variantes
                        </a>
                    @endif
                </td>
                <td>
                    <div class="d-flex align-items-center gap-2">
                        <span class="fw-bold fs-4 {{ $totalStock > 0 ? 'text-success' : 'text-danger' }}">
                            {{ $totalStock }}
                        </span>
                        <small class="text-muted">unidades</small>
                    </div>
                </td>
                <td>
                    <div class="d-flex flex-column gap-1">
                        @if($medication->is_active)
                            <span class="badge bg-success">Activo</span>
                        @else
                            <span class="badge bg-secondary">Archivado</span>
                        @endif
                        
                        @if($variantsCount > 0)
                            <span class="badge {{ $stockStatus['badge_class'] }}">
                                {{ $stockStatus['label'] }}
                            </span>
                        @else
                            <span class="badge bg-secondary">Sin variantes</span>
                        @endif
                    </div>
                </td>
                <td>
                    <div class="dropdown">
                        <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton{{ $medication->id }}" 
                                data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-cog"></i> Acciones
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $medication->id }}">
                            <!-- Ver medicamento -->
                            <li>
                                <a class="dropdown-item" href="{{ route('dif.medications.show', $medication->id) }}">
                                    <i class="fas fa-eye text-primary me-2"></i>
                                    <span class="fw-medium">Ver Medicamento</span>
                                </a>
                            </li>
                            
                            <!-- Editar medicamento -->
                            <li>
                                <a class="dropdown-item" href="{{ route('dif.medications.edit', $medication->id) }}">
                                    <i class="fas fa-edit text-secondary me-2"></i>
                                    <span class="fw-medium">Editar Medicamento</span>
                                </a>
                            </li>
                            
                            <li><hr class="dropdown-divider"></li>
                            
                            <!-- Nueva variante -->
                            <li>
                                <a class="dropdown-item" href="{{ route('dif.medication_variants.create', ['medication_id' => $medication->id]) }}">
                                    <i class="fas fa-plus text-success me-2"></i>
                                    <span class="fw-medium">Nueva Variante</span>
                                </a>
                            </li>
                            
                            <!-- Ver variantes -->
                            @if($variantsCount > 0)
                                <li>
                                    <a class="dropdown-item" href="{{ route('dif.medications.show', $medication->id) }}">
                                        <i class="fas fa-list text-info me-2"></i>
                                        <span class="fw-medium">Ver Variantes ({{ $variantsCount }})</span>
                                    </a>
                                </li>
                            @endif
                            
                            <li><hr class="dropdown-divider"></li>
                            
                            <!-- Registrar movimiento -->
                            @if($variantsCount > 0)
                                <li>
                                    <h6 class="dropdown-header">
                                        <i class="fas fa-exchange-alt text-warning me-2"></i>
                                        Registrar Movimiento
                                    </h6>
                                </li>
                                @foreach($medication->variants as $variant)
                                    <li>
                                        <a class="dropdown-item ps-4" 
                                           href="{{ route('dif.stock_movements.create', ['variant_id' => $variant->id]) }}">
                                            <i class="fas fa-arrow-right text-muted me-2"></i>
                                            <span>{{ $variant->name }}</span>
                                            <small class="text-muted d-block">Stock: {{ $variant->getCurrentStock() }} unidades</small>
                                        </a>
                                    </li>
                                @endforeach
                            @else
                                <li>
                                    <span class="dropdown-item-text text-muted">
                                        <i class="fas fa-exchange-alt me-2"></i>
                                        No hay variantes para movimientos
                                    </span>
                                </li>
                            @endif
                        </ul>
                    </div>
                </td> 
            </tr>
            @endforeach                           
        </tbody>
    </table>                    
</div>
