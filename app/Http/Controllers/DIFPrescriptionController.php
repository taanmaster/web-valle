<?php

namespace App\Http\Controllers;

use App\Models\DIFPrescription;
use App\Models\DIFDoctor;
use App\Models\Citizen;
use Illuminate\Http\Request;
use Str;
use Auth;
use Session;

class DIFPrescriptionController extends Controller
{
    public function index()
    {
        $prescriptions = DIFPrescription::with(['doctor', 'patient'])->paginate(10);
        $doctors = DIFDoctor::all();
        $patients = Citizen::all();
        return view('dif.prescriptions.index', compact('prescriptions', 'doctors', 'patients'));
    }

    public function create()
    {
        $doctors = DIFDoctor::all();
        $patients = Citizen::all();
        
        // Generar número de receta consecutivo
        $lastPrescription = DIFPrescription::orderBy('id', 'desc')->first();
        $prescriptionNum = $lastPrescription ? 
            str_pad((intval(substr($lastPrescription->prescription_num, -4)) + 1), 4, '0', STR_PAD_LEFT) : 
            '1000';
        
        return view('dif.prescriptions.create', compact('doctors', 'patients', 'prescriptionNum'));
    }

    public function store(Request $request)
    {
        // Validar
        $this->validate($request, [
            'prescription_num' => 'required|unique:d_i_f_prescriptions,prescription_num|max:255',
            'doctor_id' => 'required|exists:d_i_f_doctors,id',
            'patient_id' => 'required|exists:citizens,id',
        ]);

        $request->merge([
            'status' => $request->status ?? 'completed', // Estado por defecto
        ]);

        // Guardar datos en la base de datos
        DIFPrescription::create([
            'prescription_num' => $request->prescription_num,
            'doctor_id' => $request->doctor_id,
            'patient_id' => $request->patient_id,
            'prescription_date' => now()->format('Y-m-d'),
            'status' => $request->status,
        ]);

        // Mensaje de session
        Session::flash('success', 'Receta médica guardada correctamente.');

        // Redireccionar
        return redirect()->route('dif.prescriptions.index');
    }

    public function show(DIFPrescription $prescription)
    {
        $prescription->load(['doctor', 'patient']);
        return view('dif.prescriptions.show', compact('prescription'));
    }

    public function edit(DIFPrescription $prescription)
    {
        $doctors = DIFDoctor::all();
        $patients = Citizen::all();
        return view('dif.prescriptions.edit', compact('prescription', 'doctors', 'patients'));
    }

    public function update(Request $request, DIFPrescription $prescription)
    {
        // Validar
        $this->validate($request, [
            'prescription_num' => 'required|unique:d_i_f_prescriptions,prescription_num,' . $prescription->id . '|max:255',
            'doctor_id' => 'required|exists:d_i_f_doctors,id',
            'patient_id' => 'required|exists:citizens,id',
            'prescription_date' => 'required|date',
            'status' => 'required|in:pending,completed,cancelled',
        ]);

        // Actualizar datos
        $prescription->update([
            'prescription_num' => $request->prescription_num,
            'doctor_id' => $request->doctor_id,
            'patient_id' => $request->patient_id,
            'prescription_date' => $request->prescription_date,
            'status' => $request->status,
        ]);

        // Mensaje de session
        Session::flash('success', 'Receta médica actualizada correctamente.');

        // Redireccionar
        return redirect()->route('dif.prescriptions.show', $prescription->id);
    }

    public function destroy(DIFPrescription $prescription)
    {
        $prescription->delete();

        Session::flash('success', 'Receta médica eliminada correctamente.');
        return redirect()->route('dif.prescriptions.index');
    }
}
