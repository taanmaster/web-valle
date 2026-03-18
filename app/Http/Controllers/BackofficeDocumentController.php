<?php

namespace App\Http\Controllers;

use App\Models\BackofficeDependency;
use App\Models\BackofficeDocument;
use App\Models\BackofficeDocumentVersion;
use App\Models\BackofficeDocumentValidation;
use App\Models\EfirmaLog;
use App\Models\User;
use App\Services\BackofficeVersionService;
use App\Services\EfirmaService;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Storage;
use Session;
use Auth;
use PDF;

class BackofficeDocumentController extends Controller
{
    protected $versionService;
    protected $efirmaService;

    public function __construct(BackofficeVersionService $versionService, EfirmaService $efirmaService)
    {
        $this->versionService = $versionService;
        $this->efirmaService  = $efirmaService;
    }

    /**
     * Display a listing of the resource (Mis Oficios).
     */
    public function index()
    {
        $query = BackofficeDocument::with(['dependency', 'user', 'assignedUser'])
            ->where('user_id', Auth::id());

        // Filtros
        if (request('search')) {
            $search = request('search');
            $query->where(function ($q) use ($search) {
                $q->where('folio', 'LIKE', "%{$search}%")
                  ->orWhere('subject', 'LIKE', "%{$search}%")
                  ->orWhere('requester', 'LIKE', "%{$search}%");
            });
        }

        if (request('priority')) {
            $query->where('priority', request('priority'));
        }

        if (request('type')) {
            $query->where('type', request('type'));
        }

        if (request('status')) {
            $query->where('status', request('status'));
        }

        $documents = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('backoffice.documents.index', compact('documents'));
    }

    /**
     * Display notifications (Oficios donde el usuario es colaborador asignado).
     */
    public function notifications()
    {
        $query = BackofficeDocument::with(['dependency', 'user', 'assignedUser'])
            ->where('assigned_to', Auth::id());

        // Filtros
        if (request('search')) {
            $search = request('search');
            $query->where(function ($q) use ($search) {
                $q->where('folio', 'LIKE', "%{$search}%")
                  ->orWhere('subject', 'LIKE', "%{$search}%");
            });
        }

        if (request('priority')) {
            $query->where('priority', request('priority'));
        }

        if (request('type')) {
            $query->where('type', request('type'));
        }

        $documents = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('backoffice.documents.notifications', compact('documents'));
    }

    /**
     * Display received documents (Oficios enviados al usuario como destinatario).
     */
    public function received()
    {
        $query = BackofficeDocument::with(['dependency', 'user', 'sentToUser'])
            ->where('sent_to_user_id', Auth::id())
            ->where('status', 'firmado')
            ->whereNotNull('sent_at');

        // Filtros
        if (request('search')) {
            $search = request('search');
            $query->where(function ($q) use ($search) {
                $q->where('folio', 'LIKE', "%{$search}%")
                  ->orWhere('subject', 'LIKE', "%{$search}%");
            });
        }

        if (request('priority')) {
            $query->where('priority', request('priority'));
        }

        if (request('type')) {
            $query->where('type', request('type'));
        }

        $documents = $query->orderBy('sent_at', 'desc')->paginate(20);

        return view('backoffice.documents.received', compact('documents'));
    }

