<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>Sección</th>
                <th>Número</th>
                <th>Tipo</th>
                <th>Concepto/Descripción</th>
                <th>Total</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($rates as $rate)
                <tr>
                    <td>
                        {{ $rate->section }}
                    </td>
                    <td>
                        {{ $rate->order_number }}
                    </td>
                    <td>
                        {{ $rate->type }}
                    </td>
                    <td>
                        @switch($rate->type)
                            @case('Tarifa/Costo')
                                {{ $rate->concept }}
                            @break

                            @case('Informativo')
                                {{ $rate->description }}
                            @break
                        @endswitch
                    </td>
                    <td>
                        {{ $rate->cost ?? 'N/A' }}
                    </td>
                    <td>
                        <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#rateModal"
                            class="btn btn-sm btn-outline-secondary"
                            onclick="Livewire.dispatch('selectRate', {{ $rate }})">
                            <i class="bx bx-edit"></i> Editar
                        </a>
                        <form method="POST" action="{{ route('rates_and_cost.destroy', $rate->id) }}"
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
