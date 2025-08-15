<div class="row">
    @foreach($urban_dev_requests as $request)
    <div class="col-md-6 col-lg-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <span class="badge bg-{{ $request->status_color }} mb-0">{{ $request->status_label }}</span>
                    <small class="text-muted">#{{ $request->id }}</small>
                </div>

                <div class="mb-3">
                    <small class="mb-0 text-muted">Solicitante:</small>
                    <h5 class="mt-0 mb-1">{{ $request->user->name }}</h5>
                    <small class="text-muted">{{ $request->user->email }}</small>
                </div>
                
                <div class="mb-3">
                    <small class="text-muted">Tipo de Solicitud:</small>
                    <p class="mb-1">{{ $request->request_type_label }}</p>
                </div>

                @if($request->description)
                <div class="mb-3">
                    <small class="text-muted">Descripción:</small>
                    <p class="mb-1">{{ Str::limit($request->description, 100) }}</p>
                </div>
                @endif

                @if($request->files->count() > 0)
                <div class="mb-3">
                    <small class="text-muted">Archivos Adjuntos:</small>
                    <p class="mb-1">{{ $request->files->count() }} archivo(s)</p>
                </div>
                @endif
                
                <hr>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('urban_dev.requests.show', $request->id) }}" class="btn btn-sm btn-outline-info">Ver Detalle</a>
                    
                    <small class="text-muted align-self-center">
                        {{ $request->created_at->format('d/m/Y') }}
                    </small>
                </div>
            </div>
        </div>
    </div>
    @endforeach      
</div>
