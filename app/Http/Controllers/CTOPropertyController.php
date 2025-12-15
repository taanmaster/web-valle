<?php

namespace App\Http\Controllers;

use App\Models\CTOProperty;
use App\Models\Notification;
use App\Services\NotificationService;
use App\Imports\CTOPropertyImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Session;
use Auth;
use Carbon\Carbon;

class CTOPropertyController extends Controller
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
        $query = CTOProperty::withCount('propertyTaxes');

        if (request('search')) {
            $search = request('search');
            $query->where('taxpayer_name', 'LIKE', "%{$search}%")
                  ->orWhere('location_account', 'LIKE', "%{$search}%")
                  ->orWhere('street', 'LIKE', "%{$search}%")
                  ->orWhere('suburb', 'LIKE', "%{$search}%");
        }

        if (request('taxpayer_type')) {
            $query->where('taxpayer_type', request('taxpayer_type'));
        }

        if (request('cuota_type')) {
            $query->where('cuota_type', request('cuota_type'));
        }

        $properties = $query->paginate(30);

        return view('cto.properties.index', compact('properties'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('cto.properties.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'taxpayer_type' => 'nullable|string|max:255',
            'taxpayer_name' => 'nullable|string|max:255',
            'taxpayer_phone' => 'nullable|string|max:255',
            'street' => 'required|string|max:255',
            'street_num' => 'required|string|max:255',
            'int_num' => 'nullable|string|max:255',
            'suburb' => 'required|string|max:255',
            'cuota_type' => 'nullable|string|max:255',
            'location_account' => 'nullable|string|max:255',
            'location_type' => 'nullable|string|max:255',
            'location_num' => 'nullable|string|max:255',
            'location_note' => 'nullable|string',
            'location_origin' => 'nullable|string|max:255',
            'location_surface' => 'nullable|numeric',
            'location_use' => 'nullable|string|max:255',
            'location_law_value' => 'nullable|numeric',
            'location_surface_built' => 'nullable|numeric',
            'location_condition' => 'nullable|string|max:255',
            'last_appraisal' => 'nullable|date',
            'payment_anual' => 'nullable|numeric',
            'payment_bimonthly' => 'nullable|numeric',
            'tax_rate' => 'nullable|numeric',
            'total_payment' => 'nullable|numeric',
            'issue_date' => 'nullable|date',
            'validity_date' => 'nullable|date',
            'payment_date' => 'nullable|date',
            'notification_address' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $property = CTOProperty::create($request->all());

        // Notificación
        $type = 'cto_property';
        $by = Auth::user();
        $data = 'Creó una propiedad en el sistema';
        $model_action = "create";
        $model_id = $property->id;

        $this->notification->send($type, $by, $data, $model_action, $model_id);
        
        Session::flash('success', 'Propiedad guardada correctamente.');

        return redirect()->route('properties.index');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $property = CTOProperty::with('propertyTaxes')->findOrFail($id);
        $logs = Notification::where('type', 'cto_property')->where('model_id', $id)->get();

        return view('cto.properties.show', compact('property', 'logs'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $property = CTOProperty::findOrFail($id);
        return view('cto.properties.edit', compact('property'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'taxpayer_type' => 'nullable|string|max:255',
            'taxpayer_name' => 'nullable|string|max:255',
            'taxpayer_phone' => 'nullable|string|max:255',
            'street' => 'required|string|max:255',
            'street_num' => 'required|string|max:255',
            'int_num' => 'nullable|string|max:255',
            'suburb' => 'required|string|max:255',
            'cuota_type' => 'nullable|string|max:255',
            'location_account' => 'nullable|string|max:255',
            'location_type' => 'nullable|string|max:255',
            'location_num' => 'nullable|string|max:255',
            'location_note' => 'nullable|string',
            'location_origin' => 'nullable|string|max:255',
            'location_surface' => 'nullable|numeric',
            'location_use' => 'nullable|string|max:255',
            'location_law_value' => 'nullable|numeric',
            'location_surface_built' => 'nullable|numeric',
            'location_condition' => 'nullable|string|max:255',
            'last_appraisal' => 'nullable|date',
            'payment_anual' => 'nullable|numeric',
            'payment_bimonthly' => 'nullable|numeric',
            'tax_rate' => 'nullable|numeric',
            'total_payment' => 'nullable|numeric',
            'issue_date' => 'nullable|date',
            'validity_date' => 'nullable|date',
            'payment_date' => 'nullable|date',
            'notification_address' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $property = CTOProperty::findOrFail($id);
        $property->update($request->all());

        // Notificación
        $type = 'cto_property';
        $by = Auth::user();
        $data = 'Editó una propiedad en el sistema';
        $model_action = "update";
        $model_id = $property->id;

        $this->notification->send($type, $by, $data, $model_action, $model_id);

        Session::flash('success', 'Propiedad editada exitosamente.');

        return redirect()->route('properties.show', $property->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $property = CTOProperty::findOrFail($id);

        // Notificación
        $type = 'cto_property';
        $by = Auth::user();
        $data = 'Eliminó una propiedad del sistema';
        $model_action = "destroy";
        $model_id = $property->id;

        $this->notification->send($type, $by, $data, $model_action, $model_id);

        $property->delete();

        Session::flash('success', 'Propiedad eliminada de manera exitosa.');
        return redirect()->route('properties.index');
    }

    /**
     * Import properties from Excel file
     */
    public function import(Request $request)
    {
        $archivo = $request->file('import_file');
        $filename_excel = 'predios_importado_' . Carbon::now()->format('d_m_y_H_m_s') . '.'. $archivo->getClientOriginalExtension();
        $location = public_path('excel/');
        $archivo->move($location, $filename_excel);

        try {
            Excel::import(new CTOPropertyImport, public_path('excel/' . $filename_excel));

            // Notificación
            $type = 'cto_property';
            $by = Auth::user();
            $data = 'Importó propiedades desde Excel al sistema';
            $model_action = "import";
            $model_id = null;

            $this->notification->send($type, $by, $data, $model_action, $model_id);

            // Mensaje de session
            Session::flash('success', 'La información se importó a tu base de datos sin errores. Los registros repetidos fueron ignorados automáticamente.');

            return redirect()->route('properties.index');
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();

            foreach ($failures as $failure) {
                $failure->row(); // row that went wrong
                $failure->attribute(); // either heading key (if using heading row concern) or column index
                $failure->errors(); // Actual error messages from Laravel validator
            }

            return redirect()->route('properties.index')->with('error', 'Ocurrió un error al importar el archivo. Por favor verifica el formato.');
        }
    }
}
