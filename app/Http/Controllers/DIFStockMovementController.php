<?php

namespace App\Http\Controllers;

// Ayudantes
use Session;
use Str;
use Auth;

// Modelos
use App\Models\DIFStockMovement as StockMovement;
use App\Models\DIFMedicationVariant as MedicationVariant;
use App\Models\DIFMedication as Medication;
use App\Models\Notification;

/* Notificaciones */
use App\Services\NotificationService;

use Illuminate\Http\Request;

class DIFStockMovementController extends Controller
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
        $query = MedicationVariant::withStockStatus();

        // Aplicar filtros
        if (request('search')) {
            $search = request('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('sku', 'LIKE', "%{$search}%")
                  ->orWhereHas('medication', function($subQ) use ($search) {
                      $subQ->where('generic_name', 'LIKE', "%{$search}%")
                           ->orWhere('commercial_name', 'LIKE', "%{$search}%");
                  });
            });
        }

        // Filtrar por estado del medicamento
        if (request('medication_status')) {
            $query->whereHas('medication', function($q) {
                $q->where('is_active', request('medication_status') === 'active');
            });
        }

        $variants = $query->orderBy('name')->paginate(30);

        // Aplicar filtro de stock después de obtener los resultados
        if (request('stock_status')) {
            $stockStatus = request('stock_status');
            $variants->getCollection()->transform(function ($variant) use ($stockStatus) {
                $currentStock = $variant->getCurrentStock();
                $shouldInclude = false;
                
                switch ($stockStatus) {
                    case 'available':
                        $shouldInclude = $currentStock > 3;
                        break;
                    case 'low':
                        $shouldInclude = $currentStock > 0 && $currentStock <= 3;
                        break;
                    case 'out':
                        $shouldInclude = $currentStock <= 0;
                        break;
                }
                
                return $shouldInclude ? $variant : null;
            })->filter();
        }

        return view('dif.stock_movements.index', compact('variants'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $variants = MedicationVariant::with('medication')
                                   ->whereHas('medication', function($q) {
                                       $q->where('is_active', true);
                                   })
                                   ->orderBy('name')
                                   ->get();
        
        $variant_id = request('variant_id');
        
        return view('dif.stock_movements.create', compact('variants', 'variant_id'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'variant_id' => 'required|exists:d_i_f_medication_variants,id',
            'movement_type' => 'required|in:inbound,outbound',
            'quantity' => 'required|integer|min:1',
            'date' => 'required|date',
            'expiration_date' => 'nullable|date|after:today',
            'external_reference' => 'nullable|string|max:255',
            'notes' => 'nullable|string|max:1000',
        ]);

        // Validar que no se pueda sacar más inventario del disponible
        if ($request->movement_type === 'outbound') {
            $variant = MedicationVariant::findOrFail($request->variant_id);
            $currentStock = $variant->getCurrentStock();
            
            if ($request->quantity > $currentStock) {
                return back()->withErrors([
                    'quantity' => "No puedes sacar {$request->quantity} unidades. Stock disponible: {$currentStock}"
                ])->withInput();
            }
        }

        $additionalInfo = [];
        if ($request->notes) {
            $additionalInfo['notes'] = $request->notes;
        }

        $movement = StockMovement::create([
            'variant_id' => $request->variant_id,
            'movement_type' => $request->movement_type,
            'quantity' => $request->quantity,
            'date' => $request->date,
            'expiration_date' => $request->expiration_date,
            'external_reference' => $request->external_reference,
            'additional_info' => !empty($additionalInfo) ? $additionalInfo : null,
        ]);

        // Notificación
        $variant = MedicationVariant::with('medication')->find($request->variant_id);
        $type = 'stock_movement';
        $by = Auth::user();
        $actionText = $request->movement_type === 'inbound' ? 'Registró entrada de inventario' : 'Registró salida de inventario';
        $data = "{$actionText} para {$variant->medication->generic_name} - {$variant->name}";
        $model_action = 'create';
        $model_id = $movement->id;

        $this->notification->send($type, $by, $data, $model_action, $model_id);

        Session::flash('success', 'Movimiento de inventario registrado correctamente.');

        return redirect()->route('dif.stock_movements.index');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $movement = StockMovement::with(['variant.medication'])->findOrFail($id);
        $logs = Notification::where('type', 'stock_movement')->where('model_id', $id)->get();

        return view('dif.stock_movements.show', compact('movement', 'logs'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $movement = StockMovement::with('variant.medication')->findOrFail($id);
        $variants = MedicationVariant::with('medication')
                                   ->whereHas('medication', function($q) {
                                       $q->where('is_active', true);
                                   })
                                   ->orderBy('name')
                                   ->get();
        
        return view('dif.stock_movements.edit', compact('movement', 'variants'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'variant_id' => 'required|exists:d_i_f_medication_variants,id',
            'movement_type' => 'required|in:inbound,outbound',
            'quantity' => 'required|integer|min:1',
            'date' => 'required|date',
            'expiration_date' => 'nullable|date|after:today',
            'external_reference' => 'nullable|string|max:255',
            'notes' => 'nullable|string|max:1000',
        ]);

        $movement = StockMovement::findOrFail($id);

        // Validar inventario para salidas
        if ($request->movement_type === 'outbound') {
            $variant = MedicationVariant::findOrFail($request->variant_id);
            $currentStock = $variant->getCurrentStock();
            
            // Revertir el movimiento actual para calcular el stock real
            if ($movement->movement_type === 'outbound') {
                $currentStock += $movement->quantity;
            } else {
                $currentStock -= $movement->quantity;
            }
            
            if ($request->quantity > $currentStock) {
                return back()->withErrors([
                    'quantity' => "No puedes sacar {$request->quantity} unidades. Stock disponible: {$currentStock}"
                ])->withInput();
            }
        }

        $additionalInfo = [];
        if ($request->notes) {
            $additionalInfo['notes'] = $request->notes;
        }

        $movement->update([
            'variant_id' => $request->variant_id,
            'movement_type' => $request->movement_type,
            'quantity' => $request->quantity,
            'date' => $request->date,
            'expiration_date' => $request->expiration_date,
            'external_reference' => $request->external_reference,
            'additional_info' => !empty($additionalInfo) ? $additionalInfo : null,
        ]);

        // Notificación
        $variant = MedicationVariant::with('medication')->find($request->variant_id);
        $type = 'stock_movement';
        $by = Auth::user();
        $data = "Editó movimiento de inventario para {$variant->medication->generic_name} - {$variant->name}";
        $model_action = 'update';
        $model_id = $movement->id;

        $this->notification->send($type, $by, $data, $model_action, $model_id);

        Session::flash('success', 'Movimiento de inventario actualizado exitosamente.');

        return redirect()->route('dif.stock_movements.show', $movement->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $movement = StockMovement::with('variant.medication')->findOrFail($id);

        // Notificación
        $type = 'stock_movement';
        $by = Auth::user();
        $data = "Eliminó movimiento de inventario para {$movement->variant->medication->generic_name} - {$movement->variant->name}";
        $model_action = 'destroy';
        $model_id = $movement->id;

        $this->notification->send($type, $by, $data, $model_action, $model_id);

        $movement->delete();

        Session::flash('success', 'Movimiento de inventario eliminado de manera exitosa.');
        return redirect()->route('dif.stock_movements.index');
    }
}
