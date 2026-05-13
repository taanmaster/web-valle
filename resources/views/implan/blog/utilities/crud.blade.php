<div>
    <div class="row layout-spacing">
        <div class="main-content">
            <div class="row align-items-center mb-4">
                <div class="col text-start">
                    @if ($post != null)
                        @switch($mode)
                            @case(1)
                                <h2>Ver publicación</h2>
                            @break

                            @case(2)
                                <h2>Editar publicación</h2>
                            @break
                        @endswitch
                    @else
                        <h2>Nueva publicación</h2>
                    @endif
                </div>
            </div>
            <form method="POST" wire:submit="save" enctype="multipart/form-data">
                {{ csrf_field() }}

                <div class="row align-items-center justify-content-end m-3">
                    <div class="col-md-2">
                        <label for="published_at" class="col-form-label">Fecha de Ingreso</label>
                    </div>
                    <div class="col-md-4">
                        <input type="date" name="published_at" wire:model="published_at" class="form-control"
                            @if ($mode == 1) disabled @endif>
                    </div>
                </div>

                <div class="row align-items-center justify-content-end m-3">
                    <div class="col-md-2">
                        <label for="type" class="col-form-label">Tipo</label>
                    </div>
                    <div class="col-md-4">
                        <select name="type" wire:model="type" id="type" class="form-control"
                            @if ($mode == 1) disabled @endif>
                            <option>Seleccionar opción</option>
                            <option value="Plano">Plano Temático</option>
                            <option value="Capa">Capa</option>
                        </select>
                    </div>
                </div>

                <div class="row align-items-center m-3">
                    <div class="col-md-2">
                        <label for="title" class="col-form-label">Título</label>
                    </div>
                    <div class="col-md">
                        <input type="text" class="form-control" wire:model="title" name="title"
                            @if ($mode == 1) disabled @endif>
                    </div>
                </div>

                <div class="row m-3">
                    <div class="col-md-2">
                        <label for="image" class="col-form-label">Imagen</label>
                    </div>
                    <div class="col-md">
                        @if ($mode == 1)
                            @if ($image)
                                @php
                                    $extension = strtolower(pathinfo($image, PATHINFO_EXTENSION));
                                @endphp

                                @if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'tiff']))
                                    <img src="{{ $image }}" alt="Vista previa"
                                        style="max-width: 400px; height: auto;">
                                @else
                                    <a href="{{ $image }}" target="_blank" class="btn btn-outline-primary">
                                        Ver archivo
                                    </a>
                                @endif
                            @else
                                <p>No hay archivo disponible.</p>
                            @endif
                        @else
                            @if ($mode == 2 && $post->image != null)
                                <div class="d-flex align-items-center" style="gap: 12px; margin-bottom: 12px;">

                                    <a href="{{ $post->image }}" target="_blank" class="btn btn-outline-primary">
                                        Ver archivo
                                    </a>

                                    <button type="button" class="btn btn-outline-danger btn-sm"
                                        wire:click="removeImage({{ $post->id }})">Eliminar
                                        archivo</button>
                                </div>
                            @else
                                <div
                                    x-data="{
                                        isDragging: false,
                                        dragCount: 0,
                                        fileName: null,
                                        handleDrop(e) {
                                            this.isDragging = false;
                                            this.dragCount = 0;
                                            const files = e.dataTransfer.files;
                                            if (files.length > 0) {
                                                const dt = new DataTransfer();
                                                dt.items.add(files[0]);
                                                this.$refs.fileInput.files = dt.files;
                                                this.fileName = files[0].name;
                                                this.$refs.fileInput.dispatchEvent(new Event('change'));
                                            }
                                        }
                                    }"
                                    @dragenter.prevent="dragCount++; isDragging = true"
                                    @dragleave.prevent="dragCount--; if(dragCount === 0) isDragging = false"
                                    @dragover.prevent
                                    @drop.prevent="handleDrop($event)"
                                >
                                    <div
                                        @click="$refs.fileInput.click()"
                                        :style="isDragging
                                            ? 'border-color: #0d6efd; background-color: #e8f0fe;'
                                            : 'border-color: #6c757d; background-color: #f8f9fa;'"
                                        style="border: 2px dashed #6c757d; border-radius: 8px; padding: 2rem 1rem; text-align: center; cursor: pointer; transition: all 0.2s;"
                                    >
                                        {{-- Estado: cargando --}}
                                        <div wire:loading wire:target="image" class="text-muted">
                                            <div class="spinner-border spinner-border-sm me-2" role="status"></div>
                                            Cargando archivo, por favor espere…
                                        </div>

                                        {{-- Estado: en reposo o con archivo seleccionado --}}
                                        <div wire:loading.remove wire:target="image">
                                            <template x-if="!fileName">
                                                <div>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="currentColor" class="bi bi-cloud-arrow-up mb-2 text-secondary" viewBox="0 0 16 16">
                                                        <path fill-rule="evenodd" d="M7.646 5.146a.5.5 0 0 1 .708 0l2 2a.5.5 0 0 1-.708.708L8.5 6.707V10.5a.5.5 0 0 1-1 0V6.707L6.354 7.854a.5.5 0 1 1-.708-.708z"/>
                                                        <path d="M4.406 3.342A5.53 5.53 0 0 1 8 2c2.69 0 4.923 2 5.166 4.579C14.758 6.804 16 8.137 16 9.773 16 11.569 14.502 13 12.687 13H3.781C1.708 13 0 11.366 0 9.318c0-1.763 1.266-3.223 2.942-3.593.143-.863.698-1.723 1.464-2.383m.653.757c-.757.653-1.153 1.44-1.153 2.056v.448l-.445.049C2.064 6.805 1 7.952 1 9.318 1 10.785 2.23 12 3.781 12h8.906C13.98 12 15 10.988 15 9.773c0-1.216-1.02-2.228-2.313-2.228h-.5v-.5C12.188 4.825 10.328 3 8 3a4.53 4.53 0 0 0-2.941 1.1z"/>
                                                    </svg>
                                                    <p class="mb-1 text-muted" style="font-size: .95rem;">
                                                        Arrastra el archivo aquí o
                                                        <span style="color: #0d6efd; font-weight: 600;">haz clic para buscar</span>
                                                    </p>
                                                    <p class="mb-0 text-muted" style="font-size: .8rem;">
                                                        JPG, PNG, GIF, WEBP, TIFF, PDF, Word, Excel, ZIP — máx. 50 MB
                                                    </p>
                                                </div>
                                            </template>
                                            <template x-if="fileName">
                                                <div class="d-flex align-items-center justify-content-center gap-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-file-earmark-check text-success" viewBox="0 0 16 16">
                                                        <path d="M10.854 7.854a.5.5 0 0 0-.708-.708L7.5 9.793 6.354 8.646a.5.5 0 1 0-.708.708l1.5 1.5a.5.5 0 0 0 .708 0z"/>
                                                        <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2M9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5z"/>
                                                    </svg>
                                                    <span x-text="fileName" class="text-dark" style="font-size: .9rem; word-break: break-all;"></span>
                                                    <button
                                                        type="button"
                                                        class="btn btn-link btn-sm text-danger p-0 ms-1"
                                                        @click.stop="fileName = null; $refs.fileInput.value = ''; $wire.set('image', null)"
                                                        title="Quitar archivo"
                                                    >&times;</button>
                                                </div>
                                            </template>
                                        </div>
                                    </div>

                                    <input
                                        type="file"
                                        x-ref="fileInput"
                                        wire:model="image"
                                        class="d-none"
                                        x-on:change="fileName = $event.target.files[0]?.name ?? null"
                                    >
                                </div>

                                @error('image')
                                    <div class="alert alert-danger d-flex align-items-start gap-2 mt-2 py-2" role="alert" style="font-size: .875rem;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-exclamation-triangle-fill flex-shrink-0 mt-1" viewBox="0 0 16 16" aria-hidden="true">
                                            <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5m.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>
                                        </svg>
                                        <div>
                                            <strong>Error en el archivo:</strong> {{ $message }}
                                        </div>
                                    </div>
                                @enderror
                            @endif
                        @endif
                    </div>
                </div>

                <div class="m-3 d-flex justify-content-end" style="gap: 12px">
                    <a href="{{ route('implan.blog.index') }}" style="max-width: 110px"
                        class="btn btn-secondary btn-sm">Cancelar</a>
                    @if ($mode != 1)
                        <button type="submit" style="max-width: 110px" class="btn btn-dark btn-sm">Guardar
                            datos</button>
                    @endif
                </div>
            </form>

        </div>
    </div>
</div>
