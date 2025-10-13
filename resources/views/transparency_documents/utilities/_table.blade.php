<div class="table-responsive">
    <table class="table">
        <thead class="thead-light">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Periodo de Actualización</th>
                <th>Descripción</th>
                <th>Año</th>
                <th>Archivo</th>
                <th scope="col">Acciones</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($transparency_documents as $transparency_document)
                <tr>
                    <th scope="row">#{{ $transparency_document->id }}</th>
                    <td>
                        <a href="{{ route('transparency_documents.show', $transparency_document->id) }}">
                            {{ $transparency_document->name }}
                        </a>
                    </td>
                    <td>{{ $transparency_document->period }}º {{ $transparency_document->obligation->update_period }}
                    </td>
                    <td>
                        {{ $transparency_document->description }}
                    </td>
                    <td>{{ $transparency_document->year }}</td>
                    <td>
                        @if($transparency_document->s3_asset_url != null)
                            <a href="{{ $transparency_document->s3_asset_url }}" target="_blank">
                                {{ $transparency_document->filename }}
                            </a>
                        @else
                            <a href="{{ asset('files/documents/' . $transparency_document->filename) }}" target="_blank">
                                {{ $transparency_document->filename }}
                            </a>
                        @endif
                    </td>
                    <td>
                        <div class="btn-group" role="group" aria-label="Basic example">
                            {{--
                            <a href="{{ route('transparency_documents.show', $transparency_document->id) }}" class="btn btn-sm btn-icon"><i class='bx bx-show-alt'></i> Ver Detalle</a>
                            --}}
                            <a href="{{ route('transparency_documents.edit', $transparency_document->id) }}"
                                class="btn btn-sm btn-icon"><i class='bx bx-edit'></i> Editar</a>

                            @if (auth()->user()->hasRole('transparency_admin') || auth()->user()->hasRole('all'))  
                            <form method="POST"
                                action="{{ route('transparency_documents.destroy', $transparency_document->id) }}"
                                style="display: inline-block;">
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class='bx bx-trash-alt text-danger'></i> Eliminar
                                </button>
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
