<div class="table-responsive">
    <table class="table table-dashboard">
        <thead>
            <tr>
                <th>Imagen</th>
                <th>Información</th>
                <th>Botón</th>
                <th>Link</th>
                <th>Estatus</th>
                <th>Acciones</th>
            </tr>
        </thead>
        
        <tbody>
            @foreach($popups as $popup)
            <tr>
                <td style="width: 150px;">
                    <img style="width: 100%;" src="{{ asset('img/popups/' . $popup->image ) }}" alt="{{ $popup->title }}">
                    
                </td>
                <td style="width: 250px;">
                    <strong>{{ $popup->title }}</strong><br>
                    {{ $popup->subtitle }}
                </td>
                <td>{{ $popup->text_button }}</td>
                <td>{{ $popup->link }}</td>

                <td>
                    @if($popup->is_active == true)
                        <span class="badge bg-success">Activado</span><br>
                    @else
                        <span class="badge bg-info">Desactivado</span><br>
                    @endif
                </td>
                
                <td class="d-flex gap-3">
                    <a href="{{ route('popups.show', $popup->id) }}" class="btn btn-primary">
                        Ver Detalle
                    </a>

                    <a href="{{ route('popups.edit', $popup->id) }}" class="btn btn-primary">
                        Editar
                    </a>

                    <form method="POST" action="{{ route('popups.status', $popup->id) }}">
                        {{ csrf_field() }}
                        <button type="submit" class="btn btn-primary">
                            Cambiar Estatus
                        </button>
                    </form>

        
                    <form method="POST" action="{{ route('popups.destroy', $popup->id) }}">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}

                        <button type="submit" class="btn btn-danger">
                            Eliminar
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>