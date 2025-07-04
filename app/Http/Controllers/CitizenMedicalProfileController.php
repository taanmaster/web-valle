<?php

namespace App\Http\Controllers;

// Ayudantes
use Str;
use Auth;
use Session;

// Modelos
use App\Models\CitizenMedicalProfile;
use App\Models\Citizen;
use App\Models\DIFProgram as Program;
use App\Models\MedicalProfileProgram;
use Illuminate\Http\Request;

class CitizenMedicalProfileController extends Controller
{
    public function index()
    {
        $query = CitizenMedicalProfile::with(['citizen', 'programs']);
        
        if (request('search')) {
            $search = request('search');
            $query->where('medical_num', 'LIKE', "%{$search}%")
                  ->orWhere('blood_type', 'LIKE', "%{$search}%")
                  ->orWhere('allergies', 'LIKE', "%{$search}%")
                  ->orWhereHas('citizen', function ($q) use ($search) {
                      $q->where('name', 'LIKE', "%{$search}%")
                        ->orWhere('last_name', 'LIKE', "%{$search}%");
                  });
        }
        
        $medicalProfiles = $query->paginate(30);

        return view('dif.medical_profiles.index', compact('medicalProfiles'));
    }

    public function create()
    {
        // Obtener todos los ciudadanos activos
        $citizens = Citizen::all();
        
        // Obtener todos los programas activos
        $programs = Program::where('is_active', true)->get();
        
        // Obtener ciudadano pre-seleccionado si viene como parámetro
        $selectedCitizenId = request('citizen_id');
        
        return view('dif.medical_profiles.create', compact('citizens', 'programs', 'selectedCitizenId'));
    }

    public function store(Request $request)
    {
        //Validar
        $this->validate($request, array(
            'citizen_id' => 'required|exists:citizens,id|unique:citizen_medical_profiles,citizen_id',
            'medical_num' => 'required|max:255',
            'blood_type' => 'nullable|max:10',
            'allergies' => 'nullable|max:255',
            'medical_conditions' => 'nullable',
            'medications' => 'nullable',
            'gender' => 'required|in:Masculino,Femenino,Otro',
            'age' => 'nullable|max:3',
            'phone' => 'nullable|max:15',
            'email' => 'nullable|email|max:255',
            'program_ids' => 'nullable|array',
            'program_ids.*' => 'exists:d_i_f_programs,id',
        ));

        // Guardar perfil médico
        $medicalProfile = CitizenMedicalProfile::create([
            'citizen_id' => $request->citizen_id,
            'medical_num' => $request->medical_num,
            'blood_type' => $request->blood_type,
            'allergies' => $request->allergies,
            'medical_conditions' => $request->medical_conditions,
            'medications' => $request->medications,
            'gender' => $request->gender,
            'age' => $request->age,
            'phone' => $request->phone,
            'email' => $request->email,
        ]);

        // Asociar programas si se seleccionaron
        if ($request->program_ids) {
            $medicalProfile->programs()->attach($request->program_ids);
        }

        // Mensaje de session
        Session::flash('success', 'Perfil médico guardado correctamente.');

        // Enviar a vista
        return redirect()->route('dif.medical_profiles.index');
    }

    public function show($id)
    {
        $medicalProfile = CitizenMedicalProfile::with(['citizen', 'programs'])->find($id);
        
        return view('dif.medical_profiles.show')->with('medicalProfile', $medicalProfile);
    }

    public function edit($id)
    {
        $medicalProfile = CitizenMedicalProfile::with(['citizen', 'programs'])->find($id);
        $citizens = Citizen::all();
        $programs = Program::where('is_active', true)->get();
        
        // Obtener IDs de programas seleccionados
        $selectedPrograms = $medicalProfile->programs->pluck('id')->toArray();

        return view('dif.medical_profiles.edit', compact('medicalProfile', 'citizens', 'programs', 'selectedPrograms'));
    }

    public function update(Request $request, $id)
    {
        //Validar
        $this->validate($request, array(
            'citizen_id' => 'required|exists:citizens,id|unique:citizen_medical_profiles,citizen_id,' . $id,
            'medical_num' => 'required|max:255',
            'blood_type' => 'nullable|max:10',
            'allergies' => 'nullable|max:255',
            'medical_conditions' => 'nullable',
            'medications' => 'nullable',
            'gender' => 'required|in:Masculino,Femenino,Otro',
            'age' => 'nullable|max:3',
            'phone' => 'nullable|max:15',
            'email' => 'nullable|email|max:255',
            'program_ids' => 'nullable|array',
            'program_ids.*' => 'exists:d_i_f_programs,id',
        ));

        $medicalProfile = CitizenMedicalProfile::find($id);

        $medicalProfile->update([
            'citizen_id' => $request->citizen_id,
            'medical_num' => $request->medical_num,
            'blood_type' => $request->blood_type,
            'allergies' => $request->allergies,
            'medical_conditions' => $request->medical_conditions,
            'medications' => $request->medications,
            'gender' => $request->gender,
            'age' => $request->age,
            'phone' => $request->phone,
            'email' => $request->email,
        ]);

        // Actualizar programas asociados
        if ($request->program_ids) {
            $medicalProfile->programs()->sync($request->program_ids);
        } else {
            $medicalProfile->programs()->detach();
        }

        // Mensaje de session
        Session::flash('success', 'Perfil médico actualizado exitosamente.');

        // Enviar a vista
        return redirect()->route('dif.medical_profiles.show', $medicalProfile->id);
    }

    public function destroy($id)
    {
        $medicalProfile = CitizenMedicalProfile::find($id);
        
        // Eliminar relaciones con programas
        $medicalProfile->programs()->detach();
        
        // Eliminar perfil médico
        $medicalProfile->delete();

        Session::flash('success', 'Perfil médico eliminado de manera exitosa.');
        return redirect()->route('dif.medical_profiles.index');
    }

    /**
     * Obtener información del ciudadano para pre-llenar el formulario
     */
    public function getCitizenInfo($id)
    {
        $citizen = Citizen::find($id);
        
        if (!$citizen) {
            return response()->json(['error' => 'Ciudadano no encontrado'], 404);
        }

        return response()->json([
            'success' => true,
            'citizen' => [
                'id' => $citizen->id,
                'name' => $citizen->name,
                'first_name' => $citizen->first_name,
                'last_name' => $citizen->last_name,
                'phone' => $citizen->phone,
                'email' => $citizen->email,
                'curp' => $citizen->curp,
                'full_name' => trim($citizen->name . ' ' . $citizen->first_name . ' ' . $citizen->last_name)
            ]
        ]);
    }
}
