<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>Imagen</th>
                <th>Información</th>
                <th>Prioridad</th>
                <th>Botón</th>
                <th>Link</th>
                <th>Estatus</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($banners as $banner)
                <tr>
                    <td style="width: 150px;">
                        <img style="width: 100%;" src="{{ asset('front/img/banners/' . $banner->image) }}"
                            alt="{{ $banner->title }}">
                    </td>

                    <td style="width: 250px;">
                        <strong>{{ $banner->title }}</strong><br>
                        <p>{{ $banner->subtitle }}</p>
                    </td>

                    <td> {{ $banner->priority }}</td>
                    <td>{{ $banner->text_button }}</td>
                    <td>{{ $banner->link }}</td>

                    <td>
                        @if ($banner->is_active == true)
                            <span class="badge bg-success">Activado</span><br>
                        @else
                            <span class="badge bg-info">Desactivado</span><br>
                        @endif
                    </td>

                    <td class="d-flex gap-3">
                        <a href="{{ route('banners.show', $banner->id) }}" class="btn btn-primary" data-toggle="tooltip"
                            data-original-title="Ver Detalle">
                            Ver Detalle
                        </a>

                        <a href="{{ route('banners.edit', $banner->id) }}" class="btn btn-primary" data-toggle="tooltip"
                            data-original-title="Editar">
                            Editar
                        </a>

                        <form method="POST" action="{{ route('implan.banners.status', $banner->id) }}">
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-primary" data-toggle="tooltip"
                                data-original-title="Cambiar estado">
                                Cambiar Estado
                            </button>
                        </form>

                        <form method="POST" action="{{ route('implan.banners.destroy', $banner->id) }}">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}

                            <button type="submit" class="btn btn-danger" data-toggle="tooltip"
                                data-original-title="Eliminar Banner">
                                Eliminar
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
