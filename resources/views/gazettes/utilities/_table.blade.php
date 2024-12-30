<div class="row">
    @foreach($gazettes as $gazette)
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h5 class="mb-0">Título:</h5>
                        <h2>{{ $gazette->name }}</h2>
                    </div>

                    @switch($gazette->type)
                        @case('solemn')
                            <p class="badge bg-primary mb-0">Sesiones Solemnes</p>
                            @break
                        @case('ordinary')
                            <p class="badge bg-secondary mb-0">Sesiones Ordinarias</p>
                            @break
                        @case('extraordinary')
                            <p class="badge bg-warning mb-0">Sesiones Extraordinarias</p>
                            @break
                        @default
                            
                    @endswitch
                </div>
                
                <h5>Folio</h5>
                <h2>{{ $gazette->document_number }}</h2>
                <h5>Descripción</h5>
                <p>{{ $gazette->description }}</p>

                <hr>
                @foreach($gazette->files as $file)
                <p class="mb-0">Archivo #{{ $file->name }}</p>
                <a class="btn btn-sm btn-primary" href="{{ asset('files/gazettes/'. $file->filename) }}">Descargar Archivo</a>
                <p class="text-muted">Subido por: {{ $file->uploader->name }}</p>
                @endforeach
                <hr>
                <div class="d-flex">
                    <a href="{{ route('gazettes.edit', $gazette->id) }}" class="btn btn-sm btn-outline-info">Editar</a>
        
                    <form method="POST" action="{{ route('gazettes.destroy', $gazette->id) }}">
                        <button type="submit" class="btn btn-sm btn-danger">
                            Eliminar
                        </button>
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endforeach      
</div>
                     