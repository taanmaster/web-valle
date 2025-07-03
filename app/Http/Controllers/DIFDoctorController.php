<?php

namespace App\Http\Controllers;
// Ayudantes
use Str;
use Auth;
use Session;

// Modelos
use App\Models\DIFDoctor as Doctor;
use App\Models\DIFSpecialty;

use Illuminate\Http\Request;

class DIFDoctorController extends Controller
{
    public function index()
    {
        $query = Doctor::query();
        
        if (request('search')) {
            $search = request('search');
            $query->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('employee_num', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%");
        }
        
        $doctors = $query->with('speciality')->paginate(30);

        return view('dif.doctors.index', compact('doctors'));
    }

    public function create()
    {
        $specialties = DIFSpecialty::all();
        return view('dif.doctors.create', compact('specialties'));
    }

    public function store(Request $request)
    {
        //Validar
        $this->validate($request, array(
            'employee_num' => 'required|max:255|unique:d_i_f_doctors',
            'name' => 'required|max:255',
            'specialty_id' => 'required|integer',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|max:20',
        ));

        // Guardar datos en la base de datos
        $doctor = Doctor::create([
            'employee_num' => $request->employee_num,
            'name' => $request->name,
            'specialty_id' => $request->specialty_id,
            'full_address' => $request->full_address,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        // Mensaje de session
        Session::flash('success', 'Doctor guardado correctamente.');

        // Enviar a vista
        return redirect()->route('dif.doctors.index');
    }

    public function show($id)
    {
        $doctor = Doctor::with(['consultations', 'prescriptions', 'receipts'])->find($id);
        
        return view('dif.doctors.show')->with('doctor', $doctor);
    }

    public function edit($id)
    {
        $doctor = Doctor::find($id);
        $specialties = DIFSpecialty::all();

        return view('dif.doctors.edit', compact('doctor', 'specialties'));
    }

    public function update(Request $request, $id)
    {
        //Validar
        $this->validate($request, array(
            'employee_num' => 'required|max:255|unique:d_i_f_doctors,employee_num,' . $id,
            'name' => 'required|max:255',
            'specialty_id' => 'required|integer',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|max:20',
        ));

        $doctor = Doctor::find($id);

        $doctor->update([
            'employee_num' => $request->employee_num,
            'name' => $request->name,
            'specialty_id' => $request->specialty_id,
            'full_address' => $request->full_address,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        // Mensaje de session
        Session::flash('success', 'Doctor editado exitosamente.');

        // Enviar a vista
        return redirect()->route('dif.doctors.show', $doctor->id);
    }

    public function destroy($id)
    {
        $doctor = Doctor::find($id);
        $doctor->delete();

        Session::flash('success', 'Doctor eliminado de manera exitosa.');
        return redirect()->route('dif.doctors.index');
    }
}
