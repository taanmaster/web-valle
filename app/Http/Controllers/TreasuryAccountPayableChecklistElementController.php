<?php

namespace App\Http\Controllers;

// Ayudantes
use Str;
use Auth;
use Session;

// Modelos
use App\Models\TreasuryAccountPayableChecklistElement;

use Illuminate\Http\Request;

class TreasuryAccountPayableChecklistElementController extends Controller
{
    public function store(Request $request)
    {
        // Validar los datos
        $this->validate($request, [
            'name' => 'required|max:255',
            'description' => 'nullable|max:500',
            'order' => 'nullable|integer',
            'checklist_id' => 'required|exists:treasury_account_payable_checklists,id',
        ]);

        // Crear el elemento del checklist
        TreasuryAccountPayableChecklistElement::create([
            'name' => $request->name,
            'description' => $request->description,
            'order' => $request->order,
            'checklist_id' => $request->checklist_id,
        ]);

        // Redirigir con mensaje de éxito
        return redirect()->back()->with('success', 'Elemento agregado correctamente.');
    }

    public function edit($id)
    {
        $element = TreasuryAccountPayableChecklistElement::findOrFail($id);

        return view('treasury_account_payable_checklists.elements.edit', compact('element'));
    }

    public function update(Request $request, $id)
    {
        // Validar los datos
        $this->validate($request, [
            'name' => 'required|max:255',
            'description' => 'nullable|max:500',
            'order' => 'nullable|integer',
        ]);

        // Buscar el elemento y actualizarlo
        $element = TreasuryAccountPayableChecklistElement::findOrFail($id);
        
        $element->update([
            'name' => $request->name,
            'description' => $request->description,
            'order' => $request->order,
        ]);

        // Redirigir con mensaje de éxito
        return redirect()->back()->with('success', 'Elemento actualizado correctamente.');
    }

    public function destroy($id)
    {
        // Buscar el elemento y eliminarlo
        $element = TreasuryAccountPayableChecklistElement::findOrFail($id);
        $element->delete();

        // Redirigir con mensaje de éxito
        return redirect()->back()->with('success', 'Elemento eliminado correctamente.');
    }
}