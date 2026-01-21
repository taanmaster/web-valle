<?php

namespace App\Http\Controllers;

use App\Models\BackofficeDependency;
use App\Models\BackofficeDocument;
use App\Models\BackofficeDocumentVersion;
use App\Models\BackofficeDocumentValidation;
use App\Models\User;
use App\Services\BackofficeVersionService;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Storage;
use Session;
use Auth;
use PDF;

class BackofficeDocumentController extends Controller
{
    protected $versionService;

    public function __construct(BackofficeVersionService $versionService)
    {
        $this->versionService = $versionService;
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

        // Si ya tiene 3 validaciones, cambiar status a validado
        if ($document->validations_count >= 3) {
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
     * Firmar el oficio (solo si tiene 3 validaciones).
     */
    public function sign(Request $request, $id)
    {
        $document = BackofficeDocument::findOrFail($id);

        // Verificar que tenga 3 validaciones
        if (!$document->canBeSigned()) {
            Session::flash('error', 'Este documento requiere 3 validaciones antes de poder ser firmado.');
            return redirect()->back();
        }

        $this->validate($request, [
            'signature' => 'required|string', // Base64 de la firma
            'stamp' => 'nullable|file|mimes:png,jpg,jpeg|max:2048',
        ], [
            'signature.required' => 'La firma es obligatoria.',
        ]);

        // Procesar firma (base64 a archivo y subir a S3)
        $signatureData = $request->signature;
        $signatureData = str_replace('data:image/png;base64,', '', $signatureData);
        $signatureData = str_replace(' ', '+', $signatureData);
        $signatureImage = base64_decode($signatureData);

        $signatureFilename = 'signature_' . $document->id . '_' . time() . '.png';
        $signaturePath = 'backoffice/signatures/' . $signatureFilename;

        Storage::disk('s3')->put($signaturePath, $signatureImage);
        $signatureS3Url = Storage::disk('s3')->url($signaturePath);

        // Procesar sello si se proporcionó
        $stampFilename = null;
        $stampS3Url = null;
        if ($request->hasFile('stamp')) {
            $stamp = $request->file('stamp');
            $stampFilename = 'stamp_' . $document->id . '_' . time() . '.' . $stamp->getClientOriginalExtension();
            $stampPath = 'backoffice/stamps/' . $stampFilename;

            Storage::disk('s3')->put($stampPath, file_get_contents($stamp));
            $stampS3Url = Storage::disk('s3')->url($stampPath);
        }

        // Actualizar documento
        $document->update([
            'signature_filename' => $signatureFilename,
            'signature_s3_url' => $signatureS3Url,
            'stamp_filename' => $stampFilename,
            'stamp_s3_url' => $stampS3Url,
            'status' => 'firmado',
        ]);

        // Crear versión
        $this->versionService->createSnapshot(
            $document,
            BackofficeDocumentVersion::ACTIVITY_SIGNED,
            'Documento firmado por ' . Auth::user()->name,
            'status'
        );

        Session::flash('success', 'Oficio firmado exitosamente.');

        return redirect()->route('backoffice.documents.show', $id);
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
