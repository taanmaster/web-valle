<?php

namespace App\Http\Controllers;

use App\Models\DIFDoctorConsult;
use App\Models\DIFDoctor;
use App\Models\DIFConsultType;
use App\Models\Citizen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DIFDoctorConsultController extends Controller
{
    public function index()
    {
        $search = request('search');
        
        $consults = DIFDoctorConsult::with(['doctor', 'consultType', 'citizen'])
            ->when($search, function ($query, $search) {
                return $query->where('consult_num', 'like', "%{$search}%")
                    ->orWhere('consult_description', 'like', "%{$search}%")
                    ->orWhere('patient_id', 'like', "%{$search}%")
                    ->orWhere('status', 'like', "%{$search}%")
                    ->orWhereHas('doctor', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('citizen', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('dif.consults.index', compact('consults'));
    }

    public function create()
    {
        $doctors = DIFDoctor::orderBy('name')->get();
        $consultTypes = DIFConsultType::all();
        $citizens = Citizen::orderBy('name')->get();
        
        // Generar número de consulta único
        $consultNum = $this->generateConsultNum();

        return view('dif.consults.create', compact('doctors', 'consultTypes', 'citizens', 'consultNum'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required|exists:d_i_f_doctors,id',
            'patient_id' => 'required|exists:citizens,id',
            'consult_num' => 'required|unique:d_i_f_doctor_consults,consult_num',
            'consult_date' => 'required|date',
            'consult_description' => 'nullable|string',
            'consult_type_id' => 'nullable|exists:d_i_f_consult_types,id',
        ]);

        // Agregar el campo 'status' con valor por defecto 'pending'
        $request->merge(['status' => 'completed']);

        try {
            DIFDoctorConsult::create($request->all());
            
            return redirect()->route('dif.consults.index')
                ->with('success', 'Consulta médica creada exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error al crear la consulta médica: ' . $e->getMessage());
        }
    }

    public function show(DIFDoctorConsult $consult)
    {
        $consult->load(['doctor.specialty', 'consultType', 'citizen.medicalProfile']);
        return view('dif.consults.show', compact('consult'));
    }

    public function edit(DIFDoctorConsult $consult)
    {
        $doctors = DIFDoctor::orderBy('name')->get();
        $consultTypes = DIFConsultType::all();
        $citizens = Citizen::orderBy('name')->get();

        return view('dif.consults.edit', compact('consult', 'doctors', 'consultTypes', 'citizens'));
    }

    public function update(Request $request, DIFDoctorConsult $consult)
    {
        $request->validate([
            'doctor_id' => 'required|exists:d_i_f_doctors,id',
            'patient_id' => 'required|exists:citizens,id',
            'consult_num' => 'required|unique:d_i_f_doctor_consults,consult_num,' . $consult->id,
            'consult_date' => 'required|date',
            'consult_description' => 'nullable|string',
            'consult_type_id' => 'nullable|exists:d_i_f_consult_types,id',
            'status' => 'required|in:pending,completed,cancelled'
        ]);

        try {
            $consult->update($request->all());
            
            return redirect()->route('dif.consults.show', $consult)
                ->with('success', 'Consulta médica actualizada exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error al actualizar la consulta médica: ' . $e->getMessage());
        }
    }

    public function destroy(DIFDoctorConsult $consult)
    {
        try {
            $consult->delete();
            
            return redirect()->route('dif.consults.index')
                ->with('success', 'Consulta médica eliminada exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al eliminar la consulta médica: ' . $e->getMessage());
        }
    }

    /**
     * Genera un número de consulta único
     */
    private function generateConsultNum()
    {
        $year = date('Y');
        $month = date('m');
        
        $lastConsult = DIFDoctorConsult::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->orderBy('id', 'desc')
            ->first();
        
        $nextNumber = $lastConsult ? (int)substr($lastConsult->consult_num, -4) + 1 : 1;
        
        return 'CONS-' . $year . $month . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
    }
}
