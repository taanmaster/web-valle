<button type="button" class="btn btn-outline-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Búsqueda General <i class="mdi mdi-chevron-down"></i></button>
<div class="dropdown-menu">
    <form class="form-horizontal p-4" role="search" action="{{ route('back.financial_support_types.query') }}">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="contain">Que contenga los términos...</label>
                    <input class="form-control" type="search" name="query" placeholder="Nombre del Tipo de Apoyo">
                </div>
            </div>

            <div class="col-md-12 text-right">
                <button type="submit" class="btn btn-primary">Buscar</button>
            </div>
        </div>
    </form>
</div>
