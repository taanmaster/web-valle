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
                    $publicPath = url('files/transparency/' . $transparency_file->filename);

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
    function copyToClipboard(elementId) {
        var copyText = document.getElementById(elementId);
        copyText.select();
        copyText.setSelectionRange(0, 99999); // For mobile devices
        document.execCommand("copy");
        alert("Ruta copiada: " + copyText.value);
    }
</script>