    /**
     * Display repository (Vista webmaster - todos los oficios).
     */
    public function repository()
    {
        $query = BackofficeDocument::with(['dependency', 'user']);

        // Filtros
        if (request('search')) {
            $search = request('search');
            $query->where(function ($q) use ($search) {
                $q->where('folio', 'LIKE', "%{$search}%")
                  ->orWhere('subject', 'LIKE', "%{$search}%")
                  ->orWhere('requester', 'LIKE', "%{$search}%");
            });
        }

        if (request('type')) {
            $query->where('type', request('type'));
        }

        $documents = $query->orderBy('created_at', 'desc')->paginate(30);

        return view('backoffice.documents.repository', compact('documents'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        
        // Verificar que el usuario tenga una dependencia asignada
        if (!$user->backoffice_dependency_id) {
            Session::flash('error', 'No tienes una dependencia asignada. Contacta al administrador para que te asigne a una dependencia antes de crear oficios.');
            return redirect()->route('backoffice.documents.index');
        }

        // Obtener la dependencia del usuario para mostrar el solicitante automático
        $userDependency = $user->backofficeDependency;
        
        // Obtener todas las dependencias para el select de destino
        $dependencies = BackofficeDependency::orderBy('name')->get();

        return view('backoffice.documents.create', compact('dependencies', 'userDependency'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        
        // Verificar que el usuario tenga una dependencia asignada
        if (!$user->backoffice_dependency_id) {
            Session::flash('error', 'No tienes una dependencia asignada. Contacta al administrador.');
            return redirect()->route('backoffice.documents.index');
        }

        $this->validate($request, [
            'dependency_id' => 'required|exists:backoffice_dependencies,id',
            'subject' => 'required|string|max:255',
            'body' => 'required|string',
            'priority' => 'required|in:urgente,alta,baja',
            'type' => 'required|in:solicitud,respuesta',
        ], [
            'dependency_id.required' => 'Debe seleccionar una dependencia destino.',
            'subject.required' => 'El asunto es obligatorio.',
            'body.required' => 'El cuerpo del oficio es obligatorio.',
        ]);

        // Obtener la dependencia destino para el remitente
        $destinationDependency = BackofficeDependency::findOrFail($request->dependency_id);
        
        // Obtener la dependencia del usuario para el solicitante (snapshot del nombre del director)
        $userDependency = $user->backofficeDependency;

        // Generar folio único
        $folio = BackofficeDocument::generateFolio($request->dependency_id);

        // Crear el documento
        $document = BackofficeDocument::create([
            'folio' => $folio,
            'dependency_id' => $request->dependency_id,
            'user_id' => Auth::id(),
            'issue_date' => Carbon::today(),
            'subject' => $request->subject,
            'sender' => $destinationDependency->responsible_name,
            'body' => $request->body,
            'requester' => $userDependency->responsible_name, // Snapshot del director de la dependencia del creador
            'priority' => $request->priority,
            'type' => $request->type,
            'status' => 'borrador',
        ]);

        // Crear primera versión
        $this->versionService->createSnapshot(
            $document,
            BackofficeDocumentVersion::ACTIVITY_CREATED,
            'Oficio creado por ' . Auth::user()->name
        );

        Session::flash('success', 'Oficio creado exitosamente con folio: ' . $folio);

        return redirect()->route('backoffice.documents.show', $document->id);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $document = BackofficeDocument::with([
            'dependency',
            'user',
            'assignedUser',
            'validations.validator',
            'versions.modifiedByUser'
        ])->findOrFail($id);

        // Verificar si el usuario actual es el colaborador asignado y es primera lectura
        $showConfirmModal = false;
        if ($document->assigned_to == Auth::id() && $document->isFirstRead()) {
            $showConfirmModal = true;
        }

        // Obtener usuarios de la misma dependencia del creador del documento
        // Solo se puede enviar a revisión a compañeros de la misma dependencia
        $availableUsers = User::permission('admin_access')
            ->where('id', '!=', Auth::id())
            ->where('backoffice_dependency_id', $document->user->backoffice_dependency_id)
            ->orderBy('name')
            ->get();

        return view('backoffice.documents.show', compact('document', 'showConfirmModal', 'availableUsers'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $document = BackofficeDocument::findOrFail($id);
        $user = Auth::user();
        
        // Solo el creador puede editar y solo si está en borrador
        if ($document->user_id != Auth::id() || $document->status != 'borrador') {
            Session::flash('error', 'No tienes permiso para editar este oficio.');
            return redirect()->route('backoffice.documents.show', $id);
        }

        // Obtener la dependencia del usuario para mostrar el solicitante
        $userDependency = $user->backofficeDependency;
        $dependencies = BackofficeDependency::orderBy('name')->get();

        return view('backoffice.documents.edit', compact('document', 'dependencies', 'userDependency'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $document = BackofficeDocument::findOrFail($id);

        // Solo el creador puede editar y solo si está en borrador
        if ($document->user_id != Auth::id() || $document->status != 'borrador') {
            Session::flash('error', 'No tienes permiso para editar este oficio.');
            return redirect()->route('backoffice.documents.show', $id);
        }

        $this->validate($request, [
            'dependency_id' => 'required|exists:backoffice_dependencies,id',
            'subject' => 'required|string|max:255',
            'body' => 'required|string',
            'priority' => 'required|in:urgente,alta,baja',
            'type' => 'required|in:solicitud,respuesta',
        ]);

        // Obtener la dependencia destino para el remitente
        $destinationDependency = BackofficeDependency::findOrFail($request->dependency_id);

        // Determinar qué campos cambiaron
        $modifiedFields = [];
        if ($document->subject != $request->subject) $modifiedFields[] = 'subject';
        if ($document->body != $request->body) $modifiedFields[] = 'body';
        if ($document->priority != $request->priority) $modifiedFields[] = 'priority';
        if ($document->type != $request->type) $modifiedFields[] = 'type';
        if ($document->dependency_id != $request->dependency_id) $modifiedFields[] = 'dependency_id';

        $document->update([
            'dependency_id' => $request->dependency_id,
            'subject' => $request->subject,
            'sender' => $destinationDependency->responsible_name,
            'body' => $request->body,
            'priority' => $request->priority,
            'type' => $request->type,
        ]);

        // Crear versión de edición
        $this->versionService->createSnapshot(
            $document,
            BackofficeDocumentVersion::ACTIVITY_EDITED,
            'Oficio editado por ' . Auth::user()->name . '. Campos modificados: ' . implode(', ', $modifiedFields),
            implode(', ', $modifiedFields)
        );

        Session::flash('success', 'Oficio actualizado exitosamente.');

        return redirect()->route('backoffice.documents.show', $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $document = BackofficeDocument::findOrFail($id);

        // Solo webmaster/all pueden eliminar
        if (!Auth::user()->hasAnyRole(['webmaster', 'all'])) {
            Session::flash('error', 'No tienes permiso para eliminar este oficio.');
            return redirect()->back();
        }

        $document->delete();

        Session::flash('success', 'Oficio eliminado exitosamente.');

        return redirect()->route('backoffice.documents.repository');
    }

    /**
     * Enviar oficio para revisión (abre modal en frontend, este método procesa).
     */
    public function sendForReview(Request $request, $id)
    {
        $document = BackofficeDocument::findOrFail($id);

        // Solo el creador puede enviar para revisión
        if ($document->user_id != Auth::id()) {
            Session::flash('error', 'No tienes permiso para enviar este oficio.');
            return redirect()->back();
        }

        $this->validate($request, [
            'assigned_to' => 'required|exists:users,id',
            'assignment_message' => 'nullable|string|max:1000',
        ], [
            'assigned_to.required' => 'Debe seleccionar un colaborador.',
        ]);

        $document->update([
            'assigned_to' => $request->assigned_to,
            'assignment_message' => $request->assignment_message,
            'status' => 'revision',
            'first_read_at' => null, // Reset para que el nuevo colaborador vea el modal
        ]);

        // Crear versión
        $assignedUser = User::find($request->assigned_to);
        $this->versionService->createSnapshot(
            $document,
            BackofficeDocumentVersion::ACTIVITY_SENT_REVIEW,
            'Oficio enviado para revisión a ' . $assignedUser->name . '. Mensaje: ' . ($request->assignment_message ?? 'Sin mensaje'),
            'assigned_to'
        );

        Session::flash('success', 'Oficio enviado para revisión exitosamente.');

        return redirect()->route('backoffice.documents.show', $id);
    }

    /**
     * Confirmar recibo y lectura del oficio.
     */
    public function confirmReceipt($id)
    {
        $document = BackofficeDocument::findOrFail($id);

        // Solo el colaborador asignado puede confirmar
        if ($document->assigned_to != Auth::id()) {
            Session::flash('error', 'No tienes permiso para confirmar este oficio.');
            return redirect()->back();
        }

        $document->update([
            'first_read_at' => Carbon::now(),
        ]);

        // Crear versión
        $this->versionService->createSnapshot(
            $document,
            BackofficeDocumentVersion::ACTIVITY_CONFIRMED_RECEIPT,
            'Recibo confirmado por ' . Auth::user()->name
        );

        Session::flash('success', 'Recibo confirmado exitosamente.');

        return redirect()->route('backoffice.documents.show', $id);
    }

    /**
     * Solicitar corrección del oficio.
     */
    public function requestCorrection(Request $request, $id)
    {
        $document = BackofficeDocument::findOrFail($id);

        // Solo el colaborador asignado puede solicitar corrección
        if ($document->assigned_to != Auth::id()) {
            Session::flash('error', 'No tienes permiso para solicitar corrección de este oficio.');
            return redirect()->back();
        }

        $this->validate($request, [
            'correction_message' => 'required|string|max:2000',
        ], [
            'correction_message.required' => 'Debe especificar las correcciones requeridas.',
        ]);

        // Volver el documento a borrador para que el creador pueda editar
        $document->update([
            'status' => 'borrador',
            'assigned_to' => null,
            'assignment_message' => null,
            'first_read_at' => null,
        ]);

        // Crear versión
        $this->versionService->createSnapshot(
            $document,
            BackofficeDocumentVersion::ACTIVITY_CORRECTION_REQUESTED,
            'Corrección solicitada por ' . Auth::user()->name . '. Detalles: ' . $request->correction_message,
            'status'
        );

        Session::flash('success', 'Solicitud de corrección enviada exitosamente.');

        return redirect()->route('backoffice.documents.notifications');
    }

    /**
     * Validar el oficio (requiere 3 validaciones de usuarios diferentes).
     */
    public function validateDocument(Request $request, $id)
    {
        $document = BackofficeDocument::findOrFail($id);

        // Verificar que el usuario no sea el creador del documento
        if ($document->user_id == Auth::id()) {
            Session::flash('error', 'No puedes validar tu propio oficio.');
            return redirect()->back();
        }

        // Verificar que el usuario no haya validado antes
        if ($document->hasBeenValidatedBy(Auth::id())) {
            Session::flash('error', 'Ya has validado este documento previamente.');
            return redirect()->back();
        }

        // Verificar que el documento esté en revisión
        if ($document->status != 'revision') {
            Session::flash('error', 'Este documento no está en proceso de revisión.');
            return redirect()->back();
        }

        $this->validate($request, [
            'next_assigned_to' => 'required|exists:users,id',
            'validation_message' => 'nullable|string|max:1000',
        ], [
            'next_assigned_to.required' => 'Debe seleccionar el siguiente colaborador.',
        ]);

        // Crear la validación
        BackofficeDocumentValidation::create([
            'document_id' => $document->id,
            'validator_id' => Auth::id(),
            'message' => $request->validation_message,
        ]);

        // Incrementar contador de validaciones
        $document->increment('validations_count');

        // Actualizar el documento para el siguiente revisor
        $document->update([
            'assigned_to' => $request->next_assigned_to,
            'assignment_message' => $request->validation_message,
            'first_read_at' => null,
        ]);

        // Si ya cumple el mínimo para firmar, cambiar status a validado
        if ($document->validations_count >= 2) {
            $document->update(['status' => 'validado']);
        }

        // Crear versión
        $nextUser = User::find($request->next_assigned_to);
        $this->versionService->createSnapshot(
            $document,
            BackofficeDocumentVersion::ACTIVITY_VALIDATED,
            'Validación #' . $document->validations_count . ' por ' . Auth::user()->name . '. Enviado a ' . $nextUser->name,
            'validations_count'
        );

        Session::flash('success', 'Oficio validado exitosamente. Validaciones: ' . $document->validations_count . '/3');

        return redirect()->route('backoffice.documents.notifications');
    }

    /**
     * Firmar el oficio con canvas (fallback cuando eFirma no está disponible).
     */
    public function sign(Request $request, $id)
    {
        $document = BackofficeDocument::findOrFail($id);

        if (!$document->canBeSigned()) {
            Session::flash('error', 'Este documento requiere al menos 2 validaciones antes de poder ser firmado.');
            return redirect()->back();
        }

        if ($document->assigned_to != Auth::id()) {
            Session::flash('error', 'Solo el colaborador asignado puede firmar este oficio.');
            return redirect()->back();
        }

        $this->validate($request, [
            'signature' => 'required|string',
            'stamp'     => 'nullable|file|mimes:png,jpg,jpeg|max:2048',
        ], [
            'signature.required' => 'La firma es obligatoria.',
        ]);

        // Procesar firma (base64 a archivo y subir a S3)
        $signatureData  = $request->signature;
        $signatureData  = str_replace('data:image/png;base64,', '', $signatureData);
        $signatureData  = str_replace(' ', '+', $signatureData);
        $signatureImage = base64_decode($signatureData);

        $signatureFilename = 'signature_' . $document->id . '_' . time() . '.png';
        $signaturePath     = 'backoffice/signatures/' . $signatureFilename;

        Storage::disk('s3')->put($signaturePath, $signatureImage);
        $signatureS3Url = Storage::disk('s3')->url($signaturePath);

        // Procesar sello si se proporcionó
        $stampFilename = null;
        $stampS3Url    = null;
        if ($request->hasFile('stamp')) {
            $stamp         = $request->file('stamp');
            $stampFilename = 'stamp_' . $document->id . '_' . time() . '.' . $stamp->getClientOriginalExtension();
            $stampPath     = 'backoffice/stamps/' . $stampFilename;

            Storage::disk('s3')->put($stampPath, file_get_contents($stamp));
            $stampS3Url = Storage::disk('s3')->url($stampPath);
        }

        $document->update([
            'signature_filename' => $signatureFilename,
            'signature_s3_url'   => $signatureS3Url,
            'stamp_filename'     => $stampFilename,
            'stamp_s3_url'       => $stampS3Url,
            'status'             => 'firmado',
        ]);

        $this->versionService->createSnapshot(
            $document,
            BackofficeDocumentVersion::ACTIVITY_SIGNED,
            'Documento firmado con canvas por ' . Auth::user()->name,
            'status'
        );

        Session::flash('success', 'Oficio firmado exitosamente.');

        return redirect()->route('backoffice.documents.show', $id);
    }

    /**
     * Iniciar proceso de firma electrónica con eFirma.
     * Intenta conectar a eFirma y crear el documento; si falla retorna modo canvas.
     * Retorna JSON: { mode: 'efirma'|'canvas', iframe_url?, warning? }
     */
    public function efirmaInitiate(Request $request, $id)
    {
        $document = BackofficeDocument::findOrFail($id);

        if (!$document->canBeSigned()) {
            return response()->json(['success' => false, 'message' => 'Este documento requiere al menos 2 validaciones.'], 422);
        }

        if ($document->assigned_to != Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Solo el colaborador asignado puede firmar.'], 403);
        }

        if ($document->status !== 'validado') {
            return response()->json(['success' => false, 'message' => 'El documento debe estar en estado validado para ser firmado.'], 422);
        }

        // Si ya se inició un proceso eFirma activo, devolver iframe_url existente
        if ($document->hasEfirmaDocument() && $document->efirma_iframe_url) {
            return response()->json([
                'success'    => true,
                'mode'       => 'efirma',
                'iframe_url' => $document->efirma_iframe_url,
            ]);
        }

        try {
            if (!$this->efirmaService->isAvailable()) {
                throw new \RuntimeException('El servicio de eFirma no está disponible en este momento.');
            }

            $iframeUrl = null;

            // Si ya existe efirma_document_id pero sin iframe_url, intentar recuperar sin crear uno nuevo
            if ($document->hasEfirmaDocument()) {
                $docResult    = $this->efirmaService->getDocument($document->efirma_document_id);
                $docUsers     = $docResult['data']['users'] ?? [];
                $currentEmail = Auth::user()->email;
                foreach ($docUsers as $docUser) {
                    if (strtolower($docUser['email'] ?? '') === strtolower($currentEmail)) {
                        $iframeUrl = $docUser['iframeurl'] ?? $docUser['iframe_url'] ?? null;
                        break;
                    }
                }
                if ($iframeUrl) {
                    $document->update(['efirma_iframe_url' => $iframeUrl]);
                    return response()->json(['success' => true, 'mode' => 'efirma', 'iframe_url' => $iframeUrl]);
                }
            }

            // Generar contenido PDF
            $document->load(['dependency', 'user', 'validations.validator']);
            $pdf        = PDF::loadView('backoffice.documents.pdf', compact('document'))
                ->setPaper('letter', 'portrait');
            $pdfContent = $pdf->output();

            // Detectar entorno local por configuración de Laravel (no depende de APP_URL)
            $isLocal = app()->environment('local');

            // Generar URLs de callback y retorno
            $callbackUrl = route('backoffice.efirma.callback', $document->id);
            $returnUrl   = route('backoffice.documents.show', $document->id);

            // Crear documento en eFirma
            $metadata = [
                'name'           => 'Oficio ' . $document->folio,
                'signature_type' => 2,
                'send_mails'     => false,
                'expiry_in'      => 30,
                'users'          => [
                    [
                        'email'             => Auth::user()->email,
                        'type'              => 'signer',
                        'ignore_invitation' => true,
                    ],
                ],
                'tags' => [$document->type, $document->priority],
            ];

            // Incluir URLs siempre en producción; omitir solo en local
            if (!$isLocal) {
                $metadata['callback_url'] = $callbackUrl;
                $metadata['return_url']   = $returnUrl;
            }

            $result   = $this->efirmaService->createDocument($pdfContent, $metadata);
            $efirmaId = $result['data']['id'] ?? null;

            // Fallback: si la API devuelve id vacío, buscar por nombre en get_all
            if (empty($efirmaId)) {
                // Loguear respuesta vacía para diagnóstico
                EfirmaLog::create([
                    'document_id' => $document->id,
                    'event'       => 'create_document_empty_id',
                    'payload'     => ['folio' => $document->folio, 'name' => $metadata['name'], 'metadata' => $metadata],
                    'response'    => $result['data'],
                    'http_status' => $result['http_status'],
                    'success'     => false,
                ]);

                \Log::warning('[eFirma] createDocument devolvió id vacío', [
                    'name'     => $metadata['name'],
                    'response' => $result,
                ]);

                $allResult  = $this->efirmaService->getDocumentAll();
                $targetName = $metadata['name'];
                foreach (($allResult['data'] ?? []) as $doc) {
                    if (($doc['name'] ?? '') === $targetName && !empty($doc['id'])) {
                        $efirmaId = $doc['id'];
                        break;
                    }
                }
            }

            if (empty($efirmaId)) {
                throw new \RuntimeException('eFirma no devolvió un ID de documento.');
            }

            // GET /api/document/get/:id para obtener el iframe_url del firmante
            $docResult    = $this->efirmaService->getDocument($efirmaId);
            $docUsers     = $docResult['data']['users'] ?? [];
            $currentEmail = Auth::user()->email;
            foreach ($docUsers as $docUser) {
                if (strtolower($docUser['email'] ?? '') === strtolower($currentEmail)) {
                    $iframeUrl = $docUser['iframeurl'] ?? $docUser['iframe_url'] ?? null;
                    break;
                }
            }

            $document->update([
                'efirma_document_id' => $efirmaId,
                'efirma_iframe_url'  => $iframeUrl,
                'efirma_status'      => 'created',
                'efirma_sent_at'     => Carbon::now(),
                'efirma_error'       => null,
            ]);

            EfirmaLog::create([
                'document_id' => $document->id,
                'event'       => 'create_document',
                'payload'     => ['folio' => $document->folio, 'name' => $metadata['name']],
                'response'    => $result['data'],
                'http_status' => $result['http_status'],
                'success'     => true,
            ]);

            $this->versionService->createSnapshot(
                $document,
                BackofficeDocumentVersion::ACTIVITY_EFIRMA_SUBMITTED,
                'Documento enviado a eFirma para firma electrónica por ' . Auth::user()->name,
                'efirma_status'
            );

            return response()->json([
                'success'    => true,
                'mode'       => 'efirma',
                'iframe_url' => $iframeUrl,
            ]);

        } catch (\Exception $e) {
            EfirmaLog::create([
                'document_id' => $document->id,
                'event'       => 'create_document_error',
                'payload'     => ['folio' => $document->folio],
                'response'    => ['error' => $e->getMessage()],
                'http_status' => null,
                'success'     => false,
            ]);

            $document->update(['efirma_error' => $e->getMessage()]);

            return response()->json([
                'success' => true,
                'mode'    => 'canvas',
                'warning' => 'eFirma no está disponible. Se usará la firma de canvas como respaldo.',
            ]);
        }
    }

    /**
     * Confirmar firma electrónica: obtiene firmas de eFirma y marca el documento como firmado.
     */
    public function efirmaConfirm(Request $request, $id)
    {
        $document = BackofficeDocument::findOrFail($id);

        if ($document->assigned_to != Auth::id()) {
            Session::flash('error', 'No autorizado.');
            return redirect()->back();
        }

        if (!$document->hasEfirmaDocument()) {
            Session::flash('error', 'No hay un proceso de firma eFirma activo para este documento.');
            return redirect()->back();
        }

        try {
            // 1. Verificar estado actual del documento en eFirma
            $docResult = $this->efirmaService->getDocument($document->efirma_document_id);
            $docData   = $docResult['data'] ?? [];

            if (empty($docData['fully_signed'])) {
                Session::flash('error', 'El documento todavía no ha sido firmado completamente en eFirma. Complete la firma antes de confirmar.');
                return redirect()->route('backoffice.documents.show', $id);
            }

            // 2. Obtener detalle de las firmas
            $sigResult  = $this->efirmaService->getSignatures($document->efirma_document_id);
            $signatures = $sigResult['data'] ?? [];

            // 3. Guardar firmas + URLs de archivos firmados
            $document->update([
                'efirma_signatures' => [
                    'signatures'    => $signatures,
                    'signed_file'   => $docData['signed_file']   ?? null,
                    'merged_file'   => $docData['merged_file']   ?? null,
                    'original_file' => $docData['original_file'] ?? null,
                ],
                'efirma_status' => 'signed_complete',
                'status'        => 'firmado',
            ]);

            EfirmaLog::create([
                'document_id' => $document->id,
                'event'       => 'confirm_signature',
                'payload'     => ['efirma_id' => $document->efirma_document_id],
                'response'    => $docData,
                'http_status' => $docResult['http_status'],
                'success'     => true,
            ]);

            $this->versionService->createSnapshot(
                $document,
                BackofficeDocumentVersion::ACTIVITY_EFIRMA_SIGNED,
                'Firma electrónica confirmada en eFirma por ' . Auth::user()->name,
                'status'
            );

            Session::flash('success', 'Oficio firmado electrónicamente con eFirma exitosamente.');

        } catch (\Exception $e) {
            EfirmaLog::create([
                'document_id' => $document->id,
                'event'       => 'confirm_signature_error',
                'payload'     => ['efirma_id' => $document->efirma_document_id],
                'response'    => ['error' => $e->getMessage()],
                'http_status' => null,
                'success'     => false,
            ]);

            Session::flash('error', 'Error al confirmar la firma en eFirma: ' . $e->getMessage());
        }

        return redirect()->route('backoffice.documents.show', $id);
    }

    /**
     * Webhook: eFirma notifica automáticamente cuando ocurre un evento en el documento.
     * POST /efirma/callback/{id}  (ruta pública, sin auth)
     */
    public function efirmaCallback(Request $request, $id)
    {
        $document = BackofficeDocument::find($id);

        if (!$document) {
            return response()->json(['status' => 'not_found'], 404);
        }

        $payload     = $request->all();
        $event       = $payload['event']       ?? '';
        $fullySigned = !empty($payload['fully_signed']);

        EfirmaLog::create([
            'document_id' => $document->id,
            'event'       => 'callback_' . $event,
            'payload'     => $payload,
            'response'    => [],
            'http_status' => 200,
            'success'     => true,
        ]);

        if ($event === 'sign' && $fullySigned && $document->efirma_document_id) {
            try {
                $docResult  = $this->efirmaService->getDocument($document->efirma_document_id);
                $docData    = $docResult['data'] ?? [];
                $sigResult  = $this->efirmaService->getSignatures($document->efirma_document_id);
                $signatures = $sigResult['data'] ?? [];

                $document->update([
                    'efirma_signatures' => [
                        'signatures'    => $signatures,
                        'signed_file'   => $docData['signed_file']   ?? $payload['signed_file']   ?? null,
                        'merged_file'   => $docData['merged_file']   ?? $payload['merged_file']   ?? null,
                        'original_file' => $docData['original_file'] ?? $payload['original_file'] ?? null,
                    ],
                    'efirma_status' => 'signed_complete',
                    'status'        => 'firmado',
                ]);
            } catch (\Exception $e) {
                EfirmaLog::create([
                    'document_id' => $document->id,
                    'event'       => 'callback_sign_error',
                    'payload'     => $payload,
                    'response'    => ['error' => $e->getMessage()],
                    'http_status' => null,
                    'success'     => false,
                ]);
            }
        }

        return response()->json(['status' => 'ok']);
    }

    /**
     * Enviar recordatorio de firma a los firmantes en eFirma.
     * Retorna JSON para consumo AJAX.
     */
    public function efirmaReminder(Request $request, $id)
    {
        $document = BackofficeDocument::findOrFail($id);

        if ($document->assigned_to != Auth::id() && !Auth::user()->hasAnyRole(['webmaster', 'all'])) {
            return response()->json(['success' => false, 'message' => 'No autorizado.'], 403);
        }

        if (!$document->hasEfirmaDocument()) {
            return response()->json(['success' => false, 'message' => 'No hay un proceso de firma eFirma activo.'], 422);
        }

        try {
            $result = $this->efirmaService->sendReminder($document->efirma_document_id);

            EfirmaLog::create([
                'document_id' => $document->id,
                'event'       => 'send_reminder',
                'payload'     => ['efirma_id' => $document->efirma_document_id],
                'response'    => $result['data'] ?? [],
                'http_status' => $result['http_status'],
                'success'     => true,
            ]);

            return response()->json(['success' => true, 'message' => 'Recordatorio enviado exitosamente.']);

        } catch (\Exception $e) {
            EfirmaLog::create([
                'document_id' => $document->id,
                'event'       => 'send_reminder_error',
                'payload'     => ['efirma_id' => $document->efirma_document_id],
                'response'    => ['error' => $e->getMessage()],
                'http_status' => null,
                'success'     => false,
            ]);

            return response()->json(['success' => false, 'message' => 'Error al enviar recordatorio: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Buscar usuarios para Select2 AJAX.
     * Filtra por usuarios de la misma dependencia del usuario autenticado.
     */
    public function searchUsers(Request $request)
    {
        $search = $request->get('q', '');
        $currentUser = Auth::user();

        $users = User::permission('admin_access')
            ->where('id', '!=', Auth::id())
            ->where('backoffice_dependency_id', $currentUser->backoffice_dependency_id)
            ->where(function ($query) use ($search) {
                $query->where('name', 'LIKE', "%{$search}%")
                      ->orWhere('email', 'LIKE', "%{$search}%");
            })
            ->limit(20)
            ->get(['id', 'name', 'email']);

        $results = $users->map(function ($user) {
            return [
                'id' => $user->id,
                'text' => $user->name . ' (' . $user->email . ')',
            ];
        });

        return response()->json(['results' => $results]);
    }

    /**
     * Buscar usuarios de una dependencia específica (para enviar a destinatario).
     */
    public function searchDependencyUsers(Request $request)
    {
        $search = $request->input('q', '');
        $dependencyId = $request->input('dependency_id');

        if (!$dependencyId) {
            return response()->json(['results' => []]);
        }

        $users = User::whereNotNull('backoffice_dependency_id')
            ->where('backoffice_dependency_id', $dependencyId)
            ->where(function ($query) use ($search) {
                $query->where('name', 'LIKE', "%{$search}%")
                      ->orWhere('email', 'LIKE', "%{$search}%");
            })
            ->limit(20)
            ->get(['id', 'name', 'email']);

        $results = $users->map(function ($user) {
            return [
                'id' => $user->id,
                'text' => $user->name . ' (' . $user->email . ')',
            ];
        });

        return response()->json(['results' => $results]);
    }

    /**
     * Enviar oficio firmado a un destinatario de la dependencia destino.
     */
    public function sendToRecipient(Request $request, $id)
    {
        $document = BackofficeDocument::findOrFail($id);

        // Verificar que el documento esté firmado
        if ($document->status != 'firmado') {
            Session::flash('error', 'Solo se pueden enviar oficios firmados.');
            return redirect()->back();
        }

        // Verificar que no haya sido enviado ya
        if ($document->sent_to_user_id) {
            Session::flash('error', 'Este oficio ya fue enviado a un destinatario.');
            return redirect()->back();
        }

        $this->validate($request, [
            'sent_to_user_id' => 'required|exists:users,id',
            'sent_message' => 'nullable|string|max:500',
        ]);

        // Verificar que el usuario pertenezca a la dependencia destino
        $recipientUser = User::findOrFail($request->sent_to_user_id);
        if ($recipientUser->backoffice_dependency_id != $document->dependency_id) {
            Session::flash('error', 'El destinatario debe pertenecer a la dependencia destino del oficio.');
            return redirect()->back();
        }

        // Actualizar documento
        $document->update([
            'sent_to_user_id' => $request->sent_to_user_id,
            'sent_at' => Carbon::now(),
            'sent_message' => $request->sent_message,
        ]);

        // Registrar en historial de versiones
        $this->versionService->createSnapshot(
            $document,
            'enviado_destinatario',
            'Oficio enviado a ' . $recipientUser->name . ' de la dependencia destino'
        );

        Session::flash('success', 'Oficio enviado exitosamente a ' . $recipientUser->name);

        return redirect()->route('backoffice.documents.show', $document->id);
    }

    /**
     * Ver historial de versiones del documento.
     */
    public function versions($id)
    {
        $document = BackofficeDocument::with(['versions.modifiedByUser'])->findOrFail($id);
        $versions = $document->versions()->orderBy('created_at', 'desc')->paginate(20);

        return view('backoffice.document_versions.index', compact('document', 'versions'));
    }

    /**
     * Ver detalle de una versión específica.
     */
    public function versionShow($documentId, $versionId)
    {
        $document = BackofficeDocument::findOrFail($documentId);
        $version = BackofficeDocumentVersion::with('modifiedByUser')
            ->where('document_id', $documentId)
            ->findOrFail($versionId);

        $changes = $this->versionService->compareVersions($version);
        $snapshot = $this->versionService->getDocumentAtVersion($version);

        return view('backoffice.document_versions.show', compact('document', 'version', 'changes', 'snapshot'));
    }

    /**
     * Generar PDF del oficio firmado.
     */
    public function generatePdf($id)
    {
        $document = BackofficeDocument::with([
            'dependency',
            'user',
            'validations.validator'
        ])->findOrFail($id);

        // Solo se puede generar PDF de oficios firmados
        if ($document->status != 'firmado') {
            Session::flash('error', 'Solo se puede generar PDF de oficios firmados.');
            return redirect()->back();
        }

        $pdf = PDF::loadView('backoffice.documents.pdf', compact('document'))
            ->setPaper('letter', 'portrait');

        return $pdf->stream("Oficio_{$document->folio}.pdf");
    }
}
