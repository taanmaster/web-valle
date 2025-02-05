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
use App\Models\Citizen;
use App\Models\FinancialSupport;
use App\Models\FinancialSupportType;

use Illuminate\Http\Request;

class FinancialSupportController extends Controller
{
    public function index()
    {
        $financial_supports = FinancialSupport::paginate(10);

        $citizens = Citizen::all();
        $support_types = FinancialSupportType::all();

        $lastSupport = FinancialSupport::orderBy('int_num', 'desc')->first();
        $nextFolio = $lastSupport ? $lastSupport->int_num + 1 : 1;

        return view('financial_supports.index')
        ->with('nextFolio', $nextFolio)
        ->with('financial_supports', $financial_supports)
        ->with('citizens', $citizens)
        ->with('support_types', $support_types);
    }

    public function create()
    {
        return view('financial_supports.create');
    }

    public function store(Request $request)
    {
        //Validar
        $this -> validate($request, array(
            'citizen_id' => 'required|max:255',
        ));

        $citizen = Citizen::find($request->citizen_id);

        // Guardar datos en la base de datos
        $financial_support = FinancialSupport::create([
            'citizen_id' => $request->citizen_id,
            'int_num' => $request->int_num,
            'name' => $citizen->name,
            'first_name' => $citizen->first_name,
            'last_name' => $citizen->last_name,
            'qty' => $request->qty,
            'receipt_num' => $request->receipt_num,
            'type_id' => $request->type_id,
            'phone' => $citizen->phone
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
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'qty' => $request->qty,
            'receipt_num' => $request->receipt_num,
            'type_id' => $request->type_id,
            'phone' => $request->phone,
            'limit_qty' => $request->limit_qty,
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
        
        $pdf = PDF::loadView('_files._support_receipt_format', [
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
