<?php

namespace App\Http\Controllers;

use App\Models\MedicalProfileProgram;
use Illuminate\Http\Request;

class MedicalProfileProgramController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $medicalProfilePrograms = MedicalProfileProgram::with(['medicalProfile', 'program'])->paginate(30);
        return view('dif.medical_profile_programs.index', compact('medicalProfilePrograms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dif.medical_profile_programs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'medical_profile_id' => 'required|exists:citizen_medical_profiles,id',
            'program_id' => 'required|exists:d_i_f_programs,id',
        ]);

        MedicalProfileProgram::create($request->all());

        return redirect()->route('dif.medical_profile_programs.index')
                         ->with('success', 'Asociación creada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(MedicalProfileProgram $medicalProfileProgram)
    {
        return view('dif.medical_profile_programs.show', compact('medicalProfileProgram'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MedicalProfileProgram $medicalProfileProgram)
    {
        return view('dif.medical_profile_programs.edit', compact('medicalProfileProgram'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MedicalProfileProgram $medicalProfileProgram)
    {
        $request->validate([
            'medical_profile_id' => 'required|exists:citizen_medical_profiles,id',
            'program_id' => 'required|exists:d_i_f_programs,id',
        ]);

        $medicalProfileProgram->update($request->all());

        return redirect()->route('dif.medical_profile_programs.index')
                         ->with('success', 'Asociación actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MedicalProfileProgram $medicalProfileProgram)
    {
        $medicalProfileProgram->delete();

        return redirect()->route('dif.medical_profile_programs.index')
                         ->with('success', 'Asociación eliminada exitosamente.');
    }
}
