<div class="table-responsive">
    <table class="table">
        <thead class="thead-light">
            <tr>
                <th>ID</th>
                <th>Número de Empleado</th>
                <th>Nombre</th>
                <th>Especialidad</th>
                <th>Información de Contacto</th>
                <th scope="col">Acciones</th>
            </tr>
        </thead>

        <tbody>
            @foreach($doctors as $doctor)
            <tr>
                <th scope="row">#{{ $doctor->id }}</th>
                <td>{{ $doctor->employee_num }}</td>
                <td>{{ $doctor->name }}</td>
                <td>{{ $doctor->speciality->name ?? 'N/A' }}</td>
                <td class="text-muted">
                    @if($doctor->phone)
                        {{ $doctor->phone }}<br>
                    @endif
                    @if($doctor->email)
                        {{ $doctor->email }}<br>
                    @endif
                    @if($doctor->full_address)
                        <small>{{ Str::limit($doctor->full_address, 50) }}</small>
                    @endif
                </td>
                <td>
                    <div class="d-flex gap-2" role="group" aria-label="Basic example">
                        <a href="{{ route('dif.doctors.show', $doctor->id) }}" class="btn btn-sm btn-primary">Ver</a>
                        <a href="{{ route('dif.doctors.edit', $doctor->id) }}" class="btn btn-sm btn-secondary">Editar</a>
                        <form method="POST" action="{{ route('dif.doctors.destroy', $doctor->id) }}" style="display: inline-block;">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de que deseas eliminar este doctor?')">
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
