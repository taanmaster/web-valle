<?php

namespace App\Http\Controllers;

// Ayudantes
use Str;
use Auth;
use Session;
use Intervention\Image\Facades\Image as Image;

// Modelos
use App\Models\TreasuryAccountPayableChecklist;

use Illuminate\Http\Request;

class TreasuryAccountPayableChecklistController extends Controller
{
    public function index()
    {
        $checklists = TreasuryAccountPayableChecklist::paginate(10);

        return view('treasury_account_payable_checklists.index')->with('checklists', $checklists);
    }

    public function create()
    {
        return view('treasury_account_payable_checklists.create');
    }

    public function store(Request $request)
    {
        // Validar
        $this->validate($request, [
            'name' => 'required|max:255',
            'description' => 'nullable|max:500',
            'status' => 'required|in:active,inactive',
        ]);

        // Guardar datos en la base de datos
        TreasuryAccountPayableChecklist::create([
            'name' => $request->name,
            'description' => $request->description,
            'status' => $request->status,
        ]);

        // Mensaje de sesión
        Session::flash('success', 'Checklist creado correctamente.');

        // Redirigir
        return redirect()->route('treasury_account_payable_checklists.index');
    }

    public function show($id)
    {
        $checklist = TreasuryAccountPayableChecklist::find($id);

        return view('treasury_account_payable_checklists.show')->with('checklist', $checklist);
    }

    public function edit($id)
    {
        $checklist = TreasuryAccountPayableChecklist::find($id);

        return view('treasury_account_payable_checklists.edit')->with('checklist', $checklist);
    }

    public function update(Request $request, $id)
    {
        // Validar
        $this->validate($request, [
            'name' => 'required|max:255',
            'description' => 'nullable|max:500',
            'status' => 'required|in:active,inactive',
        ]);

        $checklist = TreasuryAccountPayableChecklist::find($id);

        // Actualizar datos
        $checklist->update([
            'name' => $request->name,
            'description' => $request->description,
            'status' => $request->status,
        ]);

        // Mensaje de sesión
        Session::flash('success', 'Checklist actualizado correctamente.');

        // Redirigir
        return redirect()->route('treasury_account_payable_checklists.index');
    }

    public function destroy($id)
    {
        $checklist = TreasuryAccountPayableChecklist::find($id);

        // Eliminar checklist
        $checklist->delete();

        // Mensaje de sesión
        Session::flash('success', 'Checklist eliminado correctamente.');

        return redirect()->route('treasury_account_payable_checklists.index');
    }
}