<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Citizen;
use App\Models\UserInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;

class CitizenProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:citizen']);
    }

    public function index()
    {
        return view('front.citizen_profile.index');
    }

    public function edit()
    {
        $user = Auth::user();
        $citizen = $this->getOrCreateCitizenProfile($user);
        
        return view('front.citizen_profile.edit', compact('citizen'));
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

    public function requests()
    {
        // Aquí podrías cargar las solicitudes del ciudadano
        // $requests = Request::where('user_id', Auth::id())->get();
        
        return view('front.citizen_profile.requests');
    }

    public function settings()
    {
        $user = Auth::user();
        $userInfo = $this->getOrCreateUserInfo($user);
        
        return view('front.citizen_profile.settings', compact('userInfo'));
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
}
