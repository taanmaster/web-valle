<?php

namespace App\Http\Controllers;

// Ayudantes
use PDF;
use Str;
use Auth;
use Session;
use Carbon\Carbon;

// Modelos
use App\Models\DIFReceipt as Receipt;
use App\Models\DIFPaymentConcept as PaymentConcept;
use App\Models\DIFReceiptConcept as ReceiptConcept;
use App\Models\DIFDoctor as Doctor;
use Illuminate\Http\Request;

class DIFReceiptController extends Controller
{
    public function index()
    {
        $query = Receipt::with(['paymentConcepts']);
        
        if (request('search')) {
            $search = request('search');
            $query->where('receipt_num', 'LIKE', "%{$search}%")
                  ->orWhere('pacient_id', 'LIKE', "%{$search}%")
                  ->orWhere('issued_by', 'LIKE', "%{$search}%");
        }
        
        $receipts = $query->orderBy('created_at', 'desc')->paginate(30);

        return view('dif.receipts.index', compact('receipts'));
    }

    public function create()
    {
        // Obtener todos los conceptos de pago activos
        $paymentConcepts = PaymentConcept::where('is_active', true)->get();
        
        // Obtener todos los doctores (sin filtro is_active ya que no existe esa columna)
        $doctors = Doctor::with('specialty')->get();
        
        // Generar número de recibo automático
        $receiptNum = $this->generateReceiptNumber();
        
        return view('dif.receipts.create', compact('paymentConcepts', 'receiptNum', 'doctors'));
    }

    public function store(Request $request)
    {
        //Validar
        $this->validate($request, array(
            'receipt_num' => 'required|unique:d_i_f_receipts,receipt_num|max:255',
            'receipt_date' => 'required|date',
            'doctor_id' => 'required|exists:d_i_f_doctors,id',
            'patient_id' => 'required|exists:citizens,id',
            'appointment' => 'nullable|max:255',
            'location' => 'nullable|max:255',
            'subtotal' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'total' => 'required|numeric|min:0',
            'payment_method' => 'required|in:cash,card,transfer,check',
            'issued_by' => 'required|max:255',
            'status' => 'required|in:pending,completed,cancelled',
            'concept_ids' => 'required|array|min:1',
            'concept_ids.*' => 'exists:d_i_f_payment_concepts,id',
        ));

        // Guardar recibo
        $receipt = Receipt::create([
            'receipt_num' => $request->receipt_num,
            'receipt_date' => $request->receipt_date,
            'doctor_id' => $request->doctor_id,
            'pacient_id' => $request->patient_id, // Nota: mantener 'pacient_id' como está en la migración
            'appointment' => $request->appointment,
            'location' => $request->location,
            'subtotal' => $request->subtotal,
            'discount' => $request->discount ?? 0,
            'total' => $request->total,
            'payment_method' => $request->payment_method,
            'issued_by' => $request->issued_by,
            'status' => $request->status,
        ]);

        // Asociar conceptos de pago
        if ($request->concept_ids) {
            $receipt->paymentConcepts()->attach($request->concept_ids);
        }

        // Mensaje de session
        Session::flash('success', 'Recibo creado correctamente.');

        // Enviar a vista
        return redirect()->route('dif.receipts.index');
    }

    public function show($id)
    {
        $receipt = Receipt::with(['paymentConcepts', 'doctor.specialty', 'patient'])->find($id);
        
        return view('dif.receipts.show')->with('receipt', $receipt);
    }

    public function edit($id)
    {
        $receipt = Receipt::with(['paymentConcepts', 'doctor', 'patient'])->find($id);
        $paymentConcepts = PaymentConcept::where('is_active', true)->get();
        $doctors = Doctor::with('specialty')->get();
        
        // Obtener IDs de conceptos seleccionados
        $selectedConcepts = $receipt->paymentConcepts->pluck('id')->toArray();

        return view('dif.receipts.edit', compact('receipt', 'paymentConcepts', 'selectedConcepts', 'doctors'));
    }

