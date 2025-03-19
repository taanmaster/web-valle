<?php

namespace App\Http\Controllers;

// Ayudantes
use PDF;
use Str;
use Auth;
use Session;

// Modelos
use App\Models\TreasuryAccountPayableContractorChecklist;

use Illuminate\Http\Request;

class TreasuryAccountPayableContractorChecklistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $checklists = TreasuryAccountPayableContractorChecklist::paginate(10);

        return view('treasury_account_payable_contractor_checklists.index')->with('checklists', $checklists);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('treasury_account_payable_contractor_checklists.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar los datos
        $this->validate($request, [
            'contractor_id' => 'required|exists:treasury_account_payable_contractors,id',
            'name' => 'required|max:255',
            'description' => 'nullable|max:500',
            'status' => 'required|in:active,inactive',
        ]);

        // Crear el checklist
        TreasuryAccountPayableContractorChecklist::create([
            'contractor_id' => $request->contractor_id,
            'name' => $request->name,
            'description' => $request->description,
            'status' => $request->status,
            'slug' => Str::slug($request->name),
        ]);

        // Mensaje de éxito
        Session::flash('success', 'Checklist creado correctamente.');

        return redirect()->route('treasury_account_payable_contractor_checklists.index');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $checklist = TreasuryAccountPayableContractorChecklist::findOrFail($id);

        return view('treasury_account_payable_contractor_checklists.show')->with('checklist', $checklist);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $checklist = TreasuryAccountPayableContractorChecklist::findOrFail($id);

        return view('treasury_account_payable_contractor_checklists.edit')->with('checklist', $checklist);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validar los datos
        $this->validate($request, [
            'name' => 'required|max:255',
            'description' => 'nullable|max:500',
            'status' => 'required|in:active,inactive',
        ]);

        // Buscar el checklist y actualizarlo
        $checklist = TreasuryAccountPayableContractorChecklist::findOrFail($id);
        $checklist->update([
            'name' => $request->name,
            'description' => $request->description,
            'status' => $request->status,
            'slug' => Str::slug($request->name),
        ]);

        // Mensaje de éxito
        Session::flash('success', 'Checklist actualizado correctamente.');

        return redirect()->route('treasury_account_payable_contractor_checklists.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $checklist = TreasuryAccountPayableContractorChecklist::findOrFail($id);

        // Eliminar el checklist
        $checklist->delete();

        // Mensaje de éxito
        Session::flash('success', 'Checklist eliminado correctamente.');

        return redirect()->route('treasury_account_payable_contractor_checklists.index');
    }

    /**
     * Descarga de documentos
     * nomenclatura de carpeta: _files
     * Todos los documentos en la carpeta _files se utilizan en las siguientes funciones:
     */
    public function downloadChecklist($id, Request $request)
    {
        $checklist = TreasuryAccountPayableContractorChecklist::find($id);
        $filename = "checklist_contratista_" . Str::slug($checklist->contractor->name) . ".pdf";
        
        $pdf = PDF::loadView('_files.treasury._contractor_checklist', [
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