<?php

namespace App\Http\Controllers;

use App\Models\CTOPropertyTax;
use App\Models\CTOProperty;
use App\Models\Notification;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Session;
use Auth;
use DB;

class CTOPropertyTaxController extends Controller
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
        $query = CTOPropertyTax::with('property');

        if (request('search')) {
            $search = request('search');
            $query->where('folio', 'LIKE', "%{$search}%")
                  ->orWhereHas('property', function($q) use ($search) {
                      $q->where('location_account', 'LIKE', "%{$search}%")
                        ->orWhere('taxpayer_name', 'LIKE', "%{$search}%");
                  });
        }

        if (request('year')) {
            $query->where('tax_year', request('year'));
        }

        if (request('bimonthly')) {
            $query->where('bimonthly_period', request('bimonthly'));
        }

        if (request('status')) {
            $query->where('payment_status', request('status'));
        }

        if (request('cuota_type')) {
            $query->where('cuota_type', request('cuota_type'));
        }

        if (request('property_id')) {
            $query->where('c_t_o_property_id', request('property_id'));
        }

        $propertyTaxes = $query->orderBy('tax_year', 'desc')
                              ->orderBy('bimonthly_period', 'desc')
                              ->paginate(30);

        // Años disponibles para el filtro
        $availableYears = CTOPropertyTax::select(DB::raw('DISTINCT tax_year'))
                                         ->orderBy('tax_year', 'desc')
                                         ->pluck('tax_year');

        // Estadísticas
        $stats = [
            'paid' => CTOPropertyTax::where('payment_status', 'pagado')->count(),
            'pending' => CTOPropertyTax::where('payment_status', 'pendiente')->count(),
            'overdue' => CTOPropertyTax::where('payment_status', 'vencido')->count(),
            'total_collected' => CTOPropertyTax::where('payment_status', 'pagado')->sum('total_payment'),
        ];

        return view('cto.property_taxes.index', compact('propertyTaxes', 'availableYears', 'stats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $properties = CTOProperty::orderBy('taxpayer_name')->get();
        return view('cto.property_taxes.create', compact('properties'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'c_t_o_property_id' => 'required|exists:c_t_o_properties,id',
            'tax_year' => 'required|integer|min:2000|max:2100',
            'bimonthly_period' => 'required|integer|min:1|max:6',
            'cuota_type' => 'required|in:cuota_minima,cuota_normal',
            'issue_date' => 'nullable|date',
            'folio' => 'nullable|string|max:255',
            'property_value' => 'nullable|numeric',
            'bimonthly_payment' => 'nullable|numeric',
            'tax_rate' => 'nullable|numeric',
            'current_amount' => 'nullable|numeric',
            'arrears_amount' => 'nullable|numeric',
            'effects' => 'nullable|numeric',
            'arrears_period' => 'nullable|string|max:255',
            'current_period_amount' => 'nullable|numeric',
            'total_arrears' => 'nullable|numeric',
            'current_account' => 'nullable|numeric',
            'property_tax_total' => 'nullable|numeric',
            'discount' => 'nullable|numeric',
            'surcharges' => 'nullable|numeric',
            'surcharges_discount' => 'nullable|numeric',
            'execution_expenses_discount' => 'nullable|numeric',
            'total_payment' => 'nullable|numeric',
            'total_payment_text' => 'nullable|string',
            'bank_reference' => 'nullable|string|max:255',
            'payment_status' => 'required|in:pendiente,pagado,vencido',
            'payment_date' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        $propertyTax = CTOPropertyTax::create($request->all());

        // Notificación
        $type = 'cto_property_tax';
        $by = Auth::user();
        $data = 'Creó un recibo de predial en el sistema';
        $model_action = "create";
        $model_id = $propertyTax->id;

        $this->notification->send($type, $by, $data, $model_action, $model_id);
        
        Session::flash('success', 'Recibo guardado correctamente.');

        return redirect()->route('property_taxes.index');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $propertyTax = CTOPropertyTax::with('property')->findOrFail($id);
        $logs = Notification::where('type', 'cto_property_tax')->where('model_id', $id)->get();

        return view('cto.property_taxes.show', compact('propertyTax', 'logs'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $propertyTax = CTOPropertyTax::findOrFail($id);
        $properties = CTOProperty::orderBy('taxpayer_name')->get();
        return view('cto.property_taxes.edit', compact('propertyTax', 'properties'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'c_t_o_property_id' => 'required|exists:c_t_o_properties,id',
            'tax_year' => 'required|integer|min:2000|max:2100',
            'bimonthly_period' => 'required|integer|min:1|max:6',
            'cuota_type' => 'required|in:cuota_minima,cuota_normal',
            'issue_date' => 'nullable|date',
            'folio' => 'nullable|string|max:255',
            'property_value' => 'nullable|numeric',
            'bimonthly_payment' => 'nullable|numeric',
            'tax_rate' => 'nullable|numeric',
            'current_amount' => 'nullable|numeric',
            'arrears_amount' => 'nullable|numeric',
            'effects' => 'nullable|numeric',
            'arrears_period' => 'nullable|string|max:255',
            'current_period_amount' => 'nullable|numeric',
            'total_arrears' => 'nullable|numeric',
            'current_account' => 'nullable|numeric',
            'property_tax_total' => 'nullable|numeric',
            'discount' => 'nullable|numeric',
            'surcharges' => 'nullable|numeric',
            'surcharges_discount' => 'nullable|numeric',
            'execution_expenses_discount' => 'nullable|numeric',
            'total_payment' => 'nullable|numeric',
            'total_payment_text' => 'nullable|string',
            'bank_reference' => 'nullable|string|max:255',
            'payment_status' => 'required|in:pendiente,pagado,vencido',
            'payment_date' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        $propertyTax = CTOPropertyTax::findOrFail($id);
        $propertyTax->update($request->all());

        // Notificación
        $type = 'cto_property_tax';
        $by = Auth::user();
        $data = 'Editó un recibo de predial en el sistema';
        $model_action = "update";
        $model_id = $propertyTax->id;

        $this->notification->send($type, $by, $data, $model_action, $model_id);

        Session::flash('success', 'Recibo editado exitosamente.');

        return redirect()->route('property_taxes.show', $propertyTax->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $propertyTax = CTOPropertyTax::findOrFail($id);

        // Notificación
        $type = 'cto_property_tax';
        $by = Auth::user();
        $data = 'Eliminó un recibo de predial del sistema';
        $model_action = "destroy";
        $model_id = $propertyTax->id;

        $this->notification->send($type, $by, $data, $model_action, $model_id);

        $propertyTax->delete();

        Session::flash('success', 'Recibo eliminado de manera exitosa.');
        return redirect()->route('property_taxes.index');
    }

    /**
     * Marcar un recibo como pagado
     */
    public function markAsPaid($id)
    {
        $propertyTax = CTOPropertyTax::findOrFail($id);
        $propertyTax->markAsPaid();

        // Notificación
        $type = 'cto_property_tax';
        $by = Auth::user();
        $data = 'Marcó un recibo como pagado';
        $model_action = "update";
        $model_id = $propertyTax->id;

        $this->notification->send($type, $by, $data, $model_action, $model_id);

        Session::flash('success', 'Recibo marcado como pagado exitosamente.');
        return redirect()->back();
    }

    /**
     * Imprimir recibo
     */
    public function print($id)
    {
        $propertyTax = CTOPropertyTax::with('property')->findOrFail($id);
        
        $pdf = PDF::loadView('cto.property_taxes.print', compact('propertyTax'))->setPaper('A4');
        
        $filename = 'recibo_predial_' . ($propertyTax->folio ?? $propertyTax->id) . '.pdf';
        
        return $pdf->download($filename);
    }
}
