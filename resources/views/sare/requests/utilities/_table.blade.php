<div class="row">
    @foreach($sare_requests as $request)
    <div class="col-md-6 col-lg-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <span class="badge bg-{{ $request->status_color }} mb-0">{{ $request->status_label }}</span>
                    <small class="text-muted">#{{ $request->request_num }}</small>
                </div>

                <div class="mb-3">
                    <small class="mb-0 text-muted">Solicitante:</small>
                    <h5 class="mt-0 mb-1">{{ $request->rfc_name }}</h5>
                    <small class="text-muted">{{ $request->user->name }}</small>
                </div>
                
                <div class="mb-3">
                    <small class="text-muted">Nombre Comercial:</small>
                    <p class="mb-1">{{ $request->commercial_name }}</p>
                </div>

                <div class="mb-3">
                    <small class="text-muted">RFC:</small>
                    <p class="mb-1">{{ $request->rfc_num }}</p>
                </div>

                <div class="mb-3">
                    <small class="text-muted">Número Catastral:</small>
                    <p class="mb-1">{{ $request->catastral_num }}</p>
                </div>

                <div class="mb-3">
                    <small class="text-muted">Tipo de Solicitud:</small>
                    <p class="mb-1">
                        @switch($request->request_type)
                            @case('general')
                                General
                                @break
                            @case('nuevo')
                                Nuevo
                                @break
                            @case('renovacion')
                                Renovación
                                @break
                            @case('anuncio')
                                Anuncio
                                @break
                            @default
                                {{ $request->request_type }}
                        @endswitch
                    </p>
                </div>

                <div class="mb-3">
                    <small class="text-muted">Fecha de Solicitud:</small>
                    <p class="mb-1">{{ $request->request_date }}</p>
                </div>

                <div class="mb-3">
                    <small class="text-muted">Empleos a Generar:</small>
                    <p class="mb-1">{{ $request->jobs_to_generate }}</p>
                </div>

                @if($request->files->count() > 0)
                <div class="mb-3">
                    <small class="text-muted">Archivos Adjuntos:</small>
                    <p class="mb-1">{{ $request->files->count() }} archivo(s)</p>
                </div>
                @endif
                
                <hr>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('sare.request.show', $request->id) }}" class="btn btn-sm btn-outline-info">Ver Detalle</a>
                    
                    <small class="text-muted align-self-center">
                        {{ $request->created_at->format('d/m/Y') }}
                    </small>
                </div>
            </div>
        </div>
    </div>
    @endforeach      
</div>
