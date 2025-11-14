@extends('front.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-normal wow fadeInUp">
                <div class="w-100">
                    @switch($gazette->type)
                        @case('ordinary')
                            <p class="small-uppercase mb-0">Sesiones Ordinarias H. Ayuntamiento 2024-2027</p>
                            @break

                        @case('extraordinary')
                            <p class="small-uppercase mb-0">Sesiones Extraordinarias H. Ayuntamiento 2024-2027</p>
                            @break

                        @case('solemn')
                            <p class="small-uppercase mb-0">Sesiones Solemnes H. Ayuntamiento 2024-2027</p>
                            @break
                        @default
                    @endswitch
                    
                    <h2>{{ $gazette->name }}</h2>
                    <p>{{ $gazette->description }}</p>

                    <div class="d-flex gap-3">
                        <p class="d-flex align-items-center gap-2"><ion-icon name="document-text-outline"></ion-icon> Acta {{ $gazette->document_number }}</p>
                        <p class="d-flex align-items-center gap-2"><ion-icon name="calendar-outline"></ion-icon> Fecha de Reunión: {{ Carbon\Carbon::parse($gazette->meeting_date)->translatedFormat('d F Y') }}</p>
                    </div>
                </div>
                
                <div class="w-100 mt-4">
                    <h5 class="mb-1 fw-bold">Archivos Disponibles</h5>
                    <p class="text-muted small mb-3">Descarga los documentos oficiales de esta sesión</p>
                    <hr>
                    
                    @if($gazette->files->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th class="fw-semibold text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.5px;">Documento</th>
                                    <th class="fw-semibold text-uppercase text-center" style="font-size: 0.75rem; letter-spacing: 0.5px;">Tipo</th>
                                    <th class="fw-semibold text-uppercase text-center" style="font-size: 0.75rem; letter-spacing: 0.5px;">Tamaño</th>
                                    <th class="fw-semibold text-uppercase text-center" style="font-size: 0.75rem; letter-spacing: 0.5px;">Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($gazette->files as $file)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <ion-icon name="document-text-outline" style="font-size: 1.5rem; color: #6c757d;"></ion-icon>
                                            <div>
                                                <p class="mb-0 fw-semibold">{{ $file->name }}</p>
                                                <small class="text-muted">{{ $file->filename }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-secondary text-uppercase">{{ $file->file_extension ?? 'PDF' }}</span>
                                    </td>
                                    <td class="text-center text-muted">
                                        {{ $file->filesize ? number_format($file->filesize / 1024 / 1024, 2) . ' MB' : 'N/A' }}
                                    </td>
                                    <td class="text-center">
                                        @if($file->s3_asset_url != null)
                                        <a target="_blank" href="{{ $file->s3_asset_url }}" class="btn btn-primary btn-sm d-inline-flex align-items-center gap-2">
                                            <ion-icon name="download-outline"></ion-icon>
                                            Descargar
                                        </a>
                                        @else
                                        <a target="_blank" href="{{ asset('files/gazettes/' . $file->filename) }}" class="btn btn-primary btn-sm d-inline-flex align-items-center gap-2">
                                            <ion-icon name="download-outline"></ion-icon>
                                            Descargar
                                        </a>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="text-center py-5">
                        <ion-icon name="folder-open-outline" style="font-size: 3rem; color: #dee2e6;"></ion-icon>
                        <p class="text-muted mt-3 mb-0">No hay archivos disponibles para esta sesión</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection