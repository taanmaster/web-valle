<?php

namespace App\Http\Controllers;

// Ayudantes
use Str;
use Auth;
use Session;
use Intervention\Image\Facades\Image as Image;

use Illuminate\Http\Request;

// Modelos
use App\Models\TreasuryAccountPayableContractor;

class TreasuryAccountPayableContractorController extends Controller
{
    public function index()
    {
        $contractors = TreasuryAccountPayableContractor::paginate(10);

        return view('treasury_account_payable_contractors.index')->with('contractors', $contractors);
    }

    public function create()
    {
        return view('treasury_account_payable_contractors.create');
    }

    public function store(Request $request)
    {
        // Validar
        $this->validate($request, [
            'name' => 'required|max:255',
            'rfc' => 'nullable|max:13',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|max:15',
            'account_name' => 'nullable|max:255',
            'account_number' => 'nullable|max:20',
            'bank_name' => 'nullable|max:255',
            'dependency_id' => 'nullable|integer',
            'status' => 'required|in:active,inactive',
        ]);

        // Guardar datos en la base de datos
        TreasuryAccountPayableContractor::create([
            'name' => $request->name,
            'rfc' => $request->rfc,
            'email' => $request->email,
            'phone' => $request->phone,
            'account_name' => $request->account_name,
            'account_number' => $request->account_number,
            'bank_name' => $request->bank_name,
            'dependency_id' => $request->dependency_id,
            'status' => $request->status,
        ]);

        // Mensaje de sesión
        Session::flash('success', 'Contratista creado correctamente.');

        // Redirigir
        return redirect()->route('treasury_account_payable_contractors.index');
    }

    public function show($id)
    {
        $contractor = TreasuryAccountPayableContractor::find($id);

        return view('treasury_account_payable_contractors.show')->with('contractor', $contractor);
    }

    public function edit($id)
    {
        $contractor = TreasuryAccountPayableContractor::find($id);

        return view('treasury_account_payable_contractors.edit')->with('contractor', $contractor);
    }

    public function update(Request $request, $id)
    {
        // Validar
        $this->validate($request, [
            'name' => 'required|max:255',
            'rfc' => 'nullable|max:13',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|max:15',
            'account_name' => 'nullable|max:255',
            'account_number' => 'nullable|max:20',
            'bank_name' => 'nullable|max:255',
            'dependency_id' => 'nullable|integer',
            'status' => 'required|in:active,inactive',
        ]);

        $contractor = TreasuryAccountPayableContractor::find($id);

        // Actualizar datos
        $contractor->update([
            'name' => $request->name,
            'rfc' => $request->rfc,
            'email' => $request->email,
            'phone' => $request->phone,
            'account_name' => $request->account_name,
            'account_number' => $request->account_number,
            'bank_name' => $request->bank_name,
            'dependency_id' => $request->dependency_id,
            'status' => $request->status,
        ]);

        // Mensaje de sesión
        Session::flash('success', 'Contratista actualizado correctamente.');

        // Redirigir
        return redirect()->route('treasury_account_payable_contractors.index');
    }

    public function destroy($id)
    {
        $contractor = TreasuryAccountPayableContractor::find($id);

        // Eliminar contratista
        $contractor->delete();

        // Mensaje de sesión
        Session::flash('success', 'Contratista eliminado correctamente.');

        return redirect()->route('treasury_account_payable_contractors.index');
    }
}