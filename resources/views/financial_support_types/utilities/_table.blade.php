<div class="table-responsive">
    <table class="table table-hover align-middle">
        <thead class="">
            <tr>
                <th style="width: 5%">ID</th>
                <th style="width: 15%">Nombre</th>
                <th style="width: 25%">Descripción</th>
                <th style="width: 10%">Monto</th>
                <th style="width: 20%">Documentos</th>
                <th style="width: 10%">Creado</th>
                <th style="width: 10%">Actualizado</th>
                <th style="width: 5%" class="text-center">Acciones</th>
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
                    <span class="badge bg-info text-dark">
                        @if($financial_support_type->monthly_cap)
                            ${{ number_format($financial_support_type->monthly_cap, 2) }}
                        @else
                            —
                        @endif
                    </span>
                </td>
                <td>
                    <div style="max-height: 60px; overflow-y: auto;">
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
                        @foreach($documents as $field => $label)
                            @if($financial_support_type->$field)
                                <span class="badge bg-success me-1 mb-1">{{ $label }}</span>
                            @endif
                        @endforeach
                    </div>
                </td>
                <td>
                    <small class="text-muted">
                        {{ $financial_support_type->created_at->format('d/m/Y') }}
                    </small>
                </td>
                <td>
                    <small class="text-muted">
                        {{ $financial_support_type->updated_at->format('d/m/Y') }}
                    </small>
                </td>
                <td class="text-center">
                    <form method="POST" action="{{ route('financial_support_types.destroy', $financial_support_type->id) }}" style="display: inline-block;">
                        <button type="submit" class="btn btn-sm btn-danger" title="Eliminar">
                            Eliminar
                        </button>
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                    </form>
                </td> 
            </tr>
            @endforeach                           
        </tbody>
    </table>                    
</div>
 