    public function update(Request $request, $id)
    {
        //Validar
        $this->validate($request, array(
            'receipt_num' => 'required|max:255|unique:d_i_f_receipts,receipt_num,'.$id,
            'receipt_date' => 'required|date',
            'doctor_id' => 'required|exists:d_i_f_doctors,id',
            'patient_id' => 'required|exists:citizens,id',
            'appointment' => 'nullable|max:255',
            'location' => 'nullable|max:255',
            'subtotal' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'total' => 'required|numeric|min:0',
            'payment_method' => 'required|in:cash,card,transfer,check',
            'issued_by' => 'required|max:255',
            'status' => 'required|in:pending,completed,cancelled',
            'concept_ids' => 'required|array|min:1',
            'concept_ids.*' => 'exists:d_i_f_payment_concepts,id',
        ));

        $receipt = Receipt::find($id);

        $receipt->update([
            'receipt_num' => $request->receipt_num,
            'receipt_date' => $request->receipt_date,
            'doctor_id' => $request->doctor_id,
            'pacient_id' => $request->patient_id, // Nota: mantener 'pacient_id' como está en la migración
            'appointment' => $request->appointment,
            'location' => $request->location,
            'subtotal' => $request->subtotal,
            'discount' => $request->discount ?? 0,
            'total' => $request->total,
            'payment_method' => $request->payment_method,
            'issued_by' => $request->issued_by,
            'status' => $request->status,
        ]);

        // Actualizar conceptos de pago
        $receipt->paymentConcepts()->sync($request->concept_ids);

        // Mensaje de session
        Session::flash('success', 'Recibo actualizado exitosamente.');

        // Enviar a vista
        return redirect()->route('dif.receipts.show', $receipt->id);
    }

    public function destroy($id)
    {
        $receipt = Receipt::find($id);
        
        // Eliminar relaciones con conceptos
        $receipt->paymentConcepts()->detach();
        
        // Eliminar recibo
        $receipt->delete();

        Session::flash('success', 'Recibo eliminado de manera exitosa.');
        return redirect()->route('dif.receipts.index');
    }

    /**
     * Generar número de recibo automático
     */
    private function generateReceiptNumber()
    {
        // Obtener el último recibo ordenado por número de folio
        $lastReceipt = Receipt::orderBy('receipt_num', 'desc')->first();
        
        if ($lastReceipt) {
            // Extraer el número del último recibo (formato: REC-XXXX)
            $lastNumber = intval(str_replace('REC-', '', $lastReceipt->receipt_num));
            $newNumber = $lastNumber + 1;
        } else {
            // Si no hay recibos previos, empezar desde 1000
            $newNumber = 1000;
        }
        
        return "REC-" . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Método AJAX para calcular totales
     */
    public function calculateTotals(Request $request)
    {
        $conceptIds = $request->input('concept_ids', []);
        $discount = $request->input('discount', 0);
        
        $subtotal = PaymentConcept::whereIn('id', $conceptIds)->sum('amount');
        $total = $subtotal - $discount;
        
        return response()->json([
            'subtotal' => number_format($subtotal, 2),
            'total' => number_format($total, 2)
        ]);
    }

    /**
     * Descargar recibo en formato PDF
     */
    public function downloadReceipt($id, Request $request)
    {
        $receipt = Receipt::with(['paymentConcepts', 'doctor.specialty', 'patient'])->find($id);
        
        if (!$receipt) {
            Session::flash('error', 'Recibo no encontrado.');
            return redirect()->back();
        }
       
        $filename = "recibo_dif_" . Str::slug($receipt->receipt_num) . ".pdf";
        
        $pdf = PDF::loadView('_files.dif._receipt_invoice', [
            'receipt' => $receipt
        ]);
        
        // Crear directorio si no existe
        $directory = public_path('dif/receipts/');
        if (!file_exists($directory)) {
            mkdir($directory, 0755, true);
        }
        
        $pdf->save($directory . $filename);
        
        // Mensaje de session
        Session::flash('success', 'Recibo descargado exitosamente.');

        return response()->download($directory . $filename);
    }
}
