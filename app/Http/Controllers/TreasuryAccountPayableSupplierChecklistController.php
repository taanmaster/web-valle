<?php

namespace App\Http\Controllers;

// Ayudantes
use PDF;
use Str;
use Auth;
use Session;

// Modelos
use App\Models\TreasuryAccountPayableSupplier;
use App\Models\TreasuryAccountPayableChecklist;
use App\Models\TreasuryAccountPayableSupplierChecklist;

use Illuminate\Http\Request;

class TreasuryAccountPayableSupplierChecklistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $checklists = TreasuryAccountPayableSupplierChecklist::paginate(10);

        return view('treasury_account_payable_supplier_checklists.index')->with('checklists', $checklists);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {
        $supplier = TreasuryAccountPayableSupplier::find($id);
        $checklists = TreasuryAccountPayableChecklist::all();

        return view('treasury_account_payable_supplier_checklists.create')
            ->with('supplier', $supplier)
            ->with('checklists', $checklists);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar
        $this->validate($request, [
            'supplier_id' => 'required|exists:treasury_account_payable_suppliers,id',
            'checklist_id' => 'required|exists:treasury_account_payable_checklists,id',
            'folio' => 'nullable|max:255',
            'received_at' => 'nullable|date',
            'return_date' => 'nullable|date',
            'dependency_id' => 'nullable|integer',
            'dependency_name' => 'nullable|max:255',
            'invoice_number' => 'nullable|max:255',
            'status' => 'required|in:active,inactive',
        ]);

        // Guardar datos en la base de datos
        $checklist = TreasuryAccountPayableSupplierChecklist::create([
            'supplier_id' => $request->supplier_id,
            'checklist_id' => $request->checklist_id,
            'folio' => $request->folio,
            'received_at' => $request->received_at,
            'return_date' => $request->return_date,
            'dependency_id' => $request->dependency_id,
            'dependency_name' => $request->dependency_name,
            'invoice_number' => $request->invoice_number,
            'status' => $request->status,
        ]);

        // Mensaje de sesión
        Session::flash('success', 'Checklist de proveedor creado correctamente.');

        // Redirigir a la vista de detalle del proveedor
        return redirect()->route('treasury_account_payable_suppliers.show', $request->supplier_id);
    }

    /**
     * Display the specified resource.
     */
    public function show($supplier_id, $checklist_id)
    {
        $supplier = TreasuryAccountPayableSupplier::find($supplier_id);
        $checklist = TreasuryAccountPayableSupplierChecklist::find($checklist_id);

        return view('treasury_account_payable_supplier_checklists.show')
        ->with('supplier', $supplier)
        ->with('checklist', $checklist);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($supplier_id, $checklist_id)
    {
        $supplier = TreasuryAccountPayableSupplier::find($supplier_id);
        $checklist = TreasuryAccountPayableSupplierChecklist::find($checklist_id);

        return view('treasury_account_payable_supplier_checklists.edit')
        ->with('supplier', $supplier)
        ->with('checklist', $checklist);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validar
        $this->validate($request, [
            'folio' => 'nullable|max:255',
            'received_at' => 'nullable|date',
            'return_date' => 'nullable|date',
            'dependency_id' => 'nullable|integer',
            'dependency_name' => 'nullable|max:255',
            'invoice_number' => 'nullable|max:255',
            'status' => 'required|in:active,inactive',
        ]);

        $checklist = TreasuryAccountPayableSupplierChecklist::find($id);

        // Actualizar datos
        $checklist->update([
            'folio' => $request->folio,
            'received_at' => $request->received_at,
            'return_date' => $request->return_date,
            'dependency_id' => $request->dependency_id,
            'dependency_name' => $request->dependency_name,
            'invoice_number' => $request->invoice_number,
            'status' => $request->status,
        ]);

        // Mensaje de sesión
        Session::flash('success', 'Checklist de proveedor actualizado correctamente.');

        // Redirigir a la vista de detalle del proveedor
        return redirect()->route('treasury_account_payable_suppliers.show', $request->supplier_id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($supplier_id, $checklist_id)
    {
        $checklist = TreasuryAccountPayableSupplierChecklist::find($checklist_id);
        
        $supplier_id = $checklist->supplier_id;

        // Eliminar checklist
        $checklist->delete();

        // Mensaje de sesión
        Session::flash('success', 'Checklist de proveedor eliminado correctamente.');

        return redirect()->route('treasury_account_payable_suppliers.show', $supplier_id);
    }

    /**
     * Descarga de documentos
     * nomenclatura de carpeta: _files
     * Todos los documentos en la carpeta _files se utilizan en las siguientes funciones:
     */
    public function downloadChecklist($id, Request $request)
    {
        $checklist = TreasuryAccountPayableSupplierChecklist::find($id);
        $filename = "checklist_proveedor_" . Str::slug($checklist->supplier->name) . ".pdf";
        
        $pdf = PDF::loadView('_files.treasury._supplier_checklist', [
            'checklist' => $checklist
        ]);
        
        $pdf->save(public_path('treasury/files/' . $filename));
        /* Finalización de proceso */

        // Mensaje de session
        Session::flash('success', 'Documento creado exitosamente... Descargando automáticamente en breve.');

        return response()->download(public_path('treasury/files/' . $filename));
        return redirect()->back();
    }
}