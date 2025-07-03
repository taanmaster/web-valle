<?php

namespace App\Http\Controllers;

// Ayudantes
use Str;
use Auth;
use Session;
use Carbon\Carbon;

// Modelos
use App\Models\DIFReceipt as Receipt;
use App\Models\DIFPaymentConcept as PaymentConcept;
use App\Models\DIFReceiptConcept as ReceiptConcept;
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
        
        // Generar número de recibo automático
        $receiptNum = $this->generateReceiptNumber();
        
        return view('dif.receipts.create', compact('paymentConcepts', 'receiptNum'));
    }

    public function store(Request $request)
    {
        //Validar
        $this->validate($request, array(
            'receipt_num' => 'required|unique:dif_receipts,receipt_num|max:255',
            'receipt_date' => 'required|date',
            'pacient_id' => 'required|max:255',
            'appointment' => 'nullable|max:255',
            'location' => 'nullable|max:255',
            'subtotal' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'total' => 'required|numeric|min:0',
            'payment_method' => 'required|in:cash,card,transfer,check',
            'issued_by' => 'required|max:255',
            'status' => 'required|in:pending,completed,cancelled',
            'concept_ids' => 'required|array|min:1',
            'concept_ids.*' => 'exists:dif_payment_concepts,id',
        ));

        // Guardar recibo
        $receipt = Receipt::create([
            'receipt_num' => $request->receipt_num,
            'receipt_date' => $request->receipt_date,
            'pacient_id' => $request->pacient_id,
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
        $receipt = Receipt::with(['paymentConcepts'])->find($id);
        
        return view('dif.receipts.show')->with('receipt', $receipt);
    }

    public function edit($id)
    {
        $receipt = Receipt::with(['paymentConcepts'])->find($id);
        $paymentConcepts = PaymentConcept::where('is_active', true)->get();
        
        // Obtener IDs de conceptos seleccionados
        $selectedConcepts = $receipt->paymentConcepts->pluck('id')->toArray();

        return view('dif.receipts.edit', compact('receipt', 'paymentConcepts', 'selectedConcepts'));
    }

    public function update(Request $request, $id)
    {
        //Validar
        $this->validate($request, array(
            'receipt_num' => 'required|max:255|unique:dif_receipts,receipt_num,'.$id,
            'receipt_date' => 'required|date',
            'pacient_id' => 'required|max:255',
            'appointment' => 'nullable|max:255',
            'location' => 'nullable|max:255',
            'subtotal' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'total' => 'required|numeric|min:0',
            'payment_method' => 'required|in:cash,card,transfer,check',
            'issued_by' => 'required|max:255',
            'status' => 'required|in:pending,completed,cancelled',
            'concept_ids' => 'required|array|min:1',
            'concept_ids.*' => 'exists:dif_payment_concepts,id',
        ));

        $receipt = Receipt::find($id);

        $receipt->update([
            'receipt_num' => $request->receipt_num,
            'receipt_date' => $request->receipt_date,
            'pacient_id' => $request->pacient_id,
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
        $today = Carbon::now()->format('Ymd');
        $lastReceipt = Receipt::where('receipt_num', 'like', "REC-{$today}-%")->orderBy('receipt_num', 'desc')->first();
        
        if ($lastReceipt) {
            $lastNumber = intval(substr($lastReceipt->receipt_num, -4));
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }
        
        return "REC-{$today}-" . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
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
}
