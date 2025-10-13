<div>

    @if ($mode != 1)
        <div class="row">
            <div class="col">

            </div>
            <div class="col-md-2 text-end">
                <a href="{{ route('municipal_inspections.create') }}" class="btn btn-primary btn-sm">
                    Agregar documento
                </a>
            </div>
        </div>
    @endif

    <div class="row my-4">
        @foreach ($years as $year)
            <div class="col-md">
                <button
                    class="btn w-100 @if ($active_year == $year) btn-secondary @else btn-outline-secondary @endif"
                    wire:click="activeYear({{ $year }})">
                    {{ $year }}
                </button>
            </div>
        @endforeach
    </div>

    <hr>

    <div class="row">
        <div class="col-md-12">
            <div class="accordion" id="accordionExample">
                @foreach ($inspections_by_dependency as $dependency => $inspections)
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapse{{ $loop->index }}" aria-expanded="false"
                                aria-controls="collapse{{ $loop->index }}">
                                {{ $dependency }}
                            </button>
                        </h2>
                        <div id="collapse{{ $loop->index }}" class="accordion-collapse collapse"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th scope="col">Nombre del Archivo</th>
                                            <th scope="col" style="width: 15%">Archivo</th>
                                            @if ($mode != 1)
                                                <th scope="col">Visible en front</th>
                                                <th scope="col" style="width: 10%">Acciones</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($inspections as $inspection)
                                            <tr>
                                                <td>{{ $inspection->name }}</td>
                                                <td>
                                                    <a href="{{ $inspection->file }}" target="_blank"
                                                        class="btn btn-sm btn-outline-primary">
                                                        Ver
                                                    </a>
                                                </td>
                                                @if ($mode != 1)
                                                    <td>
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" type="checkbox"
                                                                role="switch" id="switchCheckDefault"
                                                                @if ($inspection->is_active) checked @endif
                                                                wire:click="changeStatus({{ $inspection->id }})">
                                                            <label class="form-check-label" for="switchCheckDefault">

                                                                @switch($inspection->is_active)
                                                                    @case(1)
                                                                        Si
                                                                    @break

                                                                    @case(0)
                                                                        No
                                                                    @break
                                                                @endswitch
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('municipal_inspections.edit', $inspection->id) }}"
                                                            class="btn btn-sm btn-warning mb-2">
                                                            Editar
                                                        </a>

                                                        <form
                                                            action="{{ route('municipal_inspections.destroy', $inspection->id) }}"
                                                            method="POST" style="display: inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger"
                                                                data-toggle="tooltip" data-original-title="Eliminar"
                                                                onclick="return confirm('¿Estás seguro de que deseas eliminar esta regulación?')">
                                                                Eliminar
                                                            </button>
                                                        </form>
                                                    </td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
