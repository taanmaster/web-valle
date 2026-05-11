<div class="table-responsive">
    <table class="table table-hover align-middle">
        <thead class="table-light">
            <tr>
                <th class="fw-semibold" style="width: 5%">ID</th>
                <th class="fw-semibold" style="width: 15%">Nombre</th>
                <th class="fw-semibold" style="width: 25%">Descripción</th>
                <th class="fw-semibold" style="width: 10%">Monto</th>
                <th class="fw-semibold" style="width: 20%">Documentos</th>
                <th class="fw-semibold" style="width: 10%">Creado</th>
                <th class="fw-semibold" style="width: 10%">Actualizado</th>
                <th class="fw-semibold text-center" style="width: 5%">Acciones</th>
            </tr>
        </thead>

        <tbody>
            @foreach($financial_support_types as $financial_support_type)
            <tr>
                <td>
                    <span class="badge bg-secondary">#{{ $financial_support_type->id }}</span>
                </td>
                <td>
                    <a href="{{ route('financial_support_types.show', $financial_support_type->id) }}" class="fw-bold text-decoration-none">
                        {{ $financial_support_type->name }}
                    </a>
                </td>
                <td>
                    <small class="text-muted">
                        {{ $financial_support_type->description ? substr($financial_support_type->description, 0, 50) . (strlen($financial_support_type->description) > 50 ? '...' : '') : '—' }}
                    </small>
                </td>
                <td>
                    <span class="badge bg-info">
                        @if($financial_support_type->monthly_cap)
                            ${{ number_format($financial_support_type->monthly_cap, 2) }}
                        @else
                            —
                        @endif
                    </span>
                </td>
                <td>
                    @php
                        $documents = [
                            'doc_birth_certificate' => 'Acta nacimiento',
                            'doc_ine' => 'INE',
                            'doc_address_proof' => 'Domicilio',
                            'doc_rfc' => 'RFC',
                            'doc_death_certificate' => 'Acta defunción',
                            'doc_funeral_payment' => 'Paga funeraria',
                            'doc_cemetery_docs' => 'Panteón',
                            'doc_study_certificate' => 'Estudios',
                            'doc_medical_prescriptions' => 'Recetas',
                            'doc_medical_certificate' => 'Médica',
                            'doc_hospital_visit_card' => 'Hospital'
                        ];
                    @endphp
                    <div class="d-flex flex-wrap gap-1">
                        @foreach($documents as $field => $label)
                            @if($financial_support_type->$field)
                                <span class="badge bg-success">{{ $label }}</span>
                            @endif
                        @endforeach
                    </div>
                </td>
                <td>
                    <small class="text-muted">{{ $financial_support_type->created_at->format('d/m/Y') }}</small>
                </td>
                <td>
                    <small class="text-muted">{{ $financial_support_type->updated_at->format('d/m/Y') }}</small>
                </td>
                <td class="text-center">
                    <div class="btn-group btn-group-sm">
                        <a href="{{ route('financial_support_types.show', $financial_support_type->id) }}"
                            class="btn btn-outline-primary" title="Ver detalle" aria-label="Ver detalle">
                            <i class="fas fa-eye"></i>
                        </a>
                        <form method="POST" action="{{ route('financial_support_types.destroy', $financial_support_type->id) }}" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger" title="Eliminar" aria-label="Eliminar"
                                onclick="return confirm('¿Estás seguro de eliminar este tipo de apoyo?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>