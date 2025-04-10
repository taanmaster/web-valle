@push('stylesheets')
    <style>
        .accordion-button::after {
            margin-left: auto;
            margin-right: auto;
        }
    </style>
@endpush

<div class="d-flex w-100 mb-3 px-2">
    <div class="col-md">
        Fracción
    </div>
    <div class="col-md">
        Nombre
    </div>
    <div class="col-md">
        Descripción
    </div>
    <div class="col-md">
        Unidades
    </div>
    <div class="col-md">
        Tarifas
    </div>
    <div class="col-md-2">
        Acciones
    </div>
    <div class="col-md-1">
        Agregar inciso
    </div>
    <div class="col-md-1"></div>
</div>



<div class="accordion" id="accordionExample">
    @foreach ($article->fractions as $fraction)
        <div class="accordion-item">
            <div class="accordion-header row align-items-center w-100 mx-0">
                <div class="col-md">
                    {{ $fraction->fraction }}
                </div>

                <div class="col-md">
                    {{ $fraction->name }}
                </div>

                <div class="col-md">
                    {{ $fraction->description }}
                </div>

                <div class="col-md">
                    {{ $fraction->units ?? 'N/A' }}
                </div>


                <div class="col-md">
                    {{ $fraction->quote ?? 'N/A' }}
                </div>

                <div class="col-md-2">
                    <div style="gap: 12px">
                        <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#fractionModal"
                            class="btn btn-sm btn-outline-secondary"
                            onclick="Livewire.dispatch('selectFraction', {{ $fraction }})">
                            <i class="bx bx-edit"></i> Editar
                        </a>
                        <form method="POST" action="{{ route('revenue_collection_fractions.destroy', $fraction->id) }}"
                            style="display: inline-block;">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                <i class="bx bx-trash-alt"></i> Eliminar
                            </button>
                        </form>
                    </div>
                </div>

                <div class="col-md-1">
                    <div class="btn-group" role="group">
                        <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#clauseModal"
                            class="btn btn-sm btn-outline-primary"
                            onclick="Livewire.dispatch('newClause', {{ $fraction }})">
                            +
                        </a>
                    </div>
                </div>

                <div class="col-md-1 pe-0 d-flex justify-content-center">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="{{ '#collapse' . $fraction->id }}" aria-expanded="false"
                        aria-controls="{{ 'collapse' . $fraction->id }}" style="width: 100%">
                    </button>
                </div>
            </div>

            <div id="{{ 'collapse' . $fraction->id }}" class="accordion-collapse collapse"
                data-bs-parent="#accordionExample">
                <div class="accordion-body px-2 py-3">

                    @if ($fraction->clauses->count() == 0)
                        <div class="row w-100">
                            <div class="col-lg-12">
                                <div class="box">
                                    <div class="box-body">
                                        <div class="text-center" style="padding:40px 0px 60px 0px;">
                                            <h4>¡No hay articulos incisos en la base de datos!</h4>
                                            <p class="mb-4">Empieza a cargarlos en la fracción correspondiente.</p>
                                            <a href="javascript:void(0)" data-bs-toggle="modal"
                                                data-bs-target="#clauseModal"
                                                class="btn btn-sm btn-primary btn-uppercase"
                                                onclick="Livewire.dispatch('newClause', {{ $fraction }})"><i
                                                    class="fas fa-plus"></i>
                                                Nuevo Inciso</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="d-flex w-100 align-items-center px-2 py-3">
                            <div class="col-md">
                                Inciso
                            </div>
                            <div class="col-md">
                                Nombre
                            </div>
                            <div class="col-md">
                                Descripción
                            </div>
                            <div class="col-md">
                                Unidades
                            </div>
                            <div class="col-md">
                                Costo
                            </div>
                            <div class="col-md-3">
                                Acciones
                            </div>
                        </div>


                        <div class="bg-body-tertiary">
                            @foreach ($fraction->clauses as $clause)
                                <div class="bg-body-secondary d-flex align-items-center w-100 py-3 px-2">
                                    <div class="col-md">
                                        {{ $clause->clause }}
                                    </div>

                                    <div class="col-md">
                                        {{ $clause->name }}
                                    </div>

                                    <div class="col-md">
                                        {{ $clause->description ?? 'N/A' }}
                                    </div>

                                    <div class="col-md">
                                        {{ $clause->units ?? 'N/A' }}
                                    </div>

                                    <div class="col-md">
                                        {{ $clause->quote ?? 'N/A' }}
                                    </div>

                                    <div class="col-md-3">
                                        <div class="btn-group" role="group">
                                            <a href="javascript:void(0)" data-bs-toggle="modal"
                                                data-bs-target="#clauseModal" class="btn btn-sm btn-outline-primary"
                                                onclick="Livewire.dispatch('selectClause', {{ $clause }})">
                                                <i class="bx bx-edit"></i>
                                                Editar Inciso
                                            </a>
                                            <a href="javascript:void(0)" data-bs-toggle="modal"
                                                data-bs-target="#variantModal" class="btn btn-sm btn-outline-primary"
                                                onclick="Livewire.dispatch('newVariant', {{ $clause }})">
                                                <i class="fas fa-plus"></i> Agregar Variante
                                            </a>

                                            <form method="POST"
                                                action="{{ route('revenue_collection_clauses.destroy', $clause->id) }}"
                                                style="display: inline-block;">
                                                {{ csrf_field() }}
                                                {{ method_field('DELETE') }}
                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                    <i class="bx bx-trash-alt"></i> Eliminar
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <div class="table-responsive px-3">
                                    <table class="table table-striped table-hover">
                                        <thead class="">
                                            <tr>
                                                <th>Nombre de Variante</th>
                                                <th>Descripción</th>
                                                <th>Tarifa</th>
                                                <th>Unidades</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($clause->variants as $variant)
                                                <tr>
                                                    <td>
                                                        {{ $variant->name }}
                                                    </td>
                                                    <td>
                                                        {{ $variant->description }}
                                                    </td>
                                                    <td>
                                                        {{ $variant->units }}
                                                    </td>
                                                    <td>
                                                        {{ $variant->quote }}
                                                    </td>
                                                    <td>
                                                        <div class="btn-group" role="group">
                                                            <a href="javascript:void(0)" data-bs-toggle="modal"
                                                                data-bs-target="#variantModal"
                                                                class="btn btn-sm btn-outline-primary"
                                                                onclick="Livewire.dispatch('selectVariant', {{ $variant }})">
                                                                <i class="bx bx-edit"></i> Editar Variante
                                                            </a>

                                                            <form method="POST"
                                                                action="{{ route('revenue_collection_variants.destroy', $variant->id) }}"
                                                                style="display: inline-block;">
                                                                {{ csrf_field() }}
                                                                {{ method_field('DELETE') }}
                                                                <button type="submit"
                                                                    class="btn btn-sm btn-outline-danger">
                                                                    <i class="bx bx-trash-alt"></i> Eliminar
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endforeach
</div>
