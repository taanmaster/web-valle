<div class="row">
    @foreach($transparency_files as $transparency_file)
    <div class="col-md-3 mb-4">
        <div class="card">
            <div class="card-header bg-primary text-white">
                Dependencia: {{ $transparency_file->dependency->name }}
            </div>
            <div class="card-body text-center">
                @php
                    $icon = 'fa-file';
                    $badge = '';
                    $publicPath_old = url('files/transparency/' . $transparency_file->filename);
                    
                    // Condicional para determinar qué ruta usar (igual que en fetchFile)
                    if ($transparency_file->s3_asset_url !== null) {
                        $publicPath = $transparency_file->s3_asset_url; // Usar ruta de Amazon AWS
                    } else {
                        $publicPath = $publicPath_old; // Usar ruta local tradicional
                    }

                    switch ($transparency_file->file_extension) {
                        case 'pdf':
                            $icon = 'fa-file-pdf';
                            $badge = 'PDF';
                            break;
                        case 'doc':
                        case 'docx':
                            $icon = 'fa-file-word';
                            $badge = 'Word';
                            break;
                        case 'xls':
                        case 'xlsx':
                            $icon = 'fa-file-excel';
                            $badge = 'Excel';
                            break;
                        case 'ppt':
                        case 'pptx':
                            $icon = 'fa-file-powerpoint';
                            $badge = 'PowerPoint';
                            break;
                        case 'txt':
                            $icon = 'fa-file-alt';
                            $badge = 'Texto';
                            break;
                        case 'zip':
                        case 'rar':
                            $icon = 'fa-file-archive';
                            $badge = 'Archivo';
                            break;
                        default:
                            $icon = 'fa-file';
                            $badge = 'Archivo';
                            break;
                    }
                @endphp
                <i class="fas {{ $icon }} fa-3x"></i>
                <h5 class="card-title mt-2">{{ $transparency_file->name }}</h5>
                <span class="badge bg-primary">{{ $badge }}</span>
                @if($transparency_file->filesize)
                    <small class="text-muted d-block mt-1">
                        {{ $transparency_file->filesize > 0 ? number_format($transparency_file->filesize / 1024, 2) . ' KB' : 'N/A' }}
                    </small>
                @endif
                <input type="text" class="form-control mt-2" id="filePath{{ $transparency_file->id }}" value="{{ str_replace(' ', '%20', $publicPath) }}" readonly>
                <button type="button" class="btn btn-outline-primary mt-2" onclick="copyToClipboard('filePath{{ $transparency_file->id }}')">Copiar Ruta</button>
            </div>
            <div class="card-footer text-muted">
                <small>Creado: {{ $transparency_file->created_at }}</small><br>
                <small>Actualizado: {{ $transparency_file->updated_at }}</small>
            </div>
        </div>
    </div>
    @endforeach
</div>

<script>
    async function copyToClipboard(elementId) {
        try {
            const copyText = document.getElementById(elementId);
            const textToCopy = copyText.value;
            
            // Usar la API moderna del portapapeles
            await navigator.clipboard.writeText(textToCopy);
            
            // Mostrar toast de éxito
            showToast('Ruta copiada exitosamente', 'success');
        } catch (err) {
            // Fallback para navegadores antiguos
            try {
                const copyText = document.getElementById(elementId);
                copyText.select();
                copyText.setSelectionRange(0, 99999);
                document.execCommand("copy");
                showToast('Ruta copiada exitosamente', 'success');
            } catch (e) {
                showToast('Error al copiar la ruta', 'error');
            }
        }
    }

    function showToast(message, type = 'success') {
        const toast = document.createElement('div');
        const bgColor = type === 'success' ? 'bg-success' : 'bg-danger';
        const icon = type === 'success' ? '<i class="fas fa-check-circle me-2"></i>' : '<i class="fas fa-exclamation-circle me-2"></i>';
        
        toast.className = `alert ${bgColor} text-white alert-dismissible fade show position-fixed`;
        toast.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px; box-shadow: 0 4px 12px rgba(0,0,0,0.15);';
        toast.innerHTML = `
            ${icon}
            <span>${message}</span>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
        `;
        
        document.body.appendChild(toast);
        
        // Auto-remover después de 3 segundos
        setTimeout(() => {
            toast.classList.remove('show');
            setTimeout(() => {
                if (toast.parentNode) {
                    toast.remove();
                }
            }, 150);
        }, 3000);
    }
</script>
