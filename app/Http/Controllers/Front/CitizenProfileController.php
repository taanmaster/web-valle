<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Citizen;
use App\Models\UserInfo;
use App\Models\SareRequest;
use App\Models\SareRequestFile;
use App\Models\Summon;
use App\Models\IdentificationCertificate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CitizenProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:citizen']);
    }

    public function index()
    {
        return view('front.user_profiles.citizen.index');
    }

    public function edit()
    {
        $user = Auth::user();
        $citizen = $this->getOrCreateCitizenProfile($user);

        return view('front.user_profiles.citizen.edit', compact('citizen'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'phone' => 'nullable|string|max:15',
            'curp' => 'nullable|string|max:18',
            'current_password' => 'nullable|required_with:password',
            'password' => 'nullable|min:8|confirmed',
        ]);

        // Validar contraseña actual si se quiere cambiar
        if ($request->filled('password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'La contraseña actual no es correcta.']);
            }
        }

        // Actualizar usuario
        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        // Actualizar o crear perfil de ciudadano
        $citizen = $this->getOrCreateCitizenProfile($user);
        $citizen->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'curp' => $request->curp,
        ]);

        Session::flash('success', 'Tu perfil se actualizó correctamente.');

        return redirect()->route('citizen.profile.edit');
    }

    public function requests(Request $request)
    {
        // Cargar las solicitudes SARE del ciudadano autenticado
        $sareRequests = \App\Models\SareRequest::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Si es una petición AJAX, devolver solo los datos
        if ($request->ajax() || $request->get('ajax')) {
            return response()->json([
                'requests' => $sareRequests->map(function ($req) {
                    return [
                        'id' => $req->id,
                        'status_color' => $req->status_color,
                        'status_label' => $req->status_label,
                    ];
                })
            ]);
        }

        return view('front.user_profiles.citizen.requests', compact('sareRequests'));
    }

    public function urbanDevRequests(Request $request)
    {
        // Cargar las solicitudes de Desarrollo Urbano del ciudadano autenticado
        $urbanDevRequests = \App\Models\UrbanDevRequest::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Si es una petición AJAX, devolver solo los datos
        if ($request->ajax() || $request->get('ajax')) {
            return response()->json([
                'requests' => $urbanDevRequests->map(function ($req) {
                    return [
                        'id' => $req->id,
                        'status_color' => $req->status_color,
                        'status_label' => $req->status_label,
                    ];
                })
            ]);
        }

        return view('front.user_profiles.citizen.urban_dev_requests', compact('urbanDevRequests'));
    }

    public function settings()
    {
        $user = Auth::user();
        $userInfo = $this->getOrCreateUserInfo($user);

        return view('front.user_profiles.citizen.settings', compact('userInfo'));
    }

    public function updateNotifications(Request $request)
    {
        $user = Auth::user();
        $userInfo = $this->getOrCreateUserInfo($user);

        $userInfo->update([
            'mail_notifications' => $request->has('mail_notifications'),
            'sms_notifications' => $request->has('sms_notifications'),
            'push_notifications' => $request->has('push_notifications'),
        ]);

        Session::flash('success', 'Tus preferencias de notificaciones se actualizaron correctamente.');

        return redirect()->route('citizen.profile.settings');
    }

    /**
     * Obtener o crear perfil de ciudadano
     */
    private function getOrCreateCitizenProfile($user)
    {
        $citizen = Citizen::where('email', $user->email)->first();

        if (!$citizen) {
            $citizen = Citizen::create([
                'name' => $user->name,
                'first_name' => '', // Podrías separar el nombre si es necesario
                'last_name' => '',
                'email' => $user->email,
                'phone' => null,
                'curp' => null,
            ]);
        }

        return $citizen;
    }

    /**
     * Obtener o crear información adicional del usuario
     */
    private function getOrCreateUserInfo($user)
    {
        $userInfo = UserInfo::where('user_id', $user->id)->first();

        if (!$userInfo) {
            $citizen = $this->getOrCreateCitizenProfile($user);

            $userInfo = UserInfo::create([
                'user_id' => $user->id,
                'model_type' => 'App\Models\Citizen',
                'model_id' => $citizen->id,
                'mail_notifications' => true,
                'sms_notifications' => true,
                'push_notifications' => true,
            ]);
        }

        return $userInfo;
    }

    // =============== MÉTODOS SARE PARA CIUDADANOS ===============

    /**
     * Mostrar formulario para crear nueva solicitud SARE
     */
    public function createSareRequest()
    {
        return view('front.user_profiles.citizen.sare_create');
    }

    /**
     * Almacenar nueva solicitud SARE
     */
    public function storeSareRequest(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'request_num' => 'required|string|max:255',
            'request_date' => 'required|date',
            'catastral_num' => 'required|string|max:255',
            'request_type' => 'required|string|max:255',
            'rfc_name' => 'required|string|max:255',
            'rfc_num' => 'required|string|max:13',
            'property_owner' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'office_phone' => 'required|string|max:15',
            'mobile_phone' => 'required|string|max:15',
            'legal_representative_name' => 'required|string|max:255',
            'legal_representative_father_last_name' => 'required|string|max:255',
            'legal_representative_mother_last_name' => 'required|string|max:255',
            'legal_representative_office_phone' => 'required|string|max:15',
            'legal_representative_mobile_phone' => 'required|string|max:15',
            'legal_representative_personal_phone' => 'required|string|max:15',
            'legal_representative_email' => 'required|email|max:255',
            'legal_representative_ownership_document' => 'required|string|max:255',
            'establishment_legal_cause' => 'required|string|max:255',
            'establishment_good_faith_clause' => 'required|string|max:255',
            'establishment_address_street' => 'required|string|max:255',
            'establishment_address_number' => 'required|string|max:10',
            'establishment_address_neighborhood' => 'required|string|max:255',
            'establishment_address_municipality' => 'required|string|max:255',
            'establishment_address_state' => 'required|string|max:255',
            'establishment_address_postal_code' => 'required|string|max:5',
            'commercial_name' => 'required|string|max:255',
            'aprox_investment' => 'required|string|max:255',
            'jobs_to_generate' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            return back()->withErrors($validator)->withInput();
        }

        try {
            $sareRequest = SareRequest::create([
                'user_id' => Auth::id(),
                'status' => 'new',
                'request_type' => $request->request_type,
                'description' => $request->description,
                'request_num' => $request->request_num,
                'request_date' => $request->request_date,
                'catastral_num' => $request->catastral_num,
                'rfc_name' => $request->rfc_name,
                'rfc_num' => $request->rfc_num,
                'property_owner' => $request->property_owner,
                'office_phone' => $request->office_phone,
                'mobile_phone' => $request->mobile_phone,
                'email' => $request->email,
                'legal_representative_name' => $request->legal_representative_name,
                'legal_representative_father_last_name' => $request->legal_representative_father_last_name,
                'legal_representative_mother_last_name' => $request->legal_representative_mother_last_name,
                'legal_representative_office_phone' => $request->legal_representative_office_phone,
                'legal_representative_mobile_phone' => $request->legal_representative_mobile_phone,
                'legal_representative_personal_phone' => $request->legal_representative_personal_phone,
                'legal_representative_email' => $request->legal_representative_email,
                'legal_representative_ownership_document' => $request->legal_representative_ownership_document,
                'establishment_legal_cause' => $request->establishment_legal_cause,
                'establishment_legal_cause_addon' => $request->establishment_legal_cause_addon,
                'establishment_good_faith_clause' => $request->establishment_good_faith_clause,
                'establishment_address_street' => $request->establishment_address_street,
                'establishment_address_number' => $request->establishment_address_number,
                'establishment_address_neighborhood' => $request->establishment_address_neighborhood,
                'establishment_address_municipality' => $request->establishment_address_municipality,
                'establishment_address_state' => $request->establishment_address_state,
                'establishment_address_postal_code' => $request->establishment_address_postal_code,
                'establishment_use' => $request->establishment_use,
                'commercial_name' => $request->commercial_name,
                'aprox_investment' => $request->aprox_investment,
                'jobs_to_generate' => $request->jobs_to_generate,
                'operation_start_date' => $request->operation_start_date,
                'business_hours' => $request->business_hours,
                'is_location_in_operation' => $request->has('is_location_in_operation'),
                'zoning_front' => $request->zoning_front,
                'zoning_rear' => $request->zoning_rear,
                'zoning_left' => $request->zoning_left,
                'zoning_right' => $request->zoning_right,
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Solicitud SARE enviada correctamente.',
                    'redirect' => route('citizen.sare.show', $sareRequest)
                ]);
            }

            Session::flash('success', 'Tu solicitud SARE se ha enviado correctamente.');
            return redirect()->route('citizen.sare.show', $sareRequest);

        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al procesar la solicitud: ' . $e->getMessage()
                ], 500);
            }

            Session::flash('error', 'Error al procesar la solicitud. Por favor, inténtalo de nuevo.');
            return back()->withInput();
        }
    }

    /**
     * Mostrar detalles de una solicitud SARE
     */
    public function showSareRequest($id)
    {
        $sareRequest = SareRequest::findOrFail($id);

        // Verificar que la solicitud pertenece al usuario autenticado
        if ($sareRequest->user_id !== Auth::id()) {
            abort(403, 'No tienes acceso a esta solicitud.');
        }

        return view('front.user_profiles.citizen.sare_show', compact('sareRequest'));
    }

    /**
     * Mostrar formulario para editar solicitud SARE
     */
    public function editSareRequest($id)
    {
        $sareRequest = SareRequest::findOrFail($id);

        // Verificar que la solicitud pertenece al usuario autenticado
        if ($sareRequest->user_id !== Auth::id()) {
            abort(403, 'No tienes acceso a esta solicitud.');
        }

        return view('front.user_profiles.citizen.sare_edit', compact('sareRequest'));
    }

    /**
     * Actualizar solicitud SARE
     */
    public function updateSareRequest(Request $request, $id)
    {
        $sareRequest = SareRequest::findOrFail($id);

        // Verificar que la solicitud pertenece al usuario autenticado
        if ($sareRequest->user_id !== Auth::id()) {
            abort(403, 'No tienes acceso a esta solicitud.');
        }

        // Solo permitir edición si está en estado nuevo
        if ($sareRequest->status !== 'new') {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Solo puedes editar solicitudes en estado "Nuevo".'
                ], 403);
            }

            Session::flash('error', 'Solo puedes editar solicitudes en estado "Nuevo".');
            return redirect()->route('citizen.sare.show', $sareRequest);
        }

        $validator = Validator::make($request->all(), [
            'request_num' => 'required|string|max:255',
            'request_date' => 'required|date',
            'catastral_num' => 'required|string|max:255',
            'request_type' => 'required|string|max:255',
            'rfc_name' => 'required|string|max:255',
            'rfc_num' => 'required|string|max:13',
            'property_owner' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'office_phone' => 'required|string|max:15',
            'mobile_phone' => 'required|string|max:15',
            'legal_representative_name' => 'required|string|max:255',
            'legal_representative_father_last_name' => 'required|string|max:255',
            'legal_representative_mother_last_name' => 'required|string|max:255',
            'legal_representative_office_phone' => 'required|string|max:15',
            'legal_representative_mobile_phone' => 'required|string|max:15',
            'legal_representative_personal_phone' => 'required|string|max:15',
            'legal_representative_email' => 'required|email|max:255',
            'legal_representative_ownership_document' => 'required|string|max:255',
            'establishment_legal_cause' => 'required|string|max:255',
            'establishment_good_faith_clause' => 'required|string|max:255',
            'establishment_address_street' => 'required|string|max:255',
            'establishment_address_number' => 'required|string|max:10',
            'establishment_address_neighborhood' => 'required|string|max:255',
            'establishment_address_municipality' => 'required|string|max:255',
            'establishment_address_state' => 'required|string|max:255',
            'establishment_address_postal_code' => 'required|string|max:5',
            'commercial_name' => 'required|string|max:255',
            'aprox_investment' => 'required|string|max:255',
            'jobs_to_generate' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            return back()->withErrors($validator)->withInput();
        }

        try {
            $sareRequest->update([
                'request_type' => $request->request_type,
                'description' => $request->description,
                'request_num' => $request->request_num,
                'request_date' => $request->request_date,
                'catastral_num' => $request->catastral_num,
                'rfc_name' => $request->rfc_name,
                'rfc_num' => $request->rfc_num,
                'property_owner' => $request->property_owner,
                'office_phone' => $request->office_phone,
                'mobile_phone' => $request->mobile_phone,
                'email' => $request->email,
                'legal_representative_name' => $request->legal_representative_name,
                'legal_representative_father_last_name' => $request->legal_representative_father_last_name,
                'legal_representative_mother_last_name' => $request->legal_representative_mother_last_name,
                'legal_representative_office_phone' => $request->legal_representative_office_phone,
                'legal_representative_mobile_phone' => $request->legal_representative_mobile_phone,
                'legal_representative_personal_phone' => $request->legal_representative_personal_phone,
                'legal_representative_email' => $request->legal_representative_email,
                'legal_representative_ownership_document' => $request->legal_representative_ownership_document,
                'establishment_legal_cause' => $request->establishment_legal_cause,
                'establishment_legal_cause_addon' => $request->establishment_legal_cause_addon,
                'establishment_good_faith_clause' => $request->establishment_good_faith_clause,
                'establishment_address_street' => $request->establishment_address_street,
                'establishment_address_number' => $request->establishment_address_number,
                'establishment_address_neighborhood' => $request->establishment_address_neighborhood,
                'establishment_address_municipality' => $request->establishment_address_municipality,
                'establishment_address_state' => $request->establishment_address_state,
                'establishment_address_postal_code' => $request->establishment_address_postal_code,
                'establishment_use' => $request->establishment_use,
                'commercial_name' => $request->commercial_name,
                'aprox_investment' => $request->aprox_investment,
                'jobs_to_generate' => $request->jobs_to_generate,
                'operation_start_date' => $request->operation_start_date,
                'business_hours' => $request->business_hours,
                'is_location_in_operation' => $request->has('is_location_in_operation'),
                'zoning_front' => $request->zoning_front,
                'zoning_rear' => $request->zoning_rear,
                'zoning_left' => $request->zoning_left,
                'zoning_right' => $request->zoning_right,
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Solicitud SARE actualizada correctamente.',
                    'redirect' => route('citizen.sare.show', $sareRequest)
                ]);
            }

            Session::flash('success', 'Tu solicitud SARE se ha actualizado correctamente.');
            return redirect()->route('citizen.sare.show', $sareRequest);

        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al actualizar la solicitud: ' . $e->getMessage()
                ], 500);
            }

            Session::flash('error', 'Error al actualizar la solicitud. Por favor, inténtalo de nuevo.');
            return back()->withInput();
        }
    }

    /**
     * Eliminar solicitud SARE
     */
    public function destroySareRequest(Request $request, $id)
    {
        $sareRequest = SareRequest::findOrFail($id);

        // Verificar que la solicitud pertenece al usuario autenticado
        if ($sareRequest->user_id !== Auth::id()) {
            abort(403, 'No tienes acceso a esta solicitud.');
        }

        // Solo permitir eliminación si está pendiente
        if ($sareRequest->status !== 'pendiente') {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Solo puedes eliminar solicitudes pendientes.'
                ], 403);
            }

            Session::flash('error', 'Solo puedes eliminar solicitudes pendientes.');
            return redirect()->route('citizen.profile.requests');
        }

        try {
            // Eliminar archivos asociados de S3
            foreach ($sareRequest->files as $file) {
                $filepath = 'sare/' . $file->filename;
                Storage::disk('s3')->delete($filepath);
                $file->delete();
            }

            // Eliminar la solicitud
            $sareRequest->delete();

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Solicitud eliminada correctamente.',
                    'redirect' => route('citizen.profile.requests')
                ]);
            }

            Session::flash('success', 'Tu solicitud SARE se ha eliminado correctamente.');
            return redirect()->route('citizen.profile.requests');

        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al eliminar la solicitud: ' . $e->getMessage()
                ], 500);
            }

            Session::flash('error', 'Error al eliminar la solicitud. Por favor, inténtalo de nuevo.');
            return back();
        }
    }

    // =============== MÉTODOS DESARROLLO URBANO PARA CIUDADANOS ===============

    /**
     * Mostrar formulario para crear nueva solicitud de Desarrollo Urbano
     */
    public function createUrbanDevRequest()
    {
        return view('front.user_profiles.citizen.urban_dev_create');
    }

    /**
     * Almacenar nueva solicitud de Desarrollo Urbano
     */
    public function storeUrbanDevRequest(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'request_type' => 'required|string|in:uso-de-suelo,constancia-de-factibilidad,permiso-de-anuncios,certificacion-numero-oficial,permiso-de-division,uso-de-via-publica,licencia-de-construccion,permiso-construccion-panteones',
            'description' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }
            return back()->withErrors($validator)->withInput();
        }

        try {
            $urbanDevRequest = \App\Models\UrbanDevRequest::create([
                'user_id' => Auth::id(),
                'request_type' => $request->request_type,
                'description' => $request->description,
                'status' => 'new'
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Solicitud de Desarrollo Urbano creada exitosamente.',
                    'redirect' => route('citizen.urban_dev.show', $urbanDevRequest)
                ]);
            }

            Session::flash('success', 'Tu solicitud de Desarrollo Urbano se ha creado correctamente.');
            return redirect()->route('citizen.urban_dev.show', $urbanDevRequest);

        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al procesar la solicitud. Por favor, inténtalo de nuevo.'
                ], 500);
            }

            Session::flash('error', 'Error al procesar la solicitud. Por favor, inténtalo de nuevo.');
            return back()->withInput();
        }
    }

    /**
     * Mostrar detalles de una solicitud de Desarrollo Urbano
     */
    public function showUrbanDevRequest($id)
    {
        $urbanDevRequest = \App\Models\UrbanDevRequest::with('files')->findOrFail($id);

        // Verificar que la solicitud pertenece al usuario autenticado
        if ($urbanDevRequest->user_id !== Auth::id()) {
            abort(403, 'No tienes acceso a esta solicitud.');
        }

        return view('front.user_profiles.citizen.urban_dev_show', compact('urbanDevRequest'));
    }

    /**
     * Mostrar formulario para editar solicitud de Desarrollo Urbano
     */
    public function editUrbanDevRequest($id)
    {
        $urbanDevRequest = \App\Models\UrbanDevRequest::findOrFail($id);

        // Verificar que la solicitud pertenece al usuario autenticado
        if ($urbanDevRequest->user_id !== Auth::id()) {
            abort(403, 'No tienes acceso a esta solicitud.');
        }

        // Solo permitir edición si está en estado nuevo
        if ($urbanDevRequest->status !== 'new') {
            Session::flash('error', 'Solo puedes editar solicitudes en estado "Nuevo".');
            return redirect()->route('citizen.urban_dev.show', $urbanDevRequest);
        }

        return view('front.user_profiles.citizen.urban_dev_edit', compact('urbanDevRequest'));
    }

    /**
     * Actualizar solicitud de Desarrollo Urbano
     */
    public function updateUrbanDevRequest(Request $request, $id)
    {
        $urbanDevRequest = \App\Models\UrbanDevRequest::findOrFail($id);

        // Verificar que la solicitud pertenece al usuario autenticado
        if ($urbanDevRequest->user_id !== Auth::id()) {
            abort(403, 'No tienes acceso a esta solicitud.');
        }

        // Solo permitir edición si está en estado nuevo
        if ($urbanDevRequest->status !== 'new') {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Solo puedes editar solicitudes en estado "Nuevo".'
                ], 403);
            }

            Session::flash('error', 'Solo puedes editar solicitudes en estado "Nuevo".');
            return redirect()->route('citizen.urban_dev.show', $urbanDevRequest);
        }

        $validator = Validator::make($request->all(), [
            'request_type' => 'required|string|in:uso-de-suelo,constancia-de-factibilidad,permiso-de-anuncios,certificacion-numero-oficial,permiso-de-division,uso-de-via-publica,licencia-de-construccion,permiso-construccion-panteones',
            'description' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }
            return back()->withErrors($validator)->withInput();
        }

        try {
            $urbanDevRequest->update([
                'request_type' => $request->request_type,
                'description' => $request->description
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Solicitud actualizada exitosamente.'
                ]);
            }

            Session::flash('success', 'Tu solicitud se actualizó correctamente.');
            return redirect()->route('citizen.urban_dev.show', $urbanDevRequest);

        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al actualizar la solicitud.'
                ], 500);
            }

            Session::flash('error', 'Error al actualizar la solicitud. Por favor, inténtalo de nuevo.');
            return back()->withInput();
        }
    }

    /**
     * Eliminar solicitud de Desarrollo Urbano
     */
    public function destroyUrbanDevRequest(Request $request, $id)
    {
        $urbanDevRequest = \App\Models\UrbanDevRequest::findOrFail($id);

        // Verificar que la solicitud pertenece al usuario autenticado
        if ($urbanDevRequest->user_id !== Auth::id()) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No tienes acceso a esta solicitud.'
                ], 403);
            }
            abort(403, 'No tienes acceso a esta solicitud.');
        }

        // Solo permitir eliminación si está en estado nuevo
        if ($urbanDevRequest->status !== 'new') {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Solo puedes eliminar solicitudes en estado "Nuevo".'
                ], 403);
            }

            Session::flash('error', 'Solo puedes eliminar solicitudes en estado "Nuevo".');
            return redirect()->route('citizen.profile.urban_dev_requests');
        }

        try {
            // Eliminar archivos asociados de S3
            foreach ($urbanDevRequest->files as $file) {
                $filepath = 'desarrollo_urbano/' . $file->filename;
                Storage::disk('s3')->delete($filepath);
                $file->delete();
            }

            $urbanDevRequest->delete();

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Solicitud eliminada exitosamente.'
                ]);
            }

            Session::flash('success', 'Tu solicitud se eliminó correctamente.');
            return redirect()->route('citizen.profile.urban_dev_requests');

        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al eliminar la solicitud.'
                ], 500);
            }

            Session::flash('error', 'Error al eliminar la solicitud. Por favor, inténtalo de nuevo.');
            return back();
        }
    }

    /**
     * Upload files via dropzone for Urban Dev requests
     */
    public function uploadUrbanDevFile(Request $request)
    {
        try {
            $request->validate([
                'file' => 'required|file|max:10240|mimes:pdf,doc,docx,jpg,jpeg,png',
                'urban_dev_request_id' => 'required|exists:urban_dev_requests,id',
                'document_type' => 'required|string|max:255'
            ]);

            $urbanDevRequest = \App\Models\UrbanDevRequest::findOrFail($request->urban_dev_request_id);

            // Verificar que la solicitud pertenece al usuario autenticado
            if ($urbanDevRequest->user_id !== Auth::id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No tienes acceso a esta solicitud.'
                ], 403);
            }

            // Obtener el nombre del documento y slug correcto
            $documentInfo = $this->getDocumentInfoFromSlug($request->document_type);

            $file = $request->file('file');
            $originalName = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $fileName = 'desarrollo_urbano_' . time() . '_' . Str::random(10) . '.' . $extension;

            // Guardar archivo en S3
            $filepath = 'desarrollo_urbano/' . $fileName;
            Storage::disk('s3')->put($filepath, file_get_contents($file));
            $s3Url = Storage::disk('s3')->url($filepath);

            // Crear registro en base de datos
            $urbanDevFile = \App\Models\UrbanDevRequestFile::create([
                'user_id' => Auth::id(),
                'urban_dev_request_id' => $urbanDevRequest->id,
                'name' => $documentInfo['name'],
                'slug' => $documentInfo['slug'],
                'filename' => $fileName,
                'file_extension' => $extension,
                'filesize' => $file->getSize(),
                's3_asset_url' => $s3Url
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Archivo subido exitosamente.',
                'file' => [
                    'id' => $urbanDevFile->id,
                    'name' => $urbanDevFile->name,
                    'slug' => $urbanDevFile->slug,
                    'filename' => $urbanDevFile->filename,
                    'size' => $file->getSize(),
                    'url' => $s3Url,
                    'created_at' => $urbanDevFile->created_at->toISOString() // Agregar created_at para evitar Invalid Date
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al subir el archivo: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener información del documento basado en el slug recibido
     */
    private function getDocumentInfoFromSlug($receivedSlug)
    {
        // Mapeo completo de slugs a nombres de documentos
        $documentMapping = [
            // uso-de-suelo
            'formato-de-solicitud-para-licencia-de-uso-de-suelo-fdduem-01' => 'Formato de solicitud para licencia de Uso de Suelo (FDDUEM-01)',
            'copia-de-la-escritura-de-la-propiedad-o-documento-notariado-que-compruebe-la-posesion-del-predio' => 'Copia de la escritura de la propiedad o documento notariado que compruebe la posesión del predio',
            'contrato-de-arrendamiento-simple' => 'Contrato de arrendamiento simple.',
            'copia-del-ultimo-pago-del-predial' => 'Copia del último pago del predial.',
            'copia-de-identificacion-de-la-persona-que-acredita-la-propiedad-asi-como-la-del-arrendatario-o-representante-legal-segun-sea-el-caso' => 'Copia de identificación de la persona que acredita la propiedad asi como la del arrendatario o representante legal según sea el caso',
            'croquis-de-ubicacion-del-inmueble' => 'Croquis de ubicación del inmueble',

            // constancia-de-factibilidad, permiso-de-anuncios, certificacion-numero-oficial
            'poder-legal' => 'Poder Legal',

            // permiso-de-division
            'solicitud-por-escrito-con-proyecto-de-division' => 'Solicitud por escrito con proyecto de división',
            'croquis-del-predio' => 'Croquis del predio',
            'copia-de-identificacion-de-la-persona-que-acredita-la-propiedad' => 'Copia de identificación de la persona que acredita la propiedad',

            // licencia-de-construccion
            'proyecto-arquitectonico-en-dos-tantos-fisicos-con-escala-1-100-o-1-50-elaborados-avaldaos-y-firmados-por-dro' => 'Proyecto arquitectonico, en dos tantos físicos. Con escala 1:100 O 1:50 elaborados, avaldaos y firmados por DRO',

            // permiso-construccion-panteones
            'copia-de-identificacion-del-propietario' => 'Copia de identificación del propietario',
            'copia-del-documento-de-perpetuidad' => 'Copia del documento de perpetuidad'
        ];

        // Verificar si el slug existe en el mapeo
        if (isset($documentMapping[$receivedSlug])) {
            return [
                'name' => $documentMapping[$receivedSlug],
                'slug' => $receivedSlug
            ];
        }

        // Si no existe en el mapeo, usar el slug recibido como nombre y generar un slug limpio
        return [
            'name' => $receivedSlug,
            'slug' => Str::slug($receivedSlug)
        ];
    }

    /**
     * Delete SARE file
     */
    public function deleteSareFile(Request $request, $fileId)
    {
        try {
            $file = SareRequestFile::findOrFail($fileId);

            // Verificar que el archivo pertenece al usuario autenticado
            $sareRequest = $file->sareRequest;
            if ($sareRequest->user_id !== Auth::id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No tienes acceso a este archivo.'
                ], 403);
            }

            // Eliminar archivo de S3
            $filepath = 'sare/' . $file->filename;
            Storage::disk('s3')->delete($filepath);

            // Eliminar registro de la base de datos
            $file->delete();

            return response()->json([
                'success' => true,
                'message' => 'Archivo eliminado exitosamente.'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el archivo.'
            ], 500);
        }
    }

    /**
     * Delete urban dev file
     */
    public function deleteUrbanDevFile(Request $request, $fileId)
    {
        try {
            $file = \App\Models\UrbanDevRequestFile::findOrFail($fileId);

            // Verificar que el archivo pertenece al usuario autenticado
            if ($file->user_id !== Auth::id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No tienes acceso a este archivo.'
                ], 403);
            }

            // Eliminar archivo de S3
            $filepath = 'desarrollo_urbano/' . $file->filename;
            Storage::disk('s3')->delete($filepath);

            // Eliminar registro de la base de datos
            $file->delete();

            return response()->json([
                'success' => true,
                'message' => 'Archivo eliminado exitosamente.'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el archivo.'
            ], 500);
        }
    }

    // =============== MÉTODOS DE UPLOAD DE ARCHIVOS ===============

    /**
     * Upload files via dropzone
     */
    public function uploadSareFile(Request $request)
    {
        try {
            $request->validate([
                'file' => 'required|file|max:10240', // 10MB max
                'sare_request_id' => 'required|exists:sare_requests,id',
                'document_type' => 'required|string|max:255'
            ]);

            $file = $request->file('file');
            $sareRequestId = $request->get('sare_request_id');
            $documentType = $request->get('document_type');

            if (!$file || !$file->isValid()) {
                return response()->json(['error' => 'Archivo no válido'], 400);
            }

            // Validar extensión
            $allowedExtensions = ['pdf', 'jpg', 'jpeg', 'png', 'doc', 'docx'];
            $extension = strtolower($file->getClientOriginalExtension());

            if (!in_array($extension, $allowedExtensions)) {
                return response()->json(['error' => 'Tipo de archivo no permitido.'], 400);
            }

            // Generar nombre único con el tipo de documento
            $fileName = 'sare_' . $documentType . '_' . time() . '_' . Str::random(10) . '.' . $extension;

            // Guardar archivo en S3
            $filepath = 'sare/' . $fileName;
            Storage::disk('s3')->put($filepath, file_get_contents($file));
            $s3Url = Storage::disk('s3')->url($filepath);

            // Crear registro en base de datos
            $sareFile = SareRequestFile::create([
                'sare_request_id' => $sareRequestId,
                'name' => $documentType,
                'slug' => Str::slug($documentType),
                'file_name' => $file->getClientOriginalName(),
                'filename' => $fileName,
                'file_size' => $file->getSize(),
                'file_type' => $file->getMimeType(),
                'file_extension' => $extension,
                's3_asset_url' => $s3Url
            ]);

            return response()->json([
                'success' => true,
                'file' => [
                    'id' => $sareFile->id,
                    'name' => $sareFile->file_name,
                    'filename' => $sareFile->filename,
                    'file_name' => $sareFile->file_name,
                    'file_size' => $sareFile->file_size,
                    'formatted_size' => $sareFile->formatted_size,
                    'file_type' => $sareFile->file_type,
                    'document_type' => $documentType,
                    'url' => $s3Url
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al subir archivo: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Initialize chunk upload for large files
     */
    public function initChunkUpload(Request $request)
    {
        $filename = $request->filename;
        $filesize = $request->filesize;
        $chunkSize = $request->chunk_size;

        $totalChunks = ceil($filesize / $chunkSize);
        $uploadId = Str::random(32);

        // Crear directorio temporal para chunks
        $tempDir = public_path('temp/chunks/' . $uploadId);
        if (!file_exists($tempDir)) {
            mkdir($tempDir, 0755, true);
        }

        return response()->json([
            'upload_id' => $uploadId,
            'total_chunks' => $totalChunks
        ]);
    }

    /**
     * Upload chunk for large files
     */
    public function uploadChunk(Request $request)
    {
        try {
            $uploadId = $request->upload_id;
            $chunkIndex = $request->chunk_index;
            $chunk = $request->file('chunk');

            if (!$chunk || !$chunk->isValid()) {
                return response()->json(['error' => 'Chunk no válido'], 400);
            }

            $tempDir = public_path('temp/chunks/' . $uploadId);
            $chunkPath = $tempDir . '/chunk_' . $chunkIndex;

            // Guardar chunk
            $chunk->move($tempDir, 'chunk_' . $chunkIndex);

            return response()->json(['success' => true]);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al subir chunk: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Finalize chunk upload and combine chunks
     */
    public function finalizeChunkUpload(Request $request)
    {
        try {
            $uploadId = $request->upload_id;
            $filename = $request->filename;
            $totalChunks = $request->total_chunks;
            $sareRequestId = $request->sare_request_id;

            $tempDir = public_path('temp/chunks/' . $uploadId);

            // Validar que todos los chunks estén presentes
            for ($i = 0; $i < $totalChunks; $i++) {
                $chunkPath = $tempDir . '/chunk_' . $i;
                if (!file_exists($chunkPath)) {
                    return response()->json(['error' => 'Chunk faltante: ' . $i], 400);
                }
            }

            // Combinar chunks
            $extension = pathinfo($filename, PATHINFO_EXTENSION);
            $finalFileName = time() . '_' . Str::random(10) . '.' . $extension;
            $finalPath = public_path('storage/sare_files/' . $finalFileName);

            // Crear directorio si no existe
            $directory = dirname($finalPath);
            if (!file_exists($directory)) {
                mkdir($directory, 0755, true);
            }

            $finalFile = fopen($finalPath, 'wb');

            for ($i = 0; $i < $totalChunks; $i++) {
                $chunkPath = $tempDir . '/chunk_' . $i;
                $chunkData = file_get_contents($chunkPath);
                fwrite($finalFile, $chunkData);
                unlink($chunkPath); // Eliminar chunk temporal
            }

            fclose($finalFile);
            rmdir($tempDir); // Eliminar directorio temporal

            // Crear registro en base de datos
            $sareFile = null;
            if ($sareRequestId) {
                $sareFile = SareRequestFile::create([
                    'sare_request_id' => $sareRequestId,
                    'file_name' => $filename,
                    'file_path' => 'public/sare_files/' . $finalFileName,
                    'file_size' => filesize($finalPath),
                    'file_type' => mime_content_type($finalPath),
                ]);
            }

            return response()->json([
                'success' => true,
                'file_id' => $sareFile ? $sareFile->id : null,
                'file_name' => $filename,
                'file_path' => 'sare_files/' . $finalFileName,
                'file_size' => filesize($finalPath),
            ]);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al finalizar upload: ' . $e->getMessage()], 500);
        }
    }

    //Citatorios
    public function summons()
    {
        $user = Auth::user();
        $citizen = $this->getOrCreateCitizenProfile($user);

        $mode = 1;

        $summons = Summon::where('citizen_id', $citizen->id)->get();

        $citizenId = $citizen->id;

        return view('front.user_profiles.citizen.summons.index', [
            'summons' => $summons,
            'mode' => $mode,
            'citizenId' => $citizenId
        ]);
    }

    public function showSummon($id)
    {
        $summon = Summon::findOrFail($id);

        $mode = 1;

        return view('front.user_profiles.citizen.summons.show')->with('summon', $summon)->with('mode', $mode);
    }

    public function identificationCertificates()
    {
        $user = Auth::user();

        $mode = 1;

        $certificates = IdentificationCertificate::where('user_id', $user->id)->get();

        return view('front.user_profiles.citizen.identification_certificates', [
            'certificates' => $certificates,
            'mode' => $mode
        ]);
    }

    public function createIdentificationCertificate()
    {
        return view('front.user_profiles.citizen.identification_certificates.create');
    }
}
