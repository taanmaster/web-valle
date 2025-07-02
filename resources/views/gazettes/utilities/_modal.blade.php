<div class="modal fade" id="modalCreate" tabindex="-1" role="dialog" aria-labelledby="modalCreate" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h6 class="modal-title m-0 text-white" id="modalCreate">Nueva Gaceta</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div><!--end modal-header-->

            <form id="gazetteForm" method="POST" action="{{ route('gazettes.store') }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="modal-body pd-25">
                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <label for="name">Título del Documento  <span class="text-danger tx-12">*</span></label>
                            <input type="text" name="name" id="gazette_name" class="form-control" required="" autocomplete="off">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="document_number">Folio <span class="text-danger tx-12">*</span></label>
                            <input type="text" name="document_number" id="document_number" class="form-control" required="" autocomplete="off">
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="meeting_date">Fecha de Publicación  <span class="text-danger tx-12">*</span></label>
                            <input type="date" name="meeting_date" class="form-control" required="" autocomplete="off">
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="type">Tipo de Sesión <span class="text-danger tx-12">*</span></label>
                            <select class="form-control" name="type" required>
                                <option value="solemn">Sesiones Solemnes</option>
                                <option value="ordinary">Sesiones Ordinarias</option>
                                <option value="extraordinary">Sesiones Extraordinarias</option>
                            </select>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="description">Descripción Breve <span class="text-info tx-12">(Opcional)</span></label>
                            <textarea name="description" class="form-control" cols="30" rows="5"></textarea>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="document">Documento <span class="text-danger tx-12">*</span></label>
                            <input type="file" name="document" id="document_file" class="form-control" required="" autocomplete="off">
                            
                            <!-- Barra de progreso para subida directa -->
                            <div id="upload_progress_container" class="mt-2" style="display: none;">
                                <div class="progress">
                                    <div id="upload_progress" class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%"></div>
                                </div>
                                <small id="upload_status" class="text-muted">Preparando subida...</small>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="alert alert-info">
                                <p class="mb-0">El documento debe ser en formato PDF, puedes agregar archivos adicionales más adelante.</p>
                                <p class="mb-0 mt-1"><strong>Para archivos grandes (>8MB):</strong> Se usará subida por fragmentos para mejor rendimiento.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-de-secondary btn-sm" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" id="submit_btn" class="btn btn-de-dark btn-sm">Guardar datos</button>
                </div>
            </form>
        </div><!--end modal-content-->
    </div><!--end modal-dialog-->
</div><!--end modal-->

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('gazetteForm');
    const fileInput = document.getElementById('document_file');
    const progressContainer = document.getElementById('upload_progress_container');
    const progressBar = document.getElementById('upload_progress');
    const uploadStatus = document.getElementById('upload_status');
    const submitBtn = document.getElementById('submit_btn');
    
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
            
            const gazetteData = {
                name: document.getElementById('gazette_name').value,
                document_number: document.getElementById('document_number').value,
                description: document.querySelector('[name="description"]').value,
                type: document.querySelector('[name="type"]').value,
                meeting_date: document.querySelector('[name="meeting_date"]').value
            };
            
            // Paso 1: Crear la gaceta
            updateProgress(5, 'Creando registro...');
            const gazetteResponse = await createGazette(gazetteData);
            if (!gazetteResponse.success) {
                throw new Error(gazetteResponse.message || 'Error al crear la gaceta');
            }
            
            // Paso 2: Inicializar subida por chunks
            updateProgress(10, 'Inicializando subida...');
            const initResponse = await initChunkUpload(file, gazetteData);
            if (!initResponse.success) {
                throw new Error('Error al inicializar subida');
            }
            
            // Paso 3: Subir chunks
            updateProgress(15, 'Iniciando subida por fragmentos...');
            await uploadChunks(file, initResponse.upload_id, initResponse.total_chunks);
            
            // Paso 4: Finalizar subida
            updateProgress(90, 'Finalizando subida...');
            const finalizeResponse = await finalizeUpload(initResponse.upload_id, gazetteResponse.id);
            if (!finalizeResponse.success) {
                throw new Error(finalizeResponse.error || 'Error al finalizar subida');
            }
            
            updateProgress(100, 'Completado exitosamente');
            
            // Cerrar modal y recargar página
            setTimeout(() => {
                document.querySelector('[data-bs-dismiss="modal"]').click();
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
    
    async function createGazette(data) {
        const formData = new FormData();
        formData.append('_token', document.querySelector('[name="_token"]').value);
        Object.keys(data).forEach(key => {
            if (data[key]) formData.append(key, data[key]);
        });
        
        const response = await fetch('{{ route("gazettes.store") }}', {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            body: formData
        });
        
        if (!response.ok) {
            const errorData = await response.json().catch(() => ({}));
            throw new Error(errorData.message || 'Error al crear la gaceta');
        }
        
        return await response.json();
    }
    
    async function initChunkUpload(file, gazetteData) {
        const formData = new FormData();
        formData.append('_token', document.querySelector('[name="_token"]').value);
        formData.append('filename', file.name);
        formData.append('filesize', file.size);
        formData.append('chunk_size', CHUNK_SIZE);
        formData.append('gazette_name', gazetteData.name);
        formData.append('document_number', gazetteData.document_number);
        
        const response = await fetch('{{ route("gazettes.init-chunk-upload") }}', {
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
            
            const response = await fetch('{{ route("gazettes.upload-chunk") }}', {
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
    
    async function finalizeUpload(uploadId, gazetteId) {
        const formData = new FormData();
        formData.append('_token', document.querySelector('[name="_token"]').value);
        formData.append('upload_id', uploadId);
        formData.append('gazette_id', gazetteId);
        
        const response = await fetch('{{ route("gazettes.finalize-chunk-upload") }}', {
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
        uploadStatus.textContent = message;
        
        if (percent === 100) {
            progressBar.classList.remove('progress-bar-animated');
            progressBar.classList.add('bg-success');
        }
    }
});
</script>