<?php

namespace App\Http\Controllers;

// Ayudantes
use Session;
use Str;
use Auth;

// Modelos
use App\Models\DIFMedication as Medication;
use App\Models\Notification;

/* Notificaciones */
use App\Services\NotificationService;

use Illuminate\Http\Request;

class DIFMedicationController extends Controller
{
    private $notification;

    public function __construct()
    {
        $this->notification = new NotificationService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Medication::query();

        if (request('search')) {
            $search = request('search');
            $query->where('generic_name', 'LIKE', "%{$search}%")
                  ->orWhere('commercial_name', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%")
                  ->orWhere('type', 'LIKE', "%{$search}%")
                  ->orWhere('use_type', 'LIKE', "%{$search}%");
        }

        $medications = $query->orderBy('generic_name')->paginate(30);

        return view('dif.medications.index', compact('medications'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    return view('dif.medications.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'generic_name' => 'required|max:255',
            'commercial_name' => 'nullable|max:255',
            'description' => 'nullable|max:2000',
            'formula' => 'nullable|max:2000',
            'type' => 'nullable|max:100',
            'type_num' => 'nullable|max:50',
            'type_dosage' => 'nullable|max:50',
            'use_type' => 'nullable|max:100',
            'expiration_date' => 'required|date',
            'is_active' => 'boolean',
        ]);

        $med = Medication::create([
            'generic_name' => $request->generic_name,
            'commercial_name' => $request->commercial_name,
            'description' => $request->description,
            'formula' => $request->formula,
            'type' => $request->type,
            'type_num' => $request->type_num,
            'type_dosage' => $request->type_dosage,
            'use_type' => $request->use_type,
            'expiration_date' => $request->expiration_date,
            'is_active' => $request->has('is_active'),
        ]);

        // Notificación
        $type = 'medication';
        $by = Auth::user();
        $data = 'Creó un medicamento en el sistema';
        $model_action = 'create';
        $model_id = $med->id;

        $this->notification->send($type, $by, $data, $model_action, $model_id);

        Session::flash('success', 'Medicamento guardado correctamente.');

        return redirect()->route('dif.medications.index');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $medication = Medication::findOrFail($id);
        $logs = Notification::where('type', 'medication')->where('model_id', $id)->get();

        return view('dif.medications.show', compact('medication', 'logs'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $medication = Medication::findOrFail($id);
        
        return view('dif.medications.edit', compact('medication'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'generic_name' => 'required|max:255',
            'commercial_name' => 'nullable|max:255',
            'description' => 'nullable|max:2000',
            'formula' => 'nullable|max:2000',
            'type' => 'nullable|max:100',
            'type_num' => 'nullable|max:50',
            'type_dosage' => 'nullable|max:50',
            'use_type' => 'nullable|max:100',
            'expiration_date' => 'required|date',
            'is_active' => 'boolean',
        ]);

        $medication = Medication::findOrFail($id);

        $medication->update([
            'generic_name' => $request->generic_name,
            'commercial_name' => $request->commercial_name,
            'description' => $request->description,
            'formula' => $request->formula,
            'type' => $request->type,
            'type_num' => $request->type_num,
            'type_dosage' => $request->type_dosage,
            'use_type' => $request->use_type,
            'expiration_date' => $request->expiration_date,
            'is_active' => $request->has('is_active'),
        ]);

        // Notificación
        $type = 'medication';
        $by = Auth::user();
        $data = 'Editó un medicamento en el sistema';
        $model_action = 'update';
        $model_id = $medication->id;

        $this->notification->send($type, $by, $data, $model_action, $model_id);

        Session::flash('success', 'Medicamento editado exitosamente.');

        return redirect()->route('dif.medications.show', $medication->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $medication = Medication::findOrFail($id);

        // Notificación
        $type = 'medication';
        $by = Auth::user();
        $data = 'Eliminó un medicamento en el sistema';
        $model_action = 'destroy';
        $model_id = $medication->id;

        $this->notification->send($type, $by, $data, $model_action, $model_id);

        $medication->delete();

        Session::flash('success', 'Medicamento eliminado de manera exitosa.');
        return redirect()->route('dif.medications.index');
    }
}
