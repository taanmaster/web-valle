@push('stylesheets')
    <style>
        .accordion-button::after {
            margin-left: auto;
            margin-right: auto;
        }
    </style>
@endpush

<div class="d-flex w-100 mb-3 px-2">
    <div class="col-md-1">
        ID
    </div>
    <div class="col-md">
        Tipo
    </div>
    <div class="col-md">
        Entidad
    </div>
    <div class="col-md">
        Ley
    </div>
    <div class="col-md">
        Total
    </div>
    <div class="col-md-2">
        Acciones
    </div>
    <div class="col-md-1">
        Agregar Concepto
    </div>
    <div class="col-md-1"></div>
</div>

<div class="accordion" id="accordionExample">
    @foreach ($incomes as $income)
        <div class="accordion-item">
            <div class="accordion-header row align-items-center w-100 mx-0">
                <div class="col-md-1">
                    <strong># {{ $income->id }}</strong>
                </div>
                <div class="col-md">
                    {{ $income->type }}
                </div>
                <div class="col-md">
                    {{ $income->entity }}
                </div>
                <div class="col-md">
                    {{ $income->law }}
                </div>
                <div class="col-md">
                    {{ $income->total }}
                </div>
                <div class="col-md-2">
                    <div style="gap: 12px">
                        <a href="javascript:void(0)" class="btn btn-sm btn-outline-secondary edit-income"
                            data-id="{{ $income->id }}">
                            <i class="bx bx-edit"></i> Editar
                        </a>
                        <form method="POST" action="{{ route('revenue_law_income.destroy', $income->id) }}"
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
                        <a href="javascript:void(0)" class="btn btn-sm btn-outline-primary new-concept"
                            data-id="{{ $income->id }}">
                            +
                        </a>
                    </div>
                </div>
                <div class="col-md-1 pe-0 d-flex justify-content-center">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="{{ '#collapse' . $income->id }}" aria-expanded="false"
                        aria-controls="{{ 'collapse' . $income->id }}" style="width: 100%">
                    </button>
                </div>
            </div>

            <div id="{{ 'collapse' . $income->id }}" class="accordion-collapse collapse"
                data-bs-parent="#accordionExample">
                <div class="accordion-body px-3 py-2">

                    <div class="table-responsive px-3">
                        <table class="table table-striped table-hover">
                            <thead class="">
                                <tr>
                                    <th>CRI</th>
                                    <th>Concepto</th>
                                    <th>Ingreso estimado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($income->concepts as $concept)
                                    <tr>
                                        <td>
                                            {{ $concept->CRI }}
                                        </td>
                                        <td>
                                            {{ $concept->concept }}
                                        </td>
                                        <td>
                                            {{ $concept->estimated_income }}
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="javascript:void(0)"
                                                    class="btn btn-sm btn-outline-primary edit-concept"
                                                    data-id="{{ $concept->id }}">
                                                    <i class="bx bx-edit"></i> Editar Variante
                                                </a>

                                                <form method="POST"
                                                    action="{{ route('revenue_law_concept.destroy', $concept->id) }}"
                                                    style="display: inline-block;">
                                                    {{ csrf_field() }}
                                                    {{ method_field('DELETE') }}
                                                    <button type="submit" class="btn btn-sm btn-outline-danger">
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
                </div>
            </div>
        </div>
    @endforeach
</div>
