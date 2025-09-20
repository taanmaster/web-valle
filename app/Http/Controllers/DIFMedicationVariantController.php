<?php

namespace App\Http\Controllers;

// Ayudantes
use Session;
use Str;
use Auth;

// Modelos
use App\Models\DIFMedicationVariant as MedicationVariant;
use App\Models\DIFMedication as Medication;
use App\Models\Notification;

/* Notificaciones */
use App\Services\NotificationService;

use Illuminate\Http\Request;

class DIFMedicationVariantController extends Controller
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
        $query = MedicationVariant::with('medication');

        if (request('search')) {
            $search = request('search');
            $query->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('sku', 'LIKE', "%{$search}%")
                  ->orWhere('type', 'LIKE', "%{$search}%")
                  ->orWhere('use_type', 'LIKE', "%{$search}%")
                  ->orWhereHas('medication', function($q) use ($search) {
                      $q->where('generic_name', 'LIKE', "%{$search}%")
                        ->orWhere('commercial_name', 'LIKE', "%{$search}%");
                  });
        }

        $variants = $query->orderBy('name')->paginate(30);

        return view('dif.medication_variants.index', compact('variants'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $medications = Medication::where('is_active', true)->orderBy('generic_name')->get();
        $medication_id = request('medication_id');
        
        return view('dif.medication_variants.create', compact('medications', 'medication_id'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'medication_id' => 'required|exists:d_i_f_medications,id',
            'name' => 'required|max:255',
            'sku' => 'required|unique:d_i_f_medication_variants,sku|max:255',
            'price' => 'nullable|numeric|min:0',
            'type' => 'nullable|max:100',
            'type_num' => 'nullable|max:50',
            'type_dosage' => 'nullable|max:50',
            'use_type' => 'nullable|max:100',
        ]);

        $variant = MedicationVariant::create([
            'medication_id' => $request->medication_id,
            'name' => $request->name,
            'sku' => $request->sku,
            'price' => $request->price,
            'type' => $request->type,
            'type_num' => $request->type_num,
            'type_dosage' => $request->type_dosage,
            'use_type' => $request->use_type,
            'attributes_json' => $request->attributes_json,
        ]);

        // Notificación
        $type = 'medication_variant';
        $by = Auth::user();
        $data = 'Creó una variante de medicamento en el sistema';
        $model_action = 'create';
        $model_id = $variant->id;

        $this->notification->send($type, $by, $data, $model_action, $model_id);

        Session::flash('success', 'Variante de medicamento guardada correctamente.');

        // Redirigir al medicamento padre si se especifica
        if ($request->redirect_to_medication) {
            return redirect()->route('dif.medications.show', $request->medication_id);
        }

        return redirect()->route('dif.medication_variants.index');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $variant = MedicationVariant::with('medication')->findOrFail($id);
        $logs = Notification::where('type', 'medication_variant')->where('model_id', $id)->get();

        return view('dif.medication_variants.show', compact('variant', 'logs'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $variant = MedicationVariant::with('medication')->findOrFail($id);
        $medications = Medication::where('is_active', true)->orderBy('generic_name')->get();
        
        return view('dif.medication_variants.edit', compact('variant', 'medications'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'medication_id' => 'required|exists:d_i_f_medications,id',
            'name' => 'required|max:255',
            'sku' => 'required|unique:d_i_f_medication_variants,sku,' . $id . '|max:255',
            'price' => 'nullable|numeric|min:0',
            'type' => 'nullable|max:100',
            'type_num' => 'nullable|max:50',
            'type_dosage' => 'nullable|max:50',
            'use_type' => 'nullable|max:100',
        ]);

        $variant = MedicationVariant::findOrFail($id);

        $variant->update([
            'medication_id' => $request->medication_id,
            'name' => $request->name,
            'sku' => $request->sku,
            'price' => $request->price,
            'type' => $request->type,
            'type_num' => $request->type_num,
            'type_dosage' => $request->type_dosage,
            'use_type' => $request->use_type,
            'attributes_json' => $request->attributes_json,
        ]);

        // Notificación
        $type = 'medication_variant';
        $by = Auth::user();
        $data = 'Editó una variante de medicamento en el sistema';
        $model_action = 'update';
        $model_id = $variant->id;

        $this->notification->send($type, $by, $data, $model_action, $model_id);

        Session::flash('success', 'Variante de medicamento editada exitosamente.');

        return redirect()->route('dif.medication_variants.show', $variant->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $variant = MedicationVariant::findOrFail($id);

        // Notificación
        $type = 'medication_variant';
        $by = Auth::user();
        $data = 'Eliminó una variante de medicamento en el sistema';
        $model_action = 'destroy';
        $model_id = $variant->id;

        $this->notification->send($type, $by, $data, $model_action, $model_id);

        $variant->delete();

        Session::flash('success', 'Variante de medicamento eliminada de manera exitosa.');
        return redirect()->route('dif.medication_variants.index');
    }
}
