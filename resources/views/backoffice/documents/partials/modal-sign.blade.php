{{--
    Partial: modal-sign
    Modal de firma del oficio. Contiene tres secciones gestionadas por JS (scripts.blade.php):
      1. #signLoading  — spinner mientras se contacta al servicio eFirma
      2. #signEfirmaSection — iframe eFirma + botón confirmar + botón recordatorio
      3. #signCanvasSection — fallback: canvas de firma manuscrita + subida de sello

    La lógica de inicio se dispara con el botón #initSignBtn (en actions-reviewer.blade.php).
    El endpoint POST `efirma-initiate` decide el modo ('efirma' o canvas) y devuelve JSON.

    Variables heredadas del padre (scope @include):
        $document
--}}
<div class="modal fade" id="signModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title"><i class="fas fa-signature me-2"></i> Firmar Oficio</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">

                {{-- Sección: cargando --}}
                <div id="signLoading" class="text-center py-5">
                    <div class="spinner-border text-success mb-3" role="status">
                        <span class="visually-hidden">Cargando...</span>
                    </div>
                    <p class="text-muted">Conectando con el servicio de firma electrónica...</p>
                </div>

                {{-- Sección: eFirma iFrame --}}
                <div id="signEfirmaSection" style="display:none;">
                    <div class="alert alert-success">
                        <i class="fas fa-shield-alt me-2"></i>
                        <strong>Firma Electrónica Certificada</strong> — Se enviará un correo de confirmación antes de mostrar el documento. Una vez completada la firma, haga clic en <strong>Confirmar Firma</strong>.
                    </div>
                    {{-- Contenedor requerido por el SDK de eFirma (EfirmaTools lo usa por ID) --}}
                    <div id="efirmaContainer" style="height: 600px; width: 100%;"></div>
                    <div class="d-flex gap-2 mt-3">
                        <form action="{{ route('backoffice.documents.efirma-confirm', $document->id) }}" method="POST" class="flex-grow-1">
                            @csrf
                            <button type="submit" class="btn btn-success w-100">
                                <i class="fas fa-check-circle me-2"></i> Confirmar Firma Electrónica
                            </button>
                        </form>
                        @if($document->hasEfirmaDocument())
                            <button type="button" class="btn btn-outline-secondary" id="reminderBtn" title="Enviar recordatorio a firmante">
                                <i class="fas fa-bell"></i>
                            </button>
                        @endif
                    </div>
                </div>

                {{-- Sección: canvas (fallback) --}}
                <div id="signCanvasSection" style="display:none;">
                    <div id="signCanvasWarning" class="alert alert-warning d-none">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>eFirma no disponible.</strong> Se usará la firma de canvas como respaldo. Esta firma no tiene validez de certificado electrónico.
                    </div>
                    <div class="alert alert-success" id="signCanvasReady">
                        <i class="fas fa-check-double me-2"></i>
                        Este oficio ha completado las validaciones requeridas y está listo para ser firmado.
                    </div>
                    <form action="{{ route('backoffice.documents.sign', $document->id) }}" method="POST" enctype="multipart/form-data" id="signForm">
                        @csrf
                        <!-- Área de Firma -->
                        <div class="mb-4">
                            <label class="form-label"><strong>Firma Digital</strong> <span class="text-danger">*</span></label>
                            <div class="signature-pad-wrapper p-3" style="overflow: hidden;">
                                <div class="sigPad" id="signaturePad" style="width: 100%;">
                                    <ul class="sigNav mb-2">
                                        <li class="clearButton btn btn-sm btn-outline-secondary">
                                            <i class="fas fa-eraser me-1"></i> Limpiar
                                        </li>
                                    </ul>
                                    <div class="sig sigWrapper" style="position: relative; height: 200px; width: 100%;">
                                        <canvas class="pad" width="600" height="200" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;"></canvas>
                                        <input type="hidden" name="signature" class="output" id="signatureOutput">
                                    </div>
                                </div>
                            </div>
                            <small class="text-muted">Dibuje su firma en el área de arriba usando el mouse o pantalla táctil.</small>
                        </div>
                        <!-- Subir Sello -->
                        <div class="mb-3">
                            <label class="form-label"><strong>Sello (opcional)</strong></label>
                            <input type="file" name="stamp" class="form-control" accept=".png,.jpg,.jpeg">
                            <small class="text-muted">Suba una imagen PNG o JPG del sello que aparecerá decorativamente sobre el documento.</small>
                        </div>
                        <div class="modal-footer px-0 pb-0">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-signature me-2"></i> Firmar Documento
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
