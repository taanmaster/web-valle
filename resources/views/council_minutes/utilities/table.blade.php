<div>
    @if ($mode != 1)
        <div class="row">
            <div class="col">

            </div>
            <div class="col-md-2 text-end">
                <a href="{{ route('council_minutes.create') }}" class="btn btn-primary btn-sm">
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

            <div class="accordion" id="accordionMinutes">
                @foreach ($minutes as $session => $sessionMinutes)
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading{{ $loop->index }}">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapse{{ $loop->index }}" aria-expanded="false"
                                aria-controls="collapse{{ $loop->index }}">
                                Sesión: {{ $session }}
                            </button>
                        </h2>
                        <div id="collapse{{ $loop->index }}" class="accordion-collapse collapse"
                            data-bs-parent="#accordionMinutes">
                            <div class="accordion-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width: 10%">Año</th>
                                            <th>Nombre del Archivo</th>
                                            <th style="width: 15%">Archivo</th>
                                            @if ($mode != 1)
                                                <th>Visble en Front</th>
                                                <th style="width: 10%">Acciones</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($sessionMinutes as $minute)
                                            <tr>
                                                <td>{{ $minute->year }}</td>
                                                <td>{{ $minute->name }}</td>
                                                <td>
                                                    @if ($minute->file_path)
                                                        <a href="{{ Storage::url($minute->file_path) }}"
                                                            target="_blank" class="btn btn-sm btn-outline-primary">
                                                            Ver
                                                        </a>
                                                    @else
                                                        <span class="text-muted">Sin archivo</span>
                                                    @endif
                                                </td>
                                                @if ($mode != 1)
                                                    <td>
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" type="checkbox"
                                                                role="switch" id="switchCheckDefault"
                                                                @if ($minute->is_active) checked @endif
                                                                wire:click="changeStatus({{ $minute->id }})">
                                                            <label class="form-check-label" for="switchCheckDefault">

                                                                @switch($minute->is_active)
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
                                                        <a href="{{ route('council_minutes.edit', $minute->id) }}"
                                                            class="btn btn-sm btn-warning mb-2">
                                                            Editar
                                                        </a>

                                                        <form
                                                            action="{{ route('council_minutes.destroy', $minute->id) }}"
                                                            method="POST" style="display: inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger"
                                                                data-toggle="tooltip" data-original-title="Eliminar"
                                                                onclick="return confirm('¿Estás seguro de que deseas eliminar esta acta?')">
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
