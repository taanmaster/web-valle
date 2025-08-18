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
        $start_of_day = Carbon::now()->startOfDay();
        $end_of_day = Carbon::now()->endOfDay();

        $financial_supports = FinancialSupport::whereBetween('created_at', [$start_of_day, $end_of_day])->orderBy('receipt_num', 'asc')->get();

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

    public function todayQuery(Request $request)
    {
        /* Defining Dates */
        $date_start = $request->date_start;
        $date_end = $request->date_end;

        $start_of_day = Carbon::parse($date_start)->startOfDay();
        $end_of_day = Carbon::parse($date_start)->endOfDay();

        $financial_supports = FinancialSupport::whereBetween('created_at', [$start_of_day, $end_of_day])->orderBy('receipt_num', 'asc')->get();

        $citizens = Citizen::all();
        $support_types = FinancialSupportType::all();

        $lastSupport = FinancialSupport::orderBy('int_num', 'desc')->first();
        $nextFolio = $lastSupport ? $lastSupport->int_num + 1 : 1;

        return view('financial_supports.day_query')
            ->with('nextFolio', $nextFolio)
            ->with('financial_supports', $financial_supports)
            ->with('citizens', $citizens)
            ->with('support_types', $support_types);
    }

    public function reportQuery(Request $request)
    {
        /* Defining Dates */
        $date_start = $request->date_start ?? Carbon::now()->format('Y-m-d');
        $date_end = $request->date_end ?? Carbon::now()->format('Y-m-d');

        $start_of_day = Carbon::parse($date_start)->startOfMonth();
        $end_of_day = Carbon::parse($date_start)->endOfMonth();

        // Indicadores
        $num_apoyos_mes = FinancialSupport::whereBetween('created_at', [$start_of_day, $end_of_day])->count();
        $cantidad_invertida_apoyos = FinancialSupport::whereBetween('created_at', [$start_of_day, $end_of_day])->sum('qty');
        $cantidad_particulares_nuevos = Citizen::whereBetween('created_at', [$start_of_day, $end_of_day])->count();
        $cantidad_particulares_apoyados = FinancialSupport::whereBetween('created_at', [$start_of_day, $end_of_day])->distinct('citizen_id')->count('citizen_id');

        return view('financial_supports.report')
            ->with('num_apoyos_mes', $num_apoyos_mes)
            ->with('cantidad_invertida_apoyos', $cantidad_invertida_apoyos)
            ->with('cantidad_particulares_nuevos', $cantidad_particulares_nuevos)
            ->with('cantidad_particulares_apoyados', $cantidad_particulares_apoyados);
    }

    public function create()
    {
        return view('financial_supports.create');
    }

    public function store(Request $request)
    {
        //Validar
        $this->validate($request, array(
            'citizen_id' => 'required|max:255',
        ));

        $citizen = Citizen::find($request->citizen_id);

        $cost = FinancialSupportType::find($request->type_id)->limit_per_citizen;

        // Guardar datos en la base de datos
        $financial_support = FinancialSupport::create([
            'citizen_id' => $request->citizen_id,
            'int_num' => $request->int_num,
            'name' => $citizen->name,
            'first_name' => $citizen->first_name,
            'last_name' => $citizen->last_name,
            'qty' => $cost,
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

        return view('financial_supports.edit')->with('financial_support', $financial_support);
    }

    public function edit($id)
    {
        $financial_support = FinancialSupport::find($id);

        return view('financial_supports.edit')->with('financial_support', $financial_support);
    }

    public function update(Request $request, $id)
    {
        //Validar
        $this->validate($request, array(
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

    public function downloadCashCut(Request $request)
    {
        /* Defining Dates */
        $date_start = $request->date_start;

        $start_of_day = Carbon::parse($date_start)->startOfDay();
        $end_of_day = Carbon::parse($date_start)->endOfDay();

        $financial_supports = FinancialSupport::whereBetween('created_at', [$start_of_day, $end_of_day])->orderBy('receipt_num', 'asc')->get();

        $filename = "corte_" . $start_of_day . ".pdf";

        $pdf = PDF::loadView('_files._cash_cut', [
            'financial_supports' => $financial_supports
        ]);

        $pdf->save(public_path('financial_support/files/' . $filename));
        /* Finalización de proceso */

        // Mensaje de session
        Session::flash('success', 'Documento creado exitosamente... Descargando automáticamente en breve.');

        return response()->download(public_path('financial_support/files/' . $filename));
        return redirect()->back();
    }
}
