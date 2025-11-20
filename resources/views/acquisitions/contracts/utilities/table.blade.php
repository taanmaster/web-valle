<div>
    @if ($biddings->count() != 0)
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th></th>
                        <th>Título</th>
                        <th>Dependencia</th>
                        <th>Tipo</th>
                        <th>Monto</th>
                        <th>Estatus</th>
                        @if ($mode == 0)
                            <th>Avance</th>
                        @endif
                        @if ($mode == 1)
                            <th>Fecha de cierre</th>
                        @endif
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($biddings as $bidding)
                        <tr>
                            <td>{{ $bidding->id }}</td>
                            <td>{{ $bidding->title }}</td>
                            <td>{{ $bidding->dependency_name }}</td>
                            <td>{{ $bidding->bidding_type }}</td>
                            <td>$ {{ $bidding->ammount }}</td>
                            <td>{{ $bidding->status }}</td>

                            @if ($mode == 0)
                                @php
                                    $total = $bidding->checklists->count();
                                    $withFile = $bidding->checklists->whereNotNull('file')->count();
                                    $percentage = $total > 0 ? ($withFile / $total) * 100 : 0;
                                @endphp
                                <td>
                                    <div class="d-flex align-items-center" style="gap: 12px">
                                        <div style="width: 150px; border-radius:10px; background:#dcdcdc;"
                                            class="d-flex p-1">
                                            <div
                                                style="width: {{ $percentage }}%; height: 6px;border-radius: 10px; background: #62C764;">
                                            </div>
                                        </div>

                                        <small>{{ $percentage }} %</small>
                                    </div>
                                </td>
                            @endif

                            @if ($mode == 1)
                                <td>
                                    {{ $bidding->updated_at->format('Y-m-d') }}
                                </td>
                            @endif
                            <td>
                                <a href="{{ route('acquisitions.biddings.show', $bidding->id) }}"
                                    class="btn btn-sm btn-outline-primary mb-2">
                                    Ver
                                </a>

                                <form action="{{ route('acquisitions.biddings.destroy', $bidding->id) }}" method="POST"
                                    style="display: inline;" class="mb-0">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" data-toggle="tooltip"
                                        data-original-title="Eliminar"
                                        onclick="return confirm('¿Estás seguro de que deseas eliminar esta licitación?')">
                                        Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="align-items-center mt-4">
            {{ $biddings->links() }}
        </div>
    @else
        <div class="row">
            <div class="col-lg-12">
                <div class="box">
                    <div class="box-body">
                        <div class="text-center" style="padding:80px 0px 100px 0px;">
                            <img src="{{ asset('assets/images/empty.svg') }}" class="ml-auto mr-auto"
                                style="width:30%; margin-bottom: 40px;">
                            @switch($mode)
                                @case(0)
                                    <h4>No hay licitaciones en estado Proceso entregables</h4>
                                @break

                                @case(1)
                                    <h4>No hay licitaciones en estado Cierre</h4>
                                @break
                            @endswitch
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
