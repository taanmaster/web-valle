<?php

namespace App\Http\Controllers;

// Ayudantes
use PDF;
use Str;
use Auth;
use Session;

// Modelos
use App\Models\TreasuryAccountPayableContractor;
use App\Models\TreasuryAccountPayableChecklist;
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
    public function create($id)
    {
        $contractor = TreasuryAccountPayableContractor::find($id);
        $checklists = TreasuryAccountPayableChecklist::all();

        return view('treasury_account_payable_contractor_checklists.create')
            ->with('contractor', $contractor)
            ->with('checklists', $checklists);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar los datos
        $this->validate($request, [
            'folio' => 'nullable|max:255',
            'received_at' => 'nullable|date',
            'program_code' => 'nullable|max:255',
            'program_name' => 'required|max:255',
            'funding_source' => 'nullable|max:255',
            'budget_item' => 'nullable|max:255',
            'work_number' => 'nullable|max:255',
            'reserve_doc_pres' => 'nullable|max:255',
            'fixed_asset_number' => 'nullable|max:255',
            'contract_number' => 'nullable|max:255',
            'contractor' => 'nullable|max:255',
            'taxpayer_registration' => 'nullable|max:255',
            'award_method' => 'nullable|max:255',
            'with_resources' => 'nullable|boolean',
            'agreement' => 'nullable|max:255',
            'execution_annex' => 'nullable|max:255',
            'work' => 'nullable|max:255',
            'contract_amount' => 'nullable|numeric',
            'advance_amount' => 'nullable|numeric',
            'contract_signing_date' => 'nullable|date',
            'contract_validity_start' => 'nullable|date',
            'contract_validity_end' => 'nullable|date',
            'validity_modification_start' => 'nullable|date',
            'validity_modification_end' => 'nullable|date',
            'modification_agreement_amount' => 'nullable|numeric',
            'amount' => 'nullable|numeric',
            'modification_agreement_time_start' => 'nullable|date',
            'modification_agreement_time_end' => 'nullable|date',
            'estimated' => 'nullable|numeric',
            'iva' => 'nullable|numeric',
            'sum' => 'nullable|numeric',
            'advance_amortization' => 'nullable|numeric',
            'subtotal' => 'nullable|numeric',
            'penalty' => 'nullable|numeric',
            'net_scope' => 'nullable|numeric',
            'subtotal_2' => 'nullable|numeric',
            'iva_2' => 'nullable|numeric',
            'total' => 'nullable|numeric',
            'faism_2024_pays' => 'nullable|numeric',
            'state_pays' => 'nullable|numeric',
            'prepared_by' => 'nullable|max:255',
        ]);

        // Crear el checklist
        TreasuryAccountPayableContractorChecklist::create($request->all());

        // Mensaje de éxito
        Session::flash('success', 'Checklist creado correctamente.');

        return redirect()->route('treasury_account_payable_contractors.show', $request->contractor_id);
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
            'folio' => 'nullable|max:255',
            'received_at' => 'nullable|date',
            'program_code' => 'nullable|max:255',
            'program_name' => 'nullable|max:255',
            'funding_source' => 'nullable|max:255',
            'budget_item' => 'nullable|max:255',
            'work_number' => 'nullable|max:255',
            'reserve_doc_pres' => 'nullable|max:255',
            'fixed_asset_number' => 'nullable|max:255',
            'contract_number' => 'nullable|max:255',
            'contractor' => 'nullable|max:255',
            'taxpayer_registration' => 'nullable|max:255',
            'award_method' => 'nullable|max:255',
            'with_resources' => 'nullable|boolean',
            'agreement' => 'nullable|max:255',
            'execution_annex' => 'nullable|max:255',
            'work' => 'nullable|max:255',
            'contract_amount' => 'nullable|numeric',
            'advance_amount' => 'nullable|numeric',
            'contract_signing_date' => 'nullable|date',
            'contract_validity_start' => 'nullable|date',
            'contract_validity_end' => 'nullable|date',
            'validity_modification_start' => 'nullable|date',
            'validity_modification_end' => 'nullable|date',
            'modification_agreement_amount' => 'nullable|numeric',
            'amount' => 'nullable|numeric',
            'modification_agreement_time_start' => 'nullable|date',
            'modification_agreement_time_end' => 'nullable|date',
            'estimated' => 'nullable|numeric',
            'iva' => 'nullable|numeric',
            'sum' => 'nullable|numeric',
            'advance_amortization' => 'nullable|numeric',
            'subtotal' => 'nullable|numeric',
            'penalty' => 'nullable|numeric',
            'net_scope' => 'nullable|numeric',
            'subtotal_2' => 'nullable|numeric',
            'iva_2' => 'nullable|numeric',
            'total' => 'nullable|numeric',
            'faism_2024_pays' => 'nullable|numeric',
            'state_pays' => 'nullable|numeric',
            'prepared_by' => 'nullable|max:255',
        ]);

        // Buscar el checklist y actualizarlo
        $checklist = TreasuryAccountPayableContractorChecklist::findOrFail($id);
        $checklist->update($request->all());

        // Mensaje de éxito
        Session::flash('success', 'Checklist actualizado correctamente.');

        return redirect()->route('treasury_account_payable_contractors.show', $request->contractor_id);
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

        return redirect()->route('treasury_account_payable_contractors.show', $request->contractor_id);
    }

    /**
     * Descarga de documentos
     * nomenclatura de carpeta: _files
     * Todos los documentos en la carpeta _files se utilizan en las siguientes funciones:
     */
    public function downloadChecklist($id, Request $request)
    {
        $checklist = TreasuryAccountPayableContractorChecklist::with('contractor')->findOrFail($id);

        $filename = "checklist_contratista_" . Str::slug($checklist->contractor) . ".pdf";
        
        $pdf = PDF::loadView('_files.treasury._contractor_checklist', [
            'checklist' => $checklist
        ]);
        
        $pdf->save(public_path('treasury/files/' . $filename));
        /* Finalización de proceso */

        // Mensaje de session
        Session::flash('success', 'Documento creado exitosamente... Descargando automáticamente en breve.');

        return response()->download(public_path('treasury/files/' . $filename));
    }
}