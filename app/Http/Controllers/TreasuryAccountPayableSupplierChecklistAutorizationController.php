<?php

namespace App\Http\Controllers;

// Ayudantes
use Str;
use Auth;
use Session;

// Modelos
use App\Models\TreasuryAccountPayableSupplierChecklistAutorization;

use Illuminate\Http\Request;

class TreasuryAccountPayableSupplierChecklistAutorizationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $authorizations = TreasuryAccountPayableSupplierChecklistAutorization::paginate(10);

        return view('supplier_checklist_authorizations.index')->with('authorizations', $authorizations);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('supplier_checklist_authorizations.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar
        $this->validate($request, [
            'supplier_id' => 'required|exists:treasury_account_payable_suppliers,id',
            'supplier_checklist_id' => 'required|exists:treasury_account_payable_supplier_checklists,id',
            'folio' => 'nullable|max:255',
            'title' => 'required|max:255',
            'type' => 'required|max:255',
            'amount' => 'nullable|numeric|min:0',
            'sender_bank_name' => 'nullable|max:255',
            'sender_account_number' => 'nullable|max:255',
            'financing_fund' => 'nullable|max:255',
            'receiver_bank_name' => 'nullable|max:255',
            'receiver_account_number' => 'nullable|max:255',
            'recipient_name' => 'nullable|max:255',
            'transaction_by' => 'nullable|max:255',
            'authorized_by' => 'nullable|max:255',
            'reviewed_by' => 'nullable|max:255',
            'redacted_by' => 'nullable|max:255',
            'payment_status' => 'nullable|max:255',
        ]);

        // Guardar datos en la base de datos
        TreasuryAccountPayableSupplierChecklistAutorization::create([
            'supplier_id' => $request->supplier_id,
            'supplier_checklist_id' => $request->supplier_checklist_id,
            'folio' => $request->folio,
            'title' => $request->title,
            'type' => $request->type,
            'amount' => $request->amount,
            'sender_bank_name' => $request->sender_bank_name,
            'sender_account_number' => $request->sender_account_number,
            'financing_fund' => $request->financing_fund,
            'receiver_bank_name' => $request->receiver_bank_name,
            'receiver_account_number' => $request->receiver_account_number,
            'recipient_name' => $request->recipient_name,
            'transaction_by' => $request->transaction_by,
            'authorized_by' => $request->authorized_by,
            'reviewed_by' => $request->reviewed_by,
            'redacted_by' => $request->redacted_by,
            'status' => $request->payment_status ?? 'active',
        ]);

        // Mensaje de sesión
        Session::flash('success', 'Autorización creada correctamente.');

        // Redirigir a la vista de detalle del checklist
        return redirect()->route('supplier_checklists.show', [$request->supplier_id, $request->supplier_checklist_id]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $authorization = TreasuryAccountPayableSupplierChecklistAutorization::find($id);

        return view('tap_checklist_authorizations.show')->with('authorization', $authorization);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $authorization = TreasuryAccountPayableSupplierChecklistAutorization::find($id);

        return view('tap_checklist_authorizations.edit')->with('authorization', $authorization);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validar
        $this->validate($request, [
            'folio' => 'nullable|max:255',
            'title' => 'required|max:255',
            'type' => 'required|max:255',
            'amount' => 'nullable|numeric|min:0',
            'sender_bank_name' => 'nullable|max:255',
            'sender_account_number' => 'nullable|max:255',
            'financing_fund' => 'nullable|max:255',
            'receiver_bank_name' => 'nullable|max:255',
            'receiver_account_number' => 'nullable|max:255',
            'recipient_name' => 'nullable|max:255',
            'transaction_by' => 'nullable|max:255',
            'authorized_by' => 'nullable|max:255',
            'reviewed_by' => 'nullable|max:255',
            'redacted_by' => 'nullable|max:255',
            'payment_status' => 'nullable|max:255',
        ]);

        $authorization = TreasuryAccountPayableSupplierChecklistAutorization::find($id);

        // Actualizar datos
        $authorization->update([
            'folio' => $request->folio,
            'title' => $request->title,
            'type' => $request->type,
            'amount' => $request->amount,
            'sender_bank_name' => $request->sender_bank_name,
            'sender_account_number' => $request->sender_account_number,
            'financing_fund' => $request->financing_fund,
            'receiver_bank_name' => $request->receiver_bank_name,
            'receiver_account_number' => $request->receiver_account_number,
            'recipient_name' => $request->recipient_name,
            'transaction_by' => $request->transaction_by,
            'authorized_by' => $request->authorized_by,
            'reviewed_by' => $request->reviewed_by,
            'redacted_by' => $request->redacted_by,
            'status' => $request->payment_status ?? 'active',
        ]);

        // Mensaje de sesión
        Session::flash('success', 'Autorización actualizada correctamente.');

        // Redirigir a la vista de detalle del checklist
        return redirect()->route('supplier_checklists.show', [$authorization->supplier_id, $authorization->supplier_checklist_id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $authorization = TreasuryAccountPayableSupplierChecklistAutorization::find($id);

        $supplier = $authorization->supplier_id;
        $checklist = $authorization->supplier_checklist_id;

        // Eliminar autorización
        $authorization->delete();

        // Mensaje de sesión
        Session::flash('success', 'Autorización eliminada correctamente.');

        return redirect()->route('supplier_checklists.show', [$supplier, $checklist]);
    }
}
