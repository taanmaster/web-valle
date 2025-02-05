<?php

namespace App\Http\Controllers;

// Ayudantes
use Str;
use Auth;
use Session;

// Modelos
use App\Models\FinancialSupportType;

use Illuminate\Http\Request;

class FinancialSupportTypeController extends Controller
{
    public function index()
    {
        $financial_support_types = FinancialSupportType::paginate(10);

        return view('financial_support_types.index')->with('financial_support_types', $financial_support_types);
    }

    public function create()
    {
        return view('financial_support_types.create');
    }

    public function store(Request $request)
    {
        //Validar
        $this -> validate($request, array(
            'name' => 'required|max:255',
        ));

        // Guardar datos en la base de datos
        $financial_support_type = FinancialSupportType::create([
            'name' => $request->name,
            'description' => $request->description,
            'monthly_cap' => $request->monthly_cap,
            'limit_per_citizen' => $request->limit_per_citizen,
            'doc_birth_certificate' => in_array('Acta de nacimiento', $request->documents),
            'doc_ine' => in_array('INE', $request->documents),
            'doc_address_proof' => in_array('Comprobante de domicilio', $request->documents),
            'doc_rfc' => in_array('RFC', $request->documents),
            'doc_death_certificate' => in_array('Acta de defunción', $request->documents),
            'doc_funeral_payment' => in_array('Hoja de paga funeraria', $request->documents),
            'doc_cemetery_docs' => in_array('Documentos del panteón', $request->documents),
            'doc_study_certificate' => in_array('Constancia de estudios', $request->documents),
            'doc_medical_prescriptions' => in_array('Recetas médicas', $request->documents),
            'doc_medical_certificate' => in_array('Constancia médica', $request->documents),
            'doc_hospital_visit_card' => in_array('Tarjetón de visita al hospital', $request->documents),
        ]);

        // Mensaje de session
        Session::flash('success', 'Información guardada correctamente.');

        // Enviar a vista
        return redirect()->back();
    }

    public function show($id)
    {
        $financial_support_type = FinancialSupportType::find($id);

        return view('financial_support_types.show')->with('financial_support_type', $financial_support_type);
    }

    public function edit($id)
    {
        $financial_support_type = FinancialSupportType::find($id);

        return view('financial_support_types.edit')->with('financial_support_type', $financial_support_type);
    }

    public function update(Request $request, $id)
    {
        //Validar
        $this -> validate($request, array(
            'name' => 'required|max:255',
        ));

        $financial_support_type = FinancialSupportType::find($id);

        $financial_support_type->update([
            'name' => $request->name,
            'description' => $request->description,
            'monthly_cap' => $request->monthly_cap,
            'limit_per_citizen' => $request->limit_per_citizen,
        ]);

        // Mensaje de session
        Session::flash('success', 'Información editada exitosamente.');

        // Enviar a vista
        return redirect()->back();
    }

    public function destroy($id)
    {
        $financial_support_type = FinancialSupportType::find($id);
        $financial_support_type->delete();

        Session::flash('success', 'Se eliminó la información de manera exitosa.');
        return redirect()->back();
    }
}
