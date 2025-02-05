<div class="table-responsive">
    <table class="table">
        <thead class="thead-light">
            <tr>
                <th>id</th>
                <th>Nombre</th>
                <th>Documentos Necesarios</th>
                <th>Creado</th>
                <th>Actualizado</th>
                <th scope="col">Acciones</th>
            </tr>
        </thead>

        <tbody>
            @foreach($financial_support_types as $financial_support_type)
            <tr>
                <th scope="row">#{{ $financial_support_type->id }}</th>
                <td>
                    <a href="{{ route('financial_support_types.show', $financial_support_type->id) }}">
                        {{ $financial_support_type->name }}
                    </a>
                </td>

                <td>
                    <ul class="list-unstyled">
                        <li>{!! $financial_support_type->doc_birth_certificate ? '<span class="text-success">✔</span>' : '<span class="text-danger">✘</span>' !!} Acta de nacimiento</li>
                        <li>{!! $financial_support_type->doc_ine ? '<span class="text-success">✔</span>' : '<span class="text-danger">✘</span>' !!} INE</li>
                        <li>{!! $financial_support_type->doc_address_proof ? '<span class="text-success">✔</span>' : '<span class="text-danger">✘</span>' !!} Comprobante de domicilio</li>
                        <li>{!! $financial_support_type->doc_rfc ? '<span class="text-success">✔</span>' : '<span class="text-danger">✘</span>' !!} RFC</li>
                        <li>{!! $financial_support_type->doc_death_certificate ? '<span class="text-success">✔</span>' : '<span class="text-danger">✘</span>' !!} Acta de defunción</li>
                        <li>{!! $financial_support_type->doc_funeral_payment ? '<span class="text-success">✔</span>' : '<span class="text-danger">✘</span>' !!} Hoja de paga funeraria</li>
                        <li>{!! $financial_support_type->doc_cemetery_docs ? '<span class="text-success">✔</span>' : '<span class="text-danger">✘</span>' !!} Documentos del panteón</li>
                        <li>{!! $financial_support_type->doc_study_certificate ? '<span class="text-success">✔</span>' : '<span class="text-danger">✘</span>' !!} Constancia de estudios</li>
                        <li>{!! $financial_support_type->doc_medical_prescriptions ? '<span class="text-success">✔</span>' : '<span class="text-danger">✘</span>' !!} Recetas médicas</li>
                        <li>{!! $financial_support_type->doc_medical_certificate ? '<span class="text-success">✔</span>' : '<span class="text-danger">✘</span>' !!} Constancia médica</li>
                        <li>{!! $financial_support_type->doc_hospital_visit_card ? '<span class="text-success">✔</span>' : '<span class="text-danger">✘</span>' !!} Tarjetón de visita al hospital</li>
                    </ul>
                </td>

                <td>{{ $financial_support_type->created_at }}</td>
                <td>{{ $financial_support_type->updated_at }}</td>

                <td>
                    <div class="btn-group" role="group" aria-label="Basic example">
                        {{--  <a href="{{ route('financial_support_types.edit', $financial_support_type->id) }}" class="btn btn-sm btn-icon"><i class='bx bx-show-alt'></i></a> --}}

                        <form method="POST" action="{{ route('financial_support_types.destroy', $financial_support_type->id) }}" style="display: inline-block;">
                            <button type="submit" class="btn btn-sm btn-icon">
                                <i class='bx bx-trash-alt text-danger'></i> Eliminar
                            </button>
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                        </form>
                    </div>
                </td> 
            </tr>
            @endforeach                           
        </tbody>
    </table>                    
</div>
 