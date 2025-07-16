@extends('layouts.master')
@section('title')
    Intranet
@endsection
@section('content')
    <!-- this is breadcrumbs -->
    @component('components.breadcrumb')
        @slot('li_1')
            Intranet
        @endslot
        @slot('li_2')
            Transparencia
        @endslot
        @slot('title')
            Documentos
        @endslot
    @endcomponent

    <div class="row layout-spacing">
        <div class="main-content">
            <div class="row">
                <div class="col-12">
                    <div class="card card-body">
                        <form method="POST" action="{{ route('transparency_documents.update', $transparency_document->id) }}"
                            enctype="multipart/form-data" id="transparencyDocumentForm">
                            {{ csrf_field() }}
                            {{ method_field('PUT') }}

                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="name" class="form-label">Nombre <span
                                            class="text-danger tx-12">*</span></label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        value="{{ $transparency_document->name }}" required>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label for="description" class="form-label">Descripción <span
                                            class="text-info tx-12">(Opcional)</span></label>
                                    <textarea class="form-control" id="description" name="description" rows="3">
                                        {{ $transparency_document->description }}
                                    </textarea>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="year" class="form-label">Año <span
                                            class="text-danger tx-12">*</span></label>
                                    <input type="text" class="form-control" id="year" name="year"
                                        value="{{ $transparency_document->year }}" required>
                                </div>

                                <div class="col-md-12 mb-3">
                                    @php
                                        $periodOptions = [];
                                        $periodLabel = '';

                                        switch ($transparency_obligation->update_period) {
                                            case 'Trimestral':
                                                $periodOptions = ['1', '2', '3', '4'];
                                                $periodLabel = 'Periodo Trimestral al que pertenece:';
                                                break;
                                            case 'Anual':
                                                $periodOptions = ['1'];
                                                $periodLabel = 'Periodo Anual al que pertenece:';
                                                break;
                                            case 'Semestral':
                                                $periodOptions = ['1', '2'];
                                                $periodLabel = 'Periodo Semestral al que pertenece:';
                                                break;
                                            default:
                                                $periodOptions = ['1'];
                                                $periodLabel = 'Periodo al que pertenece:';
                                                break;
                                        }
                                    @endphp
                                    <label for="period" class="form-label">{{ $periodLabel }} <span
                                            class="text-danger tx-12">*</span></label>
                                    <select class="form-control" id="period" name="period" required>
                                        @foreach ($periodOptions as $option)
                                            <option value="{{ $option }}" {{ $transparency_document->period == $option ? 'selected' : '' }}>{{ $option }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                @if ($transparency_document->filename == 'empty')
                                    <div class="col-md-12 mb-3">
                                        <label for="filename" class="form-label">Archivo <span
                                                class="text-danger tx-12">*</span></label>
                                        <input type="file" class="form-control" id="filename" name="filename" required>
                                    </div>

                                    <!-- Contenedor para barra de progreso -->
                                    <div class="col-md-12 mb-3" id="upload_progress_container" style="display: none;">
                                        <div class="progress" style="height: 25px;">
                                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-primary" 
                                                 role="progressbar" 
                                                 id="upload_progress" 
                                                 style="width: 0%;" 
                                                 aria-valuenow="0" 
                                                 aria-valuemin="0" 
                                                 aria-valuemax="100">
                                                 <span class="progress-text">0%</span>
                                            </div>
                                        </div>
                                        <small class="text-muted mt-2 d-block" id="upload_status">Iniciando subida...</small>
                                    </div>
                                @endif

                                <input type="hidden" name="obligation_id" value="{{ $transparency_obligation->id }}">

                                <div class="row justify-content-end align-items-center" style="gap: 12px">
                                    @if ($transparency_document->filename != 'empty')
                                        <a href="{{ route('transparency_obligations.show', $transparency_document->obligation_id) }}"
                                            class="btn btn-secondary btn-sm" style="width: 120px">Cancelar</a>
                                    @endif
                                    <button type="submit" id="submit_btn" class="btn btn-dark btn-sm" style="width: 150px">
                                        Guardar Documento
                                    </button>
                                </div>
                            </div>
                        </form>

                        @if ($transparency_document->filename != 'empty')
                            <form action="{{ route('transparency_documents.deleteFile', $transparency_document->id) }}"
                                method="POST">
                                {{ csrf_field() }}
                                {{ method_field('PUT') }}
                                <div class="col-md-12 mb-3">
                                    <label for="current_file" class="form-label">Archivo Actual:</label>
                                    <a class="btn btn-link"
                                        href="{{ $transparency_document->s3_asset_url ?: asset('files/documents/' . $transparency_document->filename) }}"
                                        target="_blank">{{ $transparency_document->filename }}</a>
                                </div>

                                <button type="submit" class="btn btn-danger btn-sm" style="width: 150px">
                                    Borrar archivo actual
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('transparencyDocumentForm');
    const fileInput = document.getElementById('filename');
    const progressContainer = document.getElementById('upload_progress_container');
    const progressBar = document.getElementById('upload_progress');
    const uploadStatus = document.getElementById('upload_status');
    const submitBtn = document.getElementById('submit_btn');
    
    // Solo aplicar lógica de chunks si hay input de archivo
    if (!fileInput) {
        return;
    }
    
    // Límite de tamaño para decidir si usar subida por chunks (8MB)
    const LARGE_FILE_THRESHOLD = 8 * 1024 * 1024;
    const CHUNK_SIZE = 2 * 1024 * 1024; // 2MB chunks
    
    form.addEventListener('submit', async function(e) {
        const file = fileInput.files[0];
        
        // Si no hay archivo o es pequeño, usar método tradicional
        if (!file || file.size <= LARGE_FILE_THRESHOLD) {
            return; // Continuar con submit normal
        }
        
        // Para archivos grandes, usar subida por chunks
        e.preventDefault();
        await handleLargeFileUpload(file);
    });
    
    async function handleLargeFileUpload(file) {
        try {
            submitBtn.disabled = true;
            progressContainer.style.display = 'block';
            updateProgress(0, 'Preparando subida de archivo grande...');
            
            const documentData = {
                obligation_id: document.querySelector('[name="obligation_id"]').value,
                name: document.getElementById('name').value,
                description: document.getElementById('description').value,
                period: document.getElementById('period').value,
                year: document.getElementById('year').value
            };
            
            // Paso 1: Inicializar subida por chunks
            updateProgress(10, 'Inicializando subida...');
            const initResponse = await initChunkUpload(file, documentData);
            if (!initResponse.success) {
                throw new Error('Error al inicializar subida');
            }
            
            // Paso 2: Subir chunks
            updateProgress(15, 'Iniciando subida por fragmentos...');
            await uploadChunks(file, initResponse.upload_id, initResponse.total_chunks);
            
            // Paso 3: Finalizar subida
            updateProgress(90, 'Finalizando subida...');
            const finalizeResponse = await finalizeUpload(initResponse.upload_id);
            if (!finalizeResponse.success) {
                throw new Error(finalizeResponse.error || 'Error al finalizar subida');
            }
            
            updateProgress(100, 'Completado exitosamente');
            
            // Recargar página después de éxito
            setTimeout(() => {
                window.location.reload();
            }, 1000);
            
        } catch (error) {
            console.error('Error:', error);
            updateProgress(0, 'Error: ' + error.message);
            submitBtn.disabled = false;
            
            setTimeout(() => {
                progressContainer.style.display = 'none';
            }, 3000);
        }
    }
    
    async function initChunkUpload(file, documentData) {
        const formData = new FormData();
        formData.append('_token', document.querySelector('[name="_token"]').value);
        formData.append('filename', file.name);
        formData.append('filesize', file.size);
        formData.append('chunk_size', CHUNK_SIZE);
        formData.append('obligation_id', documentData.obligation_id);
        formData.append('name', documentData.name);
        formData.append('description', documentData.description);
        formData.append('period', documentData.period);
        formData.append('year', documentData.year);
        formData.append('document_id', '{{ $transparency_document->id }}'); // Para actualizaciones
        
        const response = await fetch('{{ route("transparency_documents.init-chunk-upload") }}', {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            body: formData
        });
        
        if (!response.ok) {
            const errorData = await response.json().catch(() => ({}));
            throw new Error(errorData.error || 'Error al inicializar subida');
        }
        
        return await response.json();
    }
    
    async function uploadChunks(file, uploadId, totalChunks) {
        for (let i = 0; i < totalChunks; i++) {
            const start = i * CHUNK_SIZE;
            const end = Math.min(start + CHUNK_SIZE, file.size);
            const chunk = file.slice(start, end);
            
            const formData = new FormData();
            formData.append('_token', document.querySelector('[name="_token"]').value);
            formData.append('upload_id', uploadId);
            formData.append('chunk_number', i);
            formData.append('chunk', chunk, `chunk_${i}`);
            
            const response = await fetch('{{ route("transparency_documents.upload-chunk") }}', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                body: formData
            });
            
            if (!response.ok) {
                const errorData = await response.json().catch(() => ({}));
                throw new Error(`Error en fragmento ${i + 1}: ${errorData.error || 'Error desconocido'}`);
            }
            
            const result = await response.json();
            if (!result.success) {
                throw new Error(`Error en fragmento ${i + 1}: ${result.error}`);
            }
            
            // Calcular progreso entre 15% y 85%
            const chunkProgress = 15 + (70 * (i + 1) / totalChunks);
            updateProgress(chunkProgress, `Subiendo fragmento ${i + 1} de ${totalChunks} (${result.progress.toFixed(1)}%)`);
        }
    }
    
    async function finalizeUpload(uploadId) {
        const formData = new FormData();
        formData.append('_token', document.querySelector('[name="_token"]').value);
        formData.append('upload_id', uploadId);
        
        const response = await fetch('{{ route("transparency_documents.finalize-chunk-upload") }}', {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            body: formData
        });
        
        if (!response.ok) {
            const errorData = await response.json().catch(() => ({}));
            throw new Error(errorData.error || 'Error al finalizar subida');
        }
        
        return await response.json();
    }
    
    function updateProgress(percent, message) {
        progressBar.style.width = percent + '%';
        progressBar.setAttribute('aria-valuenow', percent);
        progressBar.querySelector('.progress-text').textContent = Math.round(percent) + '%';
        uploadStatus.textContent = message;
        
        if (percent === 100) {
            progressBar.classList.remove('progress-bar-animated');
            progressBar.classList.remove('bg-primary');
            progressBar.classList.add('bg-success');
        }
    }
});
</script>
@endsection
