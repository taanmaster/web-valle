{{--
    Partial: scripts
    Bloque JavaScript de la vista show de documentos.
    Se incluye DENTRO de @section('script') en show.blade.php.

    Responsabilidades:
    - Mostrar el modal de confirmación de recibo al cargar la página ($showConfirmModal).
    - Inicializar Select2 en los modales: sendReviewModal, validateModal, sendRecipientModal.
    - Cargar opciones iniciales de destinatarios vía AJAX en sendRecipientModal.
    - Gestionar el flujo de firma: llamada a efirma-initiate, mostrar iframe eFirma o canvas fallback.
    - Inicializar el plugin signaturePad y validar la firma antes de enviar el formulario.
    - Botón de recordatorio eFirma (#reminderBtn).

    Variables Blade usadas:
        $document->id, $document->dependency_id,
        $showConfirmModal
--}}
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="{{ asset('libs/signature-pad-main/jquery.signaturepad.min.js') }}"></script>
<script src="{{ asset('libs/signature-pad-main/assets/json2.min.js') }}"></script>
<script src="https://mx.efirma.com/pub/js/efirmaTools.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {

    // -------------------------------------------------------------------------
    // Modal de confirmación de recibo (primera lectura)
    // -------------------------------------------------------------------------
    @if($showConfirmModal)
        var confirmModal = new bootstrap.Modal(document.getElementById('confirmReceiptModal'));
        confirmModal.show();
    @endif

    // -------------------------------------------------------------------------
    // Select2: inicialización base
    // -------------------------------------------------------------------------
    $('#assigned_to_review, #next_assigned_to').select2({
        theme: 'bootstrap-5',
        placeholder: 'Buscar colaborador...',
        allowClear: true,
        dropdownParent: $('.modal.show').length ? $('.modal.show') : $('body')
    });

    // Reinicializar Select2 al abrir modal de envío a revisión
    $('#sendReviewModal').on('shown.bs.modal', function() {
        $('#assigned_to_review').select2({
            theme: 'bootstrap-5',
            placeholder: 'Buscar colaborador...',
            dropdownParent: $(this)
        });
    });

    // Reinicializar Select2 al abrir modal de validación
    $('#validateModal').on('shown.bs.modal', function() {
        $('#next_assigned_to').select2({
            theme: 'bootstrap-5',
            placeholder: 'Buscar colaborador...',
            dropdownParent: $(this)
        });
    });

    // -------------------------------------------------------------------------
    // Select2 con AJAX para destinatario de la dependencia destino
    // -------------------------------------------------------------------------
    $('#sendRecipientModal').on('shown.bs.modal', function() {
        var modal = $(this);
        $('#sent_to_user_id').select2({
            theme: 'bootstrap-5',
            placeholder: 'Buscar contacto de la dependencia...',
            allowClear: true,
            dropdownParent: modal,
            ajax: {
                url: '{{ route("backoffice.documents.search-dependency-users") }}',
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        q: params.term,
                        dependency_id: '{{ $document->dependency_id }}'
                    };
                },
                processResults: function (data) {
                    return {
                        results: data.results
                    };
                },
                cache: true
            },
            minimumInputLength: 0
        });

        // Carga inicial de opciones sin término de búsqueda
        $.ajax({
            url: '{{ route("backoffice.documents.search-dependency-users") }}',
            data: { dependency_id: '{{ $document->dependency_id }}' },
            dataType: 'json',
            success: function(data) {
                if (data.results && data.results.length > 0) {
                    var select = $('#sent_to_user_id');
                    select.empty();
                    select.append('<option value="">Seleccionar contacto...</option>');
                    data.results.forEach(function(user) {
                        select.append('<option value="' + user.id + '">' + user.text + '</option>');
                    });
                }
            }
        });
    });

    // -------------------------------------------------------------------------
    // Botón "Firmar" — inicia proceso eFirma o cae a canvas
    // -------------------------------------------------------------------------
    var signaturePad       = null;
    var pendingCanvasInit = false;  // canvas debe inicializarse al terminar la animación del modal
    var modalFullyShown  = false;  // true después de shown.bs.modal

    // Resetear estado al cerrar el modal para permitir reapertura limpia
    $('#signModal').on('hidden.bs.modal', function () {
        signaturePad      = null;
        pendingCanvasInit = false;
        modalFullyShown  = false;
        $('#signCanvasSection').hide();
        $('#signEfirmaSection').hide();
        $('#signLoading').show();
        $('#signCanvasWarning').addClass('d-none');
        $('#signCanvasReady').show();
    });

    $('#initSignBtn').on('click', function () {
        console.log('[eFirma] Botón firmar presionado');
        $('#signLoading').show();
        $('#signEfirmaSection').hide();
        $('#signCanvasSection').hide();

        var modal = new bootstrap.Modal(document.getElementById('signModal'));
        modal.show();

        console.log('[eFirma] Lanzando POST a efirma-initiate para documento {{ $document->id }}');
        $.ajax({
            url: '{{ route("backoffice.documents.efirma-initiate", $document->id) }}',
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            success: function (data) {
                console.log('[eFirma] Respuesta de efirma-initiate:', data);
                $('#signLoading').hide();
                if (data.mode === 'efirma') {
                    console.log('[eFirma] Modo: efirma — iframe_url:', data.iframe_url);
                    console.log('[eFirma] ¿EfirmaTools disponible?', typeof EfirmaTools !== 'undefined');
                    $('#signEfirmaSection').show();
                    var efirmaTools = new EfirmaTools('efirmaContainer', data.iframe_url || '');
                    console.log('[eFirma] EfirmaTools instanciado, llamando openWindow()');
                    efirmaTools.openWindow();
                } else {
                    console.log('[eFirma] Modo: canvas — warning:', data.warning || 'ninguno');
                    if (data.warning) {
                        $('#signCanvasWarning').text(data.warning).removeClass('d-none');
                        $('#signCanvasReady').hide();
                    }
                    $('#signCanvasSection').show();
                    if (modalFullyShown) { initSignaturePad(); } else { pendingCanvasInit = true; }
                }
            },
            error: function (xhr, status, error) {
                console.error('[eFirma] Error en la petición AJAX:', status, error);
                console.error('[eFirma] Respuesta del servidor:', xhr.status, xhr.responseText);
                $('#signLoading').hide();
                $('#signCanvasWarning')
                    .text('No se pudo conectar con eFirma. Se usará firma de canvas como respaldo.')
                    .removeClass('d-none');
                $('#signCanvasReady').hide();
                $('#signCanvasSection').show();
                if (modalFullyShown) { initSignaturePad(); } else { pendingCanvasInit = true; }
            }
        });
    });

    // Iguala los atributos de resolución del canvas a su tamaño CSS renderizado.
    // Solo se aplica si las dimensiones son > 0 (modal completamente visible).
    function syncCanvasSize() {
        var wrapper = document.querySelector('.sigWrapper');
        if (!wrapper) return;
        var canvas = wrapper.querySelector('canvas.pad');
        if (!canvas) return;
        var w = wrapper.clientWidth;
        var h = wrapper.clientHeight;
        if (w > 0 && h > 0) {
            canvas.width  = w;
            canvas.height = h;
        }
    }

    function initSignaturePad() {
        if (!signaturePad) {
            syncCanvasSize();
            signaturePad = $('#signaturePad').signaturePad({
                drawOnly: true,
                lineTop: 180
            });
        }
    }

    // Único punto de inicialización del canvas: cuando el modal terminó de animar
    // y los elementos tienen dimensiones CSS reales.
    $('#signModal').on('shown.bs.modal', function() {
        modalFullyShown = true;
        if (pendingCanvasInit || $('#signCanvasSection').is(':visible')) {
            pendingCanvasInit = false;
            initSignaturePad();
        }
    });

    // Validar firma antes de enviar el formulario de canvas
    $('#signForm').on('submit', function(e) {
        if (signaturePad) {
            var signatureData = signaturePad.getSignatureImage();
            if (!signatureData || signaturePad.validateForm() === false) {
                e.preventDefault();
                alert('Por favor, dibuje su firma antes de continuar.');
                return false;
            }
            $('#signatureOutput').val(signatureData);
        }
    });

    // -------------------------------------------------------------------------
    // Botón de recordatorio eFirma
    // -------------------------------------------------------------------------
    $('#reminderBtn').on('click', function () {
        var btn = $(this);
        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i>');
        $.ajax({
            url: '{{ route("backoffice.documents.efirma-reminder", $document->id) }}',
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            success: function (data) {
                alert(data.message || 'Recordatorio enviado.');
            },
            error: function (xhr) {
                var msg = xhr.responseJSON ? xhr.responseJSON.message : 'Error al enviar recordatorio.';
                alert(msg);
            },
            complete: function () {
                btn.prop('disabled', false).html('<i class="fas fa-bell"></i>');
            }
        });
    });

});
</script>
