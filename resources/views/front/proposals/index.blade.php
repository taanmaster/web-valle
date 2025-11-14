@extends('front.layouts.app')

@section('content')
<div class="container">
    <div class="row mt-4">
        <div class="col-12">
            <div class="card card-normal wow fadeInUp">
                <div class="card-title">
                    <div class="d-flex gap-3">
                        <div class="card-icon bg-warning text-white d-flex align-items-center justify-content-center">
                            <ion-icon name="documents-outline"></ion-icon>
                        </div>
                        
                        <h3>Convocatorias H. Ayuntamiento 2024-2027</h3>
                    </div>
                    <p class="card-title-description mb-0">Entérate aquí de las convocatorias del H. Ayuntamiento</p>
                </div>

                <div class="row w-100">
                    <div class="col-md-12">
                        @if($proposals->count() > 0)
                        <div class="table-responsive">
                            <table id="proposalsTable" class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Título</th>
                                        <th>Descripción</th>
                                        <th>Tipo</th>
                                        <th>Fecha</th>
                                        <th class="text-center">Archivo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($proposals as $proposal)
                                    <tr>
                                        <td>
                                            <p class="mb-0 fw-semibold text-dark">{{ $proposal->title }}</p>
                                        </td>
                                        <td>
                                            <small class="text-muted">{{ Str::limit($proposal->description, 100) }}</small>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-secondary text-uppercase">{{ strtoupper($proposal->file_type ?? 'PDF') }}</span>
                                        </td>
                                        <td data-order="{{ $proposal->created_at }}">
                                            {{ Carbon\Carbon::parse($proposal->created_at)->translatedFormat('d F Y') }}
                                        </td>
                                        <td class="text-center">
                                            @if($proposal->filepath)
                                            <a href="{{ $proposal->filepath }}" target="_blank" class="btn btn-primary btn-sm d-inline-flex align-items-center gap-2">
                                                <ion-icon name="download-outline"></ion-icon>
                                                Descargar Convocatoria
                                            </a>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-center mt-4">
                            {{ $proposals->links('pagination::bootstrap-5') }}
                        </div>
                        @else
                        <div class="text-center py-5">
                            <ion-icon name="folder-open-outline" style="font-size: 4rem; color: #ccc;"></ion-icon>
                            <h4 class="mt-3 text-muted">No hay convocatorias disponibles en este momento</h4>
                            <p class="text-muted">Vuelve a consultar más tarde</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection