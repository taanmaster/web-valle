@extends('layouts.master')
@section('title')Paso 2: Proveedor Económico @endsection

@section('content')
<!-- Breadcrumbs -->
@component('components.breadcrumb')
@slot('li_1') Intranet @endslot
@slot('li_2') DIF @endslot
@slot('li_3') Estudios Socioeconómicos @endslot
@slot('title') Paso 2: Proveedor Económico @endslot
@endcomponent

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h4 class="card-title mb-0">Paso 2: Datos del Proveedor Económico</h4>
                        <p class="text-muted mb-0">{{ $test->citizen_name }} {{ $test->citizen_last_name }}</p>
                    </div>

                    <div class="col-auto">
                        <a href="{{ route('dif.socio_economic_tests.show', $test->id) }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left"></i> Volver
                        </a>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <!-- Barra de progreso -->
                <div class="progress-steps mb-4">
                    <div class="step-progress">
                        <div class="step completed">
                            <div class="step-number">✓</div>
                            <div class="step-title">Datos Generales</div>
                        </div>
                        <div class="step active">
                            <div class="step-number">2</div>
                            <div class="step-title">Economía y Dependientes</div>
                        </div>
                        <div class="step">
                            <div class="step-number">3</div>
                            <div class="step-title">Estructura Económica</div>
                        </div>
                        <div class="step">
                            <div class="step-number">4</div>
                            <div class="step-title">Salud</div>
                        </div>
                        <div class="step">
                            <div class="step-number">5</div>
                            <div class="step-title">Vivienda y Entorno</div>
                        </div>
                    </div>
                </div>

                <form action="{{ route('dif.socio_economic_tests.step2.store', $test->id) }}" method="POST" class="step-form" data-step="2">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-12">
                            <hr>
                            <h6 class="text-white bg-dark p-2 text-uppercase mb-3">
                                <i class="fas fa-check"></i> Datos Proveedor Económico
                            </h6>
                        </div>
                        
                        <!-- Estado Civil -->
                        <div class="col-md-12">
                            <div class="mb-4">
                                <label class="form-label fw-bold">Estado Civil</label>
                                <div class="px-2 d-flex justify-content-between flex-wrap gap-2">
                                    <div class="form-check flex-fill">
                                        <input class="form-check-input" type="radio" name="civil_status" value="single_mother_children" 
                                               data-points="5" id="civil1" {{ old('civil_status') == 'single_mother_children' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="civil1">
                                            Madre soltera con hijos / Viuda con hijos <span class="badge bg-danger ms-2">5 pts</span>
                                        </label>
                                    </div>
                                    <div class="form-check flex-fill">
                                        <input class="form-check-input" type="radio" name="civil_status" value="single_mother" 
                                               data-points="3" id="civil2" {{ old('civil_status') == 'single_mother' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="civil2">
                                            Madre soltera / Viuda sin hijos <span class="badge bg-warning ms-2">3 pts</span>
                                        </label>
                                    </div>
                                    <div class="form-check flex-fill">
                                        <input class="form-check-input" type="radio" name="civil_status" value="other" 
                                               data-points="1" id="civil3" {{ old('civil_status') == 'other' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="civil3">
                                            Unión libre sin hijos / Divorciada sin hijos / Soltera sin hijos <span class="badge bg-success ms-2">1 pt</span>
                                        </label>
                                    </div>
                                </div>
                                @error('civil_status')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                                <hr class="mt-1">
                            </div>
                            
                        </div>

                        <!-- Edad -->
                        <div class="col-md-12">
                            <div class="mb-4">
                                <label class="form-label fw-bold">Edad</label>
                                <div class="px-2 d-flex justify-content-between flex-wrap gap-2">
                                    <div class="form-check flex-fill mb-2">
                                        <input class="form-check-input" type="radio" name="age_range" value="65_plus" 
                                               data-points="5" id="age1" {{ old('age_range') == '65_plus' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="age1">
                                            65 años o más <span class="badge bg-danger ms-2">5 pts</span>
                                        </label>
                                    </div>
                                    <div class="form-check flex-fill mb-2">
                                        <input class="form-check-input" type="radio" name="age_range" value="38_64" 
                                               data-points="4" id="age2" {{ old('age_range') == '38_64' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="age2">
                                            38 a 64 años <span class="badge bg-warning ms-2">4 pts</span>
                                        </label>
                                    </div>
                                    <div class="form-check flex-fill mb-2">
                                        <input class="form-check-input" type="radio" name="age_range" value="17_37" 
                                               data-points="2" id="age3" {{ old('age_range') == '17_37' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="age3">
                                            17 a 37 años <span class="badge bg-info ms-2">2 pts</span>
                                        </label>
                                    </div>
                                    <div class="form-check flex-fill mb-2">
                                        <input class="form-check-input" type="radio" name="age_range" value="under_17" 
                                               data-points="1" id="age4" {{ old('age_range') == 'under_17' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="age4">
                                            Menor a 17 años <span class="badge bg-success ms-2">1 pt</span>
                                        </label>
                                    </div>
                                </div>
                                @error('age_range')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                                <hr class="mt-1">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Ocupación -->
                        <div class="col-md-12">
                            <div class="mb-4">
                                <label class="form-label fw-bold">Ocupación</label>
                                <div class="px-2 d-flex justify-content-between flex-wrap gap-2">
                                    <div class="form-check flex-fill mb-2">
                                        <input class="form-check-input" type="radio" name="occupation" value="unemployed" 
                                               data-points="5" id="occ1" {{ old('occupation') == 'unemployed' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="occ1">
                                            Desempleado <span class="badge bg-danger ms-2">5 pts</span>
                                        </label>
                                    </div>
                                    <div class="form-check flex-fill mb-2">
                                        <input class="form-check-input" type="radio" name="occupation" value="eventual" 
                                               data-points="3" id="occ2" {{ old('occupation') == 'eventual' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="occ2">
                                            Eventual <span class="badge bg-warning ms-2">3 pts</span>
                                        </label>
                                    </div>
                                    <div class="form-check flex-fill mb-2">
                                        <input class="form-check-input" type="radio" name="occupation" value="retired" 
                                               data-points="2" id="occ3" {{ old('occupation') == 'retired' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="occ3">
                                            Jubilado/Pensionado <span class="badge bg-info ms-2">2 pts</span>
                                        </label>
                                    </div>
                                    <div class="form-check flex-fill mb-2">
                                        <input class="form-check-input" type="radio" name="occupation" value="employed" 
                                               data-points="1" id="occ4" {{ old('occupation') == 'employed' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="occ4">
                                            Empleado <span class="badge bg-success ms-2">1 pt</span>
                                        </label>
                                    </div>
                                </div>
                                @error('occupation')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror

                                <hr class="mt-1">
                            </div>
                        </div>

                        <!-- Escolaridad -->
                        <div class="col-md-12">
                            <div class="mb-4">
                                <label class="form-label fw-bold">Escolaridad</label>
                                <div class="px-2 d-flex justify-content-between flex-wrap gap-2">
                                    <div class="form-check flex-fill mb-2">
                                        <input class="form-check-input" type="radio" name="education" value="none" 
                                               data-points="5" id="edu1" {{ old('education') == 'none' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="edu1">
                                            Sin estudios <span class="badge bg-danger ms-2">5 pts</span>
                                        </label>
                                    </div>
                                    <div class="form-check flex-fill mb-2">
                                        <input class="form-check-input" type="radio" name="education" value="primary" 
                                               data-points="3" id="edu2" {{ old('education') == 'primary' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="edu2">
                                            Primaria <span class="badge bg-warning ms-2">3 pts</span>
                                        </label>
                                    </div>
                                    <div class="form-check flex-fill mb-2">
                                        <input class="form-check-input" type="radio" name="education" value="secondary" 
                                               data-points="2" id="edu3" {{ old('education') == 'secondary' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="edu3">
                                            Secundaria <span class="badge bg-info ms-2">2 pts</span>
                                        </label>
                                    </div>
                                    <div class="form-check flex-fill mb-2">
                                        <input class="form-check-input" type="radio" name="education" value="high_school" 
                                               data-points="1" id="edu4" {{ old('education') == 'high_school' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="edu4">
                                            Preparatoria/Técnica <span class="badge bg-success ms-2">1 pt</span>
                                        </label>
                                    </div>
                                    <div class="form-check flex-fill mb-2">
                                        <input class="form-check-input" type="radio" name="education" value="professional" 
                                               data-points="1" id="edu5" {{ old('education') == 'professional' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="edu5">
                                            Profesionista <span class="badge bg-success ms-2">1 pt</span>
                                        </label>
                                    </div>
                                </div>
                                @error('education')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror

                                <hr class="mt-1">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <h6 class="text-white bg-dark p-2 text-uppercase mb-3">
                                <i class="fas fa-check"></i> Estructura Familiar
                            </h6>
                        </div>

                        <!-- Dependencia Económica -->
                        <div class="col-md-12">
                            <label class="form-label fw-bold">Dependencia Económica (Número total de personas que dependen económicamente)</label>
                            <div class="px-2 d-flex justify-content-between flex-wrap gap-2">
                                <div class="form-check flex-fill mb-2">
                                    <input class="form-check-input" type="radio" name="dependents_count" value="16" 
                                        data-points="5" id="dep1" {{ old('dependents_count') == '16' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="dep1">
                                        16+ <span class="badge bg-danger ms-2">5 pts</span>
                                    </label>
                                </div>
                                <div class="form-check flex-fill mb-2">
                                    <input class="form-check-input" type="radio" name="dependents_count" value="15" 
                                        data-points="3" id="dep2" {{ old('dependents_count') == '15' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="dep2">
                                        9 a 15 personas <span class="badge bg-warning ms-2">3 pts</span>
                                    </label>
                                </div>
                                <div class="form-check flex-fill mb-2">
                                    <input class="form-check-input" type="radio" name="dependents_count" value="9" 
                                        data-points="2" id="dep3" {{ old('dependents_count') == '9' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="dep3">
                                        6 a 9 personas <span class="badge bg-warning ms-2">2 pts</span>
                                    </label>
                                </div>
                                <div class="form-check flex-fill mb-2">
                                    <input class="form-check-input" type="radio" name="dependents_count" value="5" 
                                        data-points="1" id="dep4" {{ old('dependents_count') == '5' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="dep4">
                                        3 a 5 personas <span class="badge bg-info ms-2">1 pt</span>
                                    </label>
                                </div>
                                <div class="form-check flex-fill mb-2">
                                    <input class="form-check-input" type="radio" name="dependents_count" value="2" 
                                        data-points="1" id="dep5" {{ old('dependents_count') == '2' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="dep5">
                                        1 a 2 personas <span class="badge bg-success ms-2">1 pt</span>
                                    </label>
                                </div>
                            </div>
                            @error('dependents_count')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror

                            <hr class="mt-1">
                        </div>

                        <!-- Tabla de Dependientes Editable -->
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="mb-0">
                                    <i class="fas fa-users me-2"></i>
                                    Dependientes Registrados
                                </h5>

                                <div class="text-end">
                                    <button type="button" class="btn btn-outline-primary" id="addDependentRow">
                                        <i class="fas fa-plus"></i> Agregar Dependiente
                                    </button>
                                </div>
                            </div>
                            
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered" id="dependentsTable">
                                    <thead class="table-light">
                                        <tr>
                                            <th width="18%">Nombre</th>
                                            <th width="8%">Edad</th>
                                            <th width="12%">Parentesco</th>
                                            <th width="12%">Escolaridad</th>
                                            <th width="12%">Estado Civil</th>
                                            <th width="12%">Ocupación</th>
                                            <th width="10%">Ingreso Sem.</th>
                                            <th width="10%">Ingreso Men.</th>
                                            <th width="6%">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($test->dependents as $dependent)
                                        <tr data-dependent-id="{{ $dependent->id }}" class="dependent-saved">
                                            <td>
                                                <span class="dependent-display">{{ $dependent->name }}</span>
                                                <input type="text" class="form-control form-control-sm dependent-edit d-none" 
                                                       value="{{ $dependent->name }}" data-field="name" required>
                                            </td>
                                            <td>
                                                <span class="dependent-display">{{ $dependent->age }}</span>
                                                <input type="number" class="form-control form-control-sm dependent-edit d-none" 
                                                       value="{{ $dependent->age }}" data-field="age" min="0" max="120">
                                            </td>
                                            <td>
                                                <span class="dependent-display">{{ $dependent->relationship }}</span>
                                                <select class="form-control form-control-sm dependent-edit d-none" data-field="relationship">
                                                    <option value="">Seleccionar</option>
                                                    <option value="Hijo/a" {{ $dependent->relationship == 'Hijo/a' ? 'selected' : '' }}>Hijo/a</option>
                                                    <option value="Padre/Madre" {{ $dependent->relationship == 'Padre/Madre' ? 'selected' : '' }}>Padre/Madre</option>
                                                    <option value="Hermano/a" {{ $dependent->relationship == 'Hermano/a' ? 'selected' : '' }}>Hermano/a</option>
                                                    <option value="Abuelo/a" {{ $dependent->relationship == 'Abuelo/a' ? 'selected' : '' }}>Abuelo/a</option>
                                                    <option value="Nieto/a" {{ $dependent->relationship == 'Nieto/a' ? 'selected' : '' }}>Nieto/a</option>
                                                    <option value="Tío/a" {{ $dependent->relationship == 'Tío/a' ? 'selected' : '' }}>Tío/a</option>
                                                    <option value="Primo/a" {{ $dependent->relationship == 'Primo/a' ? 'selected' : '' }}>Primo/a</option>
                                                    <option value="Otro" {{ $dependent->relationship == 'Otro' ? 'selected' : '' }}>Otro</option>
                                                </select>
                                            </td>
                                            <td>
                                                <span class="dependent-display">{{ $dependent->schooling }}</span>
                                                <select class="form-control form-control-sm dependent-edit d-none" data-field="schooling">
                                                    <option value="">Seleccionar</option>
                                                    <option value="Sin estudios" {{ $dependent->schooling == 'Sin estudios' ? 'selected' : '' }}>Sin estudios</option>
                                                    <option value="Preescolar" {{ $dependent->schooling == 'Preescolar' ? 'selected' : '' }}>Preescolar</option>
                                                    <option value="Primaria" {{ $dependent->schooling == 'Primaria' ? 'selected' : '' }}>Primaria</option>
                                                    <option value="Secundaria" {{ $dependent->schooling == 'Secundaria' ? 'selected' : '' }}>Secundaria</option>
                                                    <option value="Preparatoria" {{ $dependent->schooling == 'Preparatoria' ? 'selected' : '' }}>Preparatoria</option>
                                                    <option value="Técnica" {{ $dependent->schooling == 'Técnica' ? 'selected' : '' }}>Técnica</option>
                                                    <option value="Universidad" {{ $dependent->schooling == 'Universidad' ? 'selected' : '' }}>Universidad</option>
                                                    <option value="Posgrado" {{ $dependent->schooling == 'Posgrado' ? 'selected' : '' }}>Posgrado</option>
                                                </select>
                                            </td>
                                            <td>
                                                <span class="dependent-display">{{ $dependent->marital_status }}</span>
                                                <select class="form-control form-control-sm dependent-edit d-none" data-field="marital_status">
                                                    <option value="">Seleccionar</option>
                                                    <option value="Soltero/a" {{ $dependent->marital_status == 'Soltero/a' ? 'selected' : '' }}>Soltero/a</option>
                                                    <option value="Casado/a" {{ $dependent->marital_status == 'Casado/a' ? 'selected' : '' }}>Casado/a</option>
                                                    <option value="Unión libre" {{ $dependent->marital_status == 'Unión libre' ? 'selected' : '' }}>Unión libre</option>
                                                    <option value="Divorciado/a" {{ $dependent->marital_status == 'Divorciado/a' ? 'selected' : '' }}>Divorciado/a</option>
                                                    <option value="Viudo/a" {{ $dependent->marital_status == 'Viudo/a' ? 'selected' : '' }}>Viudo/a</option>
                                                    <option value="Menor de edad" {{ $dependent->marital_status == 'Menor de edad' ? 'selected' : '' }}>Menor de edad</option>
                                                </select>
                                            </td>
                                            <td>
                                                <span class="dependent-display">{{ $dependent->occupation }}</span>
                                                <input type="text" class="form-control form-control-sm dependent-edit d-none" 
                                                       value="{{ $dependent->occupation }}" data-field="occupation" 
                                                       placeholder="Ocupación">
                                            </td>
                                            <td>
                                                <span class="dependent-display weekly-income" data-value="{{ $dependent->weekly_income ?? 0 }}">
                                                    @if($dependent->weekly_income)
                                                        ${{ number_format($dependent->weekly_income) }}
                                                    @else
                                                        -
                                                    @endif
                                                </span>
                                                <input type="number" class="form-control form-control-sm dependent-edit d-none" 
                                                       value="{{ $dependent->weekly_income }}" data-field="weekly_income" 
                                                       min="0" step="0.01" placeholder="0.00">
                                            </td>
                                            <td>
                                                <span class="dependent-display monthly-income" data-value="{{ $dependent->monthly_income ?? 0 }}">
                                                    @if($dependent->monthly_income)
                                                        ${{ number_format($dependent->monthly_income) }}
                                                    @else
                                                        -
                                                    @endif
                                                </span>
                                                <input type="number" class="form-control form-control-sm dependent-edit d-none" 
                                                       value="{{ $dependent->monthly_income }}" data-field="monthly_income" 
                                                       min="0" step="0.01" placeholder="0.00">
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <button type="button" class="btn btn-outline-primary btn-sm edit-dependent" 
                                                            title="Editar">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-outline-success btn-sm save-dependent d-none" 
                                                            title="Guardar">
                                                        <i class="fas fa-save"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-outline-secondary btn-sm cancel-edit d-none" 
                                                            title="Cancelar">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-outline-danger btn-sm delete-dependent" 
                                                            title="Eliminar">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot class="table-secondary">
                                        <tr class="fw-bold">
                                            <td colspan="6" class="text-end">
                                                <strong>TOTAL INGRESOS DEPENDIENTES:</strong>
                                            </td>
                                            <td class="text-center">
                                                <span id="totalWeeklyIncome" class="badge bg-primary fs-6">$0.00</span>
                                            </td>
                                            <td class="text-center">
                                                <span id="totalMonthlyIncome" class="badge bg-success fs-6">$0.00</span>
                                            </td>
                                            <td></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Caja de subtotal -->
                    <div class="subtotal-box mt-4">
                        <div class="card bg-light">
                            <div class="card-body text-center">
                                <h5 class="mb-1">Subtotal Paso 2: <span id="step-score">0</span> puntos</h5>
                                <small class="text-muted">Total acumulado: <span id="total-score">{{ $test->step_1_score ?? 0 }}</span> puntos</small>
                            </div>
                        </div>
                    </div>

                    <!-- Botones de acción -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('dif.socio_economic_tests.show', $test->id) }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-arrow-left"></i> Volver al resumen
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    Continuar al Paso 3 <i class="fas fa-arrow-right"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Cálculo en tiempo real de puntajes
            $('input[type="radio"][data-points]').on('change', function() {
                calculateStepScore();
                updateCardStyles();
            });

            // Hacer que toda la tarjeta sea clickeable
            $('.form-check').on('click', function(e) {
                if (e.target.type !== 'radio') {
                    $(this).find('input[type="radio"]').prop('checked', true).trigger('change');
                }
            });

            // ========== FUNCIONALIDAD TABLA DE DEPENDIENTES ==========
            
            // Agregar nueva fila de dependiente
            $('#addDependentRow').on('click', function() {
                const newRow = `
                    <tr class="dependent-new" data-dependent-id="new-${Date.now()}">
                        <td>
                            <span class="dependent-display d-none">-</span>
                            <input type="text" class="form-control form-control-sm dependent-edit" 
                                   data-field="name" placeholder="Nombre completo" required>
                        </td>
                        <td>
                            <span class="dependent-display d-none">-</span>
                            <input type="number" class="form-control form-control-sm dependent-edit" 
                                   data-field="age" min="0" max="120" placeholder="Edad">
                        </td>
                        <td>
                            <span class="dependent-display d-none">-</span>
                            <select class="form-control form-control-sm dependent-edit" data-field="relationship">
                                <option value="">Seleccionar</option>
                                <option value="Hijo/a">Hijo/a</option>
                                <option value="Padre/Madre">Padre/Madre</option>
                                <option value="Hermano/a">Hermano/a</option>
                                <option value="Abuelo/a">Abuelo/a</option>
                                <option value="Nieto/a">Nieto/a</option>
                                <option value="Tío/a">Tío/a</option>
                                <option value="Primo/a">Primo/a</option>
                                <option value="Otro">Otro</option>
                            </select>
                        </td>
                        <td>
                            <span class="dependent-display d-none">-</span>
                            <select class="form-control form-control-sm dependent-edit" data-field="schooling">
                                <option value="">Seleccionar</option>
                                <option value="Sin estudios">Sin estudios</option>
                                <option value="Preescolar">Preescolar</option>
                                <option value="Primaria">Primaria</option>
                                <option value="Secundaria">Secundaria</option>
                                <option value="Preparatoria">Preparatoria</option>
                                <option value="Técnica">Técnica</option>
                                <option value="Universidad">Universidad</option>
                                <option value="Posgrado">Posgrado</option>
                            </select>
                        </td>
                        <td>
                            <span class="dependent-display d-none">-</span>
                            <select class="form-control form-control-sm dependent-edit" data-field="marital_status">
                                <option value="">Seleccionar</option>
                                <option value="Soltero/a">Soltero/a</option>
                                <option value="Casado/a">Casado/a</option>
                                <option value="Unión libre">Unión libre</option>
                                <option value="Divorciado/a">Divorciado/a</option>
                                <option value="Viudo/a">Viudo/a</option>
                                <option value="Menor de edad">Menor de edad</option>
                            </select>
                        </td>
                        <td>
                            <span class="dependent-display d-none">-</span>
                            <input type="text" class="form-control form-control-sm dependent-edit" 
                                   data-field="occupation" placeholder="Ocupación">
                        </td>
                        <td>
                            <span class="dependent-display d-none weekly-income" data-value="0">-</span>
                            <input type="number" class="form-control form-control-sm dependent-edit" 
                                   data-field="weekly_income" min="0" step="0.01" placeholder="0.00">
                        </td>
                        <td>
                            <span class="dependent-display d-none monthly-income" data-value="0">-</span>
                            <input type="number" class="form-control form-control-sm dependent-edit" 
                                   data-field="monthly_income" min="0" step="0.01" placeholder="0.00">
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-outline-success btn-sm save-dependent" 
                                        title="Guardar">
                                    <i class="fas fa-save"></i>
                                </button>
                                <button type="button" class="btn btn-outline-secondary btn-sm cancel-edit" 
                                        title="Cancelar">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                `;
                
                $('#dependentsTable tbody').append(newRow);
                
                // Enfocar el primer input de la nueva fila
                $('#dependentsTable tbody tr:last-child input[data-field="name"]').focus();
            });

            // Editar dependiente existente
            $(document).on('click', '.edit-dependent', function() {
                const row = $(this).closest('tr');
                
                // Mostrar campos de edición y ocultar texto
                row.find('.dependent-display').addClass('d-none');
                row.find('.dependent-edit').removeClass('d-none');
                
                // Cambiar botones
                row.find('.edit-dependent, .delete-dependent').addClass('d-none');
                row.find('.save-dependent, .cancel-edit').removeClass('d-none');
                
                row.removeClass('dependent-saved').addClass('dependent-editing');
            });

            // Cancelar edición
            $(document).on('click', '.cancel-edit', function() {
                const row = $(this).closest('tr');
                
                if (row.hasClass('dependent-new')) {
                    // Eliminar fila nueva
                    row.remove();
                } else {
                    // Restaurar modo visualización
                    row.find('.dependent-display').removeClass('d-none');
                    row.find('.dependent-edit').addClass('d-none');
                    
                    // Cambiar botones
                    row.find('.edit-dependent, .delete-dependent').removeClass('d-none');
                    row.find('.save-dependent, .cancel-edit').addClass('d-none');
                    
                    row.removeClass('dependent-editing').addClass('dependent-saved');
                }
            });

            // Guardar dependiente
            $(document).on('click', '.save-dependent', function() {
                const row = $(this).closest('tr');
                const dependentId = row.data('dependent-id');
                const isNew = row.hasClass('dependent-new');
                
                // Validar campos requeridos
                const name = row.find('input[data-field="name"]').val().trim();
                if (!name) {
                    alert('El nombre es requerido');
                    row.find('input[data-field="name"]').focus();
                    return;
                }
                
                // Recopilar datos
                const data = {
                    socio_economic_test_id: {{ $test->id }},
                    name: name,
                    age: row.find('[data-field="age"]').val() || null,
                    relationship: row.find('[data-field="relationship"]').val() || null,
                    schooling: row.find('[data-field="schooling"]').val() || null,
                    marital_status: row.find('[data-field="marital_status"]').val() || null,
                    occupation: row.find('[data-field="occupation"]').val() || null,
                    weekly_income: row.find('[data-field="weekly_income"]').val() || null,
                    monthly_income: row.find('[data-field="monthly_income"]').val() || null,
                    _token: '{{ csrf_token() }}'
                };
                
                // Mostrar loading
                const saveBtn = $(this);
                const originalHtml = saveBtn.html();
                saveBtn.html('<i class="fas fa-spinner fa-spin"></i>').prop('disabled', true);
                
                // Realizar petición AJAX
                const url = isNew ? 
                    '{{ route("dif.socio_economic_test_dependents.store") }}' : 
                    `/dif/socio-economic-test-dependents/${dependentId}`;
                const method = isNew ? 'POST' : 'PUT';
                
                $.ajax({
                    url: url,
                    method: method,
                    data: data,
                    success: function(response) {
                        console.log('Respuesta del servidor:', response); // Debug
                        if (response.success) {
                            // Actualizar vista con los datos guardados
                            updateRowDisplay(row, response.dependent);
                            
                            // Cambiar estado de la fila
                            row.removeClass('dependent-new dependent-editing').addClass('dependent-saved');
                            row.data('dependent-id', response.dependent.id);
                            
                            // Mostrar mensaje de éxito
                            showMessage('Dependiente guardado correctamente', 'success');
                        } else {
                            showMessage('Error al guardar dependiente', 'error');
                        }
                    },
                    error: function(xhr) {
                        console.error('Error:', xhr);
                        const errors = xhr.responseJSON?.errors;
                        if (errors) {
                            const errorMsg = Object.values(errors).flat().join(', ');
                            showMessage('Error: ' + errorMsg, 'error');
                        } else {
                            showMessage('Error al guardar dependiente', 'error');
                        }
                    },
                    complete: function() {
                        saveBtn.html(originalHtml).prop('disabled', false);
                    }
                });
            });

            // Eliminar dependiente
            $(document).on('click', '.delete-dependent', function() {
                const row = $(this).closest('tr');
                const dependentId = row.data('dependent-id');
                
                if (confirm('¿Está seguro de eliminar este dependiente?')) {
                    $.ajax({
                        url: `/dif/socio-economic-test-dependents/${dependentId}`,
                        method: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.success) {
                                row.fadeOut(300, function() {
                                    $(this).remove();
                                    // Actualizar totales después de eliminar
                                    updateTotals();
                                });
                                showMessage('Dependiente eliminado correctamente', 'success');
                            } else {
                                showMessage('Error al eliminar dependiente', 'error');
                            }
                        },
                        error: function() {
                            showMessage('Error al eliminar dependiente', 'error');
                        }
                    });
                }
            });

            // Funciones auxiliares
            function updateRowDisplay(row, dependent) {
                // Actualizar todos los campos display con los valores del dependiente guardado
                
                // Nombre
                row.find('td:eq(0) .dependent-display').text(dependent.name || '-');
                row.find('td:eq(0) .dependent-edit').val(dependent.name || '');
                
                // Edad
                row.find('td:eq(1) .dependent-display').text(dependent.age || '-');
                row.find('td:eq(1) .dependent-edit').val(dependent.age || '');
                
                // Parentesco
                row.find('td:eq(2) .dependent-display').text(dependent.relationship || '-');
                row.find('td:eq(2) .dependent-edit').val(dependent.relationship || '');
                
                // Escolaridad
                row.find('td:eq(3) .dependent-display').text(dependent.schooling || '-');
                row.find('td:eq(3) .dependent-edit').val(dependent.schooling || '');
                
                // Estado Civil
                row.find('td:eq(4) .dependent-display').text(dependent.marital_status || '-');
                row.find('td:eq(4) .dependent-edit').val(dependent.marital_status || '');
                
                // Ocupación
                row.find('td:eq(5) .dependent-display').text(dependent.occupation || '-');
                row.find('td:eq(5) .dependent-edit').val(dependent.occupation || '');
                
                // Ingreso Semanal
                let weeklyIncome = dependent.weekly_income ? '$' + parseFloat(dependent.weekly_income).toLocaleString('es-MX', {minimumFractionDigits: 2}) : '-';
                row.find('td:eq(6) .dependent-display').text(weeklyIncome).attr('data-value', dependent.weekly_income || 0);
                row.find('td:eq(6) .dependent-edit').val(dependent.weekly_income || '');
                
                // Ingreso Mensual
                let monthlyIncome = dependent.monthly_income ? '$' + parseFloat(dependent.monthly_income).toLocaleString('es-MX', {minimumFractionDigits: 2}) : '-';
                row.find('td:eq(7) .dependent-display').text(monthlyIncome).attr('data-value', dependent.monthly_income || 0);
                row.find('td:eq(7) .dependent-edit').val(dependent.monthly_income || '');
                
                // Ocultar campos de edición y mostrar displays
                row.find('.dependent-edit').addClass('d-none');
                row.find('.dependent-display').removeClass('d-none');
                
                // Cambiar botones: mostrar editar/eliminar, ocultar guardar/cancelar
                row.find('.edit-dependent, .delete-dependent').removeClass('d-none');
                row.find('.save-dependent, .cancel-edit').addClass('d-none');
                
                // Actualizar totales
                updateTotals();
            }

            function updateTotals() {
                let totalWeekly = 0;
                let totalMonthly = 0;
                
                // Sumar todos los ingresos semanales
                $('.weekly-income').each(function() {
                    const value = parseFloat($(this).attr('data-value')) || 0;
                    totalWeekly += value;
                });
                
                // Sumar todos los ingresos mensuales
                $('.monthly-income').each(function() {
                    const value = parseFloat($(this).attr('data-value')) || 0;
                    totalMonthly += value;
                });
                
                // Actualizar los totales en la tabla
                $('#totalWeeklyIncome').text('$' + totalWeekly.toLocaleString('es-MX', {minimumFractionDigits: 2}));
                $('#totalMonthlyIncome').text('$' + totalMonthly.toLocaleString('es-MX', {minimumFractionDigits: 2}));
            }

            function showMessage(message, type) {
                const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
                const icon = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-triangle';
                
                const alert = $(`
                    <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
                        <i class="fas ${icon} me-2"></i>
                        ${message}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                `);
                
                $('#dependentsTable').before(alert);
                
                // Auto-dismiss después de 3 segundos
                setTimeout(() => {
                    alert.fadeOut(300, function() {
                        $(this).remove();
                    });
                }, 3000);
            }

            // ========== FUNCIONES ORIGINALES DE PUNTAJE ==========

            function calculateStepScore() {
                let stepScore = 0;
                
                // Sumar puntos de todas las opciones seleccionadas
                $('.step-form input[type="radio"]:checked').each(function() {
                    stepScore += parseInt($(this).data('points') || 0);
                });
                
                // Actualizar subtotal del paso
                $('#step-score').text(stepScore);
                
                // Calcular total acumulado
                let totalScore = {{ $test->step_1_score ?? 0 }} + stepScore;
                $('#total-score').text(totalScore);
            }

            function updateCardStyles() {
                // Remover todas las clases de selección
                $('.form-check').removeClass('selected-danger selected-warning selected-info selected-success');
                
                // Aplicar estilos según la opción seleccionada
                $('.form-check input[type="radio"]:checked').each(function() {
                    const points = $(this).data('points');
                    const card = $(this).closest('.form-check');
                    
                    if (points === 5) {
                        card.addClass('selected-danger');
                    } else if (points === 4) {
                        card.addClass('selected-warning');
                    } else if (points === 3) {
                        card.addClass('selected-warning');
                    } else if (points === 2) {
                        card.addClass('selected-info');
                    } else if (points === 1) {
                        card.addClass('selected-success');
                    }
                });
            }

            // Calcular puntaje inicial si hay valores seleccionados
            calculateStepScore();
            updateCardStyles();
            
            // Calcular totales iniciales de dependientes
            updateTotals();
        });
    </script>

    <style>
        .progress-steps {
            margin-bottom: 2rem;
        }

        .step-progress {
            display: flex;
            justify-content: space-between;
            position: relative;
        }

        .step-progress::before {
            content: '';
            position: absolute;
            top: 20px;
            left: 20px;
            right: 20px;
            height: 2px;
            background: #e9ecef;
            z-index: 1;
        }

        .step {
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
            z-index: 2;
        }

        .step-number {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #e9ecef;
            color: #6c757d;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            margin-bottom: 8px;
        }

        .step-title {
            font-size: 12px;
            text-align: center;
            color: #6c757d;
            max-width: 120px;
        }

        .step.active .step-number {
            background: #0d6efd;
            color: white;
        }

        .step.active .step-title {
            color: #0d6efd;
            font-weight: 600;
        }

        .step.completed .step-number {
            background: #198754;
            color: white;
        }

        .step.completed .step-title {
            color: #198754;
        }

        .form-check {
            padding: 15px;
            border-radius: 8px;
            border: 2px solid #e9ecef;
            transition: all 0.3s ease;
            cursor: pointer;
            background: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 10px;
            position: relative;
        }

        .form-check:hover {
            border-color: #dee2e6;
            box-shadow: 0 4px 8px rgba(0,0,0,0.15);
            transform: translateY(-1px);
        }

        .form-check-input {
            position: absolute;
            top: 10px;
            right: 10px;
            transform: scale(1.2);
        }

        .form-check-label {
            cursor: pointer;
            margin-bottom: 0;
            padding-right: 30px;
            font-weight: 500;
        }

        /* Estilos para tarjetas seleccionadas según el color del badge */
        .form-check:has(.form-check-input:checked) .badge.bg-danger,
        .form-check:has(.form-check-input[data-points="5"]:checked) {
            background-color: #dc3545 !important;
        }

        .form-check:has(.form-check-input[data-points="5"]:checked) {
            border-color: #dc3545;
            background-color: rgba(220, 53, 69, 0.1);
            color: #721c24;
        }

        .form-check:has(.form-check-input[data-points="4"]:checked) {
            border-color: #fd7e14;
            background-color: rgba(253, 126, 20, 0.1);
            color: #8d4700;
        }

        .form-check:has(.form-check-input[data-points="3"]:checked) {
            border-color: #ffc107;
            background-color: rgba(255, 193, 7, 0.1);
            color: #997404;
        }

        .form-check:has(.form-check-input[data-points="2"]:checked) {
            border-color: #0dcaf0;
            background-color: rgba(13, 202, 240, 0.1);
            color: #055160;
        }

        .form-check:has(.form-check-input[data-points="1"]:checked) {
            border-color: #198754;
            background-color: rgba(25, 135, 84, 0.1);
            color: #0f5132;
        }

        .form-check:has(.form-check-input:checked) .form-check-label {
            font-weight: 600;
        }

        .form-check:has(.form-check-input:checked) .badge {
            font-weight: 700;
            font-size: 0.8em;
        }

        /* Fallback para navegadores que no soportan :has() */
        .form-check.selected-danger {
            border-color: #dc3545;
            background-color: rgba(220, 53, 69, 0.1);
            color: #721c24;
        }

        .form-check.selected-warning {
            border-color: #ffc107;
            background-color: rgba(255, 193, 7, 0.1);
            color: #997404;
        }

        .form-check.selected-info {
            border-color: #0dcaf0;
            background-color: rgba(13, 202, 240, 0.1);
            color: #055160;
        }

        .form-check.selected-success {
            border-color: #198754;
            background-color: rgba(25, 135, 84, 0.1);
            color: #0f5132;
        }

        .subtotal-box {
            position: sticky;
            bottom: 20px;
        }

        /* Estilos para tabla de dependientes */
        #dependentsTable {
            font-size: 0.875rem;
        }

        .dependent-saved {
            background-color: #f8f9fa;
        }

        .dependent-editing {
            background-color: #fff3cd;
            border: 2px solid #ffc107;
        }

        .dependent-new {
            background-color: #d1ecf1;
            border: 2px solid #0dcaf0;
        }

        .dependent-edit.d-none {
            display: none !important;
        }

        .btn-group .btn {
            padding: 0.25rem 0.5rem;
        }

        .table-responsive {
            max-height: 400px;
            overflow-y: auto;
        }

        .table th {
            position: sticky;
            top: 0;
            background-color: #f8f9fa;
            z-index: 1;
        }
    </style>
@endpush
