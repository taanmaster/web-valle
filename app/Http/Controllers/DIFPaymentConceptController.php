<?php

namespace App\Http\Controllers;

// Ayudantes
use Str;
use Auth;
use Session;

// Modelos
use App\Models\DIFPaymentConcept as PaymentConcept;
use Illuminate\Http\Request;

class DIFPaymentConceptController extends Controller
{
    public function index()
    {
        $query = PaymentConcept::query();
        
        if (request('search')) {
            $search = request('search');
            $query->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%");
        }
        
        $paymentConcepts = $query->paginate(30);

        return view('dif.payment_concepts.index', compact('paymentConcepts'));
    }

    public function create()
    {
        return view('dif.payment_concepts.create');
    }

    public function store(Request $request)
    {
        //Validar
        $this->validate($request, array(
            'name' => 'required|max:255',
            'description' => 'nullable|max:1000',
            'amount' => 'required|numeric|min:0',
            'is_active' => 'boolean',
        ));

        // Guardar datos en la base de datos
        $paymentConcept = PaymentConcept::create([
            'name' => $request->name,
            'description' => $request->description,
            'amount' => $request->amount,
            'is_active' => $request->has('is_active'),
        ]);

        // Mensaje de session
        Session::flash('success', 'Concepto de pago guardado correctamente.');

        // Enviar a vista
        return redirect()->route('dif.payment_concepts.index');
    }

    public function show($id)
    {
        $paymentConcept = PaymentConcept::find($id);
        
        return view('dif.payment_concepts.show')->with('paymentConcept', $paymentConcept);
    }

    public function edit($id)
    {
        $paymentConcept = PaymentConcept::find($id);

        return view('dif.payment_concepts.edit')->with('paymentConcept', $paymentConcept);
    }

    public function update(Request $request, $id)
    {
        //Validar
        $this->validate($request, array(
            'name' => 'required|max:255',
            'description' => 'nullable|max:1000',
            'amount' => 'required|numeric|min:0',
            'is_active' => 'boolean',
        ));

        $paymentConcept = PaymentConcept::find($id);

        $paymentConcept->update([
            'name' => $request->name,
            'description' => $request->description,
            'amount' => $request->amount,
            'is_active' => $request->has('is_active'),
        ]);

        // Mensaje de session
        Session::flash('success', 'Concepto de pago editado exitosamente.');

        // Enviar a vista
        return redirect()->route('dif.payment_concepts.show', $paymentConcept->id);
    }

    public function destroy($id)
    {
        $paymentConcept = PaymentConcept::find($id);
        $paymentConcept->delete();

        Session::flash('success', 'Concepto de pago eliminado de manera exitosa.');
        return redirect()->route('dif.payment_concepts.index');
    }

    public function search(Request $request)
    {
        $search_query = $request->input('query');

        // Si la petición es AJAX, devolver JSON
        if ($request->ajax() || $request->wantsJson()) {
            $concepts = PaymentConcept::where('is_active', true)
                ->where(function($query) use ($search_query) {
                    $query->where('name', 'LIKE', "%{$search_query}%")
                          ->orWhere('description', 'LIKE', "%{$search_query}%");
                })
                ->limit(20)
                ->get()
                ->map(function ($concept) {
                    return [
                        'id' => $concept->id,
                        'name' => $concept->name,
                        'description' => $concept->description,
                        'amount' => $concept->amount,
                    ];
                });

            return response()->json([
                'success' => true,
                'concepts' => $concepts
            ]);
        }

        // Si no es AJAX, redirigir al índice con búsqueda
        return redirect()->route('dif.payment_concepts.index', ['search' => $search_query]);
    }
}
