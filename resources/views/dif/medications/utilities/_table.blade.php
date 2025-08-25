<div class="table-responsive">
    <table class="table">
        <thead class="thead-light">
            <tr>
                <th>ID</th>
                <th>Nombre genérico</th>
                <th>Nombre comercial</th>
                <th>Presentación / Cantidad / Unidades</th>
                <th>Caducidad</th>
                <th scope="col">Acciones</th>
            </tr>
        </thead>

        <tbody>
            @foreach($medications as $medication)
            @php
                $exp = \Carbon\Carbon::parse($medication->expiration_date);
                $isExpired = $exp->lt(\Carbon\Carbon::now());
                $isSoon = !$isExpired && $exp->lte(\Carbon\Carbon::now()->addMonth());
                $rowClass = ($isExpired || $isSoon) ? 'table-danger' : '';
            @endphp
            <tr class="{{ $rowClass }}">
                <th scope="row">#{{ $medication->id }}</th>
                <td>{{ $medication->generic_name }}</td>
                <td class="text-muted">{{ $medication->commercial_name ?? '—' }}</td>
                <td>
                    {{-- Presentación / Cantidad / Unidades --}}
                    @php
                        $presentation = $medication->type ?? '—';
                        $qty = $medication->type_num ?? '';
                        $unit = $medication->type_dosage ?? '';
                        $present_text = $presentation;
                        if($qty) $present_text .= ' / ' . $qty;
                        if($unit) $present_text .= ' / ' . $unit;
                    @endphp
                    {{ $present_text }}
                </td>
                <td>
                    {{-- Caducidad con color y badge --}}
                    @if($isExpired)
                        <span class="text-danger fw-bold">{{ $exp->format('d/m/Y') }}</span>
                        <span class="badge bg-danger ms-2">Vencido</span>
                    @elseif($isSoon)
                        <span class="text-danger fw-bold">{{ $exp->format('d/m/Y') }}</span>
                        <span class="badge bg-danger ms-2">Caduca pronto</span>
                    @else
                        {{ $exp->format('d/m/Y') }}
                    @endif
                </td>
                <td>
                    <div class="d-flex gap-2" role="group" aria-label="Basic example">
                        <a href="{{ route('dif.medications.show', $medication->id) }}" class="btn btn-sm btn-primary">Ver</a>
                        <a href="{{ route('dif.medications.edit', $medication->id) }}" class="btn btn-sm btn-secondary">Editar</a>
                        <form method="POST" action="{{ route('dif.medications.destroy', $medication->id) }}" style="display: inline-block;">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de que deseas eliminar este medicamento?')">
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
