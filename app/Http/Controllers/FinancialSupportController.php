<?php

namespace App\Http\Controllers;

// Ayudantes
use PDF;
use Str;
use Auth;
use Session;
use Image;
use Carbon\Carbon;

// Modelos
use App\Models\FinancialSupport;

use Illuminate\Http\Request;

class FinancialSupportController extends Controller
{
    public function index()
    {
        $financial_supports = FinancialSupport::paginate(10);

        return view('financial_supports.index')->with('financial_supports', $financial_supports);
    }

    public function create()
    {
        return view('financial_supports.create');
    }

    public function store(Request $request)
    {
        //Validar
        $this -> validate($request, array(
            'name' => 'required|max:255',
        ));

        // Guardar datos en la base de datos
        $financial_support = FinancialSupport::create([
            'name' => $request->name,
            'description' => $request->description,
            'document_number' => $request->document_number,
            'type' => $request->type,
            'meeting_date' => $request->meeting_date,
        ]);

        // Mensaje de session
        Session::flash('success', 'Información guardada correctamente.');

        // Enviar a vista
        return redirect()->back();
    }

    public function show($id)
    {
        $financial_support = FinancialSupport::find($id);

        return view('financial_supports.show')->with('financial_support', $financial_support);
    }

    public function edit($id)
    {
        $financial_support = FinancialSupport::find($id);

        return view('financial_supports.edit')->with('financial_support', $financial_support);
    }

    public function update(Request $request, $id)
    {
        //Validar
        $this -> validate($request, array(
            'name' => 'required|max:255',
        ));

        $financial_support = FinancialSupport::find($id);

        $financial_support->update([
            'name' => $request->name,
            'description' => $request->description,
            'document_number' => $request->document_number,
            'type' => $request->type,
            'meeting_date' => $request->meeting_date,
        ]);

        // Mensaje de session
        Session::flash('success', 'Información editada exitosamente.');

        // Enviar a vista
        return redirect()->back();
    }

    public function destroy($id)
    {
        $financial_support = FinancialSupport::find($id);
        $financial_support->delete();

        Session::flash('success', 'Se eliminó la información de manera exitosa.');
        return redirect()->back();
    }

    /**
     * Descarga de documentos
     * nomenclatura de carpeta: _files
     * Todos los documentos en la carpeta _files se utilizan en las siguientes funciones:
     */
    public function downloadGratefulness($id, Request $request)
    {
        $financial_support = FinancialSupport::find($id);
       
        $filename = "agradecimiento_" . Str::slug($financial_support->id) . ".pdf";
        
        $pdf = PDF::loadView('_files._gratefulness_format', [
            'financial_support' => $financial_support
        ]);
        
        $pdf->save(public_path('financial_support/files/' . $filename));
        /* Finalización de proceso */

        // Mensaje de session
        Session::flash('success', 'Documento creado exitosamente... Descargando automáticamente en breve.');

        return response()->download(public_path('financial_support/files/' . $filename));
        return redirect()->back();
    }

    public function downloadRequest($id, Request $request)
    {
        $financial_support = FinancialSupport::find($id);
       
        $filename = "peticion_" . Str::slug($financial_support->id) . ".pdf";
        
        $pdf = PDF::loadView('_files._request_format', [
            'financial_support' => $financial_support
        ]);
        
        $pdf->save(public_path('financial_support/files/' . $filename));
        /* Finalización de proceso */

        // Mensaje de session
        Session::flash('success', 'Documento creado exitosamente... Descargando automáticamente en breve.');

        return response()->download(public_path('financial_support/files/' . $filename));
        return redirect()->back();
    }

    public function downloadSupportReceipt($id, Request $request)
    {
        $financial_support = FinancialSupport::find($id);
       
        $filename = "recibo_de_apoyo_" . Str::slug($financial_support->id) . ".pdf";
        
        $pdf = PDF::loadView('_files._support_receipt', [
            'financial_support' => $financial_support
        ]);
        
        $pdf->save(public_path('financial_support/files/' . $filename));
        /* Finalización de proceso */

        // Mensaje de session
        Session::flash('success', 'Documento creado exitosamente... Descargando automáticamente en breve.');

        return response()->download(public_path('financial_support/files/' . $filename));
        return redirect()->back();
    }

    public function downloadUnderOath($id, Request $request)
    {
        $financial_support = FinancialSupport::find($id);
       
        $filename = "bajo_protesta_" . Str::slug($financial_support->id) . ".pdf";
        
        $pdf = PDF::loadView('_files._under_oath_format', [
            'financial_support' => $financial_support
        ]);
        
        $pdf->save(public_path('financial_support/files/' . $filename));
        /* Finalización de proceso */

        // Mensaje de session
        Session::flash('success', 'Documento creado exitosamente... Descargando automáticamente en breve.');

        return response()->download(public_path('financial_support/files/' . $filename));
        return redirect()->back();
    }

    public function downloadReceived($id, Request $request)
    {
        $financial_support = FinancialSupport::find($id);
       
        $filename = "recibi_" . Str::slug($financial_support->id) . ".pdf";
        
        $pdf = PDF::loadView('_files._received_format', [
            'financial_support' => $financial_support
        ]);
        
        $pdf->save(public_path('financial_support/files/' . $filename));
        /* Finalización de proceso */

        // Mensaje de session
        Session::flash('success', 'Documento creado exitosamente... Descargando automáticamente en breve.');

        return response()->download(public_path('financial_support/files/' . $filename));
        return redirect()->back();
    }
}
