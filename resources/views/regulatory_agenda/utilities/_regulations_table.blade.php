<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Materia</th>
                <th>Problemática</th>
                <th>Justificación</th>
                <th>Fecha de presentación</th>
                <th>Tipo</th>
                <th>Impacto</th>
                <th>Beneficiarios</th>
                <th>Semestre</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($regulations as $regulation)
                <tr>
                    <td>
                        {{ $regulation->name }}
                    </td>
                    <td>
                        {{ $regulation->subject }}
                    </td>
                    <td>
                        {{ $regulation->problematic }}
                    </td>
                    <td>
                        {{ $regulation->justification }}
                    </td>
                    <td>
                        {{ $regulation->presentation_date }}
                    </td>
                    <td>
                        {{ $regulation->type }}
                    </td>
                    <td>
                        {{ $regulation->impact }}
                    </td>
                    <td>
                        {{ $regulation->beneficiaries }}
                    </td>
                    <td>
                        {{ $regulation->semester }}
                    </td>
                    <td>
                        <a href="{{ route('regulatory_agenda_regulation.show', $regulation->id) }}"
                            class="btn btn-sm btn-outline-secondary">
                            <i class="bx bx-edit"></i> Editar
                        </a>
                        <form method="POST" action="{{ route('rates_and_cost.destroy', $regulation->id) }}"
                            style="display: inline-block;">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                <i class="bx bx-trash-alt"></i> Eliminar
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
