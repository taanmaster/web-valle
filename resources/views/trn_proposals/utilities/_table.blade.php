<div class="row">
    @foreach($proposals as $proposal)
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                @if($proposal->in_index)
                    <p class="badge bg-success mb-0">Visible en Front</p>
                @else
                    <p class="badge bg-secondary mb-0">Oculto</p>
                @endif

                <div class="d-flex justify-content-between align-items-start mt-3">
                    <div>
                        <small class="mb-0">Título:</small>
                        <h2 class="mt-0">{{ $proposal->title }}</h2>
                    </div>
                </div>
                
                <small>Descripción</small>
                <p>{{ Str::limit($proposal->description, 150) }}</p>

                <hr>

                <small>Tipo de Archivo</small>
                <p>{{ strtoupper($proposal->file_type ?? 'N/A') }}</p>
                
                <hr>

                <small>Tamaño del Archivo</small>
                <p>{{ number_format($proposal->filesize / 1024 / 1024, 2) }} MB</p>
                
                <hr>
                
                @if($proposal->filepath)
                <a class="btn btn-sm btn-primary mb-3" href="{{ $proposal->filepath }}" target="_blank">
                    <i class="fas fa-download"></i> Descargar Archivo
                </a>
                @endif
                
                <hr>

                <div class="d-flex gap-2">
                    <a href="{{ route('trn_proposals.edit', $proposal->id) }}" class="btn btn-sm btn-outline-info">Editar</a>
        
                    <form method="POST" action="{{ route('trn_proposals.destroy', $proposal->id) }}">
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de eliminar esta convocatoria?')">
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
