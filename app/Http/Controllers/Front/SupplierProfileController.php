<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;

class SupplierProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:supplier']);
    }

    /**
     * Mostrar el dashboard del proveedor
     */
    public function index()
    {
        $user = Auth::user();
        $userInfo = $this->getOrCreateUserInfo($user);
        
        // Obtener datos adicionales del proveedor desde JSON
        $supplierData = $userInfo->additional_data ?? [];

        return view('front.user_profiles.supplier.index', compact('userInfo', 'supplierData'));
    }

    /**
     * Mostrar formulario de edición del perfil del proveedor
     */
    public function edit()
    {
        $user = Auth::user();
        $userInfo = $this->getOrCreateUserInfo($user);
        
        // Obtener datos adicionales del proveedor desde JSON
        $supplierData = $userInfo->additional_data ?? [];

        return view('front.user_profiles.supplier.edit', compact('user', 'userInfo', 'supplierData'));
    }

    /**
     * Mostrar listado de notificaciones para el proveedor
     */
    public function notifications()
    {
        $user = Auth::user();
        $userInfo = $this->getOrCreateUserInfo($user);
        
        // Obtener mensajes del usuario agrupados por estado
        $messages = $user->messages()
            ->with('supplier')
            ->where('status', '!=', 'archived')
            ->orderBy('created_at', 'desc')
            ->get();
            
        $archivedMessages = $user->messages()
            ->with('supplier')
            ->where('status', 'archived')
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Obtener datos adicionales del proveedor desde JSON
        $supplierData = $userInfo->additional_data ?? [];

        return view('front.user_profiles.supplier.notifications', compact('user', 'userInfo', 'supplierData', 'messages', 'archivedMessages'));
    }

    /**
     * Mostrar listado general de alta de proveedor
     */
    public function create()
    {
        $user = Auth::user();
        $userInfo = $this->getOrCreateUserInfo($user);
        
        // Obtener datos adicionales del proveedor desde JSON
        $supplierData = $userInfo->additional_data ?? [];

        return view('front.user_profiles.supplier.create', compact('user', 'userInfo', 'supplierData'));
    }

    /**
     * Actualizar perfil del proveedor
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        $userInfo = $this->getOrCreateUserInfo($user);

        // Validación base
        $rules = [
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'phone' => 'nullable|string|max:15',
            'current_password' => 'nullable|required_with:password',
            'password' => 'nullable|min:8|confirmed',
        ];

        // Validaciones específicas para proveedores
        $supplierData = $userInfo->additional_data ?? [];
        if (isset($supplierData['person_type'])) {
            $rules['person_type'] = 'required|string|in:fisica,moral';
            $rules['company_name'] = 'required_if:person_type,moral|nullable|string|max:255';
            $rules['padron_status'] = 'required|string|in:con_padron,sin_padron';
        }

        $request->validate($rules);

        // Validar contraseña actual si se quiere cambiar
        if ($request->filled('password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors([
                    'current_password' => 'La contraseña actual no es correcta.'
                ])->withInput();
            }
        }

        // Actualizar usuario
        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        // Actualizar datos adicionales del proveedor en JSON
        $additionalData = $userInfo->additional_data ?? [];
        
        // Actualizar datos específicos del proveedor
        if ($request->has('person_type')) {
            $additionalData['person_type'] = $request->person_type;
        }
        
        if ($request->has('company_name')) {
            $additionalData['company_name'] = $request->company_name;
        }
        
        if ($request->has('padron_status')) {
            $additionalData['padron_status'] = $request->padron_status;
        }
        
        if ($request->has('phone')) {
            $additionalData['phone'] = $request->phone;
        }
        
        // Actualizar otros campos personalizados
        if ($request->has('rfc')) {
            $additionalData['rfc'] = $request->rfc;
        }
        
        if ($request->has('address')) {
            $additionalData['address'] = $request->address;
        }
        
        if ($request->has('business_activity')) {
            $additionalData['business_activity'] = $request->business_activity;
        }

        // Guardar en UserInfo
        $userInfo->update([
            'additional_data' => $additionalData
        ]);

        Session::flash('success', 'Tu perfil de proveedor se actualizó correctamente.');

        return redirect()->route('supplier.profile.edit');
    }

    /**
     * Mostrar configuraciones del proveedor
     */
    public function settings()
    {
        $user = Auth::user();
        $userInfo = $this->getOrCreateUserInfo($user);
        
        // Obtener datos adicionales del proveedor
        $supplierData = $userInfo->additional_data ?? [];

        return view('front.user_profiles.supplier.settings', compact('userInfo', 'supplierData'));
    }

    /**
     * Actualizar preferencias de notificaciones del proveedor
     */
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

        return redirect()->route('supplier.profile.settings');
    }

    /**
     * Obtener o crear información adicional del proveedor
     */
    private function getOrCreateUserInfo($user)
    {
        $userInfo = UserInfo::where('user_id', $user->id)->first();

        if (!$userInfo) {
            $userInfo = UserInfo::create([
                'user_id' => $user->id,
                'model_type' => 'App\Models\Supplier',
                'model_id' => null,
                'mail_notifications' => true,
                'sms_notifications' => true,
                'push_notifications' => true,
                'additional_data' => [
                    'person_type' => null,
                    'company_name' => null,
                    'padron_status' => null,
                    'phone' => null,
                    'registration_date' => now()->toDateString(),
                ]
            ]);
        }

        return $userInfo;
    }
}
