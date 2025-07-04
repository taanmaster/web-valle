<div class="table-responsive">
    <table class="table">
        <thead class="thead-light">
            <tr>
                <th>ID</th>
                <th>Número de Receta</th>
                <th>Doctor</th>
                <th>Paciente</th>
                <th>Fecha</th>
                <th>Estado</th>
                <th scope="col">Acciones</th>
            </tr>
        </thead>

        <tbody>
            @foreach($prescriptions as $prescription)
            <tr>
                <th scope="row">#{{ $prescription->id }}</th>
                <td>{{ $prescription->prescription_num }}</td>
                <td>{{ $prescription->doctor->name ?? 'N/A' }}</td>
                <td>{{ $prescription->patient->name ?? 'N/A' }} {{ $prescription->patient->first_name ?? '' }} {{ $prescription->patient->last_name ?? '' }}</td>
                <td>{{ $prescription->prescription_date->format('d/m/Y') }}</td>
                <td>
                    @if($prescription->status == 'pending')
                        <span class="badge bg-warning">Pendiente</span>
                    @elseif($prescription->status == 'completed')
                        <span class="badge bg-success">Completada</span>
                    @elseif($prescription->status == 'cancelled')
                        <span class="badge bg-danger">Cancelada</span>
                    @endif
                </td>
                <td>
                    <div class="d-flex gap-2" role="group" aria-label="Basic example">
                        <a href="{{ route('dif.prescriptions.show', $prescription->id) }}" class="btn btn-sm btn-primary">Ver</a>
                        <a href="{{ route('dif.prescriptions.edit', $prescription->id) }}" class="btn btn-sm btn-secondary">Editar</a>
                        <form method="POST" action="{{ route('dif.prescriptions.destroy', $prescription->id) }}" style="display: inline-block;">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <button type="submit" class="btn btn-sm btn-danger">
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